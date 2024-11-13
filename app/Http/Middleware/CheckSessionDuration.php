<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Models\Setting;

class CheckSessionDuration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Récupère les paramètres depuis la table settings
        $settings = Setting::whereIn('key', ['session_duration', 'session_start_time', 'reset_time'])->pluck('value', 'key');
        $sessionDuration = $settings['session_duration'];
        $sessionStartTime = Carbon::parse($settings['session_start_time']);
        $resetTime = Carbon::parse($settings['reset_time']);

        $startTime = Carbon::parse($request->input('start_time'));
        $endTime = Carbon::parse($request->input('end_time'));

        if ($resetTime->eq($sessionStartTime)) {
            // Si l'heure de fin est inférieure à l'heure de début, ajoutez un jour à l'heure de fin
            if ($endTime->lt($startTime)) {
                $endTime->addDay();
            }

            // Vérifie que l'intervalle entre start_time et end_time ne dépasse pas la durée de session définie
            if ($startTime->diffInMinutes($endTime) > $sessionDuration) {
                toastr()->error('La durée de session dépasse la limite autorisée!');
                return redirect()->back();
            }

            // Vérifie si l'heure de début de réservation est inférieure à l'heure actuelle
            $currentTime = Carbon::now();
            if ($startTime->lt($currentTime)) {
                // Vérifie si l'heure de début est comprise entre l'heure actuelle moins 5 minutes
                if ($startTime->lt($currentTime->subMinutes(5))) {
                    toastr()->error('L\'heure de début de réservation ne peut pas être inférieure à l\'heure actuelle moins 5 minutes.');
                    return redirect()->back();
                }
            }

        } else {
            // Si l'heure de réinitialisation est inférieure à l'heure de début de session, ajoutez un jour à l'heure de réinitialisation
            if ($resetTime->lt($sessionStartTime)) {
                $resetTime->addDay();
            }

            // Si l'heure de fin est inférieure à l'heure de début, ajoutez un jour à l'heure de fin
            if ($endTime->lt($startTime)) {
                $endTime->addDay();
            }

            // Vérifie que la durée entre start_time et end_time ne dépasse pas la durée de session définie
            if ($startTime->diffInMinutes($endTime) > $sessionDuration) {
                toastr()->error('La durée de session dépasse la limite autorisée!');
                return redirect()->back();
            }

            // Vérifiez que start_time et end_time sont compris entre session_start_time et reset_time
            if ($startTime->lt($sessionStartTime) || $endTime->gt($resetTime)) {
                toastr()->error('La session doit être réservée entre ' . $sessionStartTime->format('H:i') . ' et ' . $resetTime->format('H:i') . '.');
                return redirect()->back();
            }
        }

        return $next($request);
    }
}
