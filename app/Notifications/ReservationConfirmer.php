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
            ->subject('DON OFFERT')
            ->greeting('Bonjour ' . ($this->beneficiaire && $this->beneficiaire->user ? $this->beneficiaire->user->nom : 'Bénéficiaire') . ',')
            // Vérifie si $this->organisation est un objet avant d'accéder à la propriété
            ->line('Organisation : ' . (is_object($this->organisation) && property_exists($this->organisation, 'nomstructure')
                    ? $this->organisation->nomstructure
                    : 'Inconnue') . ' viendra vous le fournir d\'ici quelque temps.')
            ->action('Voir le don', url('/dons/'.$this->don->id))
            ->line('Bonne réception!');
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
