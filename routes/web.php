<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PenghuniAuthController;


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

//Penghuni
Route::get('/penghuni/register', function () {
    return view('pages.auth.penghuni.register-penghuni');
})->name('register.penghuni');
Route::get('/penghuni/index', function () {
    return view('pages.penghuni.dashboard-penghuni');
})->name('penghuni.index');

// Login & Lupa Password
Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');
Route::get('/lupa-password', function () {
    return view('pages.auth.lupa-password');
})->name('lupa-password');

Route::controller(PenghuniAuthController::class)->group(function () {
    Route::post('/penghuni/register', 'store')->name('penghuni.store');
    Route::post('/penghuni/login', 'sessionLogin')->name('penghuni.sessionLogin');
});
