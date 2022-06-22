<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class creationCompteRecepteur extends Mailable
{
    use Queueable, SerializesModels;

    public $data=[];
    public function __construct(array $recepteur)
    {
        $this->data=$recepteur;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Monmessage person')
                    ->view('emails.recepteurMail')
                    ->attach(public_path('Images/background1.jpg'));// mettre une piece jointe
    }
}
