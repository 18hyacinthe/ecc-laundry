<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActivity;

class TrackPageViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Do not log API requests or assets (CSS, JS)
        if ($request->is('api/*') || $request->is('assets/*')) {
            return $next($request);
        }

        try {
            DB::table('page_views')->insert([
                'url' => $request->fullUrl(), // Full URL visited
                'ip_address' => $request->ip(), // IP address
                'user_id' => Auth::id(), // ID of the logged-in user
                'user_agent' => $request->header('User-Agent'), // Browser
                'visited_at' => now(), // Date of the visit
            ]);

            UserActivity::create([
                'user_id' => Auth::id(),
                'activity' => 'Visited page',
                'url' => $request->fullUrl(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to log page view or user activity: ' . $e->getMessage());
        }

        return $next($request);
    }
}
