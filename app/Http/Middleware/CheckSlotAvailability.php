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
        $validated = $request->validate([
            'machine_id' => 'required|exists:machines,id',
            // 'start_time' => 'required|date|after:now',
            'start_time' => 'required|date',
            'end_time'   => 'required|date|after:start_time',
        ]);

        $machineId = $validated['machine_id'];
        $startTime = $validated['start_time'];
        $endTime = $validated['end_time'];

        // Recherche des conflits de réservation
        $hasConflict = Reservation::where('machine_id', $machineId)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<', $endTime) // Chevauchement au début
                          ->where('end_time', '>', $startTime); // Chevauchement à la fin
                })
                ->orWhere(function ($query) use ($startTime, $endTime) {
                    $query->where('start_time', '<=', $startTime) // Plage existante englobant la nouvelle
                          ->where('end_time', '>=', $endTime);
                });
            })
            ->exists();

        // Gestion des conflits
        if ($hasConflict) {
            return $this->handleErrorResponse($request, 'Cette machine est déjà réservée pour le créneau sélectionné.', 409);
        }

        return $next($request);
    }

    /**
     * Gérer les réponses d'erreur pour les requêtes AJAX et non-AJAX.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $message
     * @param int $statusCode
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function handleErrorResponse(Request $request, string $message, int $statusCode): Response
    {
        if ($request->ajax()) {
            return response()->json(['error' => $message], $statusCode);
        } else {
            return redirect()->back()->withErrors(['error' => $message]);
        }
    }
}
