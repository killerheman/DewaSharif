<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MetaWhatsAppService
{
    /**
     * Get dynamic Meta WhatsApp Cloud API credentials
     */
    public static function getCredentials(): array
    {
        $token = \App\Models\Setting::getVal('whatsapp_token', env('WHATSAPP_TOKEN'));
        $phoneId = \App\Models\Setting::getVal('whatsapp_phone_number_id', env('WHATSAPP_PHONE_NUMBER_ID'));
        return [$token, $phoneId];
    }

    /**
     * Send Custom Booking Confirmation Message via Meta WhatsApp Cloud API
     */
    public static function sendCustomMessage($toPhone, $booking, $type = 'Booking')
    {
        [$token, $phoneId] = static::getCredentials();

        if (empty($token) || empty($phoneId)) {
            Log::warning('WhatsApp Token or Phone ID missing in Settings and .env');
            return false;
        }

        // Clean and format phone number (India +91 prefix)
        $cleanPhone = preg_replace('/[^0-9]/', '', (string)$toPhone);
        if (strlen($cleanPhone) === 10) {
            $cleanPhone = '91' . $cleanPhone;
        }

        // Helper to extract property from array or object
        $getProp = function($key, $default = '') use ($booking) {
            if (is_array($booking)) {
                return $booking[$key] ?? $default;
            } elseif (is_object($booking)) {
                return $booking->{$key} ?? $default;
            }
            return $default;
        };

        $custName = $getProp('customer_name', $getProp('name', 'Pilgrim Guest'));
        $code = $getProp('booking_code', $getProp('order_code', $getProp('booking_id', '#DWS-2026')));
        $amount = $getProp('amount', $getProp('total_amount', $getProp('price', $getProp('fare', 0))));
        $invoiceUrl = route('customer.dashboard');

        // DewaSharif Custom Message Design
        $messageText = "🌙 *DewaSharif.com — {$type} Confirmed!*\n\n"
                     . "Dear *{$custName}*,\n"
                     . "Aapki *{$type}* successfully confirm ho chuki hai!\n\n"
                     . "📋 *Booking Code:* {$code}\n"
                     . "💰 *Paid Amount:* ₹" . number_format((float)$amount) . "\n"
                     . "📌 *Payment Status:* Paid & Verified (SBI Account)\n\n"
                     . "Aap apni booking ki poori details & Tax Invoice PDF dashboard par dekh sakte hain:\n"
                     . "🔗 " . $invoiceUrl . "\n\n"
                     . "Shukriya DewaSharif.com par visit karne ke liye! 🙏";

        $url = "https://graph.facebook.com/v17.0/{$phoneId}/messages";

        try {
            $response = Http::withToken($token)->post($url, [
                'messaging_product' => 'whatsapp',
                'to' => $cleanPhone,
                'type' => 'text',
                'text' => [
                    'body' => $messageText
                ]
            ]);

            if ($response->failed()) {
                Log::error('Meta WhatsApp Custom Message Error: ' . $response->body());
                return false;
            }

            Log::info("Meta WhatsApp Message sent successfully to {$cleanPhone} for {$code}");
            return true;
        } catch (\Throwable $e) {
            Log::error('Meta WhatsApp Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send Cab Driver & Vehicle Assignment Alert via Meta WhatsApp Cloud API
     */
    public static function sendDriverAssignmentMessage($toPhone, $booking)
    {
        [$token, $phoneId] = static::getCredentials();

        if (empty($token) || empty($phoneId)) {
            Log::warning('WhatsApp Token or Phone ID missing in Settings and .env');
            return false;
        }

        $cleanPhone = preg_replace('/[^0-9]/', '', (string)$toPhone);
        if (strlen($cleanPhone) === 10) {
            $cleanPhone = '91' . $cleanPhone;
        }

        $getProp = function($key, $default = '') use ($booking) {
            if (is_array($booking)) {
                return $booking[$key] ?? $default;
            } elseif (is_object($booking)) {
                return $booking->{$key} ?? $default;
            }
            return $default;
        };

        $custName = $getProp('customer_name', $getProp('passenger_name', 'Passenger'));
        $code = $getProp('booking_code', '#DWS-CAB-2026');
        $driverName = $getProp('driver_name', 'Assigned Driver');
        $driverPhone = $getProp('driver_phone', '9876543210');
        $vehicleNo = $getProp('driver_vehicle_number', 'UP 32 AB 1234');
        $vehicleType = $getProp('vehicle_type', 'Swift Dzire (AC)');
        $pickupTime = $getProp('pickup_time', 'As per booking date');
        $route = $getProp('route', 'Dewa Sharif Taxi Route');

        $messageText = "🚖 *DEWA SHARIF CABS — DRIVER & VEHICLE ASSIGNED*\n\n"
                     . "Dear *{$custName}*,\n"
                     . "Aapki Cab Ride ki Driver & Vehicle Details allocate kar di gayi hain:\n\n"
                     . "🎫 *Booking Code:* {$code}\n"
                     . "📍 *Route:* {$route}\n"
                     . "📅 *Pickup Date & Time:* {$pickupTime}\n\n"
                     . "👨‍✈️ *Driver Name:* {$driverName}\n"
                     . "📱 *Driver Mobile:* {$driverPhone}\n"
                     . "🔢 *Vehicle No Plate:* {$vehicleNo} ({$vehicleType})\n\n"
                     . "Kripya pickup time se 15 minute pehle taiyar rahein. Have a safe & pleasant trip! 🙏";

        $url = "https://graph.facebook.com/v17.0/{$phoneId}/messages";

        try {
            $response = Http::withToken($token)->post($url, [
                'messaging_product' => 'whatsapp',
                'to' => $cleanPhone,
                'type' => 'text',
                'text' => [
                    'body' => $messageText
                ]
            ]);

            if ($response->failed()) {
                Log::error('Meta WhatsApp Driver Alert Error: ' . $response->body());
                return false;
            }

            Log::info("Meta WhatsApp Driver Alert sent successfully to {$cleanPhone} for {$code}");
            return true;
        } catch (\Throwable $e) {
            Log::error('Meta WhatsApp Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send Live Test Message via Meta WhatsApp Cloud API
     */
    public static function sendTestMessage($toPhone)
    {
        [$token, $phoneId] = static::getCredentials();

        if (empty($token) || empty($phoneId)) {
            return [
                'success' => false,
                'message' => 'WhatsApp Token or Phone Number ID is missing. Please save valid credentials in WhatsApp Settings.'
            ];
        }

        // Clean phone number (format to country code without +, default India 91 if 10 digits)
        $cleanPhone = preg_replace('/[^0-9]/', '', (string)$toPhone);
        if (strlen($cleanPhone) === 10) {
            $cleanPhone = '91' . $cleanPhone;
        }

        $siteName = 'DewaSharif.com';
        $messageText = "🌙 *{$siteName} — WhatsApp Cloud API Live Test*\n\n"
                     . "Assalamu Alaikum / Greetings!\n\n"
                     . "✅ Congratulations! Your Meta WhatsApp Cloud API credentials are working 100% successfully on {$siteName}.\n\n"
                     . "📱 *Phone Number ID:* {$phoneId}\n"
                     . "⏰ *Timestamp:* " . now()->format('d M Y, h:i:s A') . "\n\n"
                     . "Regards,\n*{$siteName} Technical System*";

        $url = "https://graph.facebook.com/v18.0/{$phoneId}/messages";

        try {
            $response = Http::withToken($token)->timeout(15)->post($url, [
                'messaging_product' => 'whatsapp',
                'to' => $cleanPhone,
                'type' => 'text',
                'text' => [
                    'body' => $messageText
                ]
            ]);

            if ($response->failed()) {
                $errJson = $response->json();
                $errMsg = $errJson['error']['message'] ?? $response->body();
                return [
                    'success' => false,
                    'message' => "Meta API Error: {$errMsg}"
                ];
            }

            return [
                'success' => true,
                'message' => "Live test WhatsApp message sent successfully to +{$cleanPhone}! Please check your WhatsApp app."
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => "Connection Exception: " . $e->getMessage()
            ];
        }
    }
}
