<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if ($user->role === 'student') {
            return view('student.student-profile', ['user' => $user]);
        } elseif ($user->role === 'teacher') {
            return view('teacher.teacher-profile', ['user' => $user]);
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
