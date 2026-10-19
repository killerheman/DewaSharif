<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DomainRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $domain = $this->route('domain');

        return [

            'extension' => 'required|string|max:20|unique:domains,extension,' . ($domain?->id),

            'register_price' => 'required|numeric|min:0',

            'renewal_price' => 'required|numeric|min:0',

            'transfer_price' => 'required|numeric|min:0',

            'bulk_transfer_price' => 'nullable|numeric|min:0',

            'offer' => 'nullable|string|max:255',

            'description' => 'nullable|string',

            /* Future API */

            'registrar' => 'nullable|string|max:100',

            'registrar_domain_id' => 'nullable|string|max:255',

            'currency' => 'required|string|max:10',

            'min_year' => 'required|integer|min:1|max:10',

            'max_year' => 'required|integer|min:1|max:20|gte:min_year',

            'is_premium' => 'required|boolean',

            'privacy_protection' => 'required|boolean',

            'dns_management' => 'required|boolean',

            'email_forwarding' => 'required|boolean',

            /* SEO */

            'meta_title' => 'nullable|string|max:255',

            'meta_description' => 'nullable|string',

            'meta_keywords' => 'nullable|string',

            'image_alt' => 'nullable|string|max:255',

            'image_title' => 'nullable|string|max:255',

            /* Common */

            'sort_order' => 'nullable|integer|min:0',

            'is_active' => 'required|boolean',

        ];
    }
}