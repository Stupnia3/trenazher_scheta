<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'last_name'   => ['required', 'string'],
            'first_name'  => ['required', 'string'],
            'middle_name' => ['nullable', 'string'],
            'parent_name' => ['nullable', 'string'],
            'parent_surname' => ['nullable', 'string'],
            'email'       => ['required', 'string', 'email'],
            'password'    => ['required', 'string', 'confirmed', 'min:8', 'max:255'],
            'profile_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }

    public function attributes(): array
    {
        return [
            'last_name'   => 'отчество',
            'first_name'  => 'имя',
            'middle_name' => 'фамилия',
            'parent_name' => 'имя родителя',
            'parent_surname' => 'фамилия родителя',
            'email'       => 'почта',
            'password'    => 'пароль',
            'profile_image'    => 'аватар',
        ];
    }
}
