<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendReceiptMail2 extends Mailable
{
    use Queueable, SerializesModels;

    public $pathpdf;
    public $users;
    
    /**
     * Create a new message instance.
     */
    public function __construct($pathpdf, $users)
    {
        $this->pathpdf = $pathpdf; // Array di percorsi dei PDF
        $this->users = $users;
    }

    public function build()
    {
        $mail = $this->subject('Ricevuta di prestazione occasionale - EdGiTech')
                    ->view('MailSendReceipt2')
                    ->with([
                        'user' => $this->users,
                    ]);

        foreach ($this->pathpdf as $pdf) {
            $mail->attach($pdf);
        }

        return $mail;
    }
}

