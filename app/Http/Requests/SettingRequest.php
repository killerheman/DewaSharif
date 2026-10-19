<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules.
     */
    public function rules(): array
    {
        return [

            // General
            'website_name' => 'nullable|string|max:255',
            'website_url' => 'nullable|url|max:255',
            'website_email' => 'nullable|email|max:255',
            'website_phone' => 'nullable|string|max:20',
            'timezone' => 'nullable|string|max:100',
            'daily_backup_fee' => 'nullable|numeric|min:0',
            'domain_privacy_fee' => 'nullable|numeric|min:0',
            'server_backup_fee' => 'nullable|numeric|min:0',
            'server_security_fee' => 'nullable|numeric|min:0',
            'promo_bar_enabled' => 'nullable|boolean',
            'promo_bar_text' => 'nullable|string|max:500',
            'promo_bar_coupon' => 'nullable|string|max:100',
            'key_capabilities_heading' => 'nullable|string|max:255',
            'key_capabilities_desc' => 'nullable|string',
            'key_capabilities_items' => 'nullable|array',
            'key_capabilities_items.*.icon' => 'nullable|string|max:255',
            'key_capabilities_items.*.heading' => 'nullable|string|max:255',
            'key_capabilities_items.*.desc' => 'nullable|string',
            'copyright' => 'nullable|string|max:255',

            // Company
            'company_name' => 'nullable|string|max:255',
            'gst_number' => 'nullable|string|max:100',
            'pan_number' => 'nullable|string|max:100',
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'footer_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:5120',
            'favicon' => 'nullable|image|mimes:ico,png,jpg,jpeg,webp|max:5120',

            // Contact
            'support_email' => 'nullable|email|max:255',
            'sales_email' => 'nullable|email|max:255',
            'billing_email' => 'nullable|email|max:255',
            'support_phone' => 'nullable|string|max:20',
            'sales_phone' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'google_map' => 'nullable|string',
            'office_hours' => 'nullable|string|max:255',

            // Social
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',

            // Payment
            'razorpay_key' => 'nullable|string|max:255',
            'razorpay_secret' => 'nullable|string|max:255',
            'paypal_client_id' => 'nullable|string|max:255',
            'paypal_secret' => 'nullable|string|max:255',
            'phonepe_merchant_id' => 'nullable|string|max:255',
            'phonepe_salt' => 'nullable|string|max:255',
            'payu_key' => 'nullable|string|max:255',
            'payu_salt' => 'nullable|string|max:255',

            // SEO
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'google_analytics' => 'nullable|string',
            'google_tag_manager' => 'nullable|string',
            'google_site_verification' => 'nullable|string|max:255',
            'bing_site_verification' => 'nullable|string|max:255',
            'robots' => 'nullable|string|max:100',

            // API
            'domain_api_url' => 'nullable|url|max:255',
            'domain_api_key' => 'nullable|string|max:255',
            'hosting_api_url' => 'nullable|url|max:255',
            'hosting_api_key' => 'nullable|string|max:255',
            'whois_api_key' => 'nullable|string|max:255',

            'is_active' => 'nullable|boolean',

        ];
    }

    public function messages(): array
    {
        return [
            'logo.image'        => 'Header Logo must be a valid image.',
            'logo.max'          => 'Header Logo must not exceed 5 MB.',
            'footer_logo.image' => 'Footer Logo must be a valid image.',
            'footer_logo.max'   => 'Footer Logo must not exceed 5 MB.',
            'favicon.image'     => 'Favicon must be a valid image.',
            'favicon.max'       => 'Favicon must not exceed 5 MB.',
        ];
    }
}