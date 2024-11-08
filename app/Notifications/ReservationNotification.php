<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationNotification extends Notification
{
    use Queueable;

    protected $reservation;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nouvelle Réservation')
                    ->greeting('Bonjour ' . $notifiable->name . ',')
                    ->line('Votre réservation a été créée avec succès.')
                    ->line('Détails de la réservation :')
                    ->line('Machine : ' . $this->reservation->machine->name)
                    ->line('Heure de début : ' . $this->reservation->start_time->format('d/m/Y H:i'))
                    ->line('Heure de fin : ' . $this->reservation->end_time->format('d/m/Y H:i'))
                    // ->action('Voir la réservation', url('/user/reservations/' . $this->reservation->id))
                    ->action('Voir la réservation', url('/user/reservation/'))
                    ->line('Merci d\'utiliser notre application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'reservation_id' => $this->reservation->id,
            'machine_name' => $this->reservation->machine->name,
            'start_time' => $this->reservation->start_time,
            'end_time' => $this->reservation->end_time,
        ];
    }
}