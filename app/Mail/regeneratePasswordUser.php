<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class regeneratePasswordUser extends Mailable
{
    use Queueable, SerializesModels;

    public $reinit_password ;
    public $data_user;
    public $url = "localhost:9000";
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->data_user = $user;
        $this->reinit_password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('jeanpierre.thx@gmail.com')
                    ->subject('regenerate password')
                    ->markdown('mails.regeneratePasswordUser');
    }
}
