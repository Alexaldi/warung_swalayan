<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role): Response{

        //? Cek role user
        if (Auth::user()->role == $role) {
           //! Jika role user sesuai dengan role yang diinginkan
            return $next($request);
        }
            //! Jika role user tidak sesuai dengan role yang diinginkan
        return redirect('home')->withErrors('Anda tidak memiliki akses ke halaman ini');
    }
}
