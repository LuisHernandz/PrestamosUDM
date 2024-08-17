<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BibliotecarioAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check()){
            if(auth()->user()->roles_rol_id == '2'){
                return $next($request); 
            }elseif(auth()->user() -> roles_rol_id == '1'){
                return redirect() -> to('/admin');
            }
            elseif(auth()->user() -> roles_rol_id == '3'){
                return redirect() -> to('/libros/fisicos');
            }
            return redirect() -> to('/acceso');
        }
    }
}
