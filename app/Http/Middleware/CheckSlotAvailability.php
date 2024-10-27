<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Reservation;

class CheckSlotAvailability
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $machineId = $request->input('machine_id');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');

        // Récupère la réservation la plus récente de la machine
        $latestReservation = Reservation::where('machine_id', $machineId)
            ->orderBy('end_time', 'desc')
            ->first();

        // Vérifie si la réservation la plus récente existe et qu'elle chevauche le créneau demandé
        if ($latestReservation) {
            if (
                ($startTime < $latestReservation->end_time) &&
                ($endTime > $latestReservation->start_time)
            ) {
                toastr()->warning('Cette machine est déjà réservée pour ce créneau! Veuillez revenir en arrière et choisir un autre créneau.');
                return redirect()->back();
                // return response()->json(['error' => 'Le créneau demandé n\'est pas disponible pour cette machine'], 403);
            }
        }

        return $next($request);
    }
}
