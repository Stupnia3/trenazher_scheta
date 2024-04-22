<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\TeacherRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    public function registerTeacher(TeacherRegisterRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'            => 'required|regex:/^[а-яА-ЯёЁ]+$/u|max:255', // только кириллица
            'middle_name'           => 'required|regex:/^[а-яА-ЯёЁ]+$/u|max:255', // только кириллица
            'last_name'             => 'nullable|regex:/^[а-яА-ЯёЁ]+$/u|max:255', // только кириллица
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->route('register.register_teacher')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
                'role'     => RoleEnum::TEACHER->value,
                'password' => bcrypt($request->password)
            ] + $request->except('password_confirmation'));
        return redirect()->route('login');
    }

    public function registerStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'            => 'required|regex:/^[а-яА-ЯёЁ]+$/u|max:255', // только кириллица
            'middle_name'           => 'required|regex:/^[а-яА-ЯёЁ]+$/u|max:255', // только кириллица
            'parent_name'           => 'nullable|regex:/^[а-яА-ЯёЁ]+$/u|max:255', // только кириллица
            'parent_surname'        => 'nullable|regex:/^[а-яА-ЯёЁ]+$/u|max:255', // только кириллица
            'last_name'             => 'nullable|regex:/^[а-яА-ЯёЁ]+$/u|max:255', // только кириллица
            'phone'                 => 'nullable|regex:/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/|unique:users', // шаблон телефона +7 (999) 999-99-99
            'email'                 => 'required|string|email|max:255|unique:users',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::check() && Auth::user()->role === RoleEnum::TEACHER->value) {
            $request->merge(['teacher_id' => Auth::id()]);
        }


        if ($request->hasFile('profile_image')) {
            // Получение файла изображения
            $image = $request->file('profile_image');


            // Генерация уникального имени файла
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Сохранение изображения в папку storage/app/public/avatars
            $image->storeAs('public/avatars', $imageName);
            // Создание записи пользователя с сохраненным изображением
            $student = User::create([
                    'role'          => RoleEnum::STUDENT->value,
                    'password'      => bcrypt($request->password),
                    'teacher_id'    => $request->teacher_id,
                    'profile_image' => $imageName, // Только имя файла без указания поддиректории
                ] + $request->except(['password_confirmation', 'teacher_id', 'profile_image']));
        } else{
            $student = User::create([
                    'role'          => RoleEnum::STUDENT->value,
                    'password'      => bcrypt($request->password),
                    'teacher_id'    => $request->teacher_id,
                ] + $request->except(['password_confirmation', 'teacher_id', 'profile_image']));
        }




        return redirect()->route('login');
    }
}

