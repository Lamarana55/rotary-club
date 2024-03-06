<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use App\Models\Media;
use App\Models\Role;
use App\Models\RapportCommission;
use App\Models\MemberCommission;
use App\Models\DossiersHac;
use App\Models\Tracking;
use App\Models\MemberRapportCommissionMedia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RevisionDossier;
use App\Models\DossiersCommission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DossierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listeMedias(Request $request)
    {
        if (Auth::user()->role->nom !== 'Commission') {
            return view('404');
        }

        //$dossiers = DossiersCommission::orderBy('created_at', 'DESC');
        $dossiers = DossiersCommission::join('media', 'media.id_media', '=', 'dossiers_commission.id_media')
            ->join('user', 'user.id_user', '=', 'media.id_user')->orderBy('user.prenom');
        $dossiers = $dossiers->paginate(NOMBRE_PAR_PAGE);
        $membreCommissions = MemberCommission::orderBy('id', 'desc')->whereNot('fonction', 'Rapporteur')->where('category', 'Commission')->get();

        return view('dossiers.etude_commission', compact('dossiers', 'membreCommissions'));
    }

    public function postRedactionRapport(Request $request)
    {

        if($request->get('type_commission') == 'commission') $request->validate([
            'forme_juridique' => 'required',
            'capital_social' => 'required',
            'capital_montant' => 'required',
            'capital_unite' => 'required',
            'nombre_depart' => 'required',
            'nombre_part_value' => 'required',
            'pourcentage_investisseur_signe' => 'required',
            'pourcentage_investisseur_value' => 'required',
            'nombre_certificat' => 'required',
            'nombre_certificat_resident' => 'required',
            'nombre_certificat_casier_dirigeant' => 'required',
            'nombre_journaliste' => 'required',
            'nombre_diplome_technicien' => 'required',
            'categorie_chaine' => 'required',
            'public_cible' => 'required',
            'equipement_reception' => 'required',
            'equipement_studio' => 'required',
            'equipement_emission' => 'required',
            'programme_provenant_exterieur' => 'required',
            'programme_provenant_exterieur_value' => 'required',
            'production_interne_signe' => 'required',
            'production_interne_value' => 'required',
            'coproduction_signe' => 'required',
            'coproduction_value' => 'required',
            'echange_programme_signe' => 'required',
            'echange_programme_value' => 'required',
            'exigence_unite_nationale' => 'required',
            'capacite_financiere' => 'required',
            'capacite_financiere_interval' => 'required',
            'etat_financier' => 'required',
            'orientation_chaine' => 'required',
            'conclusion' => 'required',
            'production_interne_label_value'  => 'required',
            'programme_provenant_exterieur_label_value'  => 'required',
            'coproduction_label_value'  => 'required',
            'pourcentage_investisseur_label_value'  => 'required',
            'echange_programme_label_value'  => 'required',
            'date_debut'  => 'required',
            'heure_debut'  => 'required',
            'date_fin'  => 'required',
            'heure_fin'  => 'required',
            'type_commission'  => 'required',
        ]);

        if($request->get('type_commission') == 'hac') $request->validate([
            'forme_juridique' => 'required',
            'capital_social' => 'required',
            'capital_montant' => 'required',
            'capital_unite' => 'required',
            'nombre_depart' => 'required',
            'nombre_part_value' => 'required',
            'pourcentage_investisseur_signe' => 'required',
            'pourcentage_investisseur_value' => 'required',
            'nombre_certificat' => 'required',
            'nombre_certificat_resident' => 'required',
            'nombre_certificat_casier_dirigeant' => 'required',
        ]);

        if($request->get('type_commission') != 'hac' && $request->get('type_commission') != 'commission')
        {
            return redirect()->back()->withError('le rapport est géneré par la commission ou par la HAC');
        }

        RapportCommission::where('id_media',$request['id_media'])->where('type_commission',$request->get('type_commission'))->delete();
        $rapport_commission = RapportCommission::create($request->all());

        $media_id = $request['id_media'];

        if ($request->get('type_commission') == 'hac') {

            if (Auth::user()->role->nom !== 'HAC') {
                toast('Vous n\'êtes pas autorisé à effectuer cette action', 'error');
                return redirect()->back();
            }

            if(!(count($request['member']) > 0)){
                toast("Veuillez sélectionner les membres de la commission.", 'error');
                return redirect()->back();
            }

            // $membre_rapport_commissions = MemberRapportCommissionMedia::where('id_media',$request['id_media'])->where('category','HAC')->get();
            // if(!($membre_rapport_commissions->count() > 0)){
            //     toast('Veuiller sélectionner les membres de la commission', 'error');
            //     return redirect()->back();
            // }

            $this->rapportHac($request, $request->get('dossier_hac_id'), $rapport_commission);

            return redirect()->route('etude_medias_hac');
        } else {

            if (Auth::user()->role->nom !== 'Commission') {
                toast('Vous n\'êtes pas autorisé à effectuer cette action', 'error');
                return redirect()->back();
            }

            $commission = DossiersCommission::where('id_media', $media_id)->first();
            $this->rapportCommission($request, $commission->id, $rapport_commission);
            return redirect()->route('etude_media_commission');
        }
    }


    public function redactionRapportView(Request $request, $media_id)
    {
        if ($request->get('type_commission') != 'hac' && $request->get('type_commission') != 'commission') {
            return redirect()->back()->withError('le rapport est géneré par la commission ou par la HAC');
        }
        // rapport commission
        $rapport_commission_exist = RapportCommission::where('id_media',$media_id)->where('type_commission',$request->get('type_commission'))->first();

        $rapport_commission = RapportCommission::where('id_media',$media_id)->where('type_commission',$request->get('type_commission'))->first();
        if(!$rapport_commission_exist){
            $rapport_commission = RapportCommission::where('id_media',$media_id)->first();
        }

        $member_rapport_commissions = [];
        if($request->get('type_commission') == 'commission'){
            $member_rapport_commissions = MemberRapportCommissionMedia::where('id_media',$media_id)->get();
        }

        $membre_hac_commissions = [];
        if ($request->get('type_commission') == 'hac') {
            $membre_hac_commissions = MemberCommission::where('category', 'HAC')->get();
        }
        $media = Media::find($media_id);
        return view('dossiers.redaction_rapport_commission', [
            'media' => $media,
            'rapport_commission' => $rapport_commission,
            'type_commission' => $request->get('type_commission'),
            'membre_hac_commissions' => $membre_hac_commissions,
            'member_rapport_commissions' => $member_rapport_commissions,
            'rapporteur' => Auth::user()
        ]);
    }

    public function filtreMedias(Request $request, $statut)
    {
        if (Auth::user()->role->nom !== 'Commission') {
            return response()->json([
                'succes' => false,
                'message' => "Vous n'avez pas accès à cette page"
            ]);
        }

        if ($request->nom) {
            $medias = Media::where('nom_media', 'LIKE', '%' . $request->nom . '%')->get();
            $ids = [];
            foreach ($medias as $media) {
                array_push($ids, $media->id_media);
            }

            $dossiers = DossiersCommission::join('media', 'media.id_media', '=', 'dossiers_commission.id_media')
                ->join('user', 'user.id_user', '=', 'media.id_user')->orderBy('user.prenom')->whereIn('id_media', $ids);
        } else {
            $dossiers = DossiersCommission::join('media', 'media.id_media', '=', 'dossiers_commission.id_media')
                ->join('user', 'user.id_user', '=', 'media.id_user')->orderBy('user.prenom');
        }

        if ($statut == 'tous') {
            $dossiers = $dossiers->paginate(NOMBRE_PAR_PAGE);
        } else if ($statut == 'nouveaux') {
            $dossiers = $dossiers->where(['dossiers_commission.etude_en_cours' => false])->paginate(NOMBRE_PAR_PAGE);
        } else if ($statut == 'etude') {
            $dossiers = $dossiers->where(['dossiers_commission.etude_en_cours' => true, 'valide' => null])->paginate(NOMBRE_PAR_PAGE);
        } else if ($statut == 'acceptes') {
            $dossiers = $dossiers->where(['dossiers_commission.valide' => true])->paginate(NOMBRE_PAR_PAGE);
        } else if ($statut == 'rejetes') {
            $dossiers = $dossiers->where(['dossiers_commission.valide' => false])->paginate(NOMBRE_PAR_PAGE);
        } else if ($statut == 'revoir') {
            $dossiers = $dossiers->where(['dossiers_commission.revoir' => true])->paginate(NOMBRE_PAR_PAGE);
        }

        return response()->json([
            'succes' => true,
            'dossiers' => $dossiers
        ]);
    }

    public function detailsMedia(Request $request, $id)
    {
        // $dossier = DossiersCommission::find(1);
        $dossier = DossiersCommission::where('id_media', $id)->first();
        if ($dossier === null) {
            return response()->json([
                'succes' => false,
                'message' => "Ce dossier n'existe pas",
            ]);
        }

        $documents = [];
        $etudeDocumentsTermine = true;
        foreach ($dossier->media->documents as $document) {
            $doc = [
                'id' => $document->id_document,
                'nom_document' => $document->type_document->libelle,
                'file_path' => $document->file_path,
                'valide' => $document->validation_commission
            ];

            if ($document->validation_commission === null) {
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

    public function soumissionDossier(Request $request, $id)
    {
        if (Auth::user()->role->nom !== 'Commission') {
            return response()->json([
                'succes' => false,
                'message' => "Vous n'êtes pas autorisé à soumetre un dossier"
            ]);
        }

        $dossier = DossiersCommission::find($id);
        if ($dossier === null) {
            return response()->json([
                'succes' => false,
                'message' => "Ce dossier n'existe "
            ]);
        }

        $dossier->etude_en_cours = true;
        $dossier->etude_termine = false;
        $dossier->valide = null;
        $dossier->revoir = false;
        $dossier->save();

        $media = $dossier->media;
        $media->niveau = 'Commission';
        $media->save();

        return response()->json([
            'succes' => true,
            'message' => "Soumission du dossier effectuée avec succès"
        ]);
    }

    public function terminerEtude(Request $request, $id)
    {
        if (Auth::user()->role->nom !== 'Commission') {
            return response()->json(['succes' => false, 'message' => "Vous n'êtes pas autorisé à effectuer cette action"]);
        }

        $dossier_commission = DossiersCommission::find($id);
        if ($dossier_commission === null) {
            return response()->json(['succes' => false, 'message' => "Ce dossier n'existe"]);
        }
        $dossier_commission->etude_termine = true;
        $dossier_commission->save();

        return response()->json([
            'succes' => true,
            'message' => "Etude du dossier terminé avec succès"
        ]);
    }

    /**
     * Rapport de la commission
     */
    private function rapportCommission(Request $request, $id, $rapport_commission)
    {

        $dossier_commission = DossiersCommission::find($id);

        if ($dossier_commission === null) {
            return redirect()->back()->with('message', "Ce dossier n'existe");
        }

        $valide = true;
        $media = $dossier_commission->media;
        $mediaExit = Media::where('id_media', $media->id_media)->first();
        $membre_commissions = MemberRapportCommissionMedia::where('id_media', $media->id_media)->where('category', 'Commission')->get();

        foreach ($media->documents as $document) {
            if ($document->validation_commission === 0) {
                $valide = false;
            }

            if ($document->validation_hac === 0) {
                $document->validation_hac = null;
                $document->save();
            }
        }
        $data = [
            'imagePath'    => public_path('dist/img/momo.png'),
            'pathArmoirie' => convertBase64('public/assets/dist/img/armoirie.png'),
            'pathBranding' => convertBase64('public/assets/dist/img/branding.jpg'),
            'flag_guinnea' => convertBase64('public/assets/dist/img/flag_guinea.png'),
            'media' => $media,
            'member_lenght' => count($membre_commissions),
            'date' => date('d-m-Y'),
            'rapport' => $request->rapport,
            'rapport_commission' => $rapport_commission,
            'membre_commissions' => $membre_commissions,
        ];
        $pdf = PDF::loadView('template_documents.rapport_commission', $data);
        // $pdf->setWatermarkImage(convertBase64('public/assets/dist/img/branding.jpg'), $opacity = 0.6, $top = '30%', $width = '100%', $height = '100%');

        utf8_decode($pdf->output());

        $content = $pdf->setPaper('a4')->download()->getOriginalContent();

        if ($dossier_commission->rapport) {
            $oldPath = substr_replace($dossier_commission->rapport, 'public', 0, strlen('/storage'));
            Storage::delete($oldPath);
        }

        $path = 'rapports_commission/' . time() . '_rapport.pdf';
        Storage::put('public/' . $path, $content);

        $dossier_commission->valide = $valide;
        $dossier_commission->rapport = "/storage/" . $path;
        $dossier_commission->revoir = false;
        $dossier_commission->save();

        if ($valide) {
            $mediaExit->level = 2;
            $mediaExit->level_current = 3;
            $mediaExit->save();
            $media->niveau = 'HAC';
            DossiersHac::updateOrCreate(
                ['id_media' => $media->id_media],
                ['etude_en_cours' => false, 'etude_termine' => false, 'valide' => null]
            );

            $hac_user = User::whereIn("id_role", function ($query) {
                $query->from("role")->whereNom("HAC")->select("id_role")->get();
            })->where("isDelete", false)->first();
            //HAC
            if ($hac_user) {
                $objet = "Transmission des documents";
                $message_hac = message_email("transmission_document_hac", $media);
                send_notification($hac_user, $objet, $message_hac, $media, config("app.url").':'.env("PORT","9000"));
            }

            //Promoteur
            $message = message_email("examen_terminer");
            $objet = "Examen de dossier technique";
            send_notification($media->user, $objet, $message, $media, config("app.url").':'.env("PORT","9000"));
        } else {
            $mediaExit->level = 1;
            $mediaExit->level_current = 2;
            $mediaExit->save();
            $media->niveau = 'Promoteur';

            //Promoteur
            $message = message_email("examen_terminer");
            $objet = "Examen de dossier technique";

            send_notification($media->user, $objet, $message, $media, config("app.url").':'.env("PORT","9000"));
        }
        //$media->level = 2;
        $media->save();
        $tracking = Tracking::where('id_media', $media->id_media)->first();
        if ($tracking) {
            $tracking->date_etude_commission = Carbon::now();
            $tracking->save();
        }
    }

    private function rapportHac(Request $request, $dossier_hac_id, $rapport_hac)
    {

        $dossier = DossiersHac::find($dossier_hac_id);
        if ($dossier === null) {
            toast("Ce dossier n'existe pas", 'error');
            return redirect()->back();
        }
        
        MemberRapportCommissionMedia::where('id_media',$request['media_id'])->where('category','HAC')->delete();
       
        foreach ($request['member'] as $key => $value) {
            $membreRapportCommissionMedia = new MemberRapportCommissionMedia();
            $membreRapportCommissionMedia->id_media = $request['media_id'];
            $membreRapportCommissionMedia->member_commission_id = $value;
            $membreRapportCommissionMedia->category = "HAC";
            $membreRapportCommissionMedia->save();
        }    
       

        $levelExist = Media::find($dossier->media->id_media);
        $valide = true;
        foreach ($dossier->media->documents as $document) {
            if ($document->validation_hac === 0) {
                $valide = false;
                $document->validation_commission = null;
                $document->save();
            }
        }

        $membre_commissions = MemberRapportCommissionMedia::where('id_media',$dossier->media->id_media)->where('category','HAC')->get();

        $data = [
            'imagePath'    => public_path('dist/img/momo.png'),
            'pathArmoirie' => convertBase64('public/assets/dist/img/armoirie.png'),
            'pathBranding' => convertBase64('public/assets/dist/img/branding.jpg'),
            'logo_hac' => convertBase64('public/assets/dist/img/hac_logo.jpg'),
            'media' => $dossier->media->nom_media,
            'date' => date('d-m-Y'),
            'rapport_hac' => $rapport_hac,
            'membre_commissions' => $membre_commissions,
        ];
        // return view('template_documents.rapport_hac',$data);
        // die();
        $pdf = PDF::loadView('template_documents.rapport_hac', $data);
        $content = $pdf->setPaper('a4')->download()->getOriginalContent();

        if ($dossier->rapport) {
            $oldPath = substr_replace($dossier->rapport, 'public', 0, strlen('/storage'));
            Storage::delete($oldPath);
        }

        $path = 'rapports_hac/' . time() . '_rapport.pdf';
        Storage::put('public/' . $path, $content);


        $dossier->valide = $valide;
        $dossier->rapport = "/storage/" . $path;
        $dossier->save();

        $media = $dossier->media;
        // $media->level =3;
        $Recever = DB::table('media')
            ->select('id_user')
            ->where('id_media', $dossier->id_media)
            ->first();
        if (!$valide) {
            $message = message_email("avis_consultatif", $media);
            $dossier_commission = $dossier->media->dossier_commission;
            if ($dossier_commission !== null) {
                $dossier_commission->revoir = true;
                $dossier_commission->etude_termine = false;
                $dossier_commission->save();
            }

            $levelExist->level = 2;
            $levelExist->save();

            $media->niveau = 'Commission';

            $commission = User::whereIn("id_role", function ($query) {
                $query->from("role")->whereNom("Commission")->select("id_role")->get();
            })->where("isDelete", false)->first();

            if ($commission) {
                send_notification(
                    $commission,
                    "Haute autorité de la communication",
                    $message,
                    $media,
                    config("app.url").':'.env("PORT","9000")
                );
            }
        } else {
            $message = message_email("avis_consultatif", $media);
            $levelExist->level = 3;
            $levelExist->save();
            $media->niveau = 'Promoteur';

            $direction = User::whereIn("id_role", function ($query) {
                $query->from("role")->whereNom("Direction")->select("id_role")->get();
            })->where("isDelete", false)->first();

            if ($direction) {
                send_notification(
                    $direction,
                    "Haute autorité de la communication",
                    $message,
                    $media,
                    config("app.url").':'.env("PORT","9000")
                );
            }
        }

        $tracking = Tracking::where('id_media', $dossier->id_media)->first();
        if ($tracking) {
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
    }
}
