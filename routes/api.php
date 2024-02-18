<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// */api/*
Route::middleware('guest')->group(function () {
    Route::post('/register/teacher', [\App\Http\Controllers\RegisterController::class, 'registerTeacher'])->name('registration.teacher');
    Route::post('/register/student', [\App\Http\Controllers\RegisterController::class, 'registerStudent'])->name('registration.student');
    Route::post('/auth', [\App\Http\Controllers\AuthController::class, 'login'])->name('auth');
});
