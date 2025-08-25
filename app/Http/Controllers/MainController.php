<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    // Halaman utama user (bebas)
    public function userDashboard()
    {
        return view('users.dashboards.index');
    }

    // Dashboard admin (perlu login)
    public function adminDashboard()
    {
        return view('admins.dashboards.index');
    }
}
