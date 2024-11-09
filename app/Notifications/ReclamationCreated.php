<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Reclamation;

class ReclamationCreated extends Notification
{
    use Queueable;

    protected $reclamation;

    public function __construct(Reclamation $reclamation)
    {
        $this->reclamation = $reclamation;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nouvelle Réclamation Créée')
                    ->line('Une nouvelle réclamation a été créée.')
                    ->action('Voir la réclamation', url('user/reclamation/' . $this->reclamation->id))
                    ->line('Merci d\'utiliser notre application !');
    }
}