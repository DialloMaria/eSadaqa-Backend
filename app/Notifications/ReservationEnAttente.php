<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationEnAttente extends Notification
{
    use Queueable;
    public $don;
    public $organisation;
    public $beneficiaire;
    public $reservation;

    public function __construct($don, $organisation, $beneficiaire, $reservation)
    {
        $this->don = $don;
        $this->reservation = $reservation;
        $this->organisation = $organisation;
        $this->beneficiaire = $beneficiaire;
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
                        ->subject('Nouvelle réservation en attente')
                        ->greeting('Bonjour !')
                        ->line('Une nouvelle réservation sur le don ' . $this->don->libelle . ' est en attente de votre confirmation.')
                        ->line('Organisation : ' . ($this->organisation ? $this->organisation->nomstructure : 'Inconnue'))
                        ->line('Bénéficiaire : ' . ($this->beneficiaire ? $this->beneficiaire->nomstructure : 'Inconnu'))
                        ->line('reservation  : ' . ($this->reservation ? $this->reservation ->id: 'inconnu'))
                        ->action('Voir la réservation', url('/dons/' . $this->don->id))
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
            'message' => 'Une nouvelle réservation  est en attente de votre confirmation.',
            'organisation' => $this->organisation ? $this->organisation->nom : 'Inconnue',
            'beneficiaire' => $this->beneficiaire ? $this->beneficiaire->nomstructure : 'Inconnu',
            'reservation' => $this->reservation ? $this->reservation->id : 'Inconnu',
        ];
    }
}
