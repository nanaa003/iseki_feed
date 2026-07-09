<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class AdminHomeController extends Controller
{
    public function index()
    {
        $videos = \App\Models\Upload::orderBy('Order_Upload', 'asc')
                    ->pluck('Video_Path_Upload');

        return view('adminhome', ['videos' => $videos]);
    }
}
