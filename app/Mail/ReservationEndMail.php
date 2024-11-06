<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;

class ReservationEndMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function build()
    {
        return $this->subject('Fin de votre réservation')
                    ->markdown('emails.reservations.end')
                    ->with([
                        'userName' => $this->reservation->user->name,
                        'endTime' => $this->reservation->end_time,
                        'machineName' => $this->reservation->machine->name,
                    ]);
    }
}
