<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\DB;


class notificationUsers extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAllNotificationsPromoteurs(){
        Notification::where('isUpdate',false)
                    ->where('recever_id',auth()->user()->id)
                    ->update(['isUpdate'=>true]);
        $notification = Notification::where('recever_id',auth()->user()->id)
                ->orderBy('notification.created_at', 'desc')
                ->paginate(10);
        return view('notificationsUsers.notificationsPromoteurs', compact('notification'));
    }

    public function notificationLus($id){

        $user = Notification::find($id);
        $user->isUpdate = 0;
        $user->save();

        return redirect()->back();
    }

    public function previewPromoteur($media_id){
        Notification::where('isUpdate',false)
                    ->where('recever_id',auth()->user()->id)
                    ->update(['isUpdate'=>true]);
        return redirect()->route('detail-media', $media_id);
    }

    public function dafPreview($id){
        $notification = Notification::find($id);
        if($notification->isUpdate == 0){
            $notification->update(['isUpdate'=>true]);
        }

        return redirect()->route('detail-media',$notification->media->uuid);

    }
    public function previewDAF($id){//PAS bon
        $notification = Notification::find($id);
        $notification->update(['isUpdate'=>1]);

        return redirect()->route('detail-media',$notification->media->uuid);
    }
    public function previewCommission($id){
        $notification = Notification::find($id);
        if($notification->isUpdate == 0){
            $notification->update(['isUpdate'=>true]);
        }
        return redirect()->route('etude-document', $notification->media->uuid);
    }
    public function previewHAC($id){//GOOD
        $notification = Notification::find($id);
        if($notification->isUpdate == 0){
            $notification->update(['isUpdate'=>true]);
        }
        return redirect()->route('etude-document', $notification->media->uuid);
    }
    public function previewDirectionMedias($id){
        $notification = Notification::find($id);

        if($notification->isUpdate == 0){
            $notification->update(['isUpdate'=>true]);
        }

        if($notification->type_notification == 'rendez-vous')
            return redirect("meetings");
        else{
            return redirect()->route("detail-media",$notification->media->uuid);
        }

    }
    public function previewRDV($id){
        $notification = Notification::find($id);
        $notification->update(['isUpdate'=>true]);
        // if($notification == 'notification')
        return redirect("meetings");

    }
    public function previewSGG($id){//GOOD
        Notification::where('isUpdate',false)
                    ->where('recever_id',auth()->user()->id)
                    ->update(['isUpdate'=>true]);
        return redirect()->route('liste-medias');
    }
    public function previewADMIN($id){//GOOD
        Notification::where('isUpdate',false)
                    ->where('recever_id',auth()->user()->id)
                    ->update(['isUpdate'=>true]);
        return redirect()->route('utilisateur');
    }
}
