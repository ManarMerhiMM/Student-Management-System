<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');

Route::get('/register', [AuthController::class, 'showRegister'])->middleware('guest')->name('register');

Route::get('/login',  [AuthController::class, 'showLogin'])->middleware('guest')->name('login');

Route::post('/register', [AuthController::class, 'register'])->middleware('guest')->name('register.attempt');;

Route::post('/login',  [AuthController::class, 'login'])->middleware('guest')->name('login.attempt');;

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');