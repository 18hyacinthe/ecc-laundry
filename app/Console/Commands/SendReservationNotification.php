<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Carbon\Carbon;
use App\Mail\ReservationStartMail;
use App\Mail\ReservationEndMail;
use Illuminate\Support\Facades\Mail;

class SendReservationNotification extends Command
{
    protected $signature = 'reservation:notify';
    protected $description = 'Envoie un email de début et fin de réservation aux utilisateurs';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();

        // Vérifier les réservations qui commencent maintenant
        $reservationsToStart = Reservation::where('start_time', '<=', $now)
            ->where('start_time', '>=', $now->subMinute())
            ->where('notified_start', false)
            ->get();

        foreach ($reservationsToStart as $reservation) {
            Mail::to($reservation->user->email)->send(new ReservationStartMail($reservation));
            $reservation->update(['notified_start' => true]);
        }

        // Vérifier les réservations qui se terminent maintenant
        $reservationsToEnd = Reservation::where('end_time', '<=', $now)
            ->where('end_time', '>=', $now->subMinute())
            ->where('notified_end', false)
            ->get();

        foreach ($reservationsToEnd as $reservation) {
            Mail::to($reservation->user->email)->send(new ReservationEndMail($reservation));
            $reservation->update(['notified_end' => true]);
        }

        $this->info('Notifications de réservation envoyées avec succès.');
    }
}
