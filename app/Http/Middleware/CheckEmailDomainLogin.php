<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Mail\ContactAdminMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;

class CheckEmailDomainLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Validation de base
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Extraction du domaine de l'email
        $emailDomain = substr(strrchr($request->email, "@"), 1);

        // Récupération des paramètres dans la table settings
        $allowedDomain = Setting::where('key', 'allowed_domain')->value('value');
        $allowOtherDomains = Setting::where('key', 'allow_other_domains')->value('value');

        // Vérifie si l'utilisateur existe
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Toastr()->error(__('Utilisateur non trouvé.'));
            return redirect()->route('login')->withErrors(['email' => __('Utilisateur non trouvé.')]);
        }

        if ($emailDomain === $allowedDomain) {
            // Domaine autorisé : vérification du statut de l'utilisateur
            if (!$user->status) {
                Toastr()->warning(__('Votre compte est inactif. Veuillez contacter l\'administrateur pour l\'activer.'));
                return redirect()->route('login');
            }
            return $next($request);
        } elseif ($allowOtherDomains) {
            // Domaine non autorisé, mais autres domaines permis
            if (!$user->status) {
                // Envoi de l'email pour contacter l'admin
                Mail::to($user->email)->send(new ContactAdminMail($user));
                Toastr()->info(__('Veuillez contacter l\'administrateur pour activer votre compte.'));
                return redirect()->route('login');
            }
            return $next($request);
        } else {
            // Domaine non autorisé et autres domaines refusés
            Toastr()->error(__('Impossible de se connecter avec ce domaine email.'));
            return redirect()->route('login')->withErrors(['email' => __('Domaine non autorisé.')]);
        }
    }
}
