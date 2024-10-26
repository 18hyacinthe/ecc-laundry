<?php

namespace App\Http\Controllers\Admin;

use App\Models\Reservation;
use App\Models\Setting;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;

class AdminReservationController extends Controller
{
        public function showReservationForm()
    {
        // Obtenez la liste des machines disponibles pour la réservation
        $machines = Machine::all(); // Assurez-vous d’avoir le modèle Machine et les données dans la base

        return view('admin.booking.index', compact('machines'));
    }

        public function reserve(Request $request)
    {
        // Identifiants et heure demandée
        $userId = $request->user()->id;
        $machineId = $request->input('machine_id');
        $requestedTime = Carbon::parse($request->input('requested_time'));

        // Obtenir les paramètres de session depuis la table Setting
        $sessionDuration = (int) Setting::getSetting('session_duration', 2); // Convertir en entier
        $sessionStartTime = Carbon::parse(Setting::getSetting('session_start_time', '06:00'));
        $sessionEndTime = Carbon::parse(Setting::getSetting('session_end_time', '23:59:59'));

        // Validation de l'heure de réservation
        if ($requestedTime->lt($sessionStartTime) || $requestedTime->gt($sessionEndTime)) {
            return back()->withErrors(['error' => 'La réservation doit se faire entre 6h00 et 23h59.']);
        }

        // Vérifie l'alternance de 2h
        if ($requestedTime->diffInHours($sessionStartTime) % $sessionDuration != 0) {
            return back()->withErrors(['error' => 'Les réservations se font toutes les 2 heures à partir de 6h00.']);
        }

        // Limite hebdomadaire
        $weeklyLimit = Setting::getSetting('weekly_session_limit', 3);
        $reservationsCount = Reservation::where('user_id', $userId)
                                        ->whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()])
                                        ->count();
        if ($reservationsCount >= $weeklyLimit) {
            return back()->withErrors(['error' => 'Vous avez atteint la limite hebdomadaire de 3 sessions.']);
        }

        // Création de la réservation
        $endTime = $requestedTime->copy()->addHours($sessionDuration);
        Reservation::create([
            'user_id' => $userId,
            'machine_id' => $machineId,
            'start_time' => $requestedTime,
            'end_time' => $endTime,
        ]);

        return back()->with('success', 'Réservation confirmée pour ' . $requestedTime->format('H:i') . ' à ' . $endTime->format('H:i'));
    }

}
