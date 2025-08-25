<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('login_id')) {
            return redirect()->route('login')->with('error', 'Silahkan login admin terlebih dahulu.');
        }
        return $next($request);
    }
}
