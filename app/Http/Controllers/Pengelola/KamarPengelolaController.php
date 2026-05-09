<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KamarPengelolaController extends Controller
{
    public function viewKamar()
    {
        return view('pages.pengelola.kamar.kamar-pengelola');
    }
}
