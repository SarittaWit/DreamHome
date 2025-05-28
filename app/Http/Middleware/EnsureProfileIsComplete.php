<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureProfileIsComplete
{
    public function handle(Request $request, Closure $next)
    {
        // Exemple : vérifier si l'utilisateur a un numéro de téléphone
        if (is_null($request->user()->phone)) {
            return redirect()->route('HomePage')->with('error', 'Veuillez compléter votre profil.');
        }

        return $next($request);
    }
}
