<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;
use Carbon\Carbon;

class MachineOverviewController extends Controller
{
        public function index(Request $request)
    {
        // Obtenir le décalage horaire de l'utilisateur depuis la requête
        $userTimeZoneOffset = $request->input('timezone_offset', 0); // En minutes

        $machines = Machine::with('reservations')->get();

        $machinesData = $machines->map(function($machine) use ($userTimeZoneOffset) {
            // Récupération de la dernière réservation
            $latestReservation = $machine->reservations()->latest()->first();

            // Ajustement de l'heure actuelle en fonction du fuseau horaire de l'utilisateur
            $now = Carbon::now()->addMinutes($userTimeZoneOffset);
            $nextAvailableTime = $latestReservation 
                ? Carbon::parse($latestReservation->end_time)->addMinute()->addMinutes($userTimeZoneOffset)
                : $now;

            // Vérification de la disponibilité
            $isAvailableNow = !$latestReservation || $now->greaterThanOrEqualTo($latestReservation->end_time);

            return [
                'name' => $machine->name,
                'type' => $machine->type, // Assurez-vous que cette propriété est définie dans votre modèle Machine
                'status' => $isAvailableNow ? 'available' : 'in-use',
                'next_available_time' => $isAvailableNow ? 'Disponible maintenant' : $nextAvailableTime->format('H:i'),
            ];
        });

        // dd($machinesData);

        return view('frontend.machine.index', compact('machinesData'));
    }

}
