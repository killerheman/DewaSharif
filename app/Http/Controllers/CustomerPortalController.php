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
        $shopOrders = $this->sortLatest(DataStore::getCollection('shop_orders'));
        $profile = $this->getCustomerProfile();
        return view('home.customer.orders', compact('shopOrders', 'profile'));
    }

    public function billing()
    {
        $hotelBookings = DataStore::getCollection('hotel_bookings');
        $cabBookings = DataStore::getCollection('cab_bookings');
        $shopOrders = DataStore::getCollection('shop_orders');
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
                'amount' => (float)($b['total_amount'] ?? ($b['amount'] ?? 2998)),
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

            $allInvoices->push([
                'type' => 'cab',
                'id' => $rawId,
                'code' => $c['booking_code'] ?? ($c['booking_id'] ?? ('DWS-CAB-' . $rawId)),
                'invoice_no' => 'INV-CAB-' . $numId,
                'title' => ($c['route'] ?? 'Cab Duty') . ' (' . ($c['vehicle_type'] ?? 'Sedan') . ')',
                'amount' => (float)($c['total_fare'] ?? ($c['fare'] ?? 1400)),
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
                'amount' => (float)($o['total_amount'] ?? ($o['amount'] ?? 1497)),
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
        $invoiceDate = date('M d, Y');
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
            $bCheckIn = $booking['check_in'] ?? ($booking['checkin'] ?? date('d M Y'));
            $bCheckOut = $booking['check_out'] ?? ($booking['checkout'] ?? date('d M Y', strtotime('+1 day')));
            $serviceDate = $bCheckIn . ' – ' . $bCheckOut;
            $orderNo = $booking['booking_code'] ?? ($booking['booking_number'] ?? ('ORD-HOT-' . $numId));
            $paymentId = !empty($booking['utr_number']) ? ('SBI_UPI_' . $booking['utr_number']) : ($booking['payment_id'] ?? ('pay_HOT_' . substr(md5($id), 0, 10)));
            $paymentStatus = strtolower($booking['payment_status'] ?? ($booking['status'] ?? 'paid'));

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

            $totalAmount = (float)($booking['total_amount'] ?? ($booking['amount'] ?? 1499));
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
                if ((string)($c['id'] ?? '') === (string)$id) {
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
            $serviceDate = $cab['pickup_time'] ?? 'Oct 27, 2026 @ 08:30 AM';
            $orderNo = $cab['booking_code'] ?? ('ORD-CAB-' . $numId);
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

            $totalAmount = (float)($cab['total_fare'] ?? ($cab['fare'] ?? ($cab['amount'] ?? 0)));
            $hasNightCharge = !empty($cab['night_surcharge']) || (isset($cab['pickup_time']) && (
                str_contains(strtolower($cab['pickup_time']), '10:00 pm') ||
                str_contains(strtolower($cab['pickup_time']), '11:00 pm') ||
                str_contains(strtolower($cab['pickup_time']), '12:00 am') ||
                str_contains(strtolower($cab['pickup_time']), '01:00 am') ||
                str_contains(strtolower($cab['pickup_time']), '02:00 am') ||
                str_contains(strtolower($cab['pickup_time']), '03:00 am') ||
                str_contains(strtolower($cab['pickup_time']), '04:00 am')
            ));

            if ($hasNightCharge) {
                $nightFee = (float)($cab['night_surcharge'] ?? 100);
                $baseFare = max(0, $totalAmount - $nightFee);
                $items = [
                    [
                        'sl' => 1,
                        'particulars' => ($cab['route'] ?? 'Lucknow Charbagh Station → Dewa Sharif') . ' (' . ($cab['vehicle_type'] ?? 'Swift Dzire Sedan') . ')',
                        'desc' => '',
                        'price' => $baseFare,
                        'qty' => 1,
                        'discount' => 0.00,
                        'gst' => 0.00,
                        'total' => $baseFare
                    ],
                    [
                        'sl' => 2,
                        'particulars' => '🌙 Night Travel Service Surcharge (10:00 PM - 05:00 AM)',
                        'desc' => 'Mandatory night travel operational fee for late night & early morning pickup',
                        'price' => $nightFee,
                        'qty' => 1,
                        'discount' => 0.00,
                        'gst' => 0.00,
                        'total' => $nightFee
                    ]
                ];
            } else {
                $items = [
                    [
                        'sl' => 1,
                        'particulars' => ($cab['route'] ?? 'Lucknow Charbagh Station → Dewa Sharif') . ' (' . ($cab['vehicle_type'] ?? 'Swift Dzire Sedan') . ')',
                        'desc' => '',
                        'price' => $totalAmount,
                        'qty' => 1,
                        'discount' => 0.00,
                        'gst' => 0.00,
                        'total' => $totalAmount
                    ]
                ];
            }
            $netTotal = $totalAmount;

        } else {
            $shopOrders = DataStore::getCollection('shop_orders');
            $order = null;
            foreach ($shopOrders as $o) {
                if ((string)($o['id'] ?? '') === (string)$id) {
                    $order = $o;
                    break;
                }
            }
            if (!$order && !empty($shopOrders)) {
                $order = $shopOrders[0];
            }

            $rawId = $order['id'] ?? $id;
            $numId = is_numeric($rawId) ? str_pad($rawId, 3, '0', STR_PAD_LEFT) : $rawId;

            $fatehaName = $order['fateha_name'] ?? null;
            $niyazDate = $order['niyaz_date'] ?? date('d M Y');
            $distributionType = $order['distribution_type'] ?? 'Dargah Sharif Me Langar Taqseem (Distribute to Zaireen)';
            $distribution_type = $distributionType;
            $isDegh = !empty($order['is_degh']) || !empty($fatehaName) || str_contains(strtolower($order['items_summary'] ?? ''), 'degh') || str_contains(strtolower($order['items_summary'] ?? ''), 'biryani') || str_contains(strtolower($order['items_summary'] ?? ''), 'zarda') || str_contains(strtolower($order['items_summary'] ?? ''), 'kheer');

            $serviceName = $isDegh ? 'Dargah Sharif Degh Niyaz & Tabarruk Service' : 'Sacred Store & Mela Souvenirs';
            $invoiceNo = ($isDegh ? 'INV-DGH-' : 'INV-SHP-') . $numId;
            $serviceDate = $isDegh ? ($niyazDate ?? date('M d, Y')) : date('M d, Y', strtotime($order['created_at'] ?? 'now'));
            $orderNo = $order['order_code'] ?? (($isDegh ? 'ORD-DGH-' : 'ORD-SHP-') . $numId);
            $paymentId = $order['payment_id'] ?? ('pay_SHP_' . substr(md5($id), 0, 10));

            if (!empty($order['customer_name'])) $customerName = $order['customer_name'];
            if (!empty($order['customer_phone'])) $customerPhone = $order['customer_phone'];
            if (!empty($order['alternate_phone'])) {
                $customerAltPhone = $order['alternate_phone'];
            } elseif (!empty($order['customer_whatsapp']) && $order['customer_whatsapp'] !== ($order['customer_phone'] ?? '')) {
                $customerAltPhone = $order['customer_whatsapp'];
            }
            if (!empty($order['address'])) $customerAddress = $order['address'];
            elseif (!empty($order['customer_address'])) $customerAddress = $order['customer_address'];
            $customerEmail = !empty($order['customer_email']) ? $order['customer_email'] : (!empty($order['email']) ? $order['email'] : null);
            $paymentStatus = $order['payment_status'] ?? ($order['status'] ?? 'paid');

            $totalAmount = (float)($order['total_amount'] ?? ($order['amount'] ?? 1497));
            $gst = 0.00;
            $price = $totalAmount;

            $particularTitle = $order['items_summary'] ?? ($isDegh ? 'Warsi Shahi Degh Niyaz Tabarruk' : 'Sacred Store Attar & Sufi Handicrafts Package');
            $particularDesc = $isDegh 
                ? ('Fateha Ba-Naam: ' . ($fatehaName ?: 'Special Dua & Fateha') . ' | Distribution: ' . $distributionType . ' | Parcel Packing: Ready')
                : ('Courier Partner: ' . ($order['courier'] ?? 'DTDC Express') . ' | Tracking: ' . ($order['tracking'] ?? 'DT78459203IN'));

            $items = [
                [
                    'sl' => 1,
                    'particulars' => $particularTitle,
                    'desc' => $particularDesc,
                    'price' => $price,
                    'qty' => 1,
                    'discount' => 0.00,
                    'gst' => $gst,
                    'total' => $totalAmount
                ]
            ];
            $netTotal = $totalAmount;
        }

        $cabParking = \App\Helpers\DataStore::getItem('cab_parking_policy', 1) ?? ['status' => 'Active'];
        $isCabParkingActive = ($cabParking['status'] ?? 'Active') === 'Active';
        $parkingInvoiceMsg = ($type === 'cab' && $isCabParkingActive)
            ? "🅿️ *Parking Note:* Airport 10m free; extra airport/monument parking on actual receipt.\n"
            : "";

        $waMsg = "📄 *TAX INVOICE / VOUCHER — " . strtoupper($type) . " #{$invoiceNo}*\n" .
                 "🏛️ *Service:* {$serviceName}\n" .
                 "👤 *Name:* {$customerName} ({$customerPhone})\n" .
                 "📅 *Date:* {$serviceDate}\n" .
                 "💰 *Amount Paid:* ₹" . number_format($netTotal, 2) . " (Direct SBI Credit)\n" .
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

        return view('home.customer.invoice', compact(
            'type', 'id', 'serviceName', 'invoiceNo', 'invoiceDate', 'serviceDate', 'orderNo', 'paymentId',
            'customerName', 'customerEmail', 'customerPhone', 'customerAltPhone', 'customerAddress', 'idInfo',
            'items', 'netTotal', 'fatehaName', 'niyazDate', 'distribution_type', 'isDegh',
            'whatsappShareUrl', 'customerWhatsappUrl', 'cabData', 'hotelData', 'paymentStatus'
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
}
