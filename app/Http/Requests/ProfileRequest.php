<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [

            'first_name' => [
                'required',
                'string',
                'max:255',
            ],

            'last_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'field' => [
                'required',
                'in:Individual,Company,Organization',
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'phone' => [
                'nullable',
                'regex:/^[0-9+\-\s()]+$/',
                'digits_between:10,15',
            ],

            'designation' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company' => [
                'nullable',
                'string',
                'max:255',
            ],

            'gender' => [
                'nullable',
                'in:Male,Female,Other',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'country' => [
                'nullable',
                'string',
                'max:100',
            ],

            'state' => [
                'nullable',
                'string',
                'max:100',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'postal_code' => [
                'nullable',
                'string',
                'max:20',
            ],

            'bio' => [
                'nullable',
                'string',
                'max:1000',
            ],

        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
{
    return [

        'first_name.required' => 'First Name is required.',

        'gender.in' => 'Please select a valid gender.',

        'photo.image' => 'Please upload a valid image.',

        'photo.max' => 'Profile photo must not exceed 5 MB.',

        'photo.uploaded' => 'File size exceeds PHP server upload limit. Please increase upload_max_filesize in php.ini.',

        'phone.digits_between' => 'Phone number must be between 10 and 15 digits.',

    ];
}
}
