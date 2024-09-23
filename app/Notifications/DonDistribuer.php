<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Rapport;

class DonDistribuer extends Notification
{
    use Queueable;

    public $rapport;

    /**
     * Create a new notification instance.
     */
    public function __construct(Rapport $rapport)
    {
        $this->rapport = $rapport;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
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
                    ->subject('Rapport de Don Distribué')
                    ->greeting('Bonjour !')
                    ->line('Le bénéficiaire a confirmé la réception du don.')
                    ->line('Vous trouverez ci-dessous les détails du rapport :')
                    ->line($this->rapport->contenu) // Inclure le contenu du rapport
                    ->action('Voir plus de détails', url('/rapports/' . $this->rapport->id))
                    ->line('Merci pour votre générosité et d\'utiliser notre plateforme !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'rapport_id' => $this->rapport->id,
            'message' => 'Le bénéficiaire a bien reçu le don et un rapport a été généré.',
        ];
    }
}
