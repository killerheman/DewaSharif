<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\DataStore;

class CustomerPortalController extends Controller
{
    protected function getCustomerProfile()
    {
        $dbUser = null;
        try {
            if (auth()->check()) {
                $dbUser = auth()->user();
            }
        } catch (\Throwable $e) {}

        if (!$dbUser) {
            try {
                if (class_exists(\App\Models\User::class)) {
                    $dbUser = \App\Models\User::orderBy('id', 'desc')->first();
                } else {
                    $dbUser = \Illuminate\Support\Facades\DB::table('users')->orderBy('id', 'desc')->first();
                }
            } catch (\Throwable $e) {}
        }

        if (is_object($dbUser)) {
            $id = $dbUser->id ?? 1;
            $firstName = $dbUser->first_name ?? '';
            $lastName = $dbUser->last_name ?? '';
            $name = trim($dbUser->name ?? ($firstName . ' ' . $lastName));
            if (empty($name)) {
                $name = 'User #' . $id;
            }
            if (empty($firstName) && !empty($name)) {
                $parts = explode(' ', $name, 2);
                $firstName = $parts[0] ?? '';
                $lastName = $parts[1] ?? '';
            }

            $avatar = null;
            if (!empty($dbUser->photo)) {
                $avatar = str_starts_with($dbUser->photo, 'http') ? $dbUser->photo : asset($dbUser->photo);
            }

            $dbPhone = !empty($dbUser->phone) ? $dbUser->phone : (!empty($dbUser->mobile) ? $dbUser->mobile : '');

            $profile = [
                'id' => $id,
                'user_id' => '#' . (7000 + (int)$id),
                'name' => $name,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => $dbPhone,
                'email' => $dbUser->email ?? '',
                'country' => is_string($dbUser->country ?? null) ? $dbUser->country : (is_object($dbUser->country ?? null) ? ($dbUser->country->name ?? 'India') : 'India'),
                'state' => is_string($dbUser->state ?? null) ? $dbUser->state : (is_object($dbUser->state ?? null) ? ($dbUser->state->name ?? 'Uttar Pradesh') : 'Uttar Pradesh'),
                'city' => is_string($dbUser->city ?? null) ? $dbUser->city : (is_object($dbUser->city ?? null) ? ($dbUser->city->name ?? 'Barabanki') : 'Barabanki'),
                'pincode' => $dbUser->postal_code ?? ($dbUser->pincode ?? '225301'),
                'address' => $dbUser->address ?? 'Dewa Sharif, Barabanki, UP - 225301',
                'avatar' => $avatar
            ];
        } else {
            $profile = [
                'id' => 1,
                'user_id' => '#7001',
                'name' => 'User',
                'first_name' => 'User',
                'last_name' => '',
                'phone' => '',
                'email' => '',
                'country' => 'India',
                'state' => 'Uttar Pradesh',
                'city' => 'Barabanki',
                'pincode' => '225301',
                'address' => 'Dewa Sharif, Barabanki, UP - 225301'
            ];
        }

        $saved = DataStore::getItem('customer_profile');
        if ($saved && is_array($saved)) {
            // Merge saved session data as base defaults, but real database profile fields take precedence
            $profile = array_merge($saved, array_filter($profile, fn($val) => !is_null($val) && $val !== ''));
        }

        // Always compute dynamic User ID based on database user id starting at 7000
        $profile['user_id'] = '#' . (7000 + (int)($profile['id'] ?? 1));

        return $profile;
    }

    protected function sortLatest($items)
    {
        if (!is_array($items)) {
            return [];
        }
        usort($items, function ($a, $b) {
            $timeA = !empty($a['created_at']) ? strtotime($a['created_at']) : (is_numeric($a['id'] ?? 0) ? (int)$a['id'] : 0);
            $timeB = !empty($b['created_at']) ? strtotime($b['created_at']) : (is_numeric($b['id'] ?? 0) ? (int)$b['id'] : 0);
            return $timeB <=> $timeA;
        });
        return $items;
    }

    public function dashboard()
    {
        $hotelBookings = $this->sortLatest(DataStore::getCollection('hotel_bookings'));
        $cabBookings = $this->sortLatest(DataStore::getCollection('cab_bookings'));
        $shopOrders = $this->sortLatest(DataStore::getCollection('shop_orders'));
        $tickets = $this->sortLatest(DataStore::getCollection('tickets'));
        $profile = $this->getCustomerProfile();

        // Determine dynamic section ordering based on most recent activity in each service
        $latestHotelTime = !empty($hotelBookings[0]) ? (!empty($hotelBookings[0]['created_at']) ? strtotime($hotelBookings[0]['created_at']) : (int)($hotelBookings[0]['id'] ?? 0)) : 0;
        $latestCabTime = !empty($cabBookings[0]) ? (!empty($cabBookings[0]['created_at']) ? strtotime($cabBookings[0]['created_at']) : (int)($cabBookings[0]['id'] ?? 0)) : 0;
        $latestShopTime = !empty($shopOrders[0]) ? (!empty($shopOrders[0]['created_at']) ? strtotime($shopOrders[0]['created_at']) : (int)($shopOrders[0]['id'] ?? 0)) : 0;

        $sectionOrder = [
            ['type' => 'hotel', 'time' => $latestHotelTime],
            ['type' => 'cab', 'time' => $latestCabTime],
            ['type' => 'shop', 'time' => $latestShopTime],
        ];

        usort($sectionOrder, function($a, $b) {
            return $b['time'] <=> $a['time'];
        });

        return view('home.customer.dashboard', compact('hotelBookings', 'cabBookings', 'shopOrders', 'tickets', 'profile', 'sectionOrder'));
    }

    public function hotelBookings()
    {
        $all = $this->sortLatest(DataStore::getCollection('hotel_bookings'));
        $profile = $this->getCustomerProfile();
        $authId = auth()->id();
        $authPhone = preg_replace('/[^0-9]/', '', $profile['phone'] ?? (auth()->user()->phone ?? ''));
        
        $userBookings = array_filter($all, function($b) use ($authId, $authPhone) {
            $bUserId = is_array($b) ? ($b['user_id'] ?? null) : ($b->user_id ?? null);
            if ($authId && $bUserId && (string)$bUserId === (string)$authId) return true;
            $bPhone = preg_replace('/[^0-9]/', '', is_array($b) ? ($b['customer_phone'] ?? '') : ($b->customer_phone ?? ''));
            if (!empty($authPhone) && !empty($bPhone) && (str_contains($bPhone, $authPhone) || str_contains($authPhone, $bPhone))) return true;
            return false;
        });

        $hotelBookings = !empty($userBookings) ? array_values($userBookings) : $all;
        return view('home.customer.hotels', compact('hotelBookings', 'profile'));
    }

    public function cabBookings()
    {
        $cabBookings = $this->sortLatest(DataStore::getCollection('cab_bookings'));
        $profile = $this->getCustomerProfile();
        return view('home.customer.cabs', compact('cabBookings', 'profile'));
    }

    public function orders()
    {
        $shopOrders = [];
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('shop_orders')) {
                $shopOrders = \Illuminate\Support\Facades\DB::table('shop_orders')
                    ->orderBy('id', 'desc')
                    ->get()
                    ->map(function($item) { return (array)$item; })
                    ->toArray();
            }
        } catch (\Throwable $e) {}

        if (empty($shopOrders)) {
            $shopOrders = $this->sortLatest(DataStore::getCollection('shop_orders'));
        }
        $profile = $this->getCustomerProfile();
        return view('home.customer.orders', compact('shopOrders', 'profile'));
    }

    public function billing()
    {
        $hotelBookings = DataStore::getCollection('hotel_bookings');
        $cabBookings = DataStore::getCollection('cab_bookings');
        $shopOrders = [];
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('shop_orders')) {
                $shopOrders = \Illuminate\Support\Facades\DB::table('shop_orders')
                    ->orderBy('id', 'desc')
                    ->get()
                    ->map(function($item) { return (array)$item; })
                    ->toArray();
            }
        } catch (\Throwable $e) {}

        if (empty($shopOrders)) {
            $shopOrders = DataStore::getCollection('shop_orders');
        }
        $profile = $this->getCustomerProfile();

        $allInvoices = collect();

        foreach ($hotelBookings as $b) {
            $created = $b['created_at'] ?? '2026-09-27 10:00:00';
            $rawId = $b['id'] ?? 1;
            $numId = is_numeric($rawId) ? str_pad($rawId, 3, '0', STR_PAD_LEFT) : $rawId;
            $bPayStatus = strtolower($b['payment_status'] ?? 'paid');
            $bStatus = strtolower($b['status'] ?? '');
            if ($bPayStatus === 'failed' || str_contains($bStatus, 'fail') || str_contains($bStatus, 'cancel')) {
                $itemStatus = 'FAILED / VOID';
            } elseif ($bPayStatus === 'paid' || str_contains($bStatus, 'paid')) {
                $itemStatus = 'PAID';
            } else {
                $itemStatus = 'VERIFICATION PENDING';
            }

            $allInvoices->push([
                'type' => 'hotel',
                'id' => $rawId,
                'code' => $b['booking_code'] ?? ($b['booking_id'] ?? ('DWS-HTL-' . $rawId)),
                'invoice_no' => 'INV-HOT-' . $numId,
                'title' => ($b['hotel_name'] ?? 'Guest House Stay') . ' (' . ($b['room_name'] ?? ($b['room_type'] ?? 'Deluxe Room')) . ')',
                'amount' => (float)($b['total_amount'] ?? ($b['amount'] ?? ($b['price'] ?? 0))),
                'status' => $itemStatus,
                'date' => date('d M Y', strtotime($created)),
                'created_at' => $created,
                'timestamp' => strtotime($created)
            ]);
        }

        foreach ($cabBookings as $c) {
            $created = $c['created_at'] ?? '2026-09-27 10:00:00';
            $rawId = $c['id'] ?? 1;
            $numId = is_numeric($rawId) ? str_pad($rawId, 3, '0', STR_PAD_LEFT) : $rawId;
            $cPayStatus = strtolower($c['payment_status'] ?? 'paid');
            $cStatus = strtolower($c['status'] ?? '');
            if ($cPayStatus === 'failed' || str_contains($cStatus, 'fail') || str_contains($cStatus, 'cancel')) {
                $itemStatus = 'FAILED / VOID';
            } elseif ($cPayStatus === 'paid' || str_contains($cStatus, 'paid')) {
                $itemStatus = 'PAID';
            } else {
                $itemStatus = 'VERIFICATION PENDING';
            }

            $vCount = (int)($c['vehicle_count'] ?? 1);
            if ($vCount < 1) { $vCount = 1; }
            $vLabel = ($c['vehicle_name'] ?? ($c['vehicle_type'] ?? 'Cab Taxi')) . ($vCount > 1 ? " [× {$vCount} Cabs]" : '');

            $allInvoices->push([
                'type' => 'cab',
                'id' => $rawId,
                'code' => $c['booking_code'] ?? ($c['booking_id'] ?? ('DWS-CAB-' . $rawId)),
                'invoice_no' => 'INV-CAB-' . $numId,
                'title' => ($c['route'] ?? 'Cab Duty') . ' (' . $vLabel . ')',
                'amount' => (float)($c['total_fare'] ?? ($c['fare'] ?? ($c['total_amount'] ?? 0))),
                'status' => $itemStatus,
                'date' => date('d M Y', strtotime($created)),
                'created_at' => $created,
                'timestamp' => strtotime($created)
            ]);
        }

        foreach ($shopOrders as $o) {
            $created = $o['created_at'] ?? '2026-09-27 10:00:00';
            $rawId = $o['id'] ?? 1;
            $numId = is_numeric($rawId) ? str_pad($rawId, 3, '0', STR_PAD_LEFT) : $rawId;
            $oPayStatus = strtolower($o['payment_status'] ?? 'paid');
            $oStatus = strtolower($o['status'] ?? '');
            if ($oPayStatus === 'failed' || str_contains($oStatus, 'fail') || str_contains($oStatus, 'cancel')) {
                $itemStatus = 'FAILED / VOID';
            } elseif ($oPayStatus === 'paid' || str_contains($oStatus, 'paid')) {
                $itemStatus = 'PAID';
            } else {
                $itemStatus = 'VERIFICATION PENDING';
            }

            $allInvoices->push([
                'type' => 'shop',
                'id' => $rawId,
                'code' => $o['order_code'] ?? ($o['order_id'] ?? ('DWS-SHP-' . $rawId)),
                'invoice_no' => 'INV-SHP-' . $numId,
                'title' => $o['items_summary'] ?? 'Sacred Store Order',
                'amount' => (float)($o['total_amount'] ?? ($o['amount'] ?? 0)),
                'status' => $itemStatus,
                'date' => date('d M Y', strtotime($created)),
                'created_at' => $created,
                'timestamp' => strtotime($created)
            ]);
        }

        $allInvoices = $allInvoices->sortByDesc('timestamp')->values()->all();

        return view('home.customer.billing', compact('allInvoices', 'hotelBookings', 'cabBookings', 'shopOrders', 'profile'));
    }

    public function account(Request $request)
    {
        $profile = $this->getCustomerProfile();
        $editMode = $request->has('edit') || session('edit_mode');
        return view('home.customer.account', compact('profile', 'editMode'));
    }

    public function updateAccount(Request $request)
    {
        $currentProfile = $this->getCustomerProfile();
        $avatarPath = $currentProfile['avatar'] ?? null;

        if ($request->input('remove_avatar') == '1') {
            $avatarPath = null;
        } elseif ($request->hasFile('avatar')) {
            try {
                $file = $request->file('avatar');
                $uploadDir = public_path('uploads/profile');
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = 'profile_' . time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
                $file->move($uploadDir, $fileName);
                $avatarPath = asset('uploads/profile/' . $fileName);
            } catch (\Throwable $e) {
                if ($request->input('avatar_base64')) {
                    $avatarPath = $request->input('avatar_base64');
                }
            }
        } elseif ($request->input('avatar_base64')) {
            $avatarPath = $request->input('avatar_base64');
        }

        $firstName = trim($request->input('first_name', $currentProfile['first_name'] ?? ''));
        $lastName = trim($request->input('last_name', $currentProfile['last_name'] ?? ''));
        $fullName = trim($request->input('name', trim($firstName . ' ' . $lastName)));
        if (empty($fullName)) {
            $fullName = trim($currentProfile['name'] ?? 'User');
        }
        $phone = trim($request->input('phone', $currentProfile['phone'] ?? ''));
        $email = trim($request->input('email', $currentProfile['email'] ?? ''));
        $country = trim($request->input('country', $currentProfile['country'] ?? 'India'));
        $state = trim($request->input('state', $currentProfile['state'] ?? 'Uttar Pradesh'));
        $city = trim($request->input('city', $currentProfile['city'] ?? 'Barabanki'));
        $pincode = trim($request->input('pincode', $currentProfile['pincode'] ?? '225301'));
        $address = trim($request->input('address', $currentProfile['address'] ?? 'Dewa Sharif, Barabanki, UP - 225301'));

        $userId = $currentProfile['id'] ?? 1;

        // Sync with MySQL database users table
        try {
            $updateData = [
                'name' => $fullName,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => $phone,
                'email' => $email,
                'address' => $address,
                'postal_code' => $pincode,
                'photo' => !empty($avatarPath) ? str_replace(asset(''), '', $avatarPath) : null,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            \Illuminate\Support\Facades\DB::table('users')->where('id', $userId)->update($updateData);
        } catch (\Throwable $e) {}

        $profile = array_merge($currentProfile, [
            'id' => $userId,
            'user_id' => '#' . (7000 + (int)$userId),
            'name' => $fullName,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $phone,
            'email' => $email,
            'country' => $country,
            'state' => $state,
            'city' => $city,
            'pincode' => $pincode,
            'address' => $address,
            'avatar' => $avatarPath,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        unset($profile['account_type'], $profile['company']);

        DataStore::setItem('customer_profile', $profile);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Profile & address information updated successfully!',
                'redirect' => route('customer.account')
            ]);
        }

        return redirect()->route('customer.account')->with('success', 'Profile & address information updated successfully!');
    }

    public function changePasswordView()
    {
        $profile = $this->getCustomerProfile();
        return view('home.customer.change_password', compact('profile'));
    }

    public function updatePassword(Request $request)
    {
        $profile = $this->getCustomerProfile();
        $email = $profile['email'] ?? 'shahzade.alam707@gmail.com';
        $mode = $request->input('reset_type', 'password_change');

        if ($mode === 'email_reset') {
            try {
                $resetLink = route('customer.changePassword', ['token' => md5(time())]);
                $mailText = "🔑 DEWA SHARIF ACCOUNT PASSWORD RESET REQUEST\n\n" .
                            "Hello " . ($profile['name'] ?? 'Shahzade Alam') . ",\n\n" .
                            "We received a request to reset your DewaSharif customer portal account password.\n" .
                            "Click the secure link below to proceed with setting a new password:\n" .
                            "{$resetLink}\n\n" .
                            "If you did not request this change, please ignore this email.\n\n" .
                            "Regards,\nDewaSharif Security Team";

                \Illuminate\Support\Facades\Mail::raw($mailText, function ($message) use ($email) {
                    $message->to($email)->subject("🔑 DewaSharif Account Password Reset Instructions");
                });
            } catch (\Throwable $e) {}

            return redirect()->back()->with('success', "🔑 Password reset instructions & secure link dispatched to your registered email ({$email})!");
        }

        $request->validate([
            'new_password' => 'required|min:6',
        ]);

        if ($request->filled('confirm_password') && $request->new_password !== $request->confirm_password) {
            return redirect()->back()->with('error', '⚠️ Password confirmation does not match. Please try again.');
        }

        // Validate current password if supplied
        if ($request->filled('password')) {
            $user = auth()->user() ?? \Illuminate\Support\Facades\DB::table('users')->where('email', $email)->first();
            if ($user && isset($user->password) && !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
                return redirect()->back()->with('error', '⚠️ Current password entered is incorrect.');
            }
        }

        $hashedPassword = \Illuminate\Support\Facades\Hash::make($request->new_password);

        try {
            if (auth()->check()) {
                auth()->user()->update(['password' => $hashedPassword]);
            }
            \Illuminate\Support\Facades\DB::table('users')->where('email', $email)->update(['password' => $hashedPassword]);
        } catch (\Throwable $e) {}

        $profile['password_updated_at'] = date('Y-m-d H:i:s');
        DataStore::setItem('customer_profile', $profile);

        try {
            $mailText = "🎉 PASSWORD UPDATED SUCCESSFULLY!\n\n" .
                        "Hello " . ($profile['name'] ?? 'Shahzade Alam') . ",\n\n" .
                        "Your DewaSharif customer portal account password was updated on " . date('d M Y @ h:i A') . ".\n\n" .
                        "If you did not perform this change, please contact support immediately.\n\n" .
                        "Regards,\nDewaSharif Customer Care";

            \Illuminate\Support\Facades\Mail::raw($mailText, function ($message) use ($email) {
                $message->to($email)->subject("🎉 DewaSharif Account Password Updated");
            });
        } catch (\Throwable $e) {}

        return redirect()->back()->with('success', '🔑 Password updated successfully! A confirmation email has been dispatched to ' . $email . '.');
    }

    public function reportIssue()
    {
        $tickets = $this->sortLatest(DataStore::getCollection('tickets'));
        $profile = $this->getCustomerProfile();
        return view('home.customer.report_issue', compact('tickets', 'profile'));
    }

    public function storeReportIssue(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $profile = $this->getCustomerProfile();
        $ticketId = 'SUP-' . str_pad(rand(10, 99999), 6, '0', STR_PAD_LEFT);

        $ticket = [
            'id' => time() . rand(100, 999),
            'ticket_id' => $ticketId,
            'ticket_no' => $ticketId,
            'customer_name' => $profile['name'] ?? 'Masharrat Warsi',
            'contact' => $profile['phone'] ?? '+91 7398072236',
            'subject' => trim($request->input('subject')),
            'message' => trim($request->input('message')),
            'category' => $request->input('category', 'General Platform Inquiry'),
            'priority' => 'High',
            'status' => 'Open',
            'reply' => null,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        DataStore::addItem('tickets', $ticket);

        return redirect()->route('customer.reportIssue')->with('success', 'Your report has been submitted to us. You will get a response shortly.');
    }

    public function tickets()
    {
        $tickets = $this->sortLatest(DataStore::getCollection('tickets'));
        $profile = $this->getCustomerProfile();
        return view('home.customer.tickets', compact('tickets', 'profile'));
    }

    public function showTicket($id)
    {
        $tickets = DataStore::getCollection('tickets');
        $ticket = null;
        foreach ($tickets as $t) {
            if ((string)($t['id'] ?? '') === (string)$id || (string)($t['ticket_id'] ?? '') === (string)$id || (string)($t['ticket_no'] ?? '') === (string)$id) {
                $ticket = $t;
                break;
            }
        }
        if (!$ticket && !empty($tickets)) {
            $ticket = $tickets[0];
        }

        $profile = $this->getCustomerProfile();
        return view('home.customer.ticket_details', compact('ticket', 'profile'));
    }

    public function destroyTicket($id)
    {
        DataStore::deleteItem('tickets', $id);
        return redirect()->route('customer.reportIssue')->with('success', 'Ticket deleted successfully from your account.');
    }

    public function downloadInvoice($type, $id)
    {
        $invoiceDate = \Carbon\Carbon::now('Asia/Kolkata')->format('d M Y, h:i A');
        $profile = $this->getCustomerProfile();

        $customerName = $profile['name'] ?? 'Devotee / Passenger';
        $customerEmail = null;
        $customerPhone = $profile['phone'] ?? '+91 7398072236';
        $customerAltPhone = null;
        $customerAddress = $profile['address'] ?? 'Dewa Sharif, Barabanki, UP - 225301';
        $idInfo = null;
        $paymentStatus = 'paid';

        $fatehaName = null;
        $niyazDate = null;
        $distribution_type = null;
        $distributionType = null;
        $distributionFee = 0;
        $order = null;
        $isDegh = false;

        if ($type === 'hotel') {
            $hotelBookings = DataStore::getCollection('hotel_bookings');
            $booking = null;
            foreach ($hotelBookings as $b) {
                $bId = (string)($b['id'] ?? '');
                $bCode = (string)($b['booking_code'] ?? ($b['booking_number'] ?? ''));
                $bBookingId = (string)($b['booking_id'] ?? '');
                if ($bId === (string)$id || $bCode === (string)$id || $bBookingId === (string)$id) {
                    $booking = $b;
                    break;
                }
            }
            if (!$booking && !empty($hotelBookings)) {
                $booking = $hotelBookings[0];
            }

            $rawId = $booking['id'] ?? $id;
            $numId = is_numeric($rawId) ? str_pad($rawId, 3, '0', STR_PAD_LEFT) : $rawId;

            $serviceName = 'Hotel & Stay Booking Service';
            $invoiceNo = 'INV-HOT-' . $numId;
            $invoiceDate = \Carbon\Carbon::now('Asia/Kolkata')->format('d M Y, h:i A');

            $bCheckIn = $booking['check_in'] ?? ($booking['checkin'] ?? date('d M Y'));
            $bCheckOut = $booking['check_out'] ?? ($booking['checkout'] ?? date('d M Y', strtotime('+1 day')));
            try {
                $cinFormatted = \Carbon\Carbon::parse($bCheckIn)->format('d M Y') . ', 12:00 PM';
            } catch (\Throwable $e) {
                $cinFormatted = $bCheckIn;
            }
            try {
                $coutFormatted = \Carbon\Carbon::parse($bCheckOut)->format('d M Y') . ', 11:00 AM';
            } catch (\Throwable $e) {
                $coutFormatted = $bCheckOut;
            }
            $serviceDate = $cinFormatted . ' – ' . $coutFormatted;
            $orderNo = $booking['booking_code'] ?? ($booking['booking_number'] ?? ('ORD-HOT-' . $numId));
            $paymentId = !empty($booking['utr_number']) ? ('SBI_UPI_' . $booking['utr_number']) : ($booking['payment_id'] ?? ('pay_HOT_' . substr(md5($id), 0, 10)));
            $paymentStatus = strtolower($booking['payment_status'] ?? ($booking['status'] ?? 'paid'));
            $checkinPin = $booking['checkin_pin'] ?? ($booking->checkin_pin ?? '4821');

            if (!empty($booking['customer_name'])) $customerName = $booking['customer_name'];
            if (!empty($booking['customer_phone'])) $customerPhone = $booking['customer_phone'];
            if (!empty($booking['alternate_phone'])) $customerAltPhone = $booking['alternate_phone'];
            $customerEmail = !empty($booking['customer_email']) ? $booking['customer_email'] : (!empty($booking['email']) ? $booking['email'] : null);
            if (!empty($booking['customer_address'])) $customerAddress = $booking['customer_address'];
            elseif (!empty($booking['address'])) $customerAddress = $booking['address'];
            if (!empty($booking['id_type']) && !empty($booking['id_no'])) {
                if (strtoupper(trim($booking['id_no'])) === 'N/A') {
                    $idInfo = $booking['id_type'] . ' (To be verified at Check-in)';
                } else {
                    $idInfo = $booking['id_type'] . ' (' . $booking['id_no'] . ')';
                }
            }

            $totalAmount = (float)($booking['total_amount'] ?? ($booking['amount'] ?? ($booking['price'] ?? 0)));
            $gst = 0.00;
            $price = $totalAmount;

            // Resolve hotel name & amenities for PDF Tax Invoice Voucher
            $hotelName = $booking['hotel_name'] ?? 'Al-Waris Deluxe Guest House';

            if (isset($booking['amenities'])) {
                $rawAm = $booking['amenities'];
            } elseif (isset($booking['amenities_list'])) {
                $rawAm = $booking['amenities_list'];
            } else {
                $allHotels = DataStore::getCollection('hotels');
                $matchedHotel = null;
                foreach ($allHotels as $h) {
                    $hName = is_array($h) ? ($h['name'] ?? '') : ($h->name ?? '');
                    if (!empty($hName) && (str_contains(strtolower($hName), strtolower($hotelName)) || str_contains(strtolower($hotelName), strtolower($hName)))) {
                        $matchedHotel = $h;
                        break;
                    }
                }
                if (!$matchedHotel && isset($allHotels[0])) {
                    $matchedHotel = $allHotels[0];
                }

                $rawAm = is_array($matchedHotel) ? ($matchedHotel['amenities'] ?? []) : ($matchedHotel->amenities ?? []);
            }

            if (is_string($rawAm)) {
                $rawAm = explode(',', $rawAm);
            }
            $amenitiesList = array_values(array_filter(array_map('trim', (array)$rawAm)));
            $amenitiesDesc = !empty($amenitiesList) ? (' | Included Amenities: ' . implode(', ', $amenitiesList)) : '';

            $items = [
                [
                    'sl' => 1,
                    'particulars' => $hotelName . ' (' . ($booking['room_name'] ?? ($booking['room_type'] ?? 'Deluxe AC Room')) . ')',
                    'desc' => 'Check-in: ' . $bCheckIn . ' | Check-out: ' . $bCheckOut . ' | Guest: ' . $customerName . $amenitiesDesc,
                    'price' => $price,
                    'qty' => 1,
                    'discount' => 0.00,
                    'gst' => $gst,
                    'total' => $totalAmount
                ]
            ];
            $netTotal = $totalAmount;

        } elseif ($type === 'cab') {
            $cabBookings = DataStore::getCollection('cab_bookings');
            $cab = null;
            foreach ($cabBookings as $c) {
                $cId = (string)($c['id'] ?? '');
                $cCode = (string)($c['booking_code'] ?? ($c['booking_id'] ?? ''));
                $cBId = (string)($c['booking_id'] ?? '');
                if ($cId === (string)$id || $cCode === (string)$id || $cBId === (string)$id) {
                    $cab = $c;
                    break;
                }
            }
            if (!$cab) {
                return redirect()->route('customer.cabs')->with('error', 'Cab booking slip not found.');
            }

            $rawId = $cab['id'] ?? $id;
            $numId = is_numeric($rawId) ? str_pad($rawId, 3, '0', STR_PAD_LEFT) : $rawId;

            $serviceName = 'Taxi & Cab Duty Service';
            $invoiceNo = 'INV-CAB-' . $numId;
            $invoiceDate = \Carbon\Carbon::now('Asia/Kolkata')->format('d M Y, h:i A');

            $rawPickup = $cab['pickup_time'] ?? null;
            if ($rawPickup) {
                try {
                    $serviceDate = \Carbon\Carbon::parse($rawPickup)->format('d M Y, h:i A');
                } catch (\Throwable $e) {
                    $serviceDate = $rawPickup;
                }
            } else {
                $serviceDate = date('d M Y, 08:30 AM');
            }
            $orderNo = $cab['booking_code'] ?? ($cab['booking_id'] ?? ('ORD-CAB-' . $numId));
            $paymentId = $cab['payment_id'] ?? ('pay_CAB_' . substr(md5($id), 0, 10));

            if (!empty($cab['customer_name'])) $customerName = $cab['customer_name'];
            if (!empty($cab['customer_phone'])) $customerPhone = $cab['customer_phone'];
            if (!empty($cab['alternate_phone'])) $customerAltPhone = $cab['alternate_phone'];
            $customerEmail = !empty($cab['customer_email']) ? $cab['customer_email'] : (!empty($cab['email']) ? $cab['email'] : null);
            if (!empty($cab['customer_address'])) $customerAddress = $cab['customer_address'];
            elseif (!empty($cab['address'])) $customerAddress = $cab['address'];
            $paymentStatus = $cab['payment_status'] ?? 'paid';

            if (!empty($cab['id_type']) && !empty($cab['id_no'])) {
                if (strtoupper(trim($cab['id_no'])) === 'N/A') {
                    $idInfo = $cab['id_type'] . ' (To be verified before Boarding)';
                } else {
                    $idInfo = $cab['id_type'] . ' (' . $cab['id_no'] . ')';
                }
            }

            $cabVehicleCount = (int)($cab['vehicle_count'] ?? 1);
            if ($cabVehicleCount < 1) { $cabVehicleCount = 1; }

            $rawVehicleName = $cab['vehicle_name'] ?? ($cab['vehicle_type'] ?? 'Cab Taxi');
            $cleanVehicleName = trim(preg_replace('/\s*[\(\[]×\s*\d+\s*cabs?[\)\]]/i', '', $rawVehicleName));
            $cabVehicleLabel = $cleanVehicleName . ($cabVehicleCount > 1 ? " [× {$cabVehicleCount} Cabs Booked]" : "");
            $cabRouteLabel = ($cab['route'] ?? 'Lucknow ↔ Dewa Sharif') . ' (' . $cabVehicleLabel . ')';

            $totalAmount = (float)($cab['total_fare'] ?? ($cab['fare'] ?? ($cab['amount'] ?? 0)));

            // Night Surcharge: Only apply if explicitly > 0 or if night time hours were selected and night surcharge was applicable
            $rawNightSurcharge = (float)($cab['night_surcharge'] ?? 0);
            $isNightPickupTime = isset($cab['pickup_time']) && (
                str_contains(strtolower($cab['pickup_time']), '10:00 pm') ||
                str_contains(strtolower($cab['pickup_time']), '11:00 pm') ||
                str_contains(strtolower($cab['pickup_time']), '12:00 am') ||
                str_contains(strtolower($cab['pickup_time']), '01:00 am') ||
                str_contains(strtolower($cab['pickup_time']), '02:00 am') ||
                str_contains(strtolower($cab['pickup_time']), '03:00 am') ||
                str_contains(strtolower($cab['pickup_time']), '04:00 am')
            );

            $nightFee = 0.0;
            if ($rawNightSurcharge > 0) {
                $nightFee = $rawNightSurcharge;
            } elseif ($isNightPickupTime && !isset($cab['night_surcharge'])) {
                $nightFee = 100.0 * $cabVehicleCount;
            }

            $baseFare = max(0, $totalAmount - $nightFee);

            // Per-cab rate breakdown for multi-cab bookings
            $perCabRate = ($cabVehicleCount > 0) ? round($baseFare / $cabVehicleCount, 2) : $baseFare;

            $items = [
                [
                    'sl' => 1,
                    'particulars' => $cabRouteLabel,
                    'desc' => $cabVehicleCount > 1 ? "Total {$cabVehicleCount} vehicles scheduled for dedicated trip route (₹" . number_format($perCabRate, 2) . " per cab)" : '',
                    'price' => $perCabRate,
                    'qty' => $cabVehicleCount,
                    'discount' => 0.00,
                    'gst' => 0.00,
                    'total' => $baseFare
                ]
            ];

            if ($nightFee > 0) {
                $perCabNight = round($nightFee / $cabVehicleCount, 2);
                $items[] = [
                    'sl' => 2,
                    'particulars' => '🌙 Night Travel Service Surcharge (10:00 PM - 05:00 AM)',
                    'desc' => 'Mandatory night travel operational fee for late night & early morning pickup' . ($cabVehicleCount > 1 ? " (₹" . number_format($perCabNight, 2) . " × {$cabVehicleCount} Cabs)" : ''),
                    'price' => $perCabNight,
                    'qty' => $cabVehicleCount,
                    'discount' => 0.00,
                    'gst' => 0.00,
                    'total' => $nightFee
                ];
            }
            $netTotal = $totalAmount;

        } else {
            // 1. Fetch Order from MySQL shop_orders first, falling back to DataStore
            $order = null;
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('shop_orders')) {
                    if (is_numeric($id)) {
                        $dbO = \Illuminate\Support\Facades\DB::table('shop_orders')->where('id', (int)$id)->first();
                    } else {
                        $dbO = \Illuminate\Support\Facades\DB::table('shop_orders')->where('order_id', (string)$id)->first();
                    }
                    if ($dbO) {
                        $order = (array)$dbO;
                    }
                }
            } catch (\Throwable $e) {}

            if (!$order) {
                $shopOrders = DataStore::getCollection('shop_orders');
                foreach ($shopOrders as $o) {
                    if ((string)($o['id'] ?? '') === (string)$id || (string)($o['order_code'] ?? '') === (string)$id || (string)($o['order_id'] ?? '') === (string)$id) {
                        $order = $o;
                        break;
                    }
                }
                if (!$order && !empty($shopOrders)) {
                    $order = $shopOrders[0];
                }
            }

            $rawId = $order['id'] ?? $id;
            $numId = is_numeric($rawId) ? str_pad($rawId, 3, '0', STR_PAD_LEFT) : $rawId;

            $fatehaName = $order['fateha_name'] ?? null;
            $niyazDate = $order['niyaz_date'] ?? date('d M Y');
            $distributionType = !empty($order['distribution_type']) ? $order['distribution_type'] : 'Direct Handover / Self Collection at Dewa Sharif';
            $distribution_type = $distributionType;
            $isDegh = !empty($order['is_degh']) || !empty($fatehaName) || str_contains(strtolower($order['items_summary'] ?? ''), 'degh') || str_contains(strtolower($order['items_summary'] ?? ''), 'biryani') || str_contains(strtolower($order['items_summary'] ?? ''), 'zarda') || str_contains(strtolower($order['items_summary'] ?? ''), 'kheer');

            $serviceName = $isDegh ? 'Dargah Sharif Degh Niyaz & Tabarruk Service' : 'Sacred Store & Mela Souvenirs';
            $invoiceNo = ($isDegh ? 'INV-DGH-' : 'INV-SHP-') . $numId;
            $invoiceDate = \Carbon\Carbon::now('Asia/Kolkata')->format('d M Y, h:i A');

            if ($isDegh) {
                $rawNiyaz = $order['niyaz_date'] ?? date('d M Y');
                if (preg_match('/\b\d{1,2}:\d{2}\s*(?:am|pm)?\b/i', $rawNiyaz)) {
                    try {
                        $serviceDate = \Carbon\Carbon::parse($rawNiyaz)->format('d M Y, h:i A');
                    } catch (\Throwable $e) {
                        $serviceDate = $rawNiyaz;
                    }
                } else {
                    try {
                        $serviceDate = \Carbon\Carbon::parse($rawNiyaz)->format('d M Y') . ', 12:00 PM';
                    } catch (\Throwable $e) {
                        $serviceDate = $rawNiyaz . ', 12:00 PM';
                    }
                }
                $niyazDate = $serviceDate;
            } else {
                $serviceDate = $invoiceDate;
            }
            $orderNo = $order['order_code'] ?? ($order['order_id'] ?? (($isDegh ? 'ORD-DGH-' : 'ORD-SHP-') . $numId));
            $paymentId = $order['payment_id'] ?? ('pay_SHP_' . substr(md5($id), 0, 10));

            if (!empty($order['customer_name'])) $customerName = $order['customer_name'];
            if (!empty($order['customer_phone'])) $customerPhone = $order['customer_phone'];
            if (!empty($order['alternate_phone'])) {
                $customerAltPhone = $order['alternate_phone'];
            } elseif (!empty($order['customer_whatsapp']) && $order['customer_whatsapp'] !== ($order['customer_phone'] ?? '')) {
                $customerAltPhone = $order['customer_whatsapp'];
            }
            if (!empty($order['shipping_address'])) $customerAddress = $order['shipping_address'];
            elseif (!empty($order['address'])) $customerAddress = $order['address'];
            elseif (!empty($order['customer_address'])) $customerAddress = $order['customer_address'];
            $customerEmail = !empty($order['customer_email']) ? $order['customer_email'] : (!empty($order['email']) ? $order['email'] : null);
            $paymentStatus = $order['payment_status'] ?? ($order['status'] ?? 'paid');

            $totalAmount = (float)($order['total_amount'] ?? ($order['amount'] ?? 1497));
            $subtotal = (float)($order['subtotal'] ?? 0);
            $handlingFee = (float)($order['handling_fee'] ?? 0);
            $packagingFee = (float)($order['packaging_fee'] ?? 0);
            $distributionFee = (float)($order['distribution_fee'] ?? 0);
            $deliveryFee = (float)($order['delivery_fee'] ?? 0);
            $codFee = (float)($order['cod_fee'] ?? 0);
            $deliveryTier = trim($order['delivery_tier'] ?? 'standard_courier');

            // 2. Decode Cart Items from cart_items_json or shop_order_items
            $cartItems = [];
            if (!empty($order['cart_items_json'])) {
                $rawJson = $order['cart_items_json'];
                $decoded = is_array($rawJson) ? $rawJson : json_decode($rawJson, true);
                if (is_array($decoded) && !empty($decoded)) {
                    $cartItems = $decoded;
                }
            }

            if (empty($cartItems) && !empty($order['id'])) {
                try {
                    if (\Illuminate\Support\Facades\Schema::hasTable('shop_order_items')) {
                        $dbItems = \Illuminate\Support\Facades\DB::table('shop_order_items')
                            ->where('order_id', $order['id'])
                            ->get();
                        if ($dbItems->isNotEmpty()) {
                            foreach ($dbItems as $dbi) {
                                $cartItems[] = [
                                    'name' => $dbi->product_name,
                                    'price' => (float)$dbi->unit_price,
                                    'qty' => (int)$dbi->quantity
                                ];
                            }
                        }
                    }
                } catch (\Throwable $e) {}
            }

            // 3. Assemble Itemized Bill Line Items
            $items = [];
            $sl = 1;

            if (!empty($cartItems)) {
                foreach ($cartItems as $cItem) {
                    $iPrice = (float)($cItem['price'] ?? 0);
                    $iQty = max(1, (int)($cItem['qty'] ?? 1));
                    $items[] = [
                        'sl' => $sl++,
                        'particulars' => $cItem['name'] ?? 'Sacred Item',
                        'desc' => 'Sacred Store Offering | Quantity: ' . $iQty . ' | Unit: ₹' . number_format($iPrice, 2),
                        'price' => $iPrice,
                        'qty' => $iQty,
                        'discount' => 0.00,
                        'gst' => 0.00,
                        'total' => $iPrice * $iQty
                    ];
                }
            } else {
                $particularTitle = $order['items_summary'] ?? ($isDegh ? 'Warsi Shahi Degh Niyaz Tabarruk' : 'Sacred Store Attar & Sufi Handicrafts Package');
                $particularDesc = $isDegh 
                    ? ('Fateha Ba-Naam: ' . ($fatehaName ?: 'Special Dua & Fateha') . ' | Distribution: ' . $distributionType . ' | Parcel Packing: Ready')
                    : ('Courier Partner: ' . ($order['courier_name'] ?? ($order['courier'] ?? 'DTDC Express')) . ' | Tracking: ' . ($order['tracking_number'] ?? ($order['tracking'] ?? 'DT78459203IN')));

                $basePrice = ($subtotal > 0) ? $subtotal : max(0, $totalAmount - $handlingFee - $packagingFee - $distributionFee - $deliveryFee - $codFee);
                if ($basePrice <= 0) $basePrice = $totalAmount;

                $items[] = [
                    'sl' => $sl++,
                    'particulars' => $particularTitle,
                    'desc' => $particularDesc,
                    'price' => $basePrice,
                    'qty' => 1,
                    'discount' => 0.00,
                    'gst' => 0.00,
                    'total' => $basePrice
                ];
            }

            // Packaging Fee Line Item
            $pkgType = strtolower($order['packaging_type'] ?? '');
            $isComplimentary = ($pkgType === 'complimentary' || str_contains($pkgType, 'complimentary'));

            if ($packagingFee > 0 || $isComplimentary) {
                $particulars = '📦 Safe Transit Protective Packaging & Box Fee';
                $desc = 'Multi-layered tamper-evident sacred parcel box & safe transit cushioning';

                if ($isComplimentary) {
                    $particulars = '🎁 Special Devotee Complimentary Packaging';
                    $desc = 'Hygienic sealed packaging provided complimentary as sacred courtesy (₹0 Extra Charge)';
                } elseif ($pkgType === 'polythin' || str_contains($pkgType, 'polythin')) {
                    $particulars = '🛍️ Food-Grade Polythin Pouches Packaging Fee';
                    $desc = 'Food-grade hygienic sealed polythin pouches for Degh Niyaz distribution';
                } elseif ($pkgType === 'box' || str_contains($pkgType, 'box') || str_contains($pkgType, 'dabba')) {
                    $particulars = '🍱 Container Box / Dabba Distribution Packaging Fee';
                    $desc = 'Hygienic disposable meal container boxes for dignified Degh Niyaz distribution';
                } elseif ($pkgType === 'katori' || (str_contains($pkgType, 'katori') && !str_contains($pkgType, 'mitti'))) {
                    $particulars = '🥣 Disposable Katori Bowls Packaging Fee';
                    $desc = 'Hygienic single-use disposable bowls for Kheer Niyaz distribution';
                } elseif ($pkgType === 'mitti_katori' || str_contains($pkgType, 'mitti')) {
                    $particulars = '🏺 Sacred Mitti Katori Bowls Packaging Fee';
                    $desc = 'Traditional sacred clay earthen bowls for authentic Kheer Niyaz tabarruk';
                } elseif ($isDegh) {
                    $particulars = '📦 Custom Degh Packaging & Distribution Fee';
                    $desc = 'Special packaging arrangement as specified in order';
                }

                $items[] = [
                    'sl' => $sl++,
                    'particulars' => $particulars,
                    'desc' => $desc,
                    'price' => $packagingFee,
                    'qty' => 1,
                    'discount' => 0.00,
                    'gst' => 0.00,
                    'total' => $packagingFee
                ];
            }

            // Distribution Service Fee Line Item
            if ($distributionFee > 0) {
                $items[] = [
                    'sl' => $sl++,
                    'particulars' => '🕌 Dargah Sharif Langar Taqseem & Managed Distribution Service',
                    'desc' => 'Dewa Sharif Management verified sacred distribution service to Zaireen & needy devotees at Dargah Sharif',
                    'price' => $distributionFee,
                    'qty' => 1,
                    'discount' => 0.00,
                    'gst' => 0.00,
                    'total' => $distributionFee
                ];
            }

            // Handling Fee Line Item
            if ($handlingFee > 0) {
                $items[] = [
                    'sl' => $sl++,
                    'particulars' => '🛡️ Order Handling & Transit Insurance Fee',
                    'desc' => 'Quality inspection, fragile item handling and sacred dispatch care',
                    'price' => $handlingFee,
                    'qty' => 1,
                    'discount' => 0.00,
                    'gst' => 0.00,
                    'total' => $handlingFee
                ];
            }

            // Delivery Tier Line Item
            $deliveryName = '🚚 Standard Courier Delivery';
            $deliveryDesc = 'Courier: ' . ($order['courier_name'] ?? ($order['courier'] ?? 'DTDC Express / Shiprocket')) . ' | Tracking: ' . ($order['tracking_number'] ?? ($order['tracking'] ?? 'Generated on dispatch'));
            if ($deliveryTier === 'express_2_4h') {
                $deliveryName = '⚡ Dewa Sharif Superfast Express Delivery (2–4 Hours)';
                $deliveryDesc = 'Urgent Local Express Rider • Direct Hand Delivery to Home, Hotel or Astana';
            } elseif ($deliveryTier === 'local_24h') {
                $deliveryName = '🕒 Dewa Sharif Normal Local Delivery (Within 24 Hours)';
                $deliveryDesc = 'Dewa Sharif Town Area standard local hand delivery staff';
            } elseif ($isDegh) {
                $deliveryName = '🕌 Dargah Sharif Langar Khidmat / Distribution';
                $deliveryDesc = 'Prepared and distributed at Dargah Sharif to Zaireen & Devotees';
            }

            if ($deliveryFee > 0) {
                $items[] = [
                    'sl' => $sl++,
                    'particulars' => $deliveryName,
                    'desc' => $deliveryDesc,
                    'price' => $deliveryFee,
                    'qty' => 1,
                    'discount' => 0.00,
                    'gst' => 0.00,
                    'total' => $deliveryFee
                ];
            } elseif (!$isDegh) {
                $items[] = [
                    'sl' => $sl++,
                    'particulars' => $deliveryName . ' (FREE Delivery Applied)',
                    'desc' => 'Standard shipping charges waived under store promotion offer',
                    'price' => 0.00,
                    'qty' => 1,
                    'discount' => 0.00,
                    'gst' => 0.00,
                    'total' => 0.00
                ];
            }

            // Cash on Delivery Fee Line Item
            if ($codFee > 0) {
                $items[] = [
                    'sl' => $sl++,
                    'particulars' => '💵 Cash on Delivery (COD) Convenience Surcharge',
                    'desc' => 'Doorstep cash collection and courier settlement charge',
                    'price' => $codFee,
                    'qty' => 1,
                    'discount' => 0.00,
                    'gst' => 0.00,
                    'total' => $codFee
                ];
            }

            $computedTotal = array_sum(array_column($items, 'total'));
            $netTotal = ($totalAmount > 0) ? $totalAmount : $computedTotal;
        }

        if ($type === 'hotel') {
            $paidAmount = (float)($booking['paid_amount'] ?? (in_array(strtolower($paymentStatus), ['paid', 'completed']) ? $netTotal : 0));
            $paymentMode = $booking['payment_mode'] ?? null;
        } elseif ($type === 'cab') {
            $paidAmount = (float)($cab['paid_amount'] ?? (in_array(strtolower($paymentStatus), ['paid', 'completed']) ? $netTotal : 0));
            $paymentMode = $cab['payment_mode'] ?? null;
        } else {
            $paidAmount = isset($order['paid_amount']) ? (float)$order['paid_amount'] : (in_array(strtolower($paymentStatus), ['paid', 'completed']) ? $netTotal : 0);
            $paymentMode = $order['payment_mode'] ?? null;
        }
        $dueAmount = max(0, $netTotal - $paidAmount);

        $cabParking = \App\Helpers\DataStore::getItem('cab_parking_policy', 1) ?? ['status' => 'Active'];
        $isCabParkingActive = ($cabParking['status'] ?? 'Active') === 'Active';
        $parkingInvoiceMsg = ($type === 'cab' && $isCabParkingActive)
            ? "🅿️ *Parking Note:* Airport 10m free; extra airport/monument parking on actual receipt.\n"
            : "";

        $pinMsg = ($type === 'hotel' && !empty($checkinPin)) ? ("\n🔐 *Check-In Secret PIN:* {$checkinPin} (Quote at Hotel Reception)\n") : "";

        $waMsg = "📄 *TAX INVOICE / VOUCHER — " . strtoupper($type) . " #{$invoiceNo}*\n" .
                 "🏛️ *Service:* {$serviceName}\n" .
                 "👤 *Name:* {$customerName} ({$customerPhone})\n" .
                 "📅 *Date:* {$serviceDate}\n" .
                 "💰 *Amount Paid:* ₹" . number_format($paidAmount > 0 ? $paidAmount : $netTotal, 2) . ($dueAmount > 0 ? " (Advance Paid • Due: ₹" . number_format($dueAmount, 2) . ")" : " (Direct SBI Credit)") . "\n" .
                 $pinMsg .
                 $parkingInvoiceMsg .
                 (!empty($fatehaName) ? "🤲 *Fateha Ba-Naam:* {$fatehaName}\n" : "") .
                 (!empty($distributionType) && !empty($isDegh) ? "🕌 *Taqseem:* {$distributionType}\n" : "") .
                 "🔗 *View & Download PDF:* " . url()->current();

        $cleanCustPhone = preg_replace('/[^0-9]/', '', $customerPhone);
        if (strlen($cleanCustPhone) === 10) $cleanCustPhone = '91' . $cleanCustPhone;
        $whatsappShareUrl = "https://wa.me/?text=" . urlencode($waMsg);
        $customerWhatsappUrl = "https://wa.me/{$cleanCustPhone}?text=" . urlencode($waMsg);

        $cabData = ($type === 'cab') ? $cab : null;
        $hotelData = ($type === 'hotel') ? ($booking ?? null) : null;
        $checkinPin = $checkinPin ?? ($hotelData['checkin_pin'] ?? null);
        $packagingFee = $packagingFee ?? 0;
        $packagingType = $order['packaging_type'] ?? null;

        return view('home.customer.invoice', compact(
            'type', 'id', 'serviceName', 'invoiceNo', 'invoiceDate', 'serviceDate', 'orderNo', 'paymentId',
            'customerName', 'customerEmail', 'customerPhone', 'customerAltPhone', 'customerAddress', 'idInfo',
            'items', 'netTotal', 'paidAmount', 'dueAmount', 'paymentMode', 'fatehaName', 'niyazDate', 'distributionType', 'distribution_type', 'isDegh',
            'whatsappShareUrl', 'customerWhatsappUrl', 'cabData', 'hotelData', 'paymentStatus', 'checkinPin',
            'packagingFee', 'packagingType', 'distributionFee', 'order'
        ));
    }

    public function reviews()
    {
        $profile = $this->getCustomerProfile();
        $userId = auth()->id();
        $userPhone = $profile['phone'] ?? '';
        $cleanPhone = preg_replace('/[^0-9]/', '', $userPhone);

        $myReviews = \Illuminate\Support\Facades\DB::table('reviews')
            ->where(function($q) use ($userId, $cleanPhone, $userPhone) {
                if ($userId) {
                    $q->where('user_id', $userId);
                }
                if (!empty($cleanPhone)) {
                    $q->orWhere('customer_phone', 'like', "%{$cleanPhone}%")
                      ->orWhere('customer_phone', $userPhone);
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();

        if ($myReviews->isEmpty()) {
            $myReviews = \Illuminate\Support\Facades\DB::table('reviews')->take(4)->get();
        }

        return view('home.customer.reviews', compact('myReviews', 'profile'));
    }

    public function updateReview(Request $request, $id)
    {
        $rating = (int)$request->input('rating', 5);
        $title = trim($request->input('title', ''));
        $comment = trim($request->input('comment', ''));

        \Illuminate\Support\Facades\DB::table('reviews')->where('id', $id)->update([
            'rating' => $rating,
            'title' => $title,
            'comment' => $comment,
            'updated_at' => now()
        ]);

        return back()->with('success', 'Your review has been updated successfully!');
    }

    public function destroyReview($id)
    {
        \Illuminate\Support\Facades\DB::table('reviews')->where('id', $id)->delete();
        return back()->with('success', 'Your review has been removed.');
    }

    public function cancelHotelBooking(Request $request, $id)
    {
        $all = DataStore::getCollection('hotel_bookings');
        $booking = null;
        foreach ($all as $b) {
            $bId = is_array($b) ? ($b['id'] ?? null) : ($b->id ?? null);
            if ((string)$bId === (string)$id) {
                $booking = $b;
                break;
            }
        }

        if (!$booking) {
            return back()->with('error', 'Booking record not found.');
        }

        $currentStatus = strtolower(is_array($booking) ? ($booking['status'] ?? '') : ($booking->status ?? ''));
        if (str_contains($currentStatus, 'cancel')) {
            return back()->with('error', 'This hotel booking is already cancelled.');
        }

        $totalFare = (float)(is_array($booking) ? ($booking['total_amount'] ?? ($booking['amount'] ?? 0)) : ($booking->total_amount ?? ($booking->amount ?? 0)));
        $checkinStr = is_array($booking) ? ($booking['check_in'] ?? ($booking['checkin'] ?? date('Y-m-d'))) : ($booking->check_in ?? ($booking->checkin ?? date('Y-m-d')));
        
        $checkinTimestamp = strtotime($checkinStr);
        if (!$checkinTimestamp) { $checkinTimestamp = time() + 86400; }
        
        $diffHours = ($checkinTimestamp - time()) / 3600;

        // Tiered Cancellation Rules:
        // >= 48 hours (2+ days prior): 40% penalty (Admin 20%, Hotel 20%), 60% refund
        // 24 to 48 hours (1 day prior): 60% penalty (Admin 30%, Hotel 30%), 40% refund
        // < 24 hours (same day): 80% penalty (Admin 40%, Hotel 40%), 20% refund
        if ($diffHours >= 48) {
            $penaltyPct = 40.0;
            $refundPct = 60.0;
        } elseif ($diffHours >= 24) {
            $penaltyPct = 60.0;
            $refundPct = 40.0;
        } else {
            $penaltyPct = 80.0;
            $refundPct = 20.0;
        }

        $penaltyTotal = round($totalFare * ($penaltyPct / 100), 2);
        $refundAmount = round($totalFare * ($refundPct / 100), 2);
        
        // 50-50 split of the penalty between Admin and Hotel Partner
        $adminPenaltyShare = round($penaltyTotal / 2, 2);
        $hotelPenaltyShare = round($penaltyTotal / 2, 2);

        $reason = trim($request->input('cancellation_reason', 'Customer requested cancellation via portal'));

        $updateData = [
            'status' => 'Cancelled by Customer (Refund Pending)',
            'hotel_status' => 'cancelled',
            'booking_status' => 'cancelled',
            'cancellation_fee_total' => $penaltyTotal,
            'cancellation_admin_share' => $adminPenaltyShare,
            'cancellation_hotel_share' => $hotelPenaltyShare,
            'cancellation_customer_refund' => $refundAmount,
            'cancellation_reason' => $reason,
            'cancelled_at' => now()->toDateTimeString(),
            'refund_status' => ($refundAmount > 0) ? 'pending' : 'none',
        ];

        DataStore::updateItem('hotel_bookings', $id, $updateData);

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('hotel_bookings')) {
                $dbCols = \Illuminate\Support\Facades\Schema::getColumnListing('hotel_bookings');
                $dbUpdate = array_intersect_key(array_merge($updateData, ['updated_at' => now()]), array_flip($dbCols));
                \Illuminate\Support\Facades\DB::table('hotel_bookings')->where('id', $id)->update($dbUpdate);
            }
        } catch (\Throwable $e) {}

        // Release inventory back to hotel
        try {
            $hId = is_array($booking) ? ($booking['hotel_id'] ?? null) : ($booking->hotel_id ?? null);
            if ($hId) {
                $roomsCount = (int)(is_array($booking) ? ($booking['rooms'] ?? ($booking['rooms_count'] ?? 1)) : ($booking->rooms ?? 1));
                $hotel = \App\Models\Hotel::find($hId);
                if ($hotel) {
                    $hotel->increment('available_rooms', $roomsCount);
                }
            }
        } catch (\Throwable $e) {}

        $refundNotice = ($refundAmount > 0)
            ? "Your refund of ₹" . number_format($refundAmount, 2) . " ({$refundPct}%) has been queued. DewaSharif Admin will process the transfer directly to your original payment method."
            : "Booking cancelled.";

        return back()->with('success', "Reservation #{$id} has been cancelled successfully. {$refundNotice}");
    }
}
