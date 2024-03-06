<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class forgetPasswordEmail extends Mailable
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
            subject: 'Forget Password Email',
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
            markdown: 'mails.forgetPasswordEmail',
        );
    } */
    public function build()
    {
        return $this->markdown('mails.forgetPasswordEmail')->with('data',$this->data);
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
