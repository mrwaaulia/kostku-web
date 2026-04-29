<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\ProfileController;


// buatkan semua route untuk redirect ke masing masing halaman
Route::get('/', function () { return view('welcome'); });

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/login',[AuthController::class, 'login'])->name('login');
Route::get('/register',[AuthController::class, 'register'])->name('register');
Route::get('/logout',[AuthController::class, 'logout'])->name('logout');
Route::get('/kamar', [KamarController::class, 'index'])->name('kamar');
Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran');
Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan');
Route::get('/penghuni', [PenghuniController::class, 'index'])->name('penghuni');

// require __DIR__.'/auth.php';
