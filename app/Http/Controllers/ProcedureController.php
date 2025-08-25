<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Tractor;
use App\Models\Area;
use App\Models\Procedure;
use App\Models\User;

class ProcedureController extends Controller
{
    public function index()
    {
        $page = "procedure";

        $tractors = Tractor::orderBy('Name_Tractor', 'asc')->get();
        return view('procedures.index', compact('page', 'tractors'));
    }

    public function create_tractor(Request $request)
    {
        // Validasi
        $request->validate([
            'Name_Tractor' => 'required|unique:tractors,Name_Tractor',
            'Photo_Tractor' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ], [
            'Name_Tractor.required' => 'Nama wajib diisi',
            'Photo_Tractor.required' => 'Foto wajib diunggah',
            'Photo_Tractor.image' => 'File harus berupa gambar',
            'Photo_Tractor.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp',
            'Photo_Tractor.max' => 'Ukuran maksimal gambar adalah 2MB',
        ]);

        $name = $request->input('Name_Tractor');
        $photoPath = null;

        // Proses upload gambar
        if ($request->hasFile('Photo_Tractor')) {
            $file = $request->file('Photo_Tractor');
            $filename = uniqid('tractor_') . '.' . $file->getClientOriginalExtension();
            $photoPath = 'storage/tractors/' . $filename;

            // Simpan ke public/storage/tractors
            $file->move(public_path('storage/tractors'), $filename);
        }

        // Simpan ke database
        DB::table('tractors')->insert([
            'Name_Tractor' => $name,
            'Photo_Tractor' => $photoPath
        ]);

        // Buat folder: storage/app/public/procedures/{Name_Tractor}
        Storage::disk('public')->makeDirectory('procedures/' . $name);

        return redirect()->route('procedure')->with('success', 'Tractor berhasil ditambahkan dan foto disimpan');
    }

    public function update_tractor(Request $request, string $Id_Tractor)
    {
        // Ambil data tractor sebelum diubah
        $oldTractor = DB::table('tractors')->where('Id_Tractor', $Id_Tractor)->first();
        $oldName = $oldTractor->Name_Tractor;
        $oldPhoto = $oldTractor->Photo_Tractor;

        // Validasi
        $request->validate([
            'Name_Tractor' => 'required|unique:tractors,Name_Tractor,' . $Id_Tractor . ',Id_Tractor'
        ], [
            'Name_Tractor.required' => 'Nama wajib diisi'
        ]);

        $newName = $request->input('Name_Tractor');
        $photoPath = $oldPhoto;

        // Cek jika ada file baru diupload
        if ($request->hasFile('Photo_Tractor')) {
            $file = $request->file('Photo_Tractor');

            // Hapus file lama jika bukan default
            if ($oldPhoto && $oldPhoto !== 'storage/tractors/default.png' && Storage::disk('public')->exists(str_replace('storage/', '', $oldPhoto))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $oldPhoto));
            }

            // Simpan file baru dengan nama unik
            $fileName = uniqid('tractor_') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/tractors'), $fileName);

            // Update path untuk disimpan di DB
            $photoPath = 'storage/tractors/' . $fileName;
        }

        // Update di database
        DB::table('tractors')->where('Id_Tractor', $Id_Tractor)->update([
            'Name_Tractor' => $newName,
            'Photo_Tractor' => $photoPath
        ]);

        // Ubah nama folder jika nama berubah
        if ($oldName !== $newName) {
            $oldFolder = 'procedures/' . $oldName;
            $newFolder = 'procedures/' . $newName;

            if (Storage::disk('public')->exists($oldFolder)) {
                Storage::disk('public')->move($oldFolder, $newFolder);
            }

            // Ubah nama area dan procedure yang ada di tractor yang sama
            DB::table('areas')->where('Name_Tractor', $oldName)->update([
                'Name_Tractor' => $newName
            ]);
            DB::table('procedures')->where('Name_Tractor', $oldName)->update([
                'Name_Tractor' => $newName
            ]);
        }

        return redirect()->route('procedure')->with('success', 'Data dan folder berhasil diedit');
    }

    public function destroy_tractor($Id_Tractor)
    {
        // Ambil data tractor
        $tractor = Tractor::findOrFail($Id_Tractor);
        $nameTractor = $tractor->Name_Tractor;
        $folderName = 'procedures/' . $nameTractor;

        // Hapus semua area dan procedure yang terkait dengan tractor ini
        DB::table('areas')->where('Name_Tractor', $nameTractor)->delete();
        DB::table('procedures')->where('Name_Tractor', $nameTractor)->delete();

        // Hapus data tractor
        $tractor->delete();

        // Hapus folder jika ada
        if (Storage::disk('public')->exists($folderName)) {
            Storage::disk('public')->deleteDirectory($folderName);
        }

        return redirect()->route('procedure')->with('success', 'Data dan folder berhasil dihapus');
    }

    public function index_area($Name_Tractor)
    {
        $page = "procedure";

        $tractor = $Name_Tractor;
        $photoTractor = Tractor::where('Name_Tractor', $Name_Tractor)->value('Photo_Tractor');
        $areas = Area::where('Name_Tractor', $Name_Tractor)->orderBy('Name_Area', 'asc')->get();
        return view('procedures.areas', compact('page', 'tractor', 'photoTractor', 'areas'));
    }

    public function create_area(Request $request)
    {
        // Validasi basic (required saja dulu)
        $request->validate([
            'Name_Tractor' => 'required',
            'Name_Area' => 'required'
        ], [
            'Name_Tractor.required' => 'Nama tractor wajib diisi',
            'Name_Area.required' => 'Nama area wajib diisi'
        ]);

        $Name_Tractor = $request->input('Name_Tractor');
        $Name_Area = $request->input('Name_Area');

        // Cek apakah kombinasi sudah ada
        $exists = DB::table('areas')
            ->where('Name_Tractor', $Name_Tractor)
            ->where('Name_Area', $Name_Area)
            ->exists();

        if ($exists) {
            return back()->withErrors(['Nama area di tractor ini sudah ada'])->withInput();
        }

        // Simpan ke database
        DB::table('areas')->insert([
            'Name_Tractor' => $Name_Tractor,
            'Name_Area' => $Name_Area
        ]);

        // Buat folder: storage/app/public/procedures/{Name_Tractor}/{Name_Area}
        Storage::disk('public')->makeDirectory("procedures/$Name_Tractor/$Name_Area");

        return redirect()
            ->route('procedure.area.index', ['Name_Tractor' => $Name_Tractor])
            ->with('success', 'Area berhasil ditambahkan dan folder dibuat');
    }

    public function update_area(Request $request, string $Id_Area)
    {
        // Ambil data area sebelum diubah
        $oldArea = DB::table('areas')->where('Id_Area', $Id_Area)->first();
        if (!$oldArea) {
            return back()->withErrors(['Area tidak ditemukan']);
        }

        $oldNameTractor = $oldArea->Name_Tractor;
        $oldNameArea = $oldArea->Name_Area;

        // Validasi dasar
        $request->validate([
            'Name_Tractor' => 'required',
            'Name_Area' => 'required'
        ], [
            'Name_Tractor.required' => 'Nama tractor wajib diisi',
            'Name_Area.required' => 'Nama area wajib diisi'
        ]);

        $newNameTractor = $request->input('Name_Tractor');
        $newNameArea = $request->input('Name_Area');

        // Cek apakah kombinasi tractor+area yang baru sudah ada, selain yang sedang diedit
        $exists = DB::table('areas')
            ->where('Name_Tractor', $newNameTractor)
            ->where('Name_Area', $newNameArea)
            ->where('Id_Area', '!=', $Id_Area)
            ->exists();

        if ($exists) {
            return back()->withErrors(['Nama area di tractor ini sudah ada'])->withInput();
        }

        // Update database
        DB::table('areas')->where('Id_Area', $Id_Area)->update([
            'Name_Tractor' => $newNameTractor,
            'Name_Area' => $newNameArea
        ]);

        // Rename folder jika nama area atau nama tractornya berubah
        if ($oldNameTractor !== $newNameTractor || $oldNameArea !== $newNameArea) {
            $oldFolder = "procedures/$oldNameTractor/$oldNameArea";
            $newFolder = "procedures/$newNameTractor/$newNameArea";

            if (Storage::disk('public')->exists($oldFolder)) {
                Storage::disk('public')->makeDirectory("procedures/$newNameTractor");
                Storage::disk('public')->move($oldFolder, $newFolder);

                // Optional: hapus folder parent lama jika kosong
                $oldParent = "procedures/$oldNameTractor";
                if (
                    empty(Storage::disk('public')->allFiles($oldParent)) &&
                    empty(Storage::disk('public')->allDirectories($oldParent))
                ) {
                    Storage::disk('public')->deleteDirectory($oldParent);
                }

                // Ubah nama procedure yang ada di area dan tractor yang sama
                DB::table('procedures')
                    ->where('Name_Tractor', $oldNameTractor)
                    ->where('Name_Area', $oldNameArea)
                    ->update(['Name_Area' => $newNameArea]);
            }
        }

        return redirect()->route('procedure.area.index', ['Name_Tractor' => $newNameTractor])
            ->with('success', 'Data dan folder berhasil diedit');
    }

    public function destroy_area($Id_Area)
    {
        // Ambil data area
        $area = Area::findOrFail($Id_Area);
        $Name_Tractor = $area->Name_Tractor;
        $Name_Area = $area->Name_Area;
        $folderName = 'procedures/' . $Name_Tractor . '/' . $Name_Area;

        // Hapus semua procedure yang terkait dengan area dan tractor ini
        DB::table('procedures')
            ->where('Name_Tractor', $Name_Tractor)
            ->where('Name_Area', $Name_Area)
            ->delete();

        // Hapus data dari database
        $area->delete();

        // Hapus folder jika ada
        if (Storage::disk('public')->exists($folderName)) {
            Storage::disk('public')->deleteDirectory($folderName);
        }

        return redirect()->route('procedure.area.index', ['Name_Tractor' => $Name_Tractor])
            ->with('success', 'Data dan folder berhasil dihapus');
    }

    public function index_procedure($Name_Tractor, $Name_Area)
    {
        $page = "procedure";

        $tractor = $Name_Tractor;
        $photoTractor = Tractor::where('Name_Tractor', $Name_Tractor)->value('Photo_Tractor');
        $area = $Name_Area;
        $procedures = Procedure::where('Name_Tractor', $Name_Tractor)
            ->where('Name_Area', $Name_Area)
            ->orderBy('Name_Procedure', 'asc')
            ->get();
        return view('procedures.procedures', compact('page', 'tractor', 'photoTractor', 'area', 'procedures'));
    }

    public function create_procedure(Request $request)
    {
        $request->validate([
            'File_Procedure.*' => 'nullable|mimes:pdf',
            'Video_Procedure' => 'nullable|mimes:mp4,mov,webm|max:51200', // max 50MB
            'Name_Tractor' => 'required',
            'Name_Area' => 'required',
        ]);

        $tractor = $request->Name_Tractor;
        $area = $request->Name_Area;

        // Simpan file PDF
        if ($request->hasFile('File_Procedure')) {
            foreach ($request->file('File_Procedure') as $file) {
                $originalName = $file->getClientOriginalName();
                $nameProcedure = pathinfo($originalName, PATHINFO_FILENAME);
                $filename = $originalName;
                $path = 'procedures/' . $tractor . '/' . $area;

                // Definisi video path dulu
                $videopathProcedure = null;
                if ($request->hasFile('Video_Procedure')) {
                    $video = $request->file('Video_Procedure');
                    $videoName = uniqid('video_') . '.' . $video->getClientOriginalExtension();
                    $videoFolder = 'procedures/' . $tractor . '/' . $area;

                    // Simpan video
                    $video->storeAs($videoFolder, $videoName, 'public');

                    // Path untuk database
                    $videopathProcedure = $videoFolder . '/' . $videoName;
                }
                // Simpan file PDF
                $file->storeAs($path, $filename, 'public');

                // Insert atau update data di database
                DB::table('procedures')->updateOrInsert(
                    [
                        'Name_Tractor' => $tractor,
                        'Name_Area' => $area,
                        'Name_Procedure' => $nameProcedure
                    ],
                    [
                        'Video_Path_Procedure' => $videopathProcedure, // jangan salah nama
                    ]
                );
            }
        }

        // Simpan file video
        if ($request->hasFile('Video_Procedure')) {
            $video = $request->file('Video_Procedure');
            $videoName = uniqid('video_') . '.' . $video->getClientOriginalExtension();
            $videoPath = 'procedures/' . $tractor . '/' . $area . '/' . $videoName;

            // Simpan video di storage/public/procedures/{tractor}/{area}/
            $video->storeAs('procedures/' . $tractor . '/' . $area, $videoName, 'public');

            // Update kolom Video_Path_Procedure di database
            // Jika ingin menambahkan video ke procedure yang sudah ada dengan nama sama seperti file PDF:
            $nameProcedureFromVideo = pathinfo($video->getClientOriginalName(), PATHINFO_FILENAME);

            DB::table('procedures')
                ->where('Name_Tractor', $tractor)
                ->where('Name_Area', $area)
                ->where('Name_Procedure', $nameProcedureFromVideo)
                ->update([
                    'Video_Path_Procedure' => $videoPath
                ]);
        }

        return redirect()->route('procedure.procedure.index', [
            'Name_Tractor' => $tractor,
            'Name_Area' => $area
        ])->with('success', 'Prosedur dan video berhasil ditambahkan atau diperbarui');
    }

    public function update_procedure(Request $request, string $Id_Procedure)
    {
        // Ambil data procedure sebelum diubah
        $oldProcedure = DB::table('procedures')->where('Id_Procedure', $Id_Procedure)->first();
        if (!$oldProcedure) {
            return back()->withErrors(['Procedure tidak ditemukan']);
        }

        $oldNameTractor = $oldProcedure->Name_Tractor;
        $oldNameArea = $oldProcedure->Name_Area;
        $oldNameProcedure = $oldProcedure->Name_Procedure;
        $oldVideoPath = $oldProcedure->Video_Path_Procedure;

        // Validasi dasar + file video opsional
        $request->validate([
            'Name_Tractor' => 'required',
            'Name_Area' => 'required',
            'Name_Procedure' => 'required',
            'Video_Procedure' => 'nullable|mimes:mp4,mov,webm|max:51200' // max 50MB
        ], [
            'Name_Tractor.required' => 'Nama tractor wajib diisi',
            'Name_Area.required' => 'Nama area wajib diisi',
            'Name_Procedure.required' => 'Nama procedure wajib diisi'
        ]);

        $newNameTractor = $request->input('Name_Tractor');
        $newNameArea = $request->input('Name_Area');
        $newNameProcedure = $request->input('Name_Procedure');
        $newItemProcedure = $request->input('Item_Procedure') ?? '';

        // Cek duplikasi
        $exists = DB::table('procedures')
            ->where('Name_Tractor', $newNameTractor)
            ->where('Name_Area', $newNameArea)
            ->where('Name_Procedure', $newNameProcedure)
            ->where('Id_Procedure', '!=', $Id_Procedure)
            ->exists();

        if ($exists) {
            return back()->withErrors(['Nama procedure di area tractor ini sudah ada'])->withInput();
        }

        $newVideoPath = $oldVideoPath;

        // Jika ada video baru diupload
        if ($request->hasFile('Video_Procedure')) {
            $video = $request->file('Video_Procedure');
            $videoName = uniqid('video_') . '.' . $video->getClientOriginalExtension();
            $videoDir = 'procedures/' . $newNameTractor . '/' . $newNameArea;
            $video->storeAs($videoDir, $videoName, 'public');

            $newVideoPath = $videoDir . '/' . $videoName;

            // Hapus video lama jika ada
            if ($oldVideoPath && Storage::disk('public')->exists($oldVideoPath)) {
                Storage::disk('public')->delete($oldVideoPath);
            }
        }

        // Update database
        DB::table('procedures')->where('Id_Procedure', $Id_Procedure)->update([
            'Name_Tractor' => $newNameTractor,
            'Name_Area' => $newNameArea,
            'Name_Procedure' => $newNameProcedure,
            'Item_Procedure' => $newItemProcedure,
            'Video_Path_Procedure' => $newVideoPath
        ]);

        // Rename file PDF dan video jika nama berubah
        if (
            $oldNameTractor !== $newNameTractor ||
            $oldNameArea !== $newNameArea ||
            $oldNameProcedure !== $newNameProcedure
        ) {
            $newDir = 'procedures/' . $newNameTractor . '/' . $newNameArea;

            // Rename PDF
            $oldPdfPath = 'procedures/' . $oldNameTractor . '/' . $oldNameArea . '/' . $oldNameProcedure . '.pdf';
            $newPdfPath = $newDir . '/' . $newNameProcedure . '.pdf';
            if (Storage::disk('public')->exists($oldPdfPath)) {
                Storage::disk('public')->makeDirectory($newDir);
                Storage::disk('public')->move($oldPdfPath, $newPdfPath);
            }

            // Rename video jika ada dan video sebelumnya disimpan
            if ($oldVideoPath && Storage::disk('public')->exists($oldVideoPath)) {
                $videoExt = pathinfo($oldVideoPath, PATHINFO_EXTENSION);
                $newVideoFilePath = $newDir . '/' . $newNameProcedure . '.' . $videoExt;
                Storage::disk('public')->move($oldVideoPath, $newVideoFilePath);

                // Update path di DB
                DB::table('procedures')->where('Id_Procedure', $Id_Procedure)
                    ->update(['Video_Path_Procedure' => $newVideoFilePath]);
            }
        }

        return redirect()->route('procedure.procedure.index', ['Name_Tractor' => $newNameTractor, 'Name_Area' => $newNameArea])
            ->with('success', 'Data, file PDF, dan video berhasil diedit');
    }

    public function upload_procedure(Request $request, string $Id_Procedure)
    {
        // Validasi file PDF wajib, video opsional
        $request->validate([
            'File_Procedure' => 'required|mimes:pdf',
            'Video_Procedure' => 'nullable|mimes:mp4,mov,webm|max:51200' // max 50MB
        ]);

        // Ambil data procedure
        $procedure = DB::table('procedures')->where('Id_Procedure', $Id_Procedure)->first();
        if (!$procedure) {
            return back()->withErrors(['Procedure tidak ditemukan']);
        }

        $nameTractor = $procedure->Name_Tractor;
        $nameArea = $procedure->Name_Area;
        $nameProcedure = $procedure->Name_Procedure;

        $folderPath = 'procedures/' . $nameTractor . '/' . $nameArea;

        // Simpan PDF, timpa jika sudah ada
        if ($request->hasFile('File_Procedure')) {
            $file = $request->file('File_Procedure');
            $pdfFileName = $nameProcedure . '.pdf';
            Storage::disk('public')->putFileAs($folderPath, $file, $pdfFileName);
        }

        // Simpan video jika ada, timpa video lama
        if ($request->hasFile('Video_Procedure')) {
            $video = $request->file('Video_Procedure');
            $videoName = $nameProcedure . '.' . $video->getClientOriginalExtension();
            $videoPath = $folderPath . '/' . $videoName;
            Storage::disk('public')->putFileAs($folderPath, $video, $videoName);

            // Update path video di DB
            DB::table('procedures')->where('Id_Procedure', $Id_Procedure)
                ->update(['Video_Path_Procedure' => $videoPath]);
        }

        return redirect()
            ->route('procedure.procedure.index', [
                'Name_Tractor' => $nameTractor,
                'Name_Area' => $nameArea
            ])
            ->with('success', 'File PDF dan video procedure berhasil diperbarui');
    }

    public function destroy_procedure($Id_Procedure)
    {
        // Ambil data procedure
        $procedure = Procedure::findOrFail($Id_Procedure);
        $Name_Tractor = $procedure->Name_Tractor;
        $Name_Area = $procedure->Name_Area;
        $Name_Procedure = $procedure->Name_Procedure;

        // Path PDF
        $pdfPath = 'procedures/' . $Name_Tractor . '/' . $Name_Area . '/' . $Name_Procedure . '.pdf';

        // Path video (ambil dari kolom Video_Path_Procedure)
        $videoPath = $procedure->Video_Path_Procedure;

        // Hapus data dari database
        $procedure->delete();

        // Hapus file PDF jika ada
        if (Storage::disk('public')->exists($pdfPath)) {
            Storage::disk('public')->delete($pdfPath);
        }

        // Hapus file video jika ada
        if ($videoPath && Storage::disk('public')->exists($videoPath)) {
            Storage::disk('public')->delete($videoPath);
        }

        return redirect()
            ->route('procedure.procedure.index', [
                'Name_Tractor' => $Name_Tractor,
                'Name_Area' => $Name_Area
            ])
            ->with('success', 'File PDF dan video procedure berhasil dihapus');
    }
    public function insert_item_procedure(Request $request)
    {
        $request->validate([
            'Item_Tractors' => 'required|string',
            'Name_Tractor' => 'required|string',
            'Name_Area' => 'required|string',
            'Video_Procedure' => 'nullable|file|mimes:mp4,mov,avi,wmv' // validasi video optional
        ]);

        $Name_Tractor = $request->input('Name_Tractor');
        $Name_Area = $request->input('Name_Area');
        $lines = explode(PHP_EOL, $request->input('Item_Tractors'));

        // Ambil semua prosedur yang ada untuk tractor + area ini
        $proceduresInDB = Procedure::where('Name_Tractor', $Name_Tractor)
            ->where('Name_Area', $Name_Area)
            ->pluck('Name_Procedure')
            ->toArray();

        $inserted = false;

        // Cek apakah ada file video
        $videoFile = $request->file('Video_Procedure');
        $videoPath = null;
        if ($videoFile) {
            $videoName = $videoFile->getClientOriginalName();
            $videoFolder = 'procedures/' . $Name_Tractor . '/' . $Name_Area;
            Storage::disk('public')->makeDirectory($videoFolder);
            $videoFile->storeAs($videoFolder, $videoName, 'public');
            $videoPath = $videoFolder . '/' . $videoName;
        }

        foreach ($lines as $line) {
            $line = trim($line);
            if (!$line) continue;

            // Ambil kode prosedur + deskripsi
            $parts = explode("\t", $line);
            $nameProcedure = trim($parts[0] ?? '');
            $itemProcedure = trim($parts[1] ?? '');

            if ($nameProcedure && in_array($nameProcedure, $proceduresInDB)) {
                $updateData = ['Item_Procedure' => $itemProcedure];

                // Jika ada video, update path video
                if ($videoPath) {
                    $updateData['Video_Path_Procedure'] = $videoPath;
                }

                Procedure::where('Name_Tractor', $Name_Tractor)
                    ->where('Name_Area', $Name_Area)
                    ->where('Name_Procedure', $nameProcedure)
                    ->update($updateData);

                $inserted = true;
            }
        }

        if ($inserted) {
            return back()->with('success', 'Matching procedures updated successfully');
        }

        return back(); // Tidak ada yang cocok, reload tanpa pesan
    }
}
