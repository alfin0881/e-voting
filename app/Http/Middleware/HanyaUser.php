<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HanyaUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->adalahAdmin()) {
            return redirect()->route('masuk')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return $next($request);
    }
}