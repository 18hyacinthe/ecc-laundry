<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Models\Setting;

class CheckWeeklyReservationLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Récupérer la limite hebdomadaire depuis les paramètres, utiliser 3 comme valeur par défaut
        $weeklyLimit = Setting::where('key', 'weekly_session_limit')->value('value') ?? 3;

        // Compter les réservations de l'utilisateur pour la semaine en cours
        $reservationsThisWeek = $user->reservations()
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        // Vérifier si la limite est atteinte
        if ($reservationsThisWeek >= $weeklyLimit) {
            toastr()->warning('Vous avez atteint la limite de réservations hebdomadaires!');
            return redirect()->back();
            // return response()->json(['error' => 'Vous avez atteint la limite de réservations hebdomadaires.'], 403);
        }

        return $next($request);
    }
}
