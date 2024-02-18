<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function chooseRoleForm()
    {
        return view('select_role');
    }

    public function processRoleChoice(Request $request)
    {
        $role = $request->input('role');

        if ($role == 'student') {
            return view('register.register_student');
        } elseif ($role == 'teacher') {
            return view('register.register_teacher');
        }
    }


}
