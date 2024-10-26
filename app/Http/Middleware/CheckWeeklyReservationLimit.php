<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

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
        $weeklyLimit = 3; // Obtenez cette valeur depuis les paramètres admin si elle est dynamique

        $reservationsThisWeek = $user->reservations()
            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        if ($reservationsThisWeek >= $weeklyLimit) {
            return response()->json(['error' => 'Vous avez atteint la limite de réservations hebdomadaires'], 403);
        }

        return $next($request);
    }
    
}
