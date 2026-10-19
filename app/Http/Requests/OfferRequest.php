<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'title' => 'required|string|max:255',

            'message' => 'required|string',

            'type' => 'required|in:common,individual',

            'user_id' => 'nullable|exists:users,id',

            'start_date' => 'nullable|date',

            'end_date' => 'nullable|date|after_or_equal:start_date',

            'show_before_login' => 'nullable|boolean',

            'show_after_login' => 'nullable|boolean',

            'is_active' => 'required|boolean',

        ];
    }
}