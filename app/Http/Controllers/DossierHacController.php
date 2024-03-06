<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Media;
use App\Models\{Document, User};
use App\Models\DossiersHac;
use Illuminate\Http\Request;
use App\Models\RevisionDossier;
use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\MemberCommission;

class DossierHacController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listeMedias(Request $request) {
        if(Auth::user()->role->nom !== 'HAC') {
            return view('404');
        }

        $dossiers = DossiersHac::join('media', 'media.id_media', '=', 'dossiers_hac.id_media')
        ->join('user', 'user.id_user', '=', 'media.id_user')->orderBy('user.prenom');
        $dossiers = $dossiers->paginate(NOMBRE_PAR_PAGE);
        $membreCommissions = MemberCommission::orderBy('id','desc')->whereNot('fonction','Rapporteur')->where('category','Commission')->get();

        return view('dossiers.etude_hac', compact('dossiers','membreCommissions'));
    }

    public function filtreMedias(Request $request, $statut) {
        if(Auth::user()->role->nom !== 'HAC') {
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

            $dossiers = DossiersHac::join('media', 'media.id_media', '=', 'dossiers_hac.id_media')
                ->join('user', 'user.id_user', '=', 'media.id_user')->orderBy('user.prenom')->whereIn('id_media', $ids);
        } else {

            $dossiers = DossiersHac::join('media', 'media.id_media', '=', 'dossiers_hac.id_media')
                ->join('user', 'user.id_user', '=', 'media.id_user')->orderBy('user.prenom');
        }

        if($statut == 'tous') {
            $dossiers = $dossiers->paginate(NOMBRE_PAR_PAGE);
        }else if($statut == 'nouveaux') {
            $dossiers = $dossiers->where(['dossiers_hac.valide' => null])->paginate(NOMBRE_PAR_PAGE);
        }else if($statut == 'acceptes') {
            $dossiers = $dossiers->where(['dossiers_hac.valide' => true])->paginate(NOMBRE_PAR_PAGE);
        } else if($statut == 'rejetes') {
            $dossiers = $dossiers->where(['dossiers_hac.valide' => false])->paginate(NOMBRE_PAR_PAGE);
        }

        return response()->json([
            'succes' => true,
            'dossiers' => $dossiers
        ]);
    }


    public function detailsMedia(Request $request, $id) {
        $dossier = DossiersHac::find($id);

        if($dossier === null) {
            return response()->json([
                'succes' => false,
                'message' => "Ce dossier n'existe pas",
            ]);
        }

        $documents = [];
        $etudeDocumentsTermine = true;
        foreach($dossier->media->documents as $document) {
            $doc = [
                'id' => $document->id_document,
                'nom_document' => $document->type_document->libelle,
                'file_path' => $document->file_path,
                'valide' => $document->validation_hac
            ];

            if($document->validation_hac === null) {
                $etudeDocumentsTermine = false;
            }

            array_push($documents, $doc);
        }

        return response()->json([
            'succes' => true,
            'etudeDocumentsTermine' => $etudeDocumentsTermine,
            'documents' => $documents
        ]);
    }

    public function validationDocument(Request $request, $id) {
        $document = Document::find($id);

        if($document === null) {
            return response()->json(['succes' => false, 'message' => "Ce document n'existe pas"]);
        }

        $isValide = filter_var($request->valide, FILTER_VALIDATE_BOOLEAN);

        if(Auth::user()->role->nom !== 'HAC') {
            return response()->json(['succes' => false, 'message' => "Vous n'êtes pas autorisé à ". $isValide ? 'valider' : "rejeter" ."ce document"]);
        }

        $document->validation_hac = $isValide;
        $document->save();

        $etudeTermine = true;
        foreach($document->media->documents as $doc) {
            if($doc->validation_hac === null) {
                $etudeTermine = false;
            }
        }

        return response()->json([
            'succes' => true,
            'etudeTermine' => $etudeTermine,
            'message' => "Le document a été " . $isValide ? 'validé' : 'rejeté'
        ]);
    }

    public function terminerEtude(Request $request, $id) {
        if(Auth::user()->role->nom !== 'HAC') {
            return response()->json(['succes' => false, 'message' => "Vous n'êtes pas autorisé à effectuer cette action"]);
        }

        $dossier = DossiersHac::find($id);
        if($dossier === null) {
            return response()->json(['succes' => false, 'message' => "Ce dossier n'existe"]);
        }

        $dossier->etude_termine = true;
        $dossier->save();

        return response()->json([
            'succes' => true,
            'message' => "Etude du dossier terminé avec succès"
        ]);
    }

    public function rapport(Request $request, $id) {
        if(Auth::user()->role->nom !== 'HAC') {
            return response()->json(['succes' => false, 'message' => "Vous n'êtes pas autorisé à effectuer cette action"]);
        }

        $dossier = DossiersHac::find($id);
        $levelExist = Media::find($dossier->id_media);
        if($dossier === null) {
            return response()->json(['succes' => false, 'message' => "Ce dossier n'existe"]);
        }

        $valide = true;
        foreach($dossier->media->documents as $document) {
            if($document->validation_hac === 0) {
                $valide = false;
                $document->validation_commission = null;
                $document->save();
                //break;
            }
        }

        $data = [
            'imagePath'    => public_path('dist/img/momo.png'),
            'pathArmoirie' => convertBase64('public/assets/dist/img/armoirie.png'),
            'pathBranding' => convertBase64('public/assets/dist/img/branding.jpg'),
            'logo_hac' => convertBase64('public/assets/dist/img/hac_logo.jpg'),
            'media' => $dossier->media->nom_media,
            'date' => date('d-m-Y'),
            'rapport' => $request->rapport
        ];
        // return view('template_documents.rapport_hac',$data);
        // die();
        $pdf = PDF::loadView('template_documents.rapport_hac', $data);
        $content = $pdf->setPaper('a4')->download()->getOriginalContent();

        if($dossier->rapport) {
            $oldPath = substr_replace($dossier->rapport, 'public', 0, strlen('/storage'));
            Storage::delete($oldPath);
        }

        $path = 'rapports_hac/'. time().'_rapport.pdf';
        Storage::put('public/' . $path, $content);


        $dossier->valide = $valide;
        $dossier->rapport = "/storage/" . $path;
        $dossier->save();

        $media = $dossier->media;
        // $media->level =3;
        $Recever= DB::table('media')
                    ->select('id_user')
                    ->where('id_media',$dossier->id_media)
                    ->first();
        if(!$valide) {
            $message = [
                "Votre dossier technique a été rejeté par la Haute Autorité de Communication (HAC).",
                "Veuillez consulter le raport pour plus de détails."
            ];
            $dossier_commission = $dossier->media->dossier_commission;
            if($dossier_commission !== null) {
                $dossier_commission->revoir = true;
                $dossier_commission->etude_termine = false;
                $dossier_commission->save();
            }

            $levelExist->level = 2;
            $levelExist->level_current = 3;
            $levelExist->save();

            $media->niveau = 'Commission';

            $commission = User::whereIn("id_role", function ($query){
                $query->from("role")->whereNom("Commission")->select("id_role")->get();
            })->where("isDelete", false)->first();

            if($commission) {

                $message_commission = message_email("avis_consultatif", $media);

                send_notification(
                    $commission,
                    "Haute autorité de la communication",
                    $message_commission,
                    $media,
                    config("app.url").':'.env("PORT","9000")
                );
            }

        } else {

            $message = message_email("Avis_consultatif_pour_promoteur");
            $levelExist->level = 3;
            $levelExist->level_current = 4;
            $levelExist->save();
            $media->niveau = 'Promoteur';
        }

        $tracking = Tracking::where('id_media',$dossier->id_media)->first();
        if($tracking){
            $tracking->date_etude_hac = Carbon::now();
            $tracking->save();
        }

        $media->save();

        send_notification(
            $media->user,
            "Haute autorité de la communication",
            $message,
            $media,
            config("app.url").':'.env("PORT","9000")
        );

        return response()->json([
            'succes' => true,
            'valide' => $valide,
            'message' => "Le rapport a été envoyé avec succès"
        ]);
    }
}
