<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\StudentRegisterRequest;
use App\Http\Requests\TeacherRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function registerTeacher(TeacherRegisterRequest $request)
    {
        $user = User::create([
                'role' => RoleEnum::TEACHER->value,
                'password' => bcrypt($request->password)
            ] + $request->except('password_confirmation'));
        return redirect()->route('login');
    }

    public function registerStudent(StudentRegisterRequest $request)
    {
        $user = User::create([
                'role' => RoleEnum::STUDENT->value,
                'password' => bcrypt($request->password)
            ] + $request->except('password_confirmation'));
        return redirect()->route('login');
    }
}
