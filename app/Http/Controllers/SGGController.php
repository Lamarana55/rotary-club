<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Media;
use App\Models\DossiersHac;
use App\Models\DossiersSGG;
use Illuminate\Http\Request;
use App\Models\DossiersCommission;
use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SGGController extends Controller
{

    public function listeMedias(Request $request) {
        if(Auth::user()->role->nom !== 'SGG') {
            return view('404');
        }

        $dossiers = DossiersSGG::orderBy('created_at', 'DESC')->paginate(NOMBRE_PAR_PAGE);

        return view('medias.agrement', compact('dossiers'));
    }

    public function filtreMedias(Request $request, $statut) {
        if(Auth::user()->role->nom !== 'SGG') {
            return response()->json([
                'succes' => false,
                'message' => "Vous n'êtes pas autorisé à voir cette page"
            ]);
        }

        if($request->nom) {
            $medias = Media::where('nom_media', 'LIKE', '%'.$request->nom.'%')->get();
            $ids = [];
            foreach($medias as $media) {
                array_push($ids, $media->id_media);
            }

            $dossiers = DossiersSGG::orderBy('created_at', 'DESC')->whereIn('id_media', $ids);
        } else {

            $dossiers = DossiersSGG::orderBy('created_at', 'DESC');
        }

        if($statut === 'tous') {
            $dossiers = $dossiers->paginate(NOMBRE_PAR_PAGE);
        } else if($statut === 'demandes') {
            $dossiers = $dossiers->where('agrement', null)->paginate(NOMBRE_PAR_PAGE);
        } else if($statut === 'agrees') {
            $dossiers = $dossiers->where('agrement', '!=', null)->paginate(NOMBRE_PAR_PAGE);
        } else {
            $dossiers = $dossiers->paginate(NOMBRE_PAR_PAGE);
        }

        return response()->json([
            'succes' => true,
            'dossiers' => $dossiers
        ]);
    }

    public function demandesAgrement(Request $request) {
        if(Auth::user()->role->nom !== 'SGG') {
            return view('404');
        }

        $page = "demande";
        $titrePage = "Demandes d'agrément";
        $titreListe = "Demandes d'agrément";

        if($request->nom) {
            $medias = Media::where('nom_media', 'LIKE', '%'.$request->nom.'%')->get();
            $ids = [];
            foreach($medias as $media) {
                array_push($ids, $media->id_media);
            }

            $dossiers = DossiersSGG::whereIn('id_media', $ids)->where('agrement', null)->paginate(20);
        } else {

            $dossiers = DossiersSGG::where('agrement', null)->paginate(20);
        }

        return view('medias.agrement', compact('page', 'titrePage', 'titreListe', 'dossiers'));
    }

    public function agreeMedia(Request $request, $id) {
        $dossier = DossiersSGG::find($id);
        if($dossier == null) {
            return response()->json([
                'succes' => false,
                'message' => "Cette demande n'est pas enregistrée"
            ]);
        }

        if(Auth::user()->role->nom !== 'SGG') {
            return response()->json([
                'succes' => false,
                'message' => "Vous n'êtes pas autorisé à effectuer cette action"
            ]);
        }

        $validator = Validator::make($request->all(), [
            'numero_media'=>'required|unique:media,numero_media',
            'agrement'=>'required',
        ]);

        if($validator->passes()) {
            if($request->file()) {
                $fileName = time().'_'.$request->agrement->getClientOriginalName();
                $filePath = $request->file('agrement')->storeAs('agrements', $fileName, 'public');

                $dossier->agrement = "/storage/".$filePath;
                $dossier->save();

                $media = $dossier->media;
                $media->niveau = 'Promoteur';
                $media->numero_media = $request->numero_media;
                $media->level = 6;
                $media->level_current = 7;
                $media->save();

                $direction_user = User::whereIn("id_role", function ($query){
                    $query->from("role")->whereNom("Direction")->select("id_role")->get();
                })->where("isDelete", false)->first();

                if($direction_user){
                    $message_direction = message_email("enregistrement_pour_direction");
                    $objet = "Enrégistrement de l'agrement (SGG)";

                    send_notification($direction_user, $objet, $message_direction, $media);
                }

                send_notification(
                    $media->user,
                    $objet,
                    message_email("enregistrement_pour_promoteur"),
                    $media,
                    config("app.url").':'.env("PORT","9000")
                );

                $tracking = Tracking::where('id_media',$dossier->id_media)->first();
                if($tracking){
                    $tracking->date_enregistrement_media = Carbon::now();
                    $tracking->save();
                }

                return response()->json([
                    'succes' => true,
                    'message' => "L'agrément a été envoyé avec succès"
                ]);
            }
        }else {
            return response()->json([
                'succes' => false,
                'error'=>$validator->errors(),
                'message' => "Vous devez importer l'agrément"
            ]);
        }
    }

    public function mediasAgrees(Request $request) {
        if(Auth::user()->role->nom !== 'SGG') {
            return view('404');
        }
        $page = "agrees";
        $titrePage = "Médias agréés";
        $titreListe = "Médias agréés";

        if($request->nom) {
            $medias = Media::where('nom_media', 'LIKE', '%'.$request->nom.'%')->get();
            $ids = [];
            foreach($medias as $media) {
                array_push($ids, $media->id_media);
            }

            $dossiers = DossiersSGG::whereIn('id_media', $ids)->where('agrement', '!=', null)->paginate(20);
        } else {
            $dossiers = DossiersSGG::where('agrement', '!=', null)->paginate(20);
        }

        return view('medias.agrement', compact('page', 'titrePage', 'titreListe', 'dossiers'));

    }

    public function rapports(Request $request, $idMedia) {
        $dossierHac = DossiersHac::firstWhere('id_media', $idMedia);
        $dossierCommission = DossiersCommission::firstWhere('id_media', $idMedia);

        $rapportHac = '';
        $rapportCommission = '';

        if($dossierHac) {
            $rapportHac = $dossierHac->rapport;
        }

        if($dossierCommission) {
            $rapportCommission = $dossierCommission->rapport;
        }

        return response()->json([
            'rapportCommission' => $rapportCommission,
            'rapportHac' => $rapportHac,
        ]);
    }
}
