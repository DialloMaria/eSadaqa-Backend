<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationConfirmer extends Notification
{
    use Queueable;

    public $don;

    /**
     * Create a new notification instance.
     */
    public function __construct($don)
    {
        $this->don = $don;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>T
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Réservation confirmée')
            ->greeting('Bonjour !')
            ->line('Le donateur a confirmé la réservation du don ' . $this->don->libelle . '.')
            ->action('Voir le don', url('/dons/' . $this->don->id))
            ->line('Merci d\'utiliser notre plateforme !');
    }



    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'don_id' => $this->don->id,
            'message' => 'Le donateur a confirmé la réservation du don.',
        ];
    }
}
