<?php

namespace App\Http\Controllers;

use App\Models\User;

class TeacherController extends Controller
{
    public function showStudents()
    {
        // Получаем текущего пользователя (учителя)
        $teacher = auth()->user();

        // Получаем учеников, привязанных к данному учителю
        $students = $teacher->students;

        return view('teacher.students', compact('students'));
    }
}

