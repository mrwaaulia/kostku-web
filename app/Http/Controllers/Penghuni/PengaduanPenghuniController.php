<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengaduanPenghuniController extends Controller
{
    public function viewPengaduan()
    {
        return view('pages.penghuni.pengaduan-penghuni');
    }
}
