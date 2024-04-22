<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Получаем всех студентов
        $students = User::whereRole('student')->get();

        return view('teacher.students', ['students' => $students]);
    }
}
