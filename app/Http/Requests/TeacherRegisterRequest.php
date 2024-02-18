<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRegisterRequest extends FormRequest
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
            'last_name' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'middle_name' => ['nullable', 'string'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed'],
        ];
    }
    public function attributes(): array
    {
        return [
            'last_name' => 'отчество',
            'first_name' => 'имя',
            'middle_name' => 'фамилия',
            'email' => 'почта',
            'password' => 'пароль',
        ];
    }
}
