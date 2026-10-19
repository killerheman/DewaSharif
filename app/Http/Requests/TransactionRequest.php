<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'invoice_id' => 'nullable|exists:invoices,id',

            'invoice_no' => 'nullable|string|max:100',

            'gateway' => 'required|string|max:100',
            'gateway_type' => 'required|in:Razorpay,PayPal',

            'order_id' => 'nullable|string|max:255',
            'payment_id' => 'nullable|string|max:255',
            'transaction_id' => 'nullable|string|max:255',

            'amount' => 'required|numeric|min:0',
            'gst' => 'nullable|numeric|min:0',
            'vendor_amount' => 'nullable|numeric|min:0',
            'net_amount' => 'required|numeric|min:0',

            'currency' => 'required|string|max:10',

            'payment_status' => 'required|in:Pending,Paid,Failed,Refunded',

            'response' => 'nullable|array',

            'paid_at' => 'nullable|date',

            'is_active' => 'required|boolean',
        ];
    }
}