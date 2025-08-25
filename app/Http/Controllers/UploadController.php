<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    // Menampilkan semua video
    public function index()
    {
        $uploads = Upload::all();
        return view('uploads', compact('uploads')); // disesuaikan dengan view baru
    }

    // Form tambah video
    public function create()
    {
        return view('uploads');
    }

    // Simpan video baru
    public function store(Request $request)
    {
        // dd(ini_get('upload_max_filesize'), ini_get('post_max_size'));

        $request->validate([
            'video' => 'required|mimes:mp4,mov,avi,wmv,flv,webm|max:2048000', // 2GB
            'desc' => 'required|string',
        ]);

        $path = $request->file('video')->store('uploads', 'public');

        Upload::create([
            'Video_Path_Upload' => $path,
            'Desc_Upload' => $request->desc,
        ]);

        return redirect()->route('uploads')->with('success', 'Video berhasil ditambahkan!');
    }

    // Form edit video
    public function edit($id)
    {
        $upload = Upload::findOrFail($id); // typo sebelumnya: Uploads
        return view('uploads', compact('upload'));
    }

    // Update video
    public function update(Request $request, $id)
    {
        $upload = Upload::findOrFail($id);

        $request->validate([
            'video' => 'nullable|mimes:mp4,mov,avi,wmv,flv,webm|max:2048000',
            'desc' => 'required|string',
        ]);

        $videoPath = $upload->Video_Path_Upload;

        if ($request->hasFile('video')) {
            if (!$request->file('video')->isValid()) {
                return back()->withErrors(['video' => $request->file('video')->getErrorMessage()]);
            }

            // hapus file lama
            if ($videoPath && Storage::disk('public')->exists($videoPath)) {
                Storage::disk('public')->delete($videoPath);
            }

            // simpan file baru
            $videoPath = $request->file('video')->store('uploads', 'public');
        }

        // update database
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

        if (Storage::disk('public')->exists($upload->Video_Path_Upload)) {
            Storage::disk('public')->delete($upload->Video_Path_Upload);
        }

        $upload->delete(); // sebelumnya typo: $uploads->delete();

        return redirect()->route('uploads')->with('success', 'Video berhasil dihapus!');
    }
}
