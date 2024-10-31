<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class AdminSettingsController extends Controller
{

    public function showReservationsSettings()
    {
        // Récupérer les valeurs actuelles pour la vue
        $sessionDuration = Setting::getSetting('session_duration', '120'); // Par défaut : 2 heures
        $sessionStartTime = Setting::getSetting('session_start_time', '06:00'); // Par défaut : 6h00
        $weeklySessionLimit = Setting::getSetting('weekly_session_limit', '3'); // Par défaut : 3 sessions
        $resetTime = Setting::getSetting('reset_time', '00:00'); // Par défaut : 00:00
    
        return view('admin.settings.reservations', compact('sessionDuration', 'sessionStartTime', 'weeklySessionLimit', 'resetTime'));
    }
    

    public function updateReservationsSettings(Request $request)
    {
        // Validation
        $request->validate([
            'session_duration' => 'required|integer|min:1',
            'session_start_time' => 'required|date_format:H:i',
            'weekly_session_limit' => 'required|integer|min:1',
        ]);

        // Mettre à jour les paramètres
        Setting::updateOrCreate(['key' => 'session_duration'], ['value' => $request->session_duration]);
        Setting::updateOrCreate(['key' => 'session_start_time'], ['value' => $request->session_start_time]);
        Setting::updateOrCreate(['key' => 'weekly_session_limit'], ['value' => $request->weekly_session_limit]);

        toastr()->success('Les paramètres de réservation ont été mis à jour avec succès!');
        return back();
    }

        public function updateResetSystem(Request $request)
    {
        $request->validate([
            'reset_time' => 'required|date_format:H:i',
        ]);

        // Enregistrer le temps de réinitialisation dans la configuration ou la base de données
        // Par exemple, vous pouvez utiliser un fichier de configuration ou une table de réglages
        Setting::updateOrCreate(['key' => 'reset_time'], ['value' => $request->reset_time]);

        toastr()->success('Heure de réinitialisation mise à jour avec succès!');
        return back();
    }

    public function manualReset()
    {
        // Logique pour réinitialiser toutes les réservations ou configurations
        // Par exemple, vous pouvez remettre à zéro les paramètres dans la table de réglages
        Setting::where('key', 'session_duration')->update(['value' => '120']); // Réinitialiser à la valeur par défaut
        Setting::where('key', 'session_start_time')->update(['value' => '06:00']);
        Setting::where('key', 'weekly_session_limit')->update(['value' => '3']);
        Setting::where('key', 'reset_time')->update(['value' => '00:00']);
    
        toastr()->success('Toutes les sessions ont été réinitialisées avec succès!');
        return back();
    }


    public function showDomainCheck()
    {
        $allowedDomain = Setting::getSetting('allowed_domain', ''); // Par défaut : vide
        $allowOtherDomains = Setting::getSetting('allow_other_domains', '0'); // Par défaut : désactivé

        $settings = [
            'allowed_domain' => $allowedDomain,
            'allow_other_domains' => $allowOtherDomains,
        ];

        return view('admin.domaine-check.domain-restrictions', compact('settings'));
    }


    public function updateDomainCheck(Request $request)
    {
        $request->validate([
            'allowed_domain' => 'required|string',
            'allow_other_domains' => 'required|boolean',
        ]);

        Setting::updateOrCreate(['key' => 'allowed_domain'], ['value' => $request->allowed_domain]);
        Setting::updateOrCreate(['key' => 'allow_other_domains'], ['value' => $request->allow_other_domains]);

        toastr()->success('Paramètres de restriction de domaine mis à jour avec succès!');
        return back();
    }
    

}
