<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CloseTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nameticket;
    public $datatask;
    public $clientmail;

    /**
     * Create a new message instance.
     */
    public function __construct($nameticket, $datatask)
    {
        $this->nameticket = $nameticket;
        $this->datatask = $datatask;
    }

    public function build()
    {
        return $this->subject('Rapportino Chiusura Ticket - EdGiTech')
                    ->view('MailTicketClosed')
                    ->with([
                        'nameticket' => $this->nameticket,
                        'tasks'=> $this->datatask,
                        ]);
    }
}
