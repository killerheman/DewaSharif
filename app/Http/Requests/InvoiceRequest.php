<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'user_id' => 'nullable|exists:users,id',

            'invoice_no' => 'required|string|max:100',

            'payment_id' => 'nullable|string|max:255',
            'subscription_id' => 'nullable|string|max:255',

            'service_type' => 'nullable|in:Hosting,Server,Domain',
            'service_name' => 'nullable|string|max:255',

            'period' => 'nullable|string|max:100',

            'amount' => 'required|numeric|min:0',
            'gst' => 'nullable|string|max:255',
            'vendor_amount' => 'nullable|numeric|min:0',
            'net_amount' => 'required|numeric|min:0',

            'payment_status' => 'required|in:Pending,Paid,Failed,Refunded',

            'billing_address' => 'nullable|string',
            'plan_features' => 'nullable|string',

            'invoice_date' => 'nullable|date',
        ];
    }
}