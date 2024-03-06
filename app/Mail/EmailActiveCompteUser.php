<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailActiveCompteUser extends Mailable
{
    use Queueable, SerializesModels;
    private $data;
    /**
     * Create a new data instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the data envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: ($this->data['type']=='VALIDE_USER')?"Validation d'un compte":"Activation d'un compte",
        );
    }

    /**
     * Get the data content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    /* public function content()
    {
        return new Content(
            markdown: 'mails.EmailActiveCompteUser',
        );
    } */
    public function build()
    {

        return $this->markdown('mails.EmailActiveCompteUser')->with('data',$this->data);
    }
    /**
     * Get the attachments for the data.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
