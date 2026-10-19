<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $server = $this->route('server');

         return [

            'name' => 'required|string|max:255',

            'slug' => 'nullable|string|max:255',

            'banner_image_1' => 'nullable|image|max:5120',

            'banner_image_2' => 'nullable|image|max:5120',

            'banner_title' => 'required|string|max:255',

            'banner_description' => 'required|string',

            'banner_service' => 'required|string|max:255',

            'description' => 'nullable|string',

            'image' => 'nullable|image|max:5120',

            'meta_title' => 'nullable|string|max:255',

            'meta_description' => 'nullable|string',

            'meta_keywords' => 'nullable|string',

            'image_alt' => 'nullable|string|max:255',

            'image_title' => 'nullable|string|max:255',

            'sort_order' => 'nullable|integer',

            'is_active' => 'nullable|boolean',

            'key_capabilities_heading' => 'nullable|string|max:255',

            'key_capabilities_items' => 'nullable|array',

        ];
    }

    public function messages(): array
    {
        return [
            'banner_image_1.image' => 'Banner Image 1 must be a valid image.',
            'banner_image_1.max'   => 'Banner Image 1 must not exceed 5 MB.',
            'banner_image_2.image' => 'Banner Image 2 must be a valid image.',
            'banner_image_2.max'   => 'Banner Image 2 must not exceed 5 MB.',
            'image.image'          => 'Server Image must be a valid image.',
            'image.max'            => 'Server Image must not exceed 5 MB.',
        ];
    }
}
