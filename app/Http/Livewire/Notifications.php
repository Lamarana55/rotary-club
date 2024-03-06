<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class Notifications extends Component
{

    public function getAllNotificationsPromoteurs(){
        $notification = Notification::join('user','notification.recever_id','=','user.id')
                ->where('recever_id',auth()->user()->id)
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

    public function previewPromoteur($id){
        $user = Notification::find($id);
        $user->update(['isUpdate'=>true]);
        return redirect()->route('detail-media', $user->media->uuid);
    }
    public function previewDAF($id){
        $notification = Notification::find($id);
        $notification->update(['isUpdate'=>true]);
        return redirect()->route('detail-media',$notification->media->uuid);
    }
    public function previewCommission($id){
        $user = Notification::find($id);
        $user->update(['isUpdate'=>true]);
        return redirect()->route('etude_media_commission');
    }
    public function previewHAC($id){
        $user = Notification::find($id);
        $user->update(['isUpdate'=>true]);

        return redirect("/medias/".$user->media->uuid."/etudes-documents");
    }
    public function previewDirectionMedias($id){

        $notification = Notification::find($id);
        $notification->update(['isUpdate'=>true]);
        if($notification->type_notification == 'rendez-vous')
            return redirect("meetings");
        else{
            return redirect()->route("detail-media",$notification->media->uuid);
        }
    }
    public function previewRDV($id){
        $notification = Notification::find($id);
        $notification->update(['isUpdate'=>true]);
        if($notification == 'notification')
        return redirect("meetings");

    }
    public function previewSGG($id){
        $user = Notification::find($id);
        $user->update(['isUpdate'=>true]);
        return redirect()->route('liste_medias_sgg');
    }
    public function previewADMIN($id){
        // $notification = Notification::find($id);
        Notification::where('isUpdate',false)
                    ->where('recever_id',auth()->user()->id)
                    ->update(['isUpdate'=>true]);
        return redirect()->route('utilisateur');
    }
}
