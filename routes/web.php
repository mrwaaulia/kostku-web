<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PenghuniAuthController;
use App\Http\Controllers\Auth\PengelolaAuthController;
use App\Http\Controllers\Auth\LoginController;


/*
|--------------------------------------------------------------------------
| LANDING
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('pages.landing.role-select');
});


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

// Pengelola
Route::get('/pengelola/register', function () {
    return view('pages.auth.pengelola.register-pengelola');
})->name('register.pengelola');
Route::get('/pengelola/dashboard', function () {
    return view('pages.pengelola.dashboard-pengelola');
})->name('pengelola.dashboard');

//Penghuni
Route::get('/penghuni/register', function () {
    return view('pages.auth.penghuni.register-penghuni');
})->name('register.penghuni');
Route::get('/penghuni/index', function () {
    return view('pages.penghuni.dashboard-penghuni');
})->name('penghuni.index');

// Login & Lupa Password
Route::get('/login', function () { return view('pages.auth.login'); })->name('login');
Route::get('/lupa-password', function () {
    return view('pages.auth.lupa-password');
})->name('lupa-password');

// route with controller
Route::controller(LoginController::class)->group(function () {
    Route::post('/login', 'sessionLogin')->name('login');
});

Route::controller(PenghuniAuthController::class)->group(function () {
    Route::post('/penghuni/register/store', 'store')->name('penghuni.store');
});

Route::controller(PengelolaAuthController::class)->group(function () {
    Route::post('/pengelola/register/store', 'store')->name('pengelola.store');
});
