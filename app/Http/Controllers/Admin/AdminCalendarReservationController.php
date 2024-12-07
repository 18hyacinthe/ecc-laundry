<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;
use App\Models\Machine;

class AdminCalendarReservationController extends Controller
{
    public function index(Request $request)
    {
        $events = [];
        
        // Récupérer toutes les réservations avec les relations utilisateur et machine
        $reservations = Reservation::with(['user', 'machine'])->get();

        foreach ($reservations as $reservation) {
            // Convertir start_time et end_time en instances de Carbon
            $start_time = Carbon::parse($reservation->start_time);
            $end_time = Carbon::parse($reservation->end_time);

            // Utiliser la couleur de la machine si elle est définie, sinon utiliser une couleur par défaut
            $color = $reservation->machine->color ?? ($reservation->machine->type == 'washing-machine' ? '#3a04cc' : '#05ad21');

            // Ajouter l'événement au tableau avec les informations nécessaires
            $events[] = [
                'start' => $reservation->start_time,
                'end' => $reservation->end_time,
                'backgroundColor' => $color,
                'textColor' => '#ffffff', // Couleur du texte pour une meilleure visibilité
                'extendedProps' => [
                    'user_name' => $reservation->user->name,
                    'user_phone' => $reservation->user->phone ?? 'indisponible',
                    'user_email' => $reservation->user->email,
                    'machine_name' => $reservation->machine->name,
                    'machine_status' => $reservation->machine->status,
                ],
            ];
        }

        // Récupérer toutes les machines pour la légende
        $machines = Machine::all();


        return view('admin.reservation.calendar', compact('events', 'machines'));
    }

    public function getMachineDetails($id)
    {
        $machine = Machine::with(['reservations' => function($query) {
            $query->whereDate('start_time', Carbon::today())
                ->orderBy('start_time', 'asc');
        }])->findOrFail($id);

        $machineName = $machine->name;
        
        return response()->json([
            'machineName' => $machineName,
            'view' => view('admin.reservation.calendar-machine-details', compact('machine'))->render()
        ]);
    }
}
