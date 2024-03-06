<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\{User, Media};

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $receiver;
    public $media;
    public $objet;
    public $message;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $receiver, $objet, $message, $media = null, $url = null)
    {
        $this->receiver = $receiver;
        $this->media = $media;
        $this->objet = $objet;
        $this->message = $message;
        $this->url = $url;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->objet,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: "emails.main"
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
