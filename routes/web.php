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
})->name('landing');


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

// Pengelola
Route::get('/pengelola/register', function () {
    return view('pages.auth.pengelola.register-pengelola');
})->name('register.pengelola');

//Penghuni
Route::get('/penghuni/register', function () {
    return view('pages.auth.penghuni.register-penghuni');
})->name('register.penghuni');

// Login & Lupa Password
Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');
Route::get('/lupa-password', function () {
    return view('pages.auth.lupa-password');
})->name('lupa-password');

// route with controller
Route::controller(LoginController::class)->group(function () {
    Route::post('/login', 'sessionLogin')->name('login');
});

Route::controller(PenghuniAuthController::class)->group(function () {
    Route::post('/penghuni/register/store', 'store')->name('penghuni.store');
    Route::post('/penghuni/logout', 'logout')->name('penghuni.logout');
});

Route::controller(PengelolaAuthController::class)->group(function () {
    Route::post('/pengelola/register/store', 'store')->name('pengelola.store');
    Route::post('/pengelola/logout', 'logout')->name('pengelola.logout');
});

/*
|--------------------------------------------------------------------------
| PENGHUNI
|--------------------------------------------------------------------------
*/
Route::get('/penghuni/dashboard-penghuni', function () {
    return view('pages.penghuni.dashboard.dashboard-penghuni');
})->name('penghuni.dashboard-penghuni');
Route::get('/pembayaran-penghuni', function () {
    return view('pages.penghuni.pembayaran-penghuni');
})->name('pembayaran.penghuni');
Route::get('/pengaduan-penghuni', function () {
    return view('pages.penghuni.pengaduan-penghuni');
})->name('pengaduan.penghuni');

/*
|--------------------------------------------------------------------------
| PENGELOLA
|--------------------------------------------------------------------------
*/
Route::get('/dashboard-pengelola', function () {
    return view('pages.pengelola.dashboard-pengelola');
})->name('dashboard.pengelola');
Route::get('/kamar', function () {
    return view('pages.pengelola.kamar-pengelola');
})->name('kamar.pengelola');
Route::get('/pembayaran', function () {
    return view('pages.pengelola.pembayaran-pengelola');
})->name('pembayaran.pengelola');
Route::get('/pengaduan-pengelola', function () {
    return view('pages.pengelola.pengaduan-pengelola');
})->name('pengaduan.pengelola');
Route::get('/penghuni.pengelola', function () {
    return view('pages.pengelola.penghuni-pengelola');
})->name('penghuni.pengelola');
