<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportIssueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'subject' => 'subject',
            'message' => 'message',
        ];
    }
}
