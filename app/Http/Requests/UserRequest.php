<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');

        return [

            'first_name'   => 'required|string|max:255',
            'last_name'    => 'nullable|string|max:255',
            'field'        => 'required|in:Company,Organization,Individual',
            'email'        => 'required|email|max:255|unique:users,email,' . ($user?->id),
            'phone'        => 'nullable|string|max:15|unique:users,phone,' . ($user?->id),

            'photo'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            'designation'  => 'nullable|string|max:255',
            'company'      => 'nullable|string|max:255',

            'gender'       => 'nullable|in:Male,Female,Other',

            'address'      => 'nullable|string',

            'country_id'  => 'nullable|exists:countries,id',
            'state_id'    => 'nullable|exists:states,id',
            'city_id'     => 'nullable|exists:cities,id',

            'postal_code' => 'nullable|string|max:20',

            'bio'         => 'nullable|string',

            'is_active'   => 'required|boolean',

            'password' => $this->isMethod('post')
                ? 'required|string|min:4|confirmed'
                : 'nullable|string|min:4|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'photo.image' => 'Please upload a valid image.',
            'photo.max' => 'User photo must not exceed 5 MB.',
            'photo.mimes' => 'User photo must be a file of type: jpg, jpeg, png, webp.',
        ];
    }
}
