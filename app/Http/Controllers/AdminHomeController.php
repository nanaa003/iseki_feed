<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class AdminHomeController extends Controller
{
    public function index()
    {
        $uploadPath = public_path('storage/uploads');

        if (!File::exists($uploadPath)) {
            $videos = collect();
        } else {
            $files = File::files($uploadPath);

            $filenames = collect($files)
                ->map(fn($file) => $file->getFilename())
                ->filter(fn($filename) => in_array(
                    strtolower(pathinfo($filename, PATHINFO_EXTENSION)),
                    ['mp4', 'webm', 'ogg']
                ))
                ->all();

            // Urutkan secara natural
            natsort($filenames);
            $filenames = array_values($filenames); // ← reset index numerik

            $videos = collect($filenames)
                ->map(fn($filename) => 'storage/uploads/' . $filename);
        }

        return view('adminhome', ['videos' => $videos]); // pastikan nama view sesuai
    }
}
