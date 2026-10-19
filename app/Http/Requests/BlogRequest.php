<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $blog = $this->route('blog');

        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'image' => ($this->isMethod('post') ? 'required' : 'nullable').'|image|mimes:jpg,jpeg,png,webp|max:5120',
            'description' => 'nullable|string',
            'date' => 'nullable|date',

            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'image_alt' => 'nullable|string|max:255',
            'image_title' => 'nullable|string|max:255',

            'sort_order' => 'nullable|integer|min:1',
            'is_active' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Blog image is required.',
            'image.image' => 'Please upload a valid image.',
            'image.max' => 'Blog image must not exceed 5 MB.',
            'image.mimes' => 'Blog image must be a file of type: jpg, jpeg, png, webp.',
        ];
    }
}