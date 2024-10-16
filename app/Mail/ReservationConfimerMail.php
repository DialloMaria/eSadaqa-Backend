<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationConfimerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $don;

    /**
     * Create a new message instance.
     */
    public function __construct($don)
    {
        $this->don = $don;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reservation Confimée',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->subject('Reservation Confimée')
        ->html("Bonjour,
        Le donateur a confirmé la réservation du don : {$this->don->libelle}
        Voir le don : <a href='" . url('/dons/' . $this->don->id) . "'>ici</a>
        Merci d'utiliser notre plateforme !
        ")

        ;

    }

}
