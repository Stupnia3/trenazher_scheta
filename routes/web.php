<?php

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
        return view('register.register_student');
    })->name('register.student');
});

Route::post('/process-role-choice', [\App\Http\Controllers\RoleController::class, 'processRoleChoice'])->name('process.role.choice');

Route::post('/home', [\App\Http\Controllers\RoleController::class, 'registerTeacher'])->name('registration');

Route::get('/auth', function () {
    return view('auth');
})->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('partials.welcome');
    })->name('home');
    Route::get('/flash-anzan', function () {
        return view('games.flash-anzan');
    })->name('flash-anzan');
    Route::get('/profile', 'App\Http\Controllers\ProfileController@show')->name('profile.show');
    Route::post('/profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
//    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');

});




Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
