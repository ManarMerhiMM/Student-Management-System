<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    $user = Auth::user();

    return view('dashboard', ['user' => $user]);
})->middleware('auth')->name('dashboard');

Route::get('/register', [AuthController::class, 'showRegister'])->middleware(['guest'])->name('register');

Route::get('/login',  [AuthController::class, 'showLogin'])->middleware(['guest'])->name('login');

Route::post('/register', [AuthController::class, 'register'])->middleware(['guest'])->name('register.attempt');;

Route::post('/login',  [AuthController::class, 'login'])->middleware(['guest'])->name('login.attempt');;

Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth'])->name('logout');

Route::resource('students', StudentController::class)->middleware(['auth']);

Route::resource('courses', CourseController::class)->middleware(['auth']);

Route::post('/courses/{course}/enroll', [CourseController::class, 'enrollStudent'])->name('courses.enrollStudent')->middleware(['auth']);

Route::delete('/courses/{course}/students/{student}/unenroll', [CourseController::class, 'unenrollStudent'])->name('courses.unenrollStudent')->middleware(['auth']);

Route::post('/courses/{course}/update-grades-bulk', [CourseController::class, 'updateGrades'])->name('courses.updateGradesBulk')->middleware(['auth']);

Route::get('/users', [AuthController::class, 'index'])->name('users.index')->middleware(['auth']);

Route::post('/users/{user}/deactivate', [AuthController::class, 'deactivateUser'])->name('users.deactivate')->middleware(['auth']);

Route::post('/users/{user}/activate', [AuthController::class, 'activateUser'])->name('users.activate')->middleware(['auth']);
