<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\StudentMiddleware;
use App\Http\Middleware\TeacherMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/', [\App\Http\Controllers\RoleController::class, 'chooseRoleForm'])->name('choose.role.form');
    Route::get('/register/teacher', function () {
        return view('register.register_teacher');
    })->name('register.teacher');
    Route::get('/register/student', function () {
        // Получаем список всех учителей для передачи в представление
        $teachers = \App\Models\User::where('role', \App\Enums\RoleEnum::TEACHER->value)->get();

        // Отображаем представление с передачей переменной $teachers
        return view('register.register_student', ['teachers' => $teachers]);
    })->name('register.student');

    Route::get('/auth', function () {
        return view('auth');
    })->name('login');
});

Route::post('/process-role-choice', [\App\Http\Controllers\RoleController::class, 'processRoleChoice'])->name('process.role.choice');

Route::post('/home', [\App\Http\Controllers\RoleController::class, 'registerTeacher'])->name('registration');


Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('partials.welcome');
    })->name('home');
    Route::get('/flash-anzan', function () {
        return view('games.flash-anzan');
    })->name('flash-anzan');
    Route::get('/flash-cards', function () {
        return view('games.flash-cards');
    })->name('flash-cards');
    Route::get('/multiplication', function () {
        return view('games.multiplication');
    })->name('multiplication');
    Route::get('/division', function () {
        return view('games.division');
    })->name('division');
    Route::get('/columns', function () {
        return view('games.columns');
    })->name('columns');
    Route::get('/profile', 'App\Http\Controllers\ProfileController@show')->name('profile.show');
    Route::post('/profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/saveGameResult', [\App\Http\Controllers\GameController::class, 'saveGameResult']);

    Route::post('/save-game-settings', [\App\Http\Controllers\GameSettingsController::class, 'store']);
    Route::post('/save-game-results', [\App\Http\Controllers\GameResultController::class, 'store'])->name('save-game-results');

    Route::get('/rating', [\App\Http\Controllers\StudentController::class, 'ratingPage'])->name('rating.page');

    Route::post('/profile/change-password', [\App\Http\Controllers\ProfileController::class, 'changePassword'])->name('profile.changePassword');
//    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    });

Route::middleware(['auth', StudentMiddleware::class])->group(function () {

});

Route::middleware(['auth', TeacherMiddleware::class])->group(function () {
    Route::get('/students', [\App\Http\Controllers\StudentController::class, 'index'])->name('students.index');
    Route::get('/teacher/students', [\App\Http\Controllers\TeacherController::class, 'showStudents'])->name('teacher.students');
    Route::post('/toggleActivation/{user}', [\App\Http\Controllers\StudentController::class, 'toggleActivation'])->name('toggleActivation');
    Route::post('/detachTeacher/{user}', [\App\Http\Controllers\StudentController::class, 'detachTeacher'])->name('detachTeacher');
    Route::get('/all-students', [\App\Http\Controllers\StudentController::class, 'showAllStudents'])->name('showAllStudents');
    Route::post('/add-student', [\App\Http\Controllers\StudentController::class, 'addStudent'])->name('addStudent');
    Route::get('/load-students',  [\App\Http\Controllers\StudentController::class, 'loadStudents'])->name('loadStudents');
    Route::get('/load-all-students', [\App\Http\Controllers\StudentController::class, 'loadAllStudents'])->name('loadAllStudents');

    Route::get('/download-template', 'App\Http\Controllers\TeacherController@downloadTemplate')->name('downloadTemplate');
    Route::post('/uploadExcel', [\App\Http\Controllers\TeacherController::class, 'uploadExcel'])->name('uploadExcel');
    Route::get('/downloadStudents', 'App\Http\Controllers\TeacherController@downloadStudents')->name('download.students');
    Route::get('/download-file/{file}', 'App\Http\Controllers\TeacherController@download')->name('downloadFile');
});

Route::middleware(['auth', AdminMiddleware::class])->group(function () {

});


Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
