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

        // Récupérer la limite hebdomadaire depuis les paramètres, avec une mise en cache pour améliorer les performances
        $weeklyLimit = cache()->remember('weekly_session_limit', 3600, function () {
            return Setting::where('key', 'weekly_session_limit')->value('value') ?? 3;
        });

        // Calcul des dates de début et de fin de la semaine pour éviter de recalculer plusieurs fois
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        // Compter les réservations de l'utilisateur pour la semaine en cours
        $reservationsThisWeek = $user->reservations()
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        // Vérifier si la limite est atteinte
        if ($reservationsThisWeek >= $weeklyLimit) {
            toastr()->error('Vous avez atteint la limite de réservations hebdomadaires!');
            return redirect()->back();
        }

        return $next($request);
    }
}
