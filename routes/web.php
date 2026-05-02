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
Route::get('/pengelola/login', function () {
    return view('pages.auth.pengelola.login-pengelola');
})->name('login.pengelola');
Route::get('/pengelola/register', function () {
    return view('pages.auth.pengelola.register-pengelola');
})->name('register.pengelola');

//Penghuni
Route::get('/penghuni/login', function () {
    return view('pages.auth.penghuni.login-penghuni');
})->name('login.penghuni');
Route::get('/penghuni/register', function () {
    return view('pages.auth.penghuni.register-penghuni');
})->name('register.penghuni');
Route::get('/penghuni/index', function () {
    return view('pages.penghuni.dashboard-penghuni');
})->name('penghuni.index');

Route::controller(PenghuniAuthController::class)->group(function(){
    Route::post('/penghuni/register', 'store')->name('penghuni.store');
    Route::post('/penghuni/login', 'sessionLogin')->name('penghuni.sessionLogin');
});
