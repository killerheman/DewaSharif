<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'thumb_image' => ($this->isMethod('post') ? 'required' : 'nullable').'|image|mimes:jpg,jpeg,png,webp|max:5120',
            'star_rating' => 'required|integer|min:1|max:5',
            'date' => 'nullable|date',

            'image_alt' => 'nullable|string|max:255',
            'image_title' => 'nullable|string|max:255',

            'sort_order' => 'nullable|integer|min:1',
            'is_active' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'thumb_image.required' => 'Testimonial photo is required.',
            'thumb_image.image'    => 'Please upload a valid image.',
            'thumb_image.max'      => 'Testimonial photo must not exceed 5 MB.',
            'thumb_image.mimes'    => 'Testimonial photo must be a file of type: jpg, jpeg, png, webp.',
        ];
    }
}