<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendNotificationsToPromoteur extends Mailable
{
    use Queueable, SerializesModels;

    public $nameMedias;
    public $object;
    Public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nomMedias, $content, $object)
    {
        $this->nameMedias = $nomMedias;
        $this->object = $object;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Ministère de l\'information et de la communication')
                    ->view('mails.contenusMail');
    }
}
