<?php

use Illuminate\Support\Facades\Route;


// buatkan semua route untuk redirect ke masing masing halaman
Route::get('/', function () {
    return view('welcome');
});
