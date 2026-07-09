<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch videos directly from database, ordered by Order_Upload
        $videos = \App\Models\Upload::orderBy('Order_Upload', 'asc')
                    ->pluck('Video_Path_Upload');

        return view('home', ['videos' => $videos]);
    }

    public function lobby()
    {
        // Fetch videos directly from database, ordered by Order_Upload
        $videos = \App\Models\Upload::orderBy('Order_Upload', 'asc')
                    ->pluck('Video_Path_Upload');

        return view('lobby', ['videos' => $videos]);
    }
}
