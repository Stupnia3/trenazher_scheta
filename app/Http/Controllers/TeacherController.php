<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\File;
use App\Models\GameResult;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;

class TeacherController extends Controller
{
    public function showStudents()
    {
        // Получаем текущего пользователя (учителя)
        $teacher = auth()->user();

        // Получаем учеников, привязанных к данному учителю
        $students = $teacher->students;

        // Получаем файлы, привязанные к данному учителю
        $files = File::where('teacher_id', $teacher->id)->get();

        // Добавляем баллы за игры для каждого студента
        $students = $this->getStudentsWithGameScores($students);

        return view('teacher.students', compact('students', 'files'));
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


    public function downloadTemplate()
    {
        $filePath = storage_path('app/excel/template.xlsx');

        $fileName = 'template.xlsx'; // Имя файла, каким он будет скачиваться у учителя

        return response()->download($filePath, $fileName);
    }

    public function uploadExcel(Request $request)
    {
        // Получаем идентификатор учителя из сессии или запроса
        $teacherId = $request->user()->id;
        // Счетчик добавленных пользователей
        $userCount = 0;

        // Создаем коллекцию данных для Excel-файла
        $data = collect([
            ['Фамилия', 'Имя', 'Отчество', 'E-mail', 'Имя родителя', 'Фамилия родителя', 'Телефон родителя', 'Логин', 'Пароль']
        ]);

        // Если параметр filled-file присутствует, обрабатываем загрузку файла
        if ($request->hasFile('filled-file')) {
            // Получаем загруженный файл
            $file = $request->file('filled-file');

            // Читаем данные из Excel-файла в коллекцию
            $excelData = Excel::toCollection([], $file);

            // Проверяем, что данные не пустые и являются коллекцией
            if ($excelData && $excelData->count() > 0) {
                foreach ($excelData as $collection) {
                    $rowData = $collection->toArray(); // Преобразование коллекции в массив
                    array_shift($rowData);
                    // Создаем нового пользователя для каждой записи в коллекции
                    foreach ($rowData as $row) {
                        // Проверяем, существует ли пользователь с таким email
                        if (User::where('email', $row[3])->exists() || User::where('phone', $row[6])->exists()) {
                            continue; // Пропускаем пользователя, если email или phone уже существуют
                        }
                        // Создание нового пользователя
                        $user = new User();
                        $user->middle_name = $row[0] ?? ''; // Фамилия
                        $user->first_name= $row[1] ?? ''; // Имя
                        $user->last_name = $row[2] ?? ''; // Отчество
                        $user->email = $row[3] ?? ''; // E-mail (если $row[3] не определено, будет сохранена пустая строка)
                        $user->parent_name = $row[4] ?? ''; // Имя родителя
                        $user->parent_surname = $row[5] ?? ''; // Фамилия родителя
                        $user->phone = $row[6] ?? ''; // Телефон родителя

                        $user->login = Str::random(8); // Генерация логина
                        $password = Str::random(8); // Генерация пароля
                        $user->password = bcrypt($password); // Хэширование пароля
                        $user->role = 'student';
                        $user->teacher_id = $teacherId; // Привязываем пользователя к учителю

                        // Сохранение пользователя
                        $user->save();
                        // Увеличиваем счетчик добавленных пользователей
                        $userCount++;

                        // Добавляем данные студента в коллекцию для Excel-файла
                        $data->push([
                            $user->middle_name,
                            $user->first_name,
                            $user->last_name,
                            $user->email,
                            $user->parent_name,
                            $user->parent_surname,
                            $user->phone,
                            $user->login,
                            $password // Используем нехэшированный пароль
                        ]);
                    }
                }
            } else {
                return redirect()->back()->with('error', 'Не удалось прочитать данные из файла.');
            }
        }
        // Если ни один пользователь не был добавлен, возвращаемся назад с ошибкой
        if ($userCount === 0) {
            return redirect()->back()->with('error', 'Не удалось добавить пользователей.');
        }

        // Создаем экспорт и сохраняем его на сервере
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('public/uploads', $fileName);
        Excel::store(new UsersExport($data), $filePath);

        // Сохраняем информацию о файле в базе данных
        $file = new File();
        $file->name = $fileName;
        $file->path = $filePath;
        $file->teacher_id = $teacherId;
        $file->save();

        // Возвращаем пользователю ссылку на скачивание файла
        return redirect()->back()->with('success', 'Файл успешно загружен. <a href="' . route('downloadFile', $file->id) . '" id="download-link">Скачать файл</a>');

    }
    public function download(File $file)
    {
        return Storage::download($file->path, $file->name);
    }
}

