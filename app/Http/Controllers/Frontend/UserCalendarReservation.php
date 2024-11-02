<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;

class UserCalendarReservation extends Controller
{
    public function index(Request $request)
    {
        $events = [];
        
        // Récupérer toutes les réservations avec les relations utilisateur et machine
        $reservations = Reservation::with(['user', 'machine'])->get();

        foreach ($reservations as $reservation) {
            $events[] = [
                'title' => $reservation->user->name . ' - ' . $reservation->machine->name,
                'start' => $reservation->start_time,
                'end' => $reservation->finish_time,
            ];
        }

        return view('frontend.reservation.calendar-reservation', compact('events'));
    
    }
}
