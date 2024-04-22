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
            'last_name'   => ['required', 'string'],
            'first_name'  => ['required', 'string'],
            'middle_name' => ['required', 'string'],
            'email'       => ['required', 'string', 'email'],
            'password'    => ['required', 'string', 'confirmed'],
        ];
    }

    public function attributes(): array
    {
        return [
            'last_name'   => 'отчество',
            'first_name'  => 'имя',
            'middle_name' => 'фамилия',
            'email'       => 'почта',
            'password'    => 'пароль',
        ];
    }
    public function messages()
    {
        return [
            'last_name.required'  => 'Поле "Фамилия" обязательно для заполнения',
            'first_name.required'  => 'Поле "Имя" обязательно для заполнения',
            'email.required'  => 'Поле "Email" обязательно для заполнения',
            'email.email'  => 'Введите корректный адрес электронной почты',
            'email.unique'  => 'Пользователь с таким email уже зарегистрирован',
            'password.required'  => 'Поле "Пароль" обязательно для заполнения',
            'password.min'  => 'Пароль должен содержать минимум :min символов',
            'password.confirmed'  => 'Пароль и подтверждение пароля не совпадают',
        ];
    }

}
