<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'gateway' => 'required|in:Razorpay,PayPal',

            'display_name' => 'required|string|max:100',

            'key_id' => 'nullable|string|max:255',
            'key_secret' => 'nullable|string|max:255',

            'client_id' => 'nullable|string|max:255',
            'client_secret' => 'nullable|string|max:255',

            'merchant_id' => 'nullable|string|max:255',

            'webhook_secret' => 'nullable|string|max:255',

            'sandbox_mode' => 'required|boolean',

            'currency' => 'required|in:INR,USD',

            'is_active' => 'required|boolean',
        ];
    }
}