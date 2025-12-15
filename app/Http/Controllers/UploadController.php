<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    // Menampilkan semua video
    public function index()
    {
        $uploads = Upload::all();
        return view('uploads', compact('uploads'));
    }

    // Form tambah video (opsional, bisa digabung dengan index)
    public function create()
    {
        return view('uploads');
    }

    // Simpan video baru
    public function store(Request $request)
    {
        $request->validate([
            'video' => 'required|mimes:mp4,mov,avi,wmv,flv,webm|max:2048000', // 2GB
            'desc' => 'required|string|max:255',
        ]);

        $file = $request->file('video');

        // Ambil dan bersihkan nama file asli
        $cleanName = $this->sanitizeFilename(
            pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
        );
        $extension = $file->getClientOriginalExtension();

        $filename = $cleanName . '.' . $extension;

        // Simpan dengan nama asli yang aman
        $path = $file->storeAs('uploads', $filename, 'public');

        Upload::create([
            'Video_Path_Upload' => $path,
            'Desc_Upload' => $request->desc,
        ]);

        return redirect()->route('uploads')->with('success', 'Video berhasil ditambahkan!');
    }

    // Form edit video
    public function edit($id)
    {
        $upload = Upload::findOrFail($id);
        return view('uploads', compact('upload'));
    }

    // Update video
    public function update(Request $request, $id)
    {
        $upload = Upload::findOrFail($id);

        $request->validate([
            'video' => 'nullable|mimes:mp4,mov,avi,wmv,flv,webm|max:2048000',
            'desc' => 'required|string|max:255',
        ]);

        $videoPath = $upload->Video_Path_Upload;

        if ($request->hasFile('video')) {
            if (!$request->file('video')->isValid()) {
                return back()->withErrors(['video' => $request->file('video')->getErrorMessage()]);
            }

            // Hapus file lama jika ada
            if ($videoPath && Storage::disk('public')->exists($videoPath)) {
                Storage::disk('public')->delete($videoPath);
            }

            // Simpan file baru dengan nama asli yang dibersihkan
            $file = $request->file('video');
            $cleanName = $this->sanitizeFilename(
                pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)
            );
            $extension = $file->getClientOriginalExtension();
            $filename = $cleanName . '.' . $extension;

            $videoPath = $file->storeAs('uploads', $filename, 'public');
        }

        $upload->update([
            'Video_Path_Upload' => $videoPath,
            'Desc_Upload' => $request->desc,
        ]);

        return redirect()->route('uploads')->with('success', 'Video berhasil diupdate!');
    }

    // Hapus video
    public function destroy($id)
    {
        $upload = Upload::findOrFail($id);

        // Hapus file fisik jika ada
        if ($upload->Video_Path_Upload && Storage::disk('public')->exists($upload->Video_Path_Upload)) {
            Storage::disk('public')->delete($upload->Video_Path_Upload);
        }

        $upload->delete();

        return redirect()->route('uploads')->with('success', 'Video berhasil dihapus!');
    }

    /**
     * Membersihkan nama file agar aman untuk sistem file.
     *
     * Mengganti karakter non-alfanumerik (kecuali _ dan -) dengan underscore,
     * membatasi panjang, dan menghindari underscore berulang.
     */
    private function sanitizeFilename(string $filename): string
    {
        // Hanya izinkan huruf, angka, underscore, dash
        $clean = preg_replace('/[^A-Za-z0-9_\-]/', '_', $filename);
        // Batasi panjang (100 karakter sebelum ekstensi)
        $clean = substr($clean, 0, 100);
        // Ganti multiple underscore jadi satu
        $clean = preg_replace('/_+/', '_', $clean);
        // Hapus underscore di awal/akhir
        $clean = trim($clean, '_-');
        // Jika jadi kosong, beri nama default
        if ($clean === '') {
            $clean = 'video_' . time();
        }
        return $clean;
    }
}
