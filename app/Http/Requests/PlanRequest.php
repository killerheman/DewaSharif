<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name'             => 'required',
            'offer_percentage' => 'nullable|integer',
            'price'            => 'required|numeric',
            'period'           => 'required|in:month,year',
            'description'      => 'nullable|string',
            'common_id'        => 'required|integer',
            'common_type'      => 'required|string',
            'sort_order'       => 'nullable|integer',
            'is_active'        => 'nullable',
        ];
    }
}
