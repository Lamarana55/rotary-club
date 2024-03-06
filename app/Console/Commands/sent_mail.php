<?php

namespace App\Console\Commands;

use App\Mail\SendMail;
use App\Models\SentMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class sent_mail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $emails = SentMail::where('is_sent', false)->get();

        $count = 0;
        foreach($emails as $mail){
            Mail::to($mail->getUser->email)->send(new SendMail($mail->getUser,$mail->title, $mail->message, $mail->media, $mail->url));
            $mail->update(["is_sent"=> true]);
            $count++; 
        }
        echo "Mails envoiés: $count \n";
        return Command::SUCCESS;
    }
}
