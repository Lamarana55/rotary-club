<?php
namespace App\Gestions;

use App\Models\{Programme, Meeting, Media, Tracking, User};
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class GestionMeeting
{
    public function store($data)
	{

        $media = Media::find($data->media);
        $old = null;
        if($media->meeting) $old = $media->meeting;

        $programme = Programme::whereUuid($data->heure)->first();

        $check = Meeting::where("date", $data->date)
            ->where("heure", "{$programme->heure_debut}H - {$programme->heure_fin}H")
            ->where("media_id", "<>", $data->media)
            ->where('confirmer',0);

        if($check->exists()) {
            return response()->json([
                'status' => false,
                'message' => "Cette date a déjà été réservée par un autre promoteur"
            ]);
        }


        $meeting = Meeting::where('media_id',$data->media)->first();

        if($meeting){
            Meeting::where('media_id',$data->media)->update([
                'nom'=> "",
                'date' => $data->date,
                'heure'=> "{$programme->heure_debut}H - {$programme->heure_fin}H",
                'media_id' => $data->media,
                'user_id' => Auth::user()->id,
                'programme_id' => $programme->id
            ]);
        }else{
            Meeting::create([
                'nom'=> "",
                'date' => $data->date,
                'heure'=> "{$programme->heure_debut}H - {$programme->heure_fin}H",
                'media_id' => $data->media,
                'user_id' => Auth::user()->id,
                'programme_id' => $programme->id
            ]);
        }

        $meeti = Meeting::where('media_id',$data->media)->first();

        $tracking = Tracking::where('media_id',$data->media)->first();
        if($tracking){
            $tracking->date_prise_rdv = Carbon::now();
            $tracking->save();
        }


        $direction = User::whereIn("role_id", function ($query){
            $query->from("role")->whereNom("Direction")->select("id")->get();
        })->where("is_deleted", false)->first();

        if($direction) {
            send_notification(
                $direction,
                $meeting ? "Le promoteur ".$media->user->prenom.' '.$media->user->nom." a modifié le rendez-vous initial de son media ".$media->nom:"Nouveau rendez-vous",
                message_email("prise_de_rdv", $media),

                $meeti->media,
                config("app.url").':'.env("PORT","9000"),
                0,
                'rendez-vous'
            );

        }

        return response()->json([
            'status' => true,
            'media'=> Media::find($data->media)->with('meeting')->first(),
            'refresh' =>  true,
            'message' => $meeting ? "Votre rendez-vous a été modifié":"Votre rendez-vous a été enregistré"
        ]);
	}

    public function update($data, $key)
	{
        $programme = Programme::whereUuid($key)->first();

        $programme->update([
            'jour' => $data->jour,
            'heure_debut' => $data->heure_debut,
            'heure_fin' => $data->heure_fin,
        ]);

        return response()->json([
            'status' => true,
            'programme' => $programme,
            'close' =>  true,
            'message' => "Disponibilité mise à jour avec succès"
        ]);

	}

    public function delete($key)
	{
		Programme::whereUuid($key)->delete();
		return response()->json([
            'status' => true
        ]);
	}
}
