<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pathpdf;
    public $user;
    /**
     * Create a new message instance.
     */
    public function __construct($pathpdf, $user)
    {

        $this->pathpdf = $pathpdf;
        $this->user= $user;
    }

    public function build()
    {
        return $this->subject('Ricevuta di prestazione occasionale - EdGiTech')
                    ->view('MailSendReceipt')
                    ->attach($this->pathpdf)
                    ->with([
                        'user' => $this->user,
                        ]);
    }
}
