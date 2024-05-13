<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        // Вид с формой авторизации
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['login', 'password']);

        if (Auth::attempt($credentials, true)) {
            // Проверяем статус пользователя после успешной аутентификации
            $user = Auth::user();
            if ($user->status == 'not_active') {
                Auth::logout(); // Если статус "not_active", разлогиниваем пользователя
                return redirect()->back()->with('error', 'Ваша учетная запись неактивна. Обратитесь к учителю.');
            }

            return redirect()->route('home'); // Вход выполнен успешно
        }

        return redirect()->back()->with('error', 'Неправильная почта или пароль');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }
}
