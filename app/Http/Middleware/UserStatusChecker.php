<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserStatusChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Vérification du statut de l'utilisateur
        if ($user && !$user->status) {
            // Si le compte est inactif, afficher une notification Toastr et rediriger
            Toastr()->warning(__('Impossible de réserver : votre compte est inactif. Veuillez contacter l\'administrateur.'));
            return redirect()->route('user.reservation.index'); // Rediriger vers la page d'accueil ou une autre page appropriée
        }

        return $next($request); // Continuer la requête si le compte est actif
    }
}
