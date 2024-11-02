<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;

class UserCalendarReservation extends Controller
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

            // Déterminer la couleur en fonction du type de machine
            $color = $reservation->machine->type == 'washing-machine' ? '#3a04cc' : '#05ad21';

            // Ajouter l'événement au tableau avec les informations nécessaires
            $events[] = [
                'title' => $reservation->machine->name . ' (' . $start_time->format('H:i') . ' - ' . $end_time->format('H:i') . ')',
                'start' => $reservation->start_time,
                'end' => $reservation->end_time,
                'backgroundColor' => $color,
                'textColor' => '#ffffff', // Couleur du texte pour une meilleure visibilité
                'extendedProps' => [
                    'user_name' => $reservation->user->name,
                    'user_phone' => $reservation->user->phone,
                    'user_email' => $reservation->user->email,
                    'machine_status' => $reservation->machine->status,
                ],
            ];
        }

        return view('frontend.reservation.calendar-reservation', compact('events'));
    }
}
