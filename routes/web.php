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

Route::resource('students', StudentController::class)->except(['show']);

Route::resource('courses', CourseController::class)->except(['show']);

