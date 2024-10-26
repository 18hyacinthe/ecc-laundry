<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $requestedTime = $request->input('requested_time');

        $isSlotAvailable = \App\Models\Reservation::where('machine_id', $machineId)
            ->where('requested_time', $requestedTime)
            ->doesntExist();

        if (!$isSlotAvailable) {
            return response()->json(['error' => 'Le créneau demandé n\'est pas disponible pour cette machine'], 403);
        }

        return $next($request);
    }
}
