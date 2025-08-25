<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Halaman login admin
    public function index()
    {
        return view('login');
    }

    // Proses login admin
    public function login_process(Request $request)
    {
        $request->validate([
            'Username_User' => 'required|string',
            'Password_User' => 'required|string',
        ]);

        $user = User::where('Username_User', $request->Username_User)->first();

        if ($user && $user->Password_User === $request->Password_User) { // Bisa diganti Hash::check
            session([
                'login_id' => $user->Id_User,
                'login_name' => $user->Name_User,
            ]);

            return redirect()->route('adminhome');
        }

        return redirect()->back()->withErrors(['login' => 'Username atau password salah']);
    }

    // Logout admin
    public function logout()
    {
        session()->flush();
        return redirect()->route('home'); // arahkan ke halaman login
    }
}
