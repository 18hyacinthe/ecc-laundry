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

        $conflictingReservations = Reservation::where('machine_id', $machineId)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();

        if ($conflictingReservations) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Cette machine est déjà réservée pour le créneau sélectionné.'], 409);
            } else {
                toastr()->warning('Cette machine est déjà réservée pour le créneau sélectionné.');
                return redirect()->back();
            }
        }

        return $next($request);
    }

}
