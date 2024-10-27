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
        $sessionDuration = Setting::where('key', 'session_duration')->value('value');
        $sessionStartTime = Setting::where('key', 'session_start_time')->value('value');
        $resetTime = Setting::where('key', 'reset_time')->value('value');

        $startTime = Carbon::parse($request->input('start_time'));
        $endTime = Carbon::parse($request->input('end_time'));
        $sessionStartTime = Carbon::parse($sessionStartTime);
        $resetTime = Carbon::parse($resetTime);

        // Si l'heure de réinitialisation est inférieure à l'heure de début de session, ajoutez un jour à l'heure de réinitialisation
        if ($resetTime->lt($sessionStartTime)) {
            $resetTime->addDay();
        }

        // Si l'heure de fin est inférieure à l'heure de début, ajoutez un jour à l'heure de fin
        if ($endTime->lt($startTime)) {
            $endTime->addDay();
        }

        // 1. Vérifie que l'intervalle entre start_time et end_time est de 59 minutes minimum
        if ($startTime->diffInMinutes($endTime) < 59) {
            toastr()->warning('L\'intervalle entre le début et la fin de la session doit être d\'au moins 59 minutes.');
            return redirect()->back();
            // return response()->json(['error' => 'L\'intervalle entre le début et la fin de la session doit être d\'au moins 59 minutes.'], 403);
        }

        // 2. Vérifie que la durée entre start_time et end_time ne dépasse pas la durée de session définie
    
        if ($startTime->diffInMinutes($endTime) > $sessionDuration) {
            toastr()->warning('La durée de session dépasse la limite autorisée!');
            return redirect()->back();
            // return response()->json(['error' => 'La durée de session dépasse la limite autorisée.'], 403);
        }

        // // 3. Vérifie que start_time et end_time sont compris entre session_start_time et reset_time
        // $sessionStartTime = Carbon::parse($sessionStartTime);
        // $resetTime = Carbon::parse($resetTime);

        // if ($startTime->lt($sessionStartTime) || $endTime->gt($resetTime)) {
        //     toastr()->warning('La session doit être réservée entre ' . $sessionStartTime->format('H:i') . ' et ' . $resetTime->format('H:i') . '.');
        //     return redirect()->back();
        //     // return response()->json(['error' => 'La session doit être réservée entre ' . $sessionStartTime->format('H:i') . ' et ' . $resetTime->format('H:i') . '.'], 403);
        // }

        // 1. Convertir les heures de session
        $sessionStartTime = Carbon::parse($sessionStartTime);
        $resetTime = Carbon::parse($resetTime);


        // 2. Vérifiez que start_time et end_time sont compris entre session_start_time et reset_time
        if ($startTime->lt($sessionStartTime) || $endTime->gt($resetTime)) {
            toastr()->warning('La session doit être réservée entre ' . $sessionStartTime->format('H:i') . ' et ' . $resetTime->format('H:i') . '.');
            return redirect()->back();
        }


        return $next($request);
    }
}
