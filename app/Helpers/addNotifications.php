<?php

use App\Models\User;
use App\Models\Media;
use Illuminate\Support\Str;
use App\Models\{Notification};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\SentMail as SendEmail;
use App\Mail\{sendNotificationsToPromoteur,SendMail};

// // notification
function notification(User $recever, $object, $message, $media = null, $rdv = null ){
    $sender = Auth::user();

    if(!$sender) $sender = $recever;

    $notification = new Notification;

    $notification->objet = $object;

    $notification->sender_id = $sender->id;
    $notification->recever_id = $recever->id;
    if($media) {
        $notification->media_id = $media->id;
        $notification->contenu = $message;
    } else {
        $notification->contenu = $message;
    }
    // $notification->isUpdate = 1;
    $notification->save();
}



function compteurNotifications(){
    $notificationNombre = Notification::where('recever_id',auth()->user()->id)
                ->where('isUpdate', 0)
                ->get();
        $valeur = count($notificationNombre);
    return $valeur;
}

function notificationPreview(){
        $notification= Notification::where('recever_id',auth()->user()->id)
                ->where('isUpdate', 0)
                ->orderBy('notification.created_at', 'desc')
                ->paginate(3);
    return $notification;
}

function filtre_message($message)
{
    if(is_array($message)) {
        $collect = collect($message)->filter(function ($text, $key) {
            $rexg = [
                "#^Bonjour Mme/Mr#",
                "#^Mme#",
                "#Veuillez vous connecter#"
            ];
            return (!preg_match($rexg[0], $text) AND !preg_match($rexg[1], $text) AND !preg_match($rexg[2], $text));
        });

        return $collect->join(" ");
    }

    return $message;
}


function send_notification(User $receiver, $object, $message, $media = null, $url = null, $onlyMail = 0,$type_notification=null){

    $sender = Auth::user();

    if(!$sender) $sender = $receiver;

    $notification = new Notification;

    $notification->objet = $object;

    $notification->sender_id = $sender->id;
    $notification->recever_id = $receiver->id;
    if($media) {
        $notification->media_id = $media->id;
        $notification->contenu = filtre_message($message);
    } else {
        $notification->contenu = filtre_message($message);
    }
    $notification->type_notification = $type_notification;
    // $notification->isUpdate = 1;
    if($onlyMail == 0 ){
        $notification->save();
    }
    $init_msg = $message;

    $send_mail = new SendEmail();
    if(is_array($message)) {
        $message = collect($message)->join("|");
    }

    $send_mail->title = $object;
    $send_mail->user = $receiver->id;
    $send_mail->message = $message;
    $send_mail->is_sent = false;
    $send_mail->url = $url;
    $send_mail->media = $media ? $media->id : null;

    $send_mail->save();

    // Mail::to($receiver->email)->send(new SendMail($receiver, $object, $init_msg, $media, $url));
    if(config("app.env") != 'local'){
       try {
            Mail::to($send_mail->getUser->email)->send(new SendMail($send_mail->getUser,$send_mail->title, $send_mail->message, $send_mail->media, $send_mail->url));
            SendEmail::where('id',$send_mail->id)->update([
                'is_sent'=>true
            ]);
        }catch (Throwable $exception) {
            Log::error($exception);
        }
    }

}


function trunWordNotif($content = "") {
    return Str::words($content, 10, ' ...');
}
