<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SetUserLangueage
{

    // Cambiar el idioma de la aplicación dependiendo del idioma del usuario
    public function handle(Request $request, Closure $next): Response{
        
        if (Auth::check() && Auth::user()->language) {
            App::setLocale(Auth::user()->language);
        }

        return $next($request);
    }
}
