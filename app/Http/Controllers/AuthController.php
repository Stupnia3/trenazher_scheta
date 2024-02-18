<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        // view с авторизацией
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials, true)) {
            return redirect()->route('home');
        }

        return redirect()->back()->with('error', 'Неправильная почта или пароль');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }
}
