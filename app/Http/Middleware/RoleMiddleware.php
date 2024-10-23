<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check() || Auth::user()->role !== $role) {
            // Rediriger ou retourner une réponse d'erreur si l'utilisateur n'a pas le rôle requis
            return redirect('/')->with('error', 'Vous n\'avez pas accès à cette page.');
        }

        return $next($request);
    }
}
