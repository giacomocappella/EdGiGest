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

    public $ticket;
    public $tasks;
    public $clientmail;

    /**
     * Create a new message instance.
     */
    public function __construct($ticket, $tasks)
    {
        $this->ticket = $ticket;
        $this->tasks = $tasks;
    }

    public function build()
    {
        return $this->subject('Report Chiusura Ticket #' . $this->ticket->id . ' - EdGiTech')
                    ->view('MailTicketClosed')
                    ->with([
                        'ticket' => $this->ticket,
                        'tasks'=> $this->tasks,
                        ]);
    }
}
