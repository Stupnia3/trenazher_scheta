<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if ($user->role === 'student') {
            return view('student.student-profile', ['user' => $user, 'showStudentsLink' => false]);
        } elseif ($user->role === 'teacher') {
            return view('teacher.teacher-profile', ['user' => $user, 'showStudentsLink' => true]);
        } else {
            return abort(403, 'Недостаточно прав для просмотра профиля.');
        }
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Правила валидации
        $rules = [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'login' => 'required|string|max:255|unique:users,login,' . $user->id,
            'password' => 'required|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        // Сообщения об ошибках
        $messages = [
            'first_name.required' => 'Имя обязательно для заполнения.',
            'last_name.required' => 'Фамилия обязательна для заполнения.',
            'email.required' => 'E-mail обязателен для заполнения.',
            'email.email' => 'Введите корректный e-mail.',
            'email.unique' => 'Этот e-mail уже используется.',
            'login.required' => 'Логин обязателен для заполнения.',
            'login.unique' => 'Этот логин уже используется.',
            'password.required' => 'Пароль обязателен для проверки.',
            'profile_image.image' => 'Файл должен быть изображением.',
            'profile_image.mimes' => 'Допустимые форматы изображения: jpeg, png, jpg, gif, webp.',
            'profile_image.max' => 'Максимальный размер изображения - 2 МБ.',
        ];

        // Валидация данных
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Проверка введенного пароля
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Неверный пароль.');
        }

        // Проверка наличия новой аватарки в запросе
        if ($request->hasFile('profile_image')) {
            // Получение файла аватарки из запроса
            $image = $request->file('profile_image');

            // Генерация уникального имени для новой аватарки
            $imageName = time() . '_' . $image->getClientOriginalName();

            // Сохранение новой аватарки в папку storage/app/public/avatars
            $image->storeAs('public/avatars', $imageName);

            // Удаление старой аватарки, если она существует
            if ($user->profile_image) {
                Storage::delete('public/' . $user->profile_image);
            }

            // Обновление пути к аватарке в информации о пользователе
            $user->update(['profile_image' => $imageName]);
        }

        // Обновление информации о пользователе
        $user->update([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'parent_name' => $request->last_name,
            'parent_surname' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'login' => $request->login,
        ]);

        return redirect()->back()->with('success', 'Профиль успешно обновлен.');
    }

    public function edit()
    {
        $user = Auth::user();
        return redirect()->back()->with('user', $user);
    }
    public function changePassword(Request $request)
    {
        // Валидация входных данных
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // Проверка совпадения с new_password_confirmation
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = auth()->user();

        // Проверка текущего пароля
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Текущий пароль введен неправильно.');
        }

        // Обновление пароля
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Пароль успешно обновлен.');
    }

}
