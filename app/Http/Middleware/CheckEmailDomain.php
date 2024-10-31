<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Mail\ContactAdminMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;

class CheckEmailDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Validation de base
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Extraction du domaine de l'email
        $emailDomain = substr(strrchr($request->email, "@"), 1);

        // Récupération des paramètres dans la table settings
        $allowedDomain = Setting::where('key', 'allowed_domain')->value('value'); // Assurez-vous d'avoir une méthode pour récupérer ce paramètre
        $allowOtherDomains = Setting::where('key', 'allow_other_domains')->value('value');

        if ($emailDomain === $allowedDomain) {
            return $next($request); // Domaine autorisé, continuez la requête
        } elseif ($allowOtherDomains) {
            // Domaine non autorisé mais autres domaines permis
            // Création de l'utilisateur avec is_active = false
            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'is_active' => false,
            ]);

            // Envoi de l'email pour contacter l'admin avec l'utilisateur
            Mail::to($user->email)->send(new ContactAdminMail($user));

            Toastr()->info(__('Veuillez contacter l\'administrateur pour activer votre compte.'));
            return redirect()->route('login');
        } else {
            // Domaine non autorisé et autres domaines refusés
            Toastr()->error(__('Impossible de créer un compte avec ce domaine email.'));
            return redirect()->route('login')->withErrors(['email' => __('Domaine non autorisé.')]);
        }
    }
}
