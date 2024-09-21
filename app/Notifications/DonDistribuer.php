<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonDistribuer extends Notification
{
    use Queueable;

    public $don;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->don = $don;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'notification', 'sms'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Don distribué')
                    ->greeting('Bonjour !')
                    ->line('Le bénéficiaire a confirmé la réception du don ' . $this->don->libelle . '. Le don est maintenant distribué.')
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
            'message' => 'Le bénéficiaire a bien reçu le don. Statut : distribué.',
        ];
    }
}
