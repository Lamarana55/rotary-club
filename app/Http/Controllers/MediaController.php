<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Media;
use DateTimeImmutable;
use App\Models\Meeting;
use App\Models\Document;
use App\Models\Paiement;
use App\Models\codeMarchand;
use App\Models\TypeDocument;
use App\Models\TypePaiement;
use Illuminate\Http\Request;
use App\Gestions\GestionMedia;
use App\Models\ParametrePaiement;
use Illuminate\Support\Facades\DB;
use App\Models\{CahierDeCharge, DocumentTechnique, DocumentTypePromoteur, Dossier, DossiersSGG, Programme, Message, Tracking, User};
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\MediaCreateRequest;
use Illuminate\Support\Facades\Validator;
use App\Models\DossiersCommission;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function activeStepper(Request $request)
    {
        try {
            $media = Media::find($request->id_media);
            $media->level_current = $request->level_current;
            $media->save();

            return response()->json([
                'status'=>true,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'=>false,
                'error'=>$e
            ]);
        }

    }

    public function description_type_document($id)
    {
        $type = TypeDocument::find($id);
        return response()->json($type);
    }


    public function show_projet_agrement($id)
    {
        $document = DossiersSGG::where('id_media',$id)->first();
        return response()->json([
            'document'=>$document
        ]);
    }

    public function show($id)
    {
        return view('medias.medias.edit', [
            'data' => Media::find($id)
        ]);
    }

    public function recu_paiement_cahier_charge($id)
    {   $recu = Paiement::find($id);

        return response()->json([
            'succes' => true,
            'recu' => $recu,
        ]);
    }

    public function document_by_id($id)
    {   $document = Document::find($id);
        $rapport = Media::find($document->id_media)->with('dossier_commission','dossier_hac');

        return response()->json([
            'succes' => true,
            'document' => $document,
            'nom_document' => $document->type_document->libelle,
            'rapport' => $rapport,
        ]);
    }

    public function confirmerRendezVous(Request $request)
    {
        $programme = Programme::find($request->id_programme);
        if($programme == null) {
            return response()->json([
                'succes' => false,
                'message' => "Ce programme n'est pas enregistré"
            ]);
        }

        $media = Media::find($request->id_media);
        if($media == null || $media->user->id_user != Auth::user()->id_user) {
            return response()->json([
                'succes' => false,
                'message' => "Vous ne disposer pas ce média"
            ]);
        }
        $timeExist = Meeting::where('date',$programme->date)->where('heure',$request->heure)->first();
        if($timeExist){
            return response()->json([
                'succes' => false,
                'message' => "ce rendez-vous de ".$request->heure." est déjà prise"
            ]);
        }else{
            $programme->pris = true;
            $programme->save();

            $media->niveau = 'Direction';
            $media->save();

            $meeting = Meeting::updateOrCreate([
                'nom'=>$request->representant,
                'date' => $programme->date,
                'heure'=>$request->heure,
                'id_media' => $request->id_media,
                'id_user' => auth()->user()->id_user,
                'id_programme' => $request->id_programme
            ]);

            $meeting->annuler = false;
            $meeting->save();

            return response()->json([
                'succes' => true,
                'media'=>Media::find($request->id_media)->with('meeting')->first(),
                'message' => "Votre rendez-vous a été enregistré"
            ]);
        }


    }

    public function paiementFraisAgrement(Request $request) {
        $media = Media::find($request->id_media);
        if($media == null) {
            return response()->json([
                'succes' => false,
                'message' => "Vous ne disposer pas de ce média"
            ]);
        }

        if(Auth::user()->id_user !== $media->user->id_user) {
            return response()->json(['succes' => false, 'message' => "Vous n'êtes pas autorisé à importer le reçu dans ce média"]);
        }

        $parametrePaiement = $media->type_media->parametre_paiement;
        $typePaiement = TypePaiement::firstWhere('isagrement', true);

        if($typePaiement == null) {
            return response()->json([
                'succes' => false,
                'message' => "Une erreur s'est produit lors de l'importation du reçu"
            ]);
        }

        $existRecu = Paiement::where('id_media',$request->id_media)
            ->where('id_type_paiement',$typePaiement->id)
            ->where('mode','=','Recu')
            ->first();

        if($existRecu){
            if($request->file()) {
                $fileName = time().'_'.$request->recu->getClientOriginalName();
                $filePath = $request->file('recu')->storeAs('recus_agrement', $fileName, 'public');

                $existRecu->date = $request->date_paiement_agrement;
                $existRecu->recu = "/storage/".$filePath;
                $existRecu->valide = null;
                $paiement = $existRecu->save();

                $media->niveau = 'Direction';
                $media->save();

                $message = message_email("paiement_agrement", $media);
                $objet = "Paiement agrément";

                $direction = User::whereIn("id_role", function ($query){
                    $query->from("role")->whereNom("Direction")->select("id_role")->get();
                })->where("is_deleted", false)->first();

                if($direction) send_notification($direction, $objet, $message, $media, config("app.url").':'.env("PORT","9000"), 0, 'Paiement');

                //Promoteur
                $message = message_email("msg_de_verification_de_paiement_agrement");

                send_notification($media->user, $objet, $message, $media, null);

                $tracking = Tracking::where('id_media',$request->id_media)->first();
                if($tracking){
                    $tracking->date_paiement_agrement = Carbon::now();
                    $tracking->save();
                }

                return response()->json([
                    'succes' => true,
                    'paiement'=>Paiement::find($existRecu->id_paiement),
                    'message' => "Le paiement a été effectué avec succes"
                ]);
            } else {
                return response()->json([
                    'succes' => false,
                    'message' => "Vous devez importer le reçu de paiement"
                ]);
            }
        }else{
            if($request->file()) {
                $fileName = time().'_'.$request->recu->getClientOriginalName();
                $filePath = $request->file('recu')->storeAs('recus_agrement', $fileName, 'public');
                $paiement = Paiement::updateOrCreate([
                    'id_media'=>$request->id_media,
                    'id_type_paiement'=>$typePaiement->id,
                    'montant'=>$parametrePaiement->montant,
                    'mode'=>'Recu',
                    'date'=>$request->date_paiement_agrement,
                    'recu'=>"/storage/".$filePath
                ]);

                $paiement->valide = null;
                $paiement->save();

                $media = $paiement->media;
                $media->niveau = 'Direction';
                $media->save();

                $message = message_email("paiement_agrement", $media);
                $objet = "Paiement agrément";

                $direction = User::whereIn("id_role", function ($query){
                    $query->from("role")->whereNom("Direction")->select("id_role")->get();
                })->where("is_deleted", false)->first();

                if($direction) send_notification($direction, $objet, $message, $media, config("app.url").':'.env("PORT","9000"),0,'Paiement');

                //Promoteur
                $message = message_email("msg_de_verification_de_paiement_agrement");

                send_notification($media->user, $objet, $message, $media, null);

                $tracking = Tracking::where('id_media',$request->id_media)->first();
                if($tracking){
                    $tracking->date_paiement_agrement = Carbon::now();
                    $tracking->save();
                }

                return response()->json([
                    'succes' => true,
                    'paiement'=>Paiement::find($paiement->id_paiement),
                    'message' => "Le paiement a été effectué avec succes"
                ]);
            } else {
                return response()->json([
                    'succes' => false,
                    'message' => "Vous devez importer le reçu de paiement"
                ]);
            }
        }
    }

    public function showDescription($id)
    {
        $media = Media::find($id);
        $paiement = ParametrePaiement::firstWhere('is_cahier_charge', true);

        return response()->json([
            'status' =>200,
            'media' =>$media,
            'paiement' =>$paiement,
        ]);
    }

    public function create()
    {
        $media =null;
        return view('medias.medias.addEdit', compact('media'));
    }

    public function save_paiement_cahier_charge(Request $request)
    {
        $messages = [
            'numero.required' => 'Le champ numero doit contenir un nombre.',
            'numero.min' =>'Le champ numéro doit contenir au moins 9 chiffres',
            'numero.max'=>'Le champ numéro ne doit pas dépasser 12 chiffres'
          ];
        $media = Media::find($request->id_media);
        $typePaiement = TypePaiement::firstWhere('iscahiercharge', true);
        $param_paiement = ParametrePaiement::firstWhere('is_cahier_charge', true);
        $paiement = new Paiement();
        $exitPaiement = Paiement::where('id_media',$request->id_media)->first();

        if($exitPaiement){
            if($request->mode == 'Recu'){
                Validator::make($request->all(), [
                    'recu' => ['required'],
                    'numero_recu' => 'required',
                ]);
                $fileName = time().'_'.$request->file('recu')->getClientOriginalName();
                $filePath = $request->file('recu')->storeAs('recus', $fileName, 'public');
                $exitPaiement->recu = "/storage/" . $filePath;
                $exitPaiement->mode = $request->mode;
                $exitPaiement->date = $request->date;
                $exitPaiement->numero_recu = $request->numero_recu;
                $exitPaiement->montant = $param_paiement->montant;
                $exitPaiement->id_media = $request->id_media;
                $exitPaiement->id_type_paiement = $typePaiement->id;
                $exitPaiement->valide = null;
                $exitPaiement->save();

                $traking = Tracking::where('id_media',$request->id_media)->first();
                if($traking){
                    $traking->date_achat_cahier = Carbon::now();
                    $traking->save();
                }

                $message = message_email("paiement_cahier_de_charge", $media);
                $objet = "Nouveau paiement";

                $daf = User::whereIn("id_role", function ($query){
                    $query->from("role")->whereNom("DAF")->select("id_role")->get();
                })->where("is_deleted", false)->first();

                if($daf) send_notification($daf, $objet, $message, $media, config("app.url").':'.env("PORT","9000"));

                send_notification(
                    $media->user,
                    $objet,
                    message_email("confirmation_de_paiement_cahier_de_charge"),
                    $media,
                    null,
                    1
                );

                $media->niveau = 'DAF';
                $data = $media->update();
                return response()->json([
                    'data'=>$data,
                    'status'=>200
                ]);

            }else{
                $validator = Validator::make($request->all(), [
                    'numero' => 'required|min:9|max:12',
                    'date' => 'required',
                ], $messages);
                if($validator->passes()){
                    $exitPaiement->date = $request->date;
                    $exitPaiement->numero_recu = $request->numero_recu;
                    $exitPaiement->numero = $request->numero;
                    $exitPaiement->mode = $request->mode;
                    $exitPaiement->codeMarchand = $request->code;
                    $exitPaiement->montant = $param_paiement->montant;
                    $exitPaiement->id_media = $request->id_media;
                    $exitPaiement->id_type_paiement = $typePaiement->id;
                    $exitPaiement->valide = null;
                    $exitPaiement->save();

                    $message = message_email("paiement_cahier_de_charge", $media);
                    $objet = "Nouveau paiement";
                    $traking = Tracking::where('id_media', $request->id_media)->first();
                    if($traking){
                        $traking->date_achat_cahier = Carbon::now();
                        $traking->save();
                    }

                    $daf = User::whereIn("id_role", function ($query){
                        $query->from("role")->whereNom("DAF")->select("id_role")->get();
                    })->where("is_deleted", false)->first();

                    if($daf) send_notification($daf, $objet, $message, $media, config("app.url").':'.env("PORT","9000"));

                    send_notification(
                        $media->user,
                        $objet,
                        message_email("confirmation_de_paiement_cahier_de_charge"),
                        $media,
                        null,
                        1
                    );

                    //update niveau
                    $media->niveau = 'DAF';
                    $data = $media->update();

                    return response()->json([
                        'data'=>$data,
                        'status'=>200
                    ]);
                }else{
                    return response()->json([
                        'error'=>$validator->errors(),
                        'status'=>200
                    ]);
                }

            }
        }else{
            if($request->mode == 'Recu'){
                $validator = Validator::make($request->all(), [
                    'recu' => ['required'],
                    'numero_recu' => 'required',
                ]);

                $fileName = time().'_'.$request->file('recu')->getClientOriginalName();

                $filePath = $request->file('recu')->storeAs('recus', $fileName, 'public');

                $paiement->recu = "/storage/" . $filePath;
                $paiement->mode = $request->mode;
                $paiement->date = $request->date;
                $paiement->numero_recu = $request->numero_recu;
                $paiement->montant = $param_paiement->montant;
                $paiement->id_media = $request->id_media;
                $paiement->id_type_paiement = $typePaiement->id;
                $paiement->valide = null;
                $paiement->save();
                //update niveau
                $media->niveau = 'DAF';
                $data = $media->update();

                $traking = Tracking::where('id_media',$request->id_media)->first();
                if($traking){
                    $traking->date_achat_cahier = Carbon::now();
                    $traking->save();
                }


                $message = message_email("paiement_cahier_de_charge", $media);
                $objet = "Nouveau paiement";

                $daf = User::whereIn("id_role", function ($query){
                    $query->from("role")->whereNom("DAF")->select("id_role")->get();
                })->where("is_deleted", false)->first();

                if($daf) send_notification($daf, $objet, $message, $media, config("app.url").':'.env("PORT","9000"));

                send_notification(
                    $media->user,
                    $objet,
                    message_email("confirmation_de_paiement_cahier_de_charge"),
                    $media,
                    null,
                    1
                );

                return response()->json([
                    'data'=>$data,
                    'status'=>200
                ]);

            }else{
                $validator = Validator::make($request->all(), [
                    'numero' => 'required|min:9|max:12',
                    'date' => 'required',
                ], $messages);

                if($validator->passes()) {
                    $paiement->numero = $request->numero;
                    $paiement->date = $request->date;
                    $paiement->codeMarchand = $request->code;
                    $paiement->numero_recu = $request->numero_recu;
                    $paiement->mode = $request->mode;
                    $paiement->montant = $param_paiement->montant;
                    $paiement->id_media = $request->id_media;
                    $paiement->id_type_paiement = $typePaiement->id;
                    $paiement->valide = null;
                    $paiement->save();
                    //update niveau

                    $traking = Tracking::where('id_media',$request->id_media)->first();
                    $traking->date_achat_cahier = Carbon::now();
                    $traking->save();

                    $media->niveau = 'DAF';
                    $data = $media->update();
                    $message = message_email("paiement_cahier_de_charge", $media);
                    $objet = "Nouveau paiement";

                    $daf = User::whereIn("id_role", function ($query){
                        $query->from("role")->whereNom("DAF")->select("id_role")->get();
                    })->where("is_deleted", false)->first();

                    if($daf) send_notification($daf, $objet, $message, $media, config("app.url").':'.env("PORT","9000"));

                    send_notification(
                        $media->user,
                        $objet,
                        message_email("confirmation_de_paiement_cahier_de_charge"),
                        $media,
                        null,1
                    );

                    $traking = Tracking::where('id_media',$request->id_media)->first();
                    if($traking){
                        $traking->date_achat_cahier = Carbon::now();
                        $traking->save();
                    }

                    return response()->json([
                        'data'=>$data,
                        'status'=>200
                    ]);
                }else{
                    return response()->json([
                        'error'=>$validator->errors(),
                        'status'=>500
                    ]);
                }
            }
        }
    }

    public function save(MediaCreateRequest $request, GestionMedia $gestion)
    {
        $gestion->store($request);
        toast('Enregistrement effectué avec succes!','success');
        return redirect('mes-medias');
    }

    public function getMediaById($id)
    {
        $media = Media::find($id);
        return view('medias.medias.addEdit', compact('media'));
    }

    public function update(Request $request, GestionMedia $gestion, $id)
    {

        if($request->has('logo')){
            $request->validate([
                'nom_media' => ['required'],
                'telephone' => 'required|min:9',
                'email' => ['required', 'email'],
                'description'=> ['required'],
                'logo' => ['required','image','mimes:png,jpg,jpeg'],
                'type_media'=>'required|exists:type_media,id_type_media',
                'forme_juridique'=>'required|exists:forme_juridique,id_forme_juridique',
            ]);

            $gestion->update($request, $id);
            toast('Modification effectué avec succes!','success');
            return redirect('mes-medias');
        }else{
            $request->validate([
                'nom_media' => ['required'],
                'telephone' => 'required|min:9',
                'email' => ['required', 'email'],
                'description'=> ['required'],
                'type_media'=>'required|exists:type_media,id_type_media',
                'forme_juridique'=>'required|exists:forme_juridique,id_forme_juridique',
                ]);
           // $media->nom_media = $request->nom_media;

            $gestion->update($request, $id);
            toast('Modification effectué avec succes!','success');
            return redirect('mes-medias');
        }


    }

    public function save_importation_document_technique(Request $request, GestionMedia $gestion)
    {
        if($request->document == null)
        {
            return response()->json(['succes' => false, 'message' => "Veuillez selectionner un document technique"]);
        }else{
            return $gestion->save_importation_document_technique($request);
        }

    }

    public function soumissionDossier(Request $request)
    {
        $media = Media::find($request->id_media);
        if($media === null) {
            return response()->json([
                'succes' => false,
                'message' => "Le média n'existe pas"
            ]);
        }

        DossiersCommission::updateOrCreate(
            ['id_media' => $request->id_media],
            ['id_user' =>$media->id_user, 'etude_en_cours' => false, 'etude_termine' => false, 'valide' => null]);

        $media->niveau = 'Commission';
        $media->save();

        $tracking = Tracking::where('id_media',$request->id_media)->first();
        if($tracking){
            $tracking->date_soumis_pro = Carbon::now();
            $tracking->save();
        }

        // $traking = Tracking::where('id_media',$request->id_media)->first();
        // $traking->date_achat_cahier = Carbon::now();
        // $traking->save();

        $message = message_email("soummission_de_dossier", $media);
        $objet = "Soumission des documents";

        $commission = User::whereIn("id_role", function ($query){
            $query->from("role")->whereNom("Commission")->select("id_role")->get();
        })->where("is_deleted", false)->first();

        if($commission) send_notification($commission, $objet, $message, $media, config("app.url").':'.env("PORT","9000"));

        return response()->json([
            'succes' => true,
            'message' => "Votre dossier a été soumis avec succès"
        ]);
    }


    public function mesMedias() {

        $media = Media::where('is_deleted',0)->where('user_id',auth()->user()->id)->orderBy('created_at','desc')->get();
        return view('medias.medias.liste',['medias'=>$media,'alert'=>False]);
    }

    public function detele_medias(Request $request)
    {
        $media = Media::find($request->id_use);
        $media->is_deleted = 1;
        $media->save();

        return redirect()->route('mesmedias');
    }


    public function details(Request $request) {

        $tracking = Tracking::firstOrCreate([
            'media_id' => $request->id,
        ]);

        if(!$tracking->date_create_media) {
            $tracking->update(['date_create_media' => now()]);
        }


        $dateDebutCommissionTech = Carbon::parse($tracking->date_create_valide_cahier)->format('Y-m-d');
        $dateFinCommssionTech = Carbon::parse($tracking->date_soumis_pro)->format('Y-m-d');

        $dateDifference = abs(strtotime($dateFinCommssionTech) - strtotime($dateDebutCommissionTech));
        //$dateDifference = abs(strtotime($tracking->date_etude_commission) - strtotime($tracking->date_soumis_pro));
        $years  = floor($dateDifference / (365 * 60 * 60 * 24));
        $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $joursCom   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));
        //fin calcule des jours

        $dateDebMediaCreate = new DateTime($tracking->date_create_media);
        $dateFinMediaCreate = new DateTime($tracking->date_achat_cahier);
        $resutl1 = ($dateFinMediaCreate->format('U') - $dateDebMediaCreate->format('U')) / 3600;

        //Calculer les heures de traitement de la commission
        $dateDebCommissionCreate = new DateTime($tracking->date_soumis_pro);
        $dateFinCommissionCreate = new DateTime($tracking->date_etude_commission);
        $resutl2 = ($dateFinCommissionCreate->format('U') - $dateDebCommissionCreate->format('U')) / 3600;

        //Calculer les heures de traitement de la hac
        $dateDebHacCreate = new DateTime($tracking->date_etude_commission);
        $dateFinHacCreate = new DateTime($tracking->date_etude_hac);
        $resutl3 = ($dateFinHacCreate->format('U') - $dateDebHacCreate->format('U')) / 3600;

        //Calculer les heures de paiement frais d'agrement
        $dateDebFraisAgrementCreate = new DateTime($tracking->date_etude_hac);
        $dateFinFraisAgrementCreate = new DateTime($tracking->date_paiement_agrement);
        $resutl4 = ($dateFinFraisAgrementCreate->format('U') - $dateDebFraisAgrementCreate->format('U')) / 3600;

        //Calculer les transmission
        $dateDebTransmissionCreate = new DateTime($tracking->date_paiement_agrement);
        $dateFinTransmissionCreate = new DateTime($tracking->date_transmission_projet_agrement);
        $resutl5 = ($dateFinTransmissionCreate->format('U') - $dateDebTransmissionCreate->format('U')) / 3600;

        //Calculer les heures de traitement de la hac
        $dateDebEnregistrementCreate = new DateTime($tracking->date_transmission_projet_agrement);
        $dateFinEnregistrementCreate = new DateTime($tracking->date_enregistrement_media);
        $resutl6 = ($dateFinEnregistrementCreate->format('U') - $dateDebEnregistrementCreate->format('U')) / 3600;

        //Calculer les heures de traitement de la hac
        $dateDebPriseRVDCreate = new DateTime($tracking->date_enregistrement_media);
        $dateFinPriseRVDCreate = new DateTime($tracking->date_prise_rdv);
        $resutl7 = ($dateFinPriseRVDCreate->format('U') - $dateDebPriseRVDCreate->format('U')) / 3600;
        $data = ['joursCom'=>$joursCom,'resutl1'=>$resutl1,'resutl2'=>$resutl2,'resutl3'=>$resutl3,'resutl4'=>$resutl4,'resutl5'=>$resutl5];

        // $typeDoc = null;
        $data = Media::find($request->id);

        if($data->stape ==null || $data->stape =='')
        {
            $data->stape = 0;
            $data->save();
        }

        $typeDoc  = CahierDeCharge::where('isCurrent',true)
            ->where('type_media_id',$data->type_media)->first();


        if($data === null || (Auth::user()->role->nom == 'Promoteur' && Auth::user()->id !== $data->user->id)) {
            return view('404');
        }

        $typesDocument = DocumentTypePromoteur::where([
            'type_promoteur_id' => $data->user->type_promoteur_id
        ])->get();

        $typePaiement = TypePaiement::firstWhere('nom', 'Agrément');

        $jours = Programme::getJours();
        $mois = Programme::getMois();

        $origin = new DateTimeImmutable(date('Y-m-d'));
        $target = new DateTimeImmutable(date('Y-m-d'));
        $interval = $origin->diff($target);
        // $documentsInvalides = $this->getDocuementInvalides($data);

        $paiement = Paiement::where(['media_id' => $request->id, 'type_paiement' => $typePaiement->id])->get()->first();
        $commentaire = Paiement::where('media_id', $data->media_id)->first();

        $hideImportFraisAgrement = false;
        if($paiement === null || $paiement->valide === 0) {
            $hideImportFraisAgrement = true;
        }
        $hideImportFraisAgrement = !$hideImportFraisAgrement;

        $soumission = $this->autorisationSoumission($data);
        $documents = Document::where('media_id',$request->id)->get();

        $msg = new MessageController();
        $msg->createMessage();

        $montant = ParametrePaiement::where('is_cahier_charge', true)->first();


        $message = Message::first();
        $disponibilites = Programme::whereNotNull("jour")->orderBy("heure_debut", "DESC")->get();
        $CodeOM = '458752';//codeMarchand::where('modepaiement',"Orange Money")->where('status',1)->first();
        $CodeMOMO ='963852'; //codeMarchand::where('modepaiement',"Mobile Money")->where('status',1)->first();
        return view('medias.medias.details', compact('joursCom','resutl1','resutl2','resutl3','resutl4','resutl5','resutl6','resutl7','typeDoc','data','documents', "disponibilites", 'paiement', 'mois', 'jours', 'hideImportFraisAgrement', 'soumission', 'interval', 'typesDocument',"commentaire", "message","montant", "CodeOM", "CodeMOMO"));
    }

    private function getDocuementInvalides(Media $media) {
        $typesDocument = DocumentTypePromoteur::where(['type_promoteur_id' => $media->user->type_promoteur_id])->get();
        $ids = [];
        foreach($media->documents as $document) {
           array_push($ids, $document->type_document->id_type_document);
        }

        $documentsInvalides = $typesDocument->diff(DocumentTechnique::whereIn('id', $ids)->get());
        return $documentsInvalides;
    }

    private function autorisationSoumission(Media $media) {
        $documentsInvalides = $this->getDocuementInvalides($media);
        $soumission = false;
        if((count($documentsInvalides) == 0 && $media->dossier_commission === null) ||
        (count($documentsInvalides) == 0 && $media->dossier_commission !== null && $media->dossier_commission->valide === 0 && $media->hasDocumentRejeteCommission() == false)) {
            $soumission = true;
        }

        return $soumission;
    }


    public function processus(Request $request, $id) {
        $media = Media::find($id);
        if($media === null || Auth::user()->id_user !== $media->user->id_user) {
            return view('404');
        }

        $typesDocument = TypeDocument::where('is_document_technique', true)->get();
        $typePaiement = TypePaiement::firstWhere('libelle', 'Agrément');

        $jours = Programme::getJours();
        $mois = Programme::getMois();

        $origin = new DateTimeImmutable(date('Y-m-d'));
        $target = new DateTimeImmutable(date('Y-m-d'));
        $interval = $origin->diff($target);
        $documentsInvalides = $this->getDocuementInvalides($media);

        $paiement = Paiement::where(['id_media' => $id, 'id_type_paiement' => $typePaiement->id])->get()->first();
        $hideImportFraisAgrement = false;
        if($paiement === null || $paiement->valide === 0) {
            $hideImportFraisAgrement = true;
        }
        $hideImportFraisAgrement = !$hideImportFraisAgrement;

        $soumission = $this->autorisationSoumission($media);
        return view('medias.processus', compact('media', 'paiement', 'mois', 'jours', 'hideImportFraisAgrement', 'soumission', 'interval', 'typesDocument', 'documentsInvalides'));
    }

    public function remplacerDocument(Request $request, $id) {

        if($request->file()) {
            $fileName = time().'_'.$request->document->getClientOriginalName();
            $filePath = $request->file('document')->storeAs('documents', $fileName, 'public');
        } else {
            return response()->json(['succes' => false, 'message' => "Erreur importation fichier"]);
        }

        $document = Document::find($id);
        if($document == null) {
            return response()->json(['succes' => false, 'message' => "Ce document n'existe pas média"]);

        }

        if(Auth::user()->id_user !== $document->media->user->id_user) {
            return response()->json(['succes' => false, 'message' => "Vous n'êtes pas autorisé à remplacer ce document"]);
        }

        $document->file_path = "/storage/" . $filePath;
        $document->validation_commission = null;
        $document->validation_hac = null;
        $document->save();

        $soumission = $this->autorisationSoumission($document->media);

        return response()->json([
            'succes' => true,
            'file_path' => $document->file_path,
            'idDocument' => $id,
            'soumission' => $soumission,
            'idMedia' => $document->media->id_media,
            'message' => "Le document a été remplacé avec succès"]);
    }

    public function importationDocumentTechnique(Request $request, $id) {
        $validations = ['document' => 'required', 'type' => 'required'];
        $request->validate($validations);

        if($request->file()) {
            $fileName = time().'_'.$request->document->getClientOriginalName();
            $filePath = $request->file('document')->storeAs('documents', $fileName, 'public');
        } else {
            return response()->json(['succes' => false, 'message' => "Erreur importation fichier"]);
        }

        $media = Media::find($id);
        if($media == null) {
            return response()->json(['succes' => false, 'message' => "Vous ne possedez pas ce média"]);

        }

        if(Auth::user()->id_user !== $media->user->id_user) {
            return response()->json(['succes' => false, 'message' => "Vous n'êtes pas autorisé à importer des documents dans ce média"]);
        }

        $doc = Document::updateOrCreate(
            ['id_media' => $id, 'id_type_document' => $request->type],
            ['file_path' => "/storage/" . $filePath, 'valide' => null]
        );

        $typesDocument = TypeDocument::where('is_document_technique', true)->get();
        $documentsRequis = count($typesDocument);
        $documentEnvoye = count($media->documents);
        $documentsInvalides = $this->getDocuementInvalides($media);

        $soumission = $this->autorisationSoumission($media);

        return response()->json([
            'succes' => true,
            'documentsRequis' => $documentsRequis,
            'documentEnvoye' => $documentEnvoye,
            'file_path' => $doc->file_path,
            'nom_document' => $doc->type_document->libelle,
            'idDocument' => $doc->id_document,
            'soumission' => $soumission,
            'documentsInvalides' => $documentsInvalides,
            'action' => $media->dossier_commission === null || $media->dossier_commission->valide === 0,
            'message' => "Le document a été importer avec succès"]);
    }

    public function suppressionDocumentTechnique(Request $request, $id) {
        $document = Document::find($id);
        if($document == null) {
            return response()->json([
                'succes' => false,
                'message' => "Ce document n'existe pas"
            ]);
        }

        if(Auth::user()->id_user !== $document->media->user->id_user) {
            return response()->json([
                'succes' => false,
                'message' => "Vous n'êtes pas autorisé à supprimer ce document"
            ]);
        }

        $path = substr_replace($document->file_path, 'public', 0, strlen('/storage'));
        Storage::delete($path);
        $document->delete();

        $typesDocument = TypeDocument::where('is_document_technique', true)->get();
        $documentsRequis = count($typesDocument);
        $documentEnvoye = count($document->media->documents);
        $documentsInvalides = $this->getDocuementInvalides($document->media);
        $documents = Document::where('id_media',$document->id_media)->with('media','type_document')->get();

        return response()->json([
            'succes' => true,
            'documentsRequis' => $documentsRequis,
            'media'=>$document->id_media,
            'documentEnvoye' => $documentEnvoye,
            'documentsInvalides' => $documentsInvalides,
            'documents'=>$documents,
            'message' => "Le document a été supprimé avec succès",
            'path' => $path
        ]);
    }

    public function etudeDocuments(Request $request, $id) {
        $media = Media::find($id);
        // dd($media);
        if($media === null || !in_array(Auth::user()->role->nom, ['Commission', 'HAC'])) {
            return view('404');
        }

        $etudeDocumentsTermine = 1;
        foreach($media->documents as $document) {
            if(Auth::user()->role->nom === 'Commission') {
                if($document->validation_commission === null) {
                    $etudeDocumentsTermine = 0;
                }
            } else {
                if($document->validation_hac === null) {
                    $etudeDocumentsTermine = 0;
                }
            }
        }

        $clotureEtude = 0;
        if(Auth::user()->role->nom === 'Commission') {
            $dossier_commission = $media->dossier_commission;
            if($dossier_commission && $dossier_commission->etude_termine === 1) {
                $clotureEtude = 1;
            }
        }

        if(Auth::user()->role->nom === 'HAC') {
            $dossier_hac = $media->dossier_hac;
            if($dossier_hac && $dossier_hac->etude_termine === 1) {
                $clotureEtude = 1;
            }
        }


        return view('dossiers.etude_document', compact('media', 'etudeDocumentsTermine', 'clotureEtude'));
    }

    public function validationDocumentTechnique(Request $request, $id) {
        $document = Document::find($id);

        if($document === null) {
            return response()->json(['succes' => false, 'message' => "Ce document n'existe pas"]);
        }

        $isValide = filter_var($request->valide, FILTER_VALIDATE_BOOLEAN);

        if(Auth::user()->role->nom !== 'Commission') {
            return response()->json(['succes' => false, 'message' => "Vous n'êtes pas autorisé à ". $isValide ? 'valider' : "rejeter" ."ce document"]);
        }

        $document->validation_commission = $isValide;
        $document->save();

        $etudeTermine = 1;
        foreach($document->media->documents as $doc) {
            if($doc->validation_commission === null) {
                $etudeTermine = 0;
            }
        }

        $clotureEtude = 0;
        if(Auth::user()->role->nom === 'Commission') {
            $dossier_commission = $document->media->dossier_commission;
            if($dossier_commission && $dossier_commission->etude_termine === 1) {
                $clotureEtude = 1;
            }
        }

        if(Auth::user()->role->nom === 'HAC') {
            $dossier_hac = $document->media->dossier_hac;
            if($dossier_hac && $dossier_hac->etude_termine === 1) {
                $clotureEtude = 1;
            }
        }

        return response()->json([
            'succes' => true,
            'etudeTermine' => $etudeTermine,
            'clotureEtude' => $clotureEtude,
            'message' => "Le document a été " . $isValide ? 'validé' : 'rejeté'
        ]);
    }

    public function validationEtudeDocumentsTechniques(Request $request, $id) {
        $media = Media::find($id);

        if($media === null) {
            return response()->json(['succes' => false, 'message' => "Ce média n'existe pas"]);
        }

        $valide = $request->valide == 1;

        if(!in_array(Auth::user()->role->nom, ['Commission', 'HAC'])) {
            return response()->json(['succes' => false, 'message' => "Vous n'êtes pas autorisé à étudier ce dossier"]);
        }

        $commentaires = $request->commentaires;

        foreach($commentaires as $commentaire) {
            $document = Document::find($commentaire['id']);
            if($document) {
                if(Auth::user()->role->nom === 'Commission') {
                    $document->is_validated_commission = $valide;
                    $document->comment_rejet_commission = $commentaire['commentaire'];
                    $media->en_attente_commission = false;
                    $media->en_cours_commission = true;
                    $media->update();
                }elseif(Auth::user()->role->nom === 'HAC') {
                    $document->is_validated_hac = $valide;
                    $document->comment_rejet_hac = $commentaire['commentaire'];

                    $media->en_attente_hac = false;
                    $media->en_cours_hac = true;
                    $media->update();
                }

                $document->save();
            }
        }

        $firstDossier = Dossier::where('media_id',$media->id)->first();
        if($firstDossier){
            if(Auth::user()->role->nom === 'Commission'){
                $firstDossier->status_commission = 'revoir';
                $firstDossier->is_valided_commission = true;
                $firstDossier->save();

                $media->en_attente_commission = false;
                $media->en_cours_commission = true;
                $media->update();
            }elseif(Auth::user()->role->nom === 'HAC'){
                $firstDossier->is_valided_hac = true;
                $firstDossier->save();
                $media->en_attente_hac = false;
                $media->en_cours_hac = true;
                $media->update();
            }
        }

        $etudeTermine = 1;

        foreach($media->documents as $doc) {
            if(Auth::user()->role->nom === 'Commission') {
                if($doc->is_validated_commission === null) {
                    $etudeTermine = 0;
                }
            } else {
                if($doc->is_validated_hac === null) {
                    $etudeTermine = 0;
                }
            }
        }

        $clotureEtude = 0;
        if(Auth::user()->role->nom === 'Commission') {
            $dossier_commission = $media->dossier_commission;
            if($dossier_commission && $dossier_commission->etude_termine === 1) {
                $clotureEtude = 1;
            }
        }

        if(Auth::user()->role->nom === 'HAC') {
            $dossier_hac = $media->dossier_hac;
            if($dossier_hac && $dossier_hac->etude_termine === 1) {
                $clotureEtude = 1;
            }
        }

        return response()->json([
            'succes' => true,
            'etudeTermine' => $etudeTermine,
            'commentaires' => $commentaires,
            'valide' => $valide,
            'clotureEtude' => $clotureEtude,
            'message' => "Document.s " . ($valide ? 'validé.s' : 'rejeté.s')
        ]);
    }

    public function terminerEtudeDocumentsTechniques(Request $request, $id) {
        $media = Media::find($id);

        if($media === null) {
            return response()->json(['succes' => false, 'message' => "Ce média n'existe pas"]);
        }

        if(!in_array(Auth::user()->role->nom, ['Commission', 'HAC'])) {
            return response()->json(['succes' => false, 'message' => "Vous n'êtes pas autorisé à étudier ce dossier"]);
        }

        $url = '';
        if(Auth::user()->role->nom === 'Commission') {
            $valide = true;
            foreach($media->documents as $document) {
                if($document->validation_commission === 0) {
                    $valide = false;
                }
                if($document->validation_hac === 0) {
                    $document->validation_hac = null;
                    $document->save();
                }
            }
            $dossier_commission = $media->dossier_commission;

            if($valide == false){
                $media->level = 1;
                $media->save();
                // $message = "L'étude des documents techniques est terminée ";
                $media->niveau = 'Promoteur';

                //Promoteur
                $message = message_email("examen_terminer");
                $objet = "Examen de la commission technique ";
                send_notification($media->user, $objet, $message, $media, config("app.url").':'.env("PORT","9000"));
                $media->save();

                $dossier_commission->valide = $valide;
                $dossier_commission->revoir = false;
                $dossier_commission->save();
            }
            if($dossier_commission) {
                $dossier_commission->etude_termine = true;
                $dossier_commission->save();
            }

            $url = '/medias/etudes/commission';
        } else {
            $dossier_hac = $media->dossier_hac;

            $valide = true;
            foreach($media->documents as $document) {
                if($document->validation_hac === 0) {
                    $valide = false;
                    $document->validation_commission = null;
                    $document->save();
                    //break;
                }
            }
            if($valide == false){
                $dossier_hac->valide = $valide;
                $dossier_hac->save();

                $message = [
                    "Votre dossier technique a été rejeté par la Haute Autorité de Communication (HAC).",
                    "Veuillez consulter le raport pour plus de détails."
                ];
                $dossier_commission = $media->dossier_commission;
                if($dossier_commission !== null) {
                    $dossier_commission->revoir = true;
                    $dossier_commission->etude_termine = false;
                    $dossier_commission->save();
                }

                $media->level = 2;
                $media->niveau = 'Commission';
                $media->save();

                $commission = User::whereIn("id_role", function ($query){
                    $query->from("role")->whereNom("Commission")->select("id_role")->get();
                })->where("is_deleted", false)->first();

                if($commission) {
                    $message_commission = message_email("avis_consultatif", $media);

                    // dd($message_commission);
                    send_notification(
                        $commission,
                        "Haute autorité de la communication",
                        $message_commission,
                        $media,
                        config("app.url")
                    );
                }

            }

            if($dossier_hac) {
                $dossier_hac->etude_termine = true;
                $dossier_hac->save();
            }

            $url = '/medias/etudes/hac';
        }

        return response()->json([
            'succes' => true,
            'message' => "Etude du dossier terminé avec succès",
            'url' => $url
        ]);
    }

    public function depotDossier(Request $request, $id) {
        $media = Media::find($id);
        if($media == null) {
            return response()->json(
                [
                    'succes' => false,
                    'message' => "Vous ne possedez pas ce média"
            ]);
        }

        if(Auth::user()->id_user !== $media->user->id_user) {
            return response()->json(
                [
                    'succes' => false,
                    'message' => "Vous n'êtes pas autorisé à soumettre les dossiers de ce média"
                ]
            );
        }

        DossiersCommission::updateOrCreate(
            ['id_media' => $id],
            ['etude_en_cours' => false, 'etude_termine' => false, 'valide' => null]);

        $media->niveau = 'Commission';
        $media->save();

        return response()->json(
            [
                'succes' => true,
                'message' => "Votre dossier a été soumis avec succès"
            ]
        );
    }

    public function listeMedia(Request $request)
    {
        if(Auth::user()->role->nom !== 'Direction') {
            return view('404');
        }

        if($request->nom) {
            $medias = Media::where('nom_media', 'LIKE', '%'.$request->nom.'%')->get();
            $ids = [];
            foreach($medias as $media) {
                array_push($ids, $media->id_media);
            }

            $medias = Media::whereIn('id_media', $ids)->paginate(20);
        } else {
            $medias = Media::paginate(20);
        }

        return view('medias.enregistres', compact('medias'));
    }

    public function mediasAgres(Request $request)
    {
        if(Auth::user()->role->nom !== 'Direction') {
            return view('404');
        }

        if($request->nom) {
            $medias = Media::where('nom_media', 'LIKE', '%'.$request->nom.'%')->get();
            $ids = [];
            foreach($medias as $media) {
                array_push($ids, $media->id_media);
            }

            $meetings = Meeting::whereIn('id_media', $ids)->where('agrement', '<>', null)->paginate(20);
        } else {
            $meetings = Meeting::where('agrement', '<>', null)->paginate(20);
        }

        return view('medias.agrees', compact('meetings'));
    }
}
