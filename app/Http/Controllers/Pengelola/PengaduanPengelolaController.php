<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengaduanPengelolaController extends Controller
{
    public function viewPengaduan()
    {
        return view('pages.pengelola.pengaduan.pengaduan-pengelola');
    }
}
