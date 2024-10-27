<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Setting;
use App\Models\Machine;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class UserReservationController extends Controller
{
    public function showReservationForm()
    {
        $user = Auth::user();
        $machines = Machine::all(); // Récupère toutes les machines

        // Définir la limite de sessions autorisées (à récupérer depuis les paramètres admin si disponible)
        $totalSessionsAllowed = Setting::getSetting('weekly_session_limit', 3);

        // Obtenir le nombre de sessions utilisées par l'utilisateur cette semaine
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        $sessionsUsed = Reservation::where('user_id', $user->id)
                ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
                ->count();

        // Calculer les sessions restantes
        $weeklySessionLimitRemaining = max(0, $totalSessionsAllowed - $sessionsUsed);

        toastr()->info('Il vous reste ' . $weeklySessionLimitRemaining . ' sessions cette semaine.');

        return view('frontend.reservation.index', compact('machines', 'weeklySessionLimitRemaining'));
    }

    public function reserve(Request $request)
    {
        // Validations côté contrôleur en cas d'erreurs (même si elles sont couvertes par les middlewares)
        $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time'
        ]);

        $userId = $request->user()->id;
        $machineId = $request->input('machine_id');
        $startTime = Carbon::parse($request->input('start_time'));
        $endTime = Carbon::parse($request->input('end_time'));

        // Calcul du nombre de réservations restantes
        $weeklyLimit = Setting::getSetting('weekly_session_limit', 3);
        $reservationsCount = Reservation::where('user_id', $userId)
                                        ->whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()])
                                        ->count();
        $weeklySessionLimitRemaining = max($weeklyLimit - $reservationsCount, 0);

        // Création de la réservation après validation
        Reservation::create([
            'user_id' => $userId,
            'machine_id' => $machineId,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'weekly_session_limit_remaining' => $weeklySessionLimitRemaining - 1
        ]);

        return back()->with('success', 'Réservation confirmée pour ' . $startTime->format('H:i') . ' à ' . $endTime->format('H:i'));
    }
}
