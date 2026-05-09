<?php

namespace App\Http\Controllers\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardPengelolaController extends Controller
{
    public function viewDashboard()
    {
        return view('pages.pengelola.dashboard-pengelola');
    }
}
