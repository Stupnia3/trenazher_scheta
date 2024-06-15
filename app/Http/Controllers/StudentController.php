<?php

namespace App\Http\Controllers;
use App\Models\GameSettings;
use App\Models\Student;
use App\Models\User;
use App\Models\GameResult;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    // Методы index, toggleActivation, detachTeacher, showAllStudents, addStudent, loadAllStudents и loadStudents остаются без изменений

    public function index()
    {
        $students = $this->getStudentsWithGameScores(User::whereRole('student')->paginate(10));

        return view('teacher.add', ['students' => $students]);
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
        // Загружаем студентов вместе с их игровыми результатами
        $students = $this->getStudentsWithGameScores(User::whereRole('student')->paginate(10));

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

    public function loadStudents(Request $request)
    {
        // Получаем поисковый запрос из запроса
        $search = $request->input('search');

        // Запрос на получение студентов
        $query = User::whereRole('student');

        // Применяем поиск, если он задан
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%');
            });
        }

        // Получаем данные о странице и количестве элементов на странице
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);

        // Загружаем студентов с учетом страницы и количества элементов на странице
        $students = $query->paginate($perPage, ['*'], 'page', $page);

        // Добавляем результаты игр
        $students = $this->getStudentsWithGameScores($students);

        // Возвращаем данные в формате JSON
        return response()->json($students);
    }

    // Добавляем новый метод для страницы рейтинга
    public function ratingPage()
    {
        $students = $this->getStudentsWithGameScores(User::whereRole('student')->paginate(10));

        return view('rating_page', ['students' => $students]);
    }

    // Метод loadAllStudents остается без изменений
    public function loadAllStudents()
    {
        $students = Student::all();
        return response()->json($students);
    }

    private function getStudentsWithGameScores($students)
    {
        $students->each(function($student) {
            $student->flash_anzan_score = $this->getGameScore($student->id, 'flash-anzan');
            $student->flash_cards_score = $this->getGameScore($student->id, 'flash-cards');
            $student->multiplication_score = $this->getGameScore($student->id, 'multiplication');
            $student->division_score = $this->getGameScore($student->id, 'division');
            $student->columns_score = $this->getGameScore($student->id, 'columns');
        });

        return $students;
    }

    private function getGameScore($userId, $gameName)
    {
        return GameResult::where('user_id', $userId)->where('game_name', $gameName)->sum('score');
    }
    public function showGames($id)
    {
        $student = User::findOrFail($id);

        // Получаем игры и их настройки по типам
        $flashAnzanSettings = GameSettings::where('user_id', $id)->where('game_name', 'flash-anzan')->orderBy('created_at', 'desc')->get();
        $flashAnzanResults = GameResult::where('user_id', $id)->where('game_name', 'flash-anzan')->orderBy('created_at', 'desc')->get();

        $flashCardsSettings = GameSettings::where('user_id', $id)->where('game_name', 'flash-cards')->orderBy('created_at', 'desc')->get();
        $flashCardsResults = GameResult::where('user_id', $id)->where('game_name', 'flash-cards')->orderBy('created_at', 'desc')->get();

        $divisionSettings = GameSettings::where('user_id', $id)->where('game_name', 'division')->orderBy('created_at', 'desc')->get();
        $divisionResults = GameResult::where('user_id', $id)->where('game_name', 'division')->orderBy('created_at', 'desc')->get();

        $multiplicationSettings = GameSettings::where('user_id', $id)->where('game_name', 'multiplication')->orderBy('created_at', 'desc')->get();
        $multiplicationResults = GameResult::where('user_id', $id)->where('game_name', 'multiplication')->orderBy('created_at', 'desc')->get();

        $columnsResults = GameResult::where('user_id', $id)->where('game_name', 'columns')->orderBy('created_at', 'desc')->get();

        return view('teacher.games', compact(
            'student',
            'flashAnzanSettings', 'flashAnzanResults',
            'flashCardsSettings', 'flashCardsResults',
            'divisionSettings', 'divisionResults',
            'multiplicationSettings', 'multiplicationResults', 'columnsResults'
        ));
    }
}
