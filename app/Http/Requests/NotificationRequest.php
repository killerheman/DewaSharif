<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $notification = $this->route('notification');

        return [

            'title' => 'required|string|max:255',

            'message' => 'required|string',

            'type' => 'required|in:common,individual',

            'user_id' => 'nullable|exists:users,id',

            'start_date' => 'nullable|date',

            'end_date' => 'nullable|date|after_or_equal:start_date',

            'is_active' => 'required|boolean',

        ];
    }
}