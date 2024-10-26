<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionDuration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sessionDuration = config('settings.session_duration'); // Récupère la durée de session depuis les réglages admin
        $requestedTime = \Carbon\Carbon::parse($request->input('requested_time'));
        $now = \Carbon\Carbon::now();

        if ($requestedTime->diffInMinutes($now) > $sessionDuration) {
            return response()->json(['error' => 'La durée de session dépasse la limite autorisée'], 403);
        }

        return $next($request);
    }
}
