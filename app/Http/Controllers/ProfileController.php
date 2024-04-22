<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            'email' => $request->email,
            'parent_name' => $request->parent_name,
            'parent_surname' => $request->parent_surname,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success', 'Профиль успешно обновлен.');
    }

    public function edit()
    {
        $user = Auth::user();
        return redirect()->back()->with('user', $user);
    }
}
