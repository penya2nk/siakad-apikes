<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class RedirectIfUserMahasiswaAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard = 'isMahasiswa')
    {
         if (!Auth::guest() && Auth::guard($guard)->check()){
            
			 return redirect('/home/menu_mahasiswa');
           
			}
         return $next($request);
    }
}