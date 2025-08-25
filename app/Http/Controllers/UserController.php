<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Tampilkan semua data user
    public function index()
    {
        if (!Session::has('login_id')) {
            return redirect()->route('login')->withErrors(['unauthorized' => 'Silakan login terlebih dahulu.']);
        }

        $users = User::all();
        return view('users', compact('users'));
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Username_User' => 'required|unique:users,Username_User|max:20',
            'Name_User' => 'required|string|max:100',
            'Password_User' => 'required',
        ]);

        User::create([
            'Username_User' => $validated['Username_User'],
            'Name_User' => $validated['Name_User'],
            'Password_User' => $validated['Password_User'], // Tidak di-hash
        ]);

        return redirect()->route('user')->with('success', 'Data user berhasil ditambahkan.');
    }

    // Memperbarui user berdasarkan ID
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'Username_User' => 'required|max:20|unique:users,Username_User,' . $id . ',Id_User',
            'Name_User' => 'required|string|max:100',
            'Password_User' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'Username_User' => $validated['Username_User'],
            'Name_User' => $validated['Name_User'],
            'Password_User' => $validated['Password_User'], // Tetap disimpan apa adanya
        ]);

        return redirect()->route('user')->with('success', 'Data user berhasil diperbarui.');
    }

    // Menghapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user')->with('success', 'Data user berhasil dihapus.');
    }
}
