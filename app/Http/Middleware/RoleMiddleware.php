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
            Auth::logout();
            toastr()->error('Vous n\'avez pas les autorisations nécessaires pour accéder à cette page.');
            return redirect('/');
        }

        return $next($request);
    }
}
