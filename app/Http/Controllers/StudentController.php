<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Student;


class StudentController extends Controller
{
    public function index()
    {
        // Получаем всех студентов
        $students = User::whereRole('student')->get();

        return view('teacher.students', ['students' => $students]);
    }

    public function toggleActivation(User $user): JsonResponse
    {
        $user->status = $user->status === 'active' ? 'not_active' : 'active';
        $user->save();

        return response()->json(['status' => $user->status]);
    }
    public function detachTeacher(User $user)
    {
        // Обновляем teacher_id на null
        $user->update(['teacher_id' => null]);

        // Получаем актуальный статус пользователя после обновления
        $status = $user->fresh()->status;

        // Возвращаем статус пользователя вместе с ответом
        return response()->json(['status' => $status, 'success' => true]);
    }

    public function showAllStudents()
    {
        $students = User::whereRole('student')->get();
        return view('teacher.add', ['students' => $students]);
    }

    public function addStudent(Request $request)
    {
        // Проверяем, были ли переданы данные формы
        if ($request->has('teacher_id') && $request->has('student_id')) {
            // Получаем данные из запроса
            $teacherId = $request->input('teacher_id');
            $studentId = $request->input('student_id');

            // Проверяем, существует ли такой ученик и учитель
            $teacher = User::find($teacherId);
            $student = Student::find($studentId);

            if ($teacher && $student) {
                // Проверяем, не прикреплен ли уже этот ученик к другому учителю
                if (!$student->teacher_id) {
                    // Привязываем ученика к учителю
                    $student->teacher_id = $teacherId;
                    $student->save();

                    // Возвращаем успешный ответ
                    return response()->json(['success' => true]);
                } else {
                    // Ученик уже прикреплен к другому учителю
                    return response()->json(['error' => 'Ученик уже прикреплен к другому учителю']);
                }
            } else {
                // Учитель или ученик не найден
                return response()->json(['error' => 'Учитель или ученик не найден']);
            }
        } else {
            // Не хватает данных в запросе
            return response()->json(['error' => 'Не хватает данных в запросе']);
        }
    }


}

