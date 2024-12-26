<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$guard = null): Response
    {   
        if (Auth::guard($guard)->check()) {
            // Jika pengguna sudah login, redirect ke halaman dashboard
            return redirect('/admin'); // Ganti dengan route yang sesuai
        }
        return $next($request);
    }
}