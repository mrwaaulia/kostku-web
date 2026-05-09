<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembayaranPenghuniController extends Controller
{
    public function viewPembayaran()
    {
        return view('pages.penghuni.pembayaran-penghuni');
    }
}
