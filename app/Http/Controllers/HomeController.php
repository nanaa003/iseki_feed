<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua file video di folder storage/app/uploads
        $videoFiles = collect(File::files(public_path('storage/uploads')))
            ->map(fn($file) => 'storage/uploads/' . $file->getFilename());

        return view('home', ['videos' => $videoFiles]);
    }
}
