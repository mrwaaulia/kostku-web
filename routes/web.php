<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\PenghuniAuthController;
use App\Http\Controllers\Auth\PengelolaAuthController;
use App\Http\Controllers\Auth\LupaPasswordController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Penghuni\PengaduanPenghuniController;
use App\Http\Controllers\Penghuni\PembayaranPenghuniController;
use App\Http\Controllers\Penghuni\DashboardPenghuniController;

use App\Http\Controllers\Pengelola\DashboardPengelolaController;
use App\Http\Controllers\Pengelola\KamarPengelolaController;
use App\Http\Controllers\Pengelola\PembayaranPengelolaController;
use App\Http\Controllers\Pengelola\PengaduanPengelolaController;
use App\Http\Controllers\Pengelola\PenghuniPengelolaController;

use App\Http\Controllers\SuperAdmin\DashboardSuperAdminController;

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

// Login Controller
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'view')->name('login');
    Route::post('/postLogin', 'sessionLogin')->name('sessionLogin');
});

// Lupa Password
Route::controller(LupaPasswordController::class)->group(function () {
    Route::get('/lupa-password', 'view')->name('lupa-password');
});

// Penghuni Auth
Route::controller(PenghuniAuthController::class)->group(function () {
    Route::post('/penghuni/register/store', 'store')->name('penghuni.store');
    Route::post('/penghuni/logout', 'logout')->name('penghuni.logout');
    Route::get('/penghuni/register', 'viewRegister')->name('register.penghuni');
});

// Pengelola Auth
Route::controller(PengelolaAuthController::class)->group(function () {
    Route::post('/pengelola/register/store', 'store')->name('pengelola.store');
    Route::post('/pengelola/logout', 'logout')->name('pengelola.logout');
    Route::get('/pengelola/register', 'viewRegister')->name('register.pengelola');
});


/*
|--------------------------------------------------------------------------
| PENGHUNI
|--------------------------------------------------------------------------
*/

// Dashboard Penghuni
Route::controller(DashboardPenghuniController::class)->group(function () {
    Route::get('/penghuni/dashboard-penghuni', 'viewDashboard')->name('dashboard.penghuni');
});

// Pembayaran Penghuni
Route::controller(PembayaranPenghuniController::class)->group(function () {
    Route::get('/penghuni/pembayaran-penghuni', 'viewPembayaran')->name('pembayaran.penghuni');
});

// Pengaduan Penghuni
Route::controller(PengaduanPenghuniController::class)->group(function () {
    Route::get('/penghuni/pengaduan-penghuni', 'viewPengaduan')->name('pengaduan.penghuni');
});

/*
|--------------------------------------------------------------------------
| PENGELOLA
|--------------------------------------------------------------------------
*/

// Dashboard Pengelola
Route::controller(DashboardPengelolaController::class)->group(function () {
    Route::get('/pengelola/dashboard-pengelola', 'viewDashboard')->name('dashboard.pengelola');
});

// Kamar Pengelola
Route::controller(KamarPengelolaController::class)->group(function () {
    Route::get('/pengelola/kamar-pengelola', 'viewKamar')->name('kamar.pengelola');
    Route::post('/pengelola/kamar-pengelola/store', 'storeKamar')->name('kamar.store');
});

// Pembayaran Pengelola
Route::controller(PembayaranPengelolaController::class)->group(function () {
    Route::get('/pengelola/pembayaran-pengelola', 'viewPembayaran')->name('pembayaran.pengelola');
});

// Pengaduan Pengelola
Route::controller(PengaduanPengelolaController::class)->group(function () {
    Route::get('/pengelola/pengaduan-pengelola', 'viewPengaduan')->name('pengaduan.pengelola');
});

// Penghuni Pengelola
Route::controller(PenghuniPengelolaController::class)->group(function () {
    Route::get('/pengelola/penghuni-pengelola', 'viewPenghuni')->name('penghuni.pengelola');
});

/*
|--------------------------------------------------------------------------
| SUPER ADMIN
|--------------------------------------------------------------------------
*/

// Dashboard Super Admin
Route::controller(DashboardSuperAdminController::class)->group(function () {
    Route::get('/superadmin/dashboard-superadmin', 'viewDashboard')->name('dashboard.superadmin');
});
