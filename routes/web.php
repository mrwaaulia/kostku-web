<?php

use Illuminate\Support\Facades\Route;


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
