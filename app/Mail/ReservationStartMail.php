<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;

class ReservationStartMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function build()
    {
        return $this->subject('Début de votre réservation')
                    ->markdown('emails.reservations.start')
                    ->with([
                        'userName' => $this->reservation->user->name,
                        'startTime' => $this->reservation->start_time,
                        'machineName' => $this->reservation->machine->name,
                    ]);
    }
}
