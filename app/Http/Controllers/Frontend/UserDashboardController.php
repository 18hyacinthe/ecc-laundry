<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;
use App\Models\Setting;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Définir la limite de sessions autorisées (à récupérer depuis les paramètres admin si disponible)
        $totalSessionsAllowed = Setting::getSetting('weekly_session_limit', 3);

        // Obtenir le nombre de sessions utilisées par l'utilisateur cette semaine
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $sessionsUsed = Reservation::where('user_id', $user->id)
                        ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                        ->count();

        // Calculer les sessions restantes
        $sessionsRemaining = max(0, $totalSessionsAllowed - $sessionsUsed);

        // Récupérer l'historique des réservations de l'utilisateur
        $reservations = Reservation::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('frontend.dashboard.common.dashboard', compact('totalSessionsAllowed', 'sessionsUsed', 'sessionsRemaining', 'reservations'));
    }
}
