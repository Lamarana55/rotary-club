<?php

namespace App\Http\Livewire;

use App\Models\CahierDeCharge;
use App\Models\CodeMarchand;
use App\Models\Document;
use App\Models\DocumentTechnique;
use App\Models\DocumentTypePromoteur;
use App\Models\Dossier;
use App\Models\Media;
use App\Models\Meeting;
use App\Models\Paiement;
use App\Models\ParametrePaiement;
use App\Models\Programme;
use App\Models\Tracking;
use App\Models\TypeMedia;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use PDF;
use PhpParser\Node\Expr\FuncCall;

class GestionDetailPromoteurComponent extends Component
{
    use WithFileUploads;

    public $currentPreview = PREVIEWCOMMISSION;

    public $media;
    public $CodeMOMO;
    public $CodeBanque;
    public $CodeOM;
    public $montant;
    public $paiement;
    public $disponibilites=[];
    public $programme;
    public $documentsTechniques;
    public $documents=[];
    public $firstDocument;
    public $filePath;
    public $listDocuments;
    public $modePaiement;
    public $dateDePaiement;
    public $numeroDePaiement;
    public $code;
    public $dossier;
    public $recuPaiement;
    public $recu;
    public $numeroDeRecu;
    public $cahierChargePayer;
    public $fraisAgrement;
    public $documentsRequis;
    public $soumission;
    public $preview = "";
    public $current_stape;
    public $resutl1;
    public $resutl2;
    public $resutl3;
    public $resutl4;
    public $resutl5;
    public $resutl6;
    public $resutl7;
    public $joursCom;
    public $typeDoc;
    public $showDescription;
    public $is_visualiseragreement = false;
    public $is_visualiserprojetagreement = false;
    public $commentaire;
    public $options = [
        "Paiement non reçu",
        "Preuve non valide",
        "Montant incorrect",
        "Autres, veuillez contacter la DAF du MIC"
    ];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function AdminAuthCheck()
    {
        if(!Auth::guard()->check())
        {
            return redirect('/login');
        }
    }

    public function validationPaiementCahierCharger($id)
    {

        $paiement = Paiement::find($id);
        $stape = Media::find($paiement->media_id);
        $paiement->is_valided = true;
        $media = $paiement->media;
        $stape->stape = 1;
        $stape->current_stape = 2;
        $stape->en_attente = false;
        $stape->en_cours = true;
        $stape->update();
        $data = [
            'imagePath'    => public_path('dist/img/momo.png'),
            'pathArmoirie' => convertBase64('public/assets/dist/img/armoirie.png'),
            'pathBranding' => convertBase64('public/assets/dist/img/branding.jpg'),
            'flag_guinnea' => convertBase64('public/assets/dist/img/flag_guinea.png'),
            'media' => $stape,
            'montant' => $paiement->montant,
            'date' => date('d-m-Y'),
            'mode' => $paiement->mode
        ];
        $pdf = PDF::loadView('template_documents.recu_cahier_charge', $data);
        $content = $pdf->setPaper('a4')->download()->getOriginalContent();

        $path = 'recus_cahier_charge_genere/' . time() . '_recu.pdf';
        Storage::put('public/' . $path, $content);
        $paiement->recu_genere = "/storage/" . $path;
        // $message = message_email("validation_paiement_cahier_de_charge_autre");
        $objet = "Paiement de cahier des charges";

        $types = $stape->type.' '.$stape->type_media;
        // $message = message_email("validation_paiement_cahier_de_charge_autre");
        $message =["La division des affaires financières du ministère de l’information et de la communication a validé votre paiement.", "Votre cahier des charges pour <b>".$types."</b> est maintenant disponible sur la plateforme.", "Veuillez vous connecter pour plus d'informations."];

        $paiement->save();

        send_notification($media->user, $objet, $message, $media, config("app.url") . ':' . env("PORT", "9000"));

        $tracking = Tracking::where('media_id', $paiement->media_id)->first();
        if ($tracking) {
            $tracking->date_valide_cahier = Carbon::now();
            $tracking->save();
        }

        $this->showValideCahierChargeClose();
        $this->dispatchBrowserEvent("showSuccessMessage", [
            "is_valided" => true,
            "message" => "Le paiement a été validé"
        ]);

        // return $this->redirect('detail-media/'.$paiement->media_id);

    }

    public function rejetPaiementCahierCharger($id)
    {
        $paiement = Paiement::find($id);
        $stape = Media::find($paiement->media_id);
        $paiement->is_valided = false;

        $paiement->commentaire_reject = $this->commentaire;

        if ($paiement->commentaire_reject == "Montant incorrect") {
            $message = message_email("rejet_paiement_cahier_de_charge_montant_incorrect");
        } else {
            $message = message_email("rejet_paiement_cahier_de_charge_autre", null, $this->commentaire);
        }

        $objet = "Rejet paiement de cahier des charges";
        $stape->stape = null;
        $stape->en_attente = false;
        $stape->en_cours = true;
        $stape->update();

        $paiement->update();
        $media = $paiement->media;

        send_notification($media->user, $objet, $message, $media, config("app.url") . ':' . env("PORT", "9000"));

        $tracking = Tracking::where('media_id', $paiement->media_id)->first();
        if ($tracking) {
            $tracking->date_valide_cahier = Carbon::now();
            $tracking->save();
        }

        $this->showRejetPaiementCahierChargeCloseModal();
        $this->dispatchBrowserEvent("showSuccessMessage", [
            "is_valided" => false,
            "message" => "Le paiement a été rejeté..."
        ]);

        // $this->redirect('/liste-medias');
    }

    public function showRejetPaiementCahierChargeCloseModal()
    {
        $this->dispatchBrowserEvent("showRejetPaiementCahierChargeCloseModal");
    }

    public function showRejetPaiementCahierChargeModal($id)
    {
        $this->paiement = Paiement::find($id);
        $this->dispatchBrowserEvent("showRejetPaiementCahierChargeModal");
    }

    private function showCodeMarchand()
    {
        $this->CodeOM = CodeMarchand::where('modepaiement',"Orange Money")->where('status',1)->first();
        $this->CodeMOMO = CodeMarchand::where('modepaiement',"Mobile Money")->where('status',1)->first();
        $this->CodeBanque = CodeMarchand::where('modepaiement',"Paiement Bancaire")->where('status',1)->first();

    }

    public function afficherDescription($id)
    {
        $this->showDescription = DocumentTechnique::find($id);

    }

    private function getDocuementTechniques(Media $media) {
        $documents = Document::where('media_id',$media->id)->where('categorie','document_technique')->get();
        $typesDocument = DocumentTypePromoteur::where('type_promoteur_id',$media->user->type_promoteur_id)->with('type_promoteur','document_technique')->get();
        $ids = [];
        foreach($documents as $document) {
           array_push($ids, $document->document_type_promoteur->id);
        }
        $documentsTechniques = $typesDocument->diff(DocumentTypePromoteur::whereIn('id', $ids)->get());
        return $documentsTechniques;
    }

    private function hasDocumentRejeteCommission()
    {
        $hasDocumentRejete = false;
        foreach($this->listDocuments as $document) {
            if($document->is_validated_commission === 0) {
                $hasDocumentRejete = true;
                break;
            }
        }

		return $hasDocumentRejete;
    }

    private function autorisationSoumission() {
        $dossier = Dossier::where('media_id',$this->media->id)->first();
        $documentsInvalides = $this->documentsTechniques;
        $soumission = false;
        if((count($documentsInvalides) == 0 && $dossier === null) ||
        (count($documentsInvalides) == 0 && $dossier !== null && $dossier->status_commission === 'rejeter' && $this->hasDocumentRejeteCommission() == false)) {
            $soumission = true;
        }

        return $soumission;
    }

    public function showPreviewFiles($id)
    {
        $this->firstDocument = Document::find($id);
        $this->currentPreview =true;
        $this->preview = "document";
    }

    public function closeCurrentPreview()
    {
        $this->preview = "";
        $this->currentPreview =false;
    }

    public function showModalValideFraisAgrement($id)
    {
        $this->paiement = Paiement::where('type_paiement','fraisAgrement')->where('media_id',$id)->first();
        $this->dispatchBrowserEvent("showModalValideFraisAgrement");

    }

    public function showModalRejetPaiementFraisAgrement($id)
    {
        $this->paiement = Paiement::where('type_paiement','fraisAgrement')->where('media_id',$id)->first();
        $this->dispatchBrowserEvent("showModalRejetFraisAgrement");
    }

    public function showValideCahierChargeModal($id)
    {

        $this->paiement = Paiement::find($id);
        $this->dispatchBrowserEvent("showValideCahierChargeModal");
    }

    public function showValideCahierChargeClose()
    {

        $this->dispatchBrowserEvent("showValideCahierChargeClose");
    }

    public function validationRejetPaiementFraisAgrement($id, $status)
    {
        $paiement = Paiement::find($id);
        $stape = Media::find($paiement->media_id);
        if($status ==1)
        {
            $paiement->is_valided = true;
            $paiement->save();

            $message = message_email('validation_recu_de_paiement_agrement');
            $objet = "Paiement agrément (Trésor public)";

            $stape->status_conseiller=false;
            $stape->stape=4;
            $stape->current_stape=5;
            $stape->save();

            $traking = Tracking::where('media_id', $paiement->media_id)->first();
            if($traking){
                $traking->date_valide_paiement_agrement = Carbon::now();
                $traking->update();
            }

            send_notification($stape->user, $objet, $message, $stape,config("app.url") . ':' . env("PORT", "9000"));

            $this->dispatchBrowserEvent("showSuccessMessage", [
                "is_valided" => true,
                "message" => "Le paiement a été validé..."
            ]);

        }elseif($status==0){
            $paiement->is_valided = false;
            $paiement->save();

            $message = message_email("rejet_recu_de_paiement_agrement");
            $objet = "Paiement agrément (Trésor public)";

            $stape->stape=3;
            $stape->current_stape=4;
            $stape->save();

            $this->dispatchBrowserEvent("showSuccessMessage", [
                "is_valided" => false,
                "message" => "Le paiement a été rejeté..."
            ]);
        }

        $this->redirect('/detail-media/'.$this->media->uuid);

    }

    public function mount($id)
    {
        $this->AdminAuthCheck();
        $this->dateDePaiement = explode(' ',\Carbon\Carbon::now())[0];
        $this->media = Media::whereUuid($id)->first();

        $this->current_stape = $this->media->current_stape;

        $type_media = TypeMedia::whereNom($this->media->type_media)->first();
        $this->typeDoc  = CahierDeCharge::where('isCurrent',true)
            ->where('type_media_id',$type_media->id)->first();

        $notifs = DB::table('notification')
            ->where('media_id', $this->media->id)
            ->where('recever_id',Auth::user()->id)
            ->where('isUpdate',0)->get();
        $arrayNotif = array();

        if(Auth::user()->role->nom !='Promoteur'){
            foreach ($notifs as $notif) {
                $arrayNotif['isUpdate'] = true;
                DB::table('notification')
                    ->where('media_id', $this->media->id)
                    ->where('recever_id',Auth::user()->id)
                    ->where('isUpdate', 0)
                    ->update($arrayNotif);
            }
        }

        $tracking = Tracking::firstOrCreate(['media_id' => $this->media->id]);

        if(!$tracking->date_create_media) {
            $tracking->update(['date_create_media' => now()]);
        }

        $dateDebutCommissionTech = Carbon::parse($tracking->date_create_valide_cahier)->format('Y-m-d');
        $dateFinCommssionTech = Carbon::parse($tracking->date_soumis_pro)->format('Y-m-d');

        $dateDifference = abs(strtotime($dateFinCommssionTech) - strtotime($dateDebutCommissionTech));
        $years  = floor($dateDifference / (365 * 60 * 60 * 24));
        $months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $this->joursCom   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));
        //fin calcule des jours

        $dateDebMediaCreate = new DateTime($tracking->date_create_media);
        $dateFinMediaCreate = new DateTime($tracking->date_achat_cahier);
        $this->resutl1 = ($dateFinMediaCreate->format('U') - $dateDebMediaCreate->format('U')) / 3600;

        //Calculer les heures de traitement de la commission
        $dateDebCommissionCreate = new DateTime($tracking->date_soumis_pro);
        $dateFinCommissionCreate = new DateTime($tracking->date_etude_commission);
        $this->resutl2 = ($dateFinCommissionCreate->format('U') - $dateDebCommissionCreate->format('U')) / 3600;

        //Calculer les heures de traitement de la hac
        $dateDebHacCreate = new DateTime($tracking->date_etude_commission);
        $dateFinHacCreate = new DateTime($tracking->date_etude_hac);
        $this->resutl3 = ($dateFinHacCreate->format('U') - $dateDebHacCreate->format('U')) / 3600;

        //Calculer les heures de paiement frais d'agrement
        $dateDebFraisAgrementCreate = new DateTime($tracking->date_etude_hac);
        $dateFinFraisAgrementCreate = new DateTime($tracking->date_paiement_agrement);
        $this->resutl4 = ($dateFinFraisAgrementCreate->format('U') - $dateDebFraisAgrementCreate->format('U')) / 3600;

        //Calculer les transmission
        $dateDebTransmissionCreate = new DateTime($tracking->date_paiement_agrement);
        $dateFinTransmissionCreate = new DateTime($tracking->date_transmission_projet_agrement);
        $this->resutl5 = ($dateFinTransmissionCreate->format('U') - $dateDebTransmissionCreate->format('U')) / 3600;

        //Calculer les heures de traitement de la hac
        $dateDebEnregistrementCreate = new DateTime($tracking->date_transmission_projet_agrement);
        $dateFinEnregistrementCreate = new DateTime($tracking->date_enregistrement_media);
        $this->resutl6 = ($dateFinEnregistrementCreate->format('U') - $dateDebEnregistrementCreate->format('U')) / 3600;

        //Calculer les heures de traitement de la hac
        $dateDebPriseRVDCreate = new DateTime($tracking->date_enregistrement_media);
        $dateFinPriseRVDCreate = new DateTime($tracking->date_prise_rdv);
        $this->resutl7 = ($dateFinPriseRVDCreate->format('U') - $dateDebPriseRVDCreate->format('U')) / 3600;
        // $data = ['joursCom'=>$joursCom,'resutl1'=>$resutl1,'resutl2'=>$resutl2,'resutl3'=>$resutl3,'resutl4'=>$resutl4,'resutl5'=>$resutl5];

        $this->documentsRequis = DocumentTypePromoteur::where('type_promoteur_id',$this->media->user->type_promoteur_id)->get();

        $this->listDocuments = Document::where('media_id',$this->media->id)->where('categorie','document_technique')->with('media','document_type_promoteur')->get();

        $this->montant = ParametrePaiement::where('is_cahier_charge', true)->first();
        $this->disponibilites = Programme::whereNotNull("jour")->orderBy("heure_debut", "DESC")->get();
        $this->programme = Meeting::where('media_id',$this->media->id)->first();

        $this->showCodeMarchand();
        $this->documentsTechniques = $this->getDocuementTechniques($this->media);

        $this->dateDePaiement = date('Y-m-d');

        $this->soumission = $this->autorisationSoumission();
    }

    public function sendMailDelaiTraitement(){
        //paiement de cahier des charges
        if(getTemps('paiement de cahier des charges',traking($this->media->id)->date_create_media??null) >= delais('paiement de cahier des charges')->delais){
            // isSendMailToUser($this->media->user->id,$this->media->id,getMessageAlert(delais('paiement de cahier des charges'), $this->media));
            if(convertionDelais(getTemps('paiement de cahier des charges',traking($this->media->id)->date_create_media??null),'paiement de cahier des charges')=='75%'){
                if(isSendMailToUser($this->media->user->id,$this->media->id,getMessageAlert2(delais('paiement de cahier des charges'), $this->media))==null){
                    if($this->cahierChargePayer===null || $this->cahierChargePayer->is_valided==false){
                        $objet ="Expiration du délai";
                        // send_notification(auth::user(), $objet, getMessageAlert2(delais('paiement de cahier des charges'), $this->media), $this->media, null);
                    }
                }
            }else{
                if(isSendMailToUser($this->media->user->id,$this->media->id,getMessageAlert(delais('paiement de cahier des charges'), $this->media))==null){
                    if($this->cahierChargePayer===null || $this->cahierChargePayer->is_valided==false){
                        $objet ="Expiration du délai";
                        // send_notification(auth::user(), $objet, getMessageAlert(delais('paiement de cahier des charges'), $this->media), $this->media, null);
                    }
                }
            }
        }
        //paiement frais agrément
        // if(getTemps('soumission des documents technique',traking($this->media->id)->date_valide_cahier??null) >= delais('soumission des documents technique')->delais){
        //     // isSendMailToUser($this->media->user->id,$this->media->id,getMessageAlert(delais('soumission des documents technique'), $this->media));
        //     if(convertionDelais(getTemps('soumission des documents technique',traking($this->media->id)->date_valide_cahier??null),'soumission des documents technique')=='75%'){
        //         if(isSendMailToUser($this->media->user->id,$this->media->id,getMessageAlert2(delais('soumission des documents technique'), $this->media))==null){
        //             if($this->fraisAgrement==null || $this->fraisAgrement->is_valided==0){
        //                 $objet ="Expiration du délai";
        //                 send_notification(auth::user(), $objet, getMessageAlert2(delais('soumission des documents technique'), $this->media), $this->media, null);
        //             }
        //         }
        //     }else{
        //         if(isSendMailToUser($this->media->user->id,$this->media->id,getMessageAlert(delais('soumission des documents technique'), $this->media))==null){
        //             if($this->fraisAgrement==null || $this->fraisAgrement->is_valided==0){
        //                 $objet ="Expiration du délai";
        //                 send_notification(auth::user(), $objet, getMessageAlert(delais('soumission des documents technique'), $this->media), $this->media, null);
        //             }
        //         }
        //     }
        // }

        //soumission
        // if(getTemps('paiement de frais d\'agrément',traking($this->media->id)->date_etude_hac??null) >= delais('paiement de frais d\'agrément')->delais){
        //     // isSendMailToUser($this->media->user->id,$this->media->id,getMessageAlert(delais('paiement de frais d\'agrément'), $this->media));
        //     if(convertionDelais(getTemps('paiement de frais d\'agrément',traking($this->media->id)->date_etude_hac??null),'paiement de frais d\'agrément')=='75%'){
        //         if(isSendMailToUser($this->media->user->id,$this->media->id,getMessageAlert2(delais('paiement de frais d\'agrément'), $this->media))==null){
        //             if($this->fraisAgrement==null || $this->fraisAgrement->is_valided==0){
        //                 $objet ="Expiration du délai";
        //                 send_notification(auth::user(), $objet, getMessageAlert2(delais('paiement de frais d\'agrément'), $this->media), $this->media, null);
        //             }
        //         }
        //     }else{
        //         if(isSendMailToUser($this->media->user->id,$this->media->id,getMessageAlert(delais('paiement de frais d\'agrément'), $this->media))==null){
        //             if($this->fraisAgrement==null || $this->fraisAgrement->is_valided==0){
        //                 $objet ="Expiration du délai";
        //                 send_notification(auth::user(), $objet, getMessageAlert(delais('paiement de frais d\'agrément'), $this->media), $this->media, null);
        //             }
        //         }
        //     }
        // }

        //validation validation du paiement de cahier des charges chez daf
        // if(getTemps('validation du paiement de cahier des charges',traking($this->media->id)->date_achat_cahier??null) >= delais('validation du paiement de cahier des charges')->delais){
        //     if(convertionDelais(getTemps('validation du paiement de cahier des charges',traking($this->media->id)->date_achat_cahier??null),'validation du paiement de cahier des charges')=='75%'){
        //         if(isSendMailToUser($this->media->user->id,$this->media->id,getMessageAlert2(delais('validation du paiement de cahier des charges'), $this->media))==null){
        //             if($this->cahierChargePayer && $this->cahierChargePayer->is_valided==null || $this->cahierChargePayer && $this->cahierChargePayer->is_valided==0){
        //                 $objet ="Expiration du délai";
        //                 send_notification(auth::user(), $objet, getMessageAlert2(delais('validation du paiement de cahier des charges'), $this->media), $this->media, null);
        //             }
        //         }
        //     }else{
        //         if(isSendMailToUser($this->media->user->id,$this->media->id,getMessageAlert(delais('validation du paiement de cahier des charges'), $this->media))==null){
        //             if($this->cahierChargePayer && $this->cahierChargePayer->is_valided==null || $this->cahierChargePayer && $this->cahierChargePayer->is_valided==0){
        //                 $objet ="Expiration du délai";
        //                 send_notification(auth::user(), $objet, getMessageAlert(delais('validation du paiement de cahier des charges'), $this->media), $this->media, null);
        //             }
        //         }
        //     }
        // }
    }

    public function render()
    {
        $this->cahierChargePayer = Paiement::where('media_id',$this->media->id)->where('type_paiement','cahierDesCharges')->first();
        $this->fraisAgrement = Paiement::where('media_id',$this->media->id)->where('type_paiement','fraisAgrement')->first();
        $this->dossier = Dossier::where('media_id',$this->media->id)->first();
        //alert si le delai de tratement est fini
        // $this->sendMailDelaiTraitement();
        return view('medias.medias.detail_media')
            ->extends("layouts.default",['title'=>'Processus de validation du média '])
            ->section("content");
    }

    public function closeModalMomo(){
        $this->dateDePaiement = "";
        $this->numeroDePaiement = "";
        $this->resetValidation();
    }

    public function closeModalOrangeMoney(){
        $this->resetValidation();
        $this->dateDePaiement = "";
        $this->numeroDePaiement = "";
    }

    public function closeModalRecu(){
        $this->resetValidation();
        $this->dispatchBrowserEvent("closeModalRecu");
    }

    public function closeModaDocumentTe(){
        $this->dispatchBrowserEvent("closeModaDocumentTechniques");
    }

    public function paiementCahierDesCharges($id)
    {
        $this->code = CodeMarchand::find($id);
        $paiement = new Paiement();
        $existPaiement = Paiement::where('media_id',$this->media->id)->where('type_paiement','cahierDesCharges')->first();

        if($this->code->modepaiement == 'Paiement Bancaire')
        {
            $validateArr = [
                "dateDePaiement" => "required",
                "recuPaiement" => "required|max:2048",
                "numeroDeRecu"=>"required|numeric|min:2"
            ];
            $this->validate($validateArr);

            $imagePath ="";
            if($this->recuPaiement != null){
                $path = $this->recuPaiement->store("paiement_cahier_charge", "public");
                $imagePath = "storage/".$path;
            }

            if($existPaiement){
                $existPaiement->montant = $this->montant->montant;
                $existPaiement->mode = $this->code->modepaiement;
                $existPaiement->date_paiement = $this->dateDePaiement;
                $existPaiement->telephone = $this->numeroDeRecu;
                $existPaiement->code_marchant = $this->code->code;
                $existPaiement->type_paiement = 'cahierDesCharges';
                $existPaiement->is_valided = null;
                $existPaiement->is_deleted = false;
                $existPaiement->recu = $imagePath;
                $existPaiement->media_id = $this->media->id;
                $existPaiement->save();

                $this->dateDePaiement = "";
                $this->numeroDePaiement = "";

            }else{
                $paiement->montant = $this->montant->montant;
                $paiement->mode = $this->code->modepaiement;
                $paiement->date_paiement = $this->dateDePaiement;
                $paiement->telephone = $this->numeroDeRecu;
                $paiement->code_marchant = $this->code->code;
                $paiement->type_paiement = 'cahierDesCharges';
                $paiement->is_valided = null;
                $paiement->is_deleted = false;
                $paiement->recu = $imagePath;
                $paiement->media_id = $this->media->id;
                $paiement->save();
            }

        }else{
            $validateArr = [
                "dateDePaiement" => "required",
                'numeroDePaiement'=>'required|min:9|max:9',

            ];
            $this->validate($validateArr);
            $prefixe = substr($this->numeroDePaiement, 0, 2);
            // dump($prefixe);
            if($this->code->modepaiement=='Orange Money'){
                if($prefixe ==61 || $prefixe ==62){
                    // return throw ValidationException::withMessages(['numeroDePaiement' => 'Veuillez saisir un numéro orange']);
                }else{
                    return throw ValidationException::withMessages(['numeroDePaiement' => 'Veuillez saisir un numéro orange']);
                }
            }elseif($this->code->modepaiement =='Mobile Money'){
                if($prefixe !=66){
                    return throw ValidationException::withMessages(['numeroDePaiement' => 'Veuillez saisir un numéro MTN']);
                }
            }

            if($existPaiement){
                $existPaiement->montant = $this->montant->montant;
                $existPaiement->mode = $this->code->modepaiement;
                $existPaiement->telephone = $this->numeroDePaiement;
                $existPaiement->date_paiement = $this->dateDePaiement;
                $existPaiement->code_marchant = $this->code->code;
                $existPaiement->recu = null;
                $existPaiement->type_paiement = 'cahierDesCharges';
                $existPaiement->is_valided = null;
                $existPaiement->is_deleted = false;
                $existPaiement->media_id = $this->media->id;
                $existPaiement->save();

            }else{
                $paiement->montant = $this->montant->montant;
                $paiement->mode = $this->code->modepaiement;
                $paiement->telephone = $this->numeroDePaiement;
                $paiement->recu = null;
                $paiement->date_paiement = $this->dateDePaiement;
                $paiement->code_marchant = $this->code->code;
                $paiement->type_paiement = 'cahierDesCharges';
                $paiement->is_valided = null;
                $paiement->is_deleted = false;
                $paiement->media_id = $this->media->id;
                $paiement->save();

            }

        }

        $message = message_email("paiement_cahier_de_charge", $this->media);
        $objet = "Nouveau paiement";
        $traking = Tracking::where('media_id', $this->media->id)->first();
        if($traking){
            $traking->date_achat_cahier = Carbon::now();
            $traking->save();
        }

        $daf = User::whereIn("role_id", function ($query){
            $query->from("role")->whereNom("DAF")->select("id")->get();
        })->where("is_deleted", false)->first();

        $direction = User::whereIn("role_id", function ($query){
            $query->from("role")->whereNom("Direction")->select("id")->get();
        })->where("is_deleted", false)->first();

        $ministre = User::whereIn("role_id", function ($query){
            $query->from("role")->whereNom("Ministre")->select("id")->get();
        })->where("is_deleted", false)->first();

        $commission = User::whereIn("role_id", function ($query){
            $query->from("role")->whereNom("Commission")->select("id")->get();
        })->where("is_deleted", false)->first();

        if($daf) send_notification($daf, $objet, $message, $this->media, config("app.url").':'.env("PORT","9000"));

        if($direction) send_notification($direction, $objet, $message, $this->media, config("app.url").':'.env("PORT","9000"));

        if($ministre) send_notification($ministre, $objet, $message, $this->media, config("app.url").':'.env("PORT","9000"));
        if($commission) send_notification($commission, $objet, $message, $this->media, config("app.url").':'.env("PORT","9000"));

        send_notification(
            $this->media->user,
            $objet,
            message_email("confirmation_de_paiement_cahier_de_charge"),
            $this->media,
            null,
            1
        );
        //changer status
        $state = Media::find($this->media->id);
        $state->en_attente = true;
        $state->update();
        //vide les champs apres traitement
        $this->dateDePaiement = "";
        $this->numeroDePaiement = "";
        $this->recuPaiement = "";
        $this->numeroDeRecu="";
        $this->redirect('/detail-media/'.$this->media->uuid);
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Paiement cahier de charge effecuté avec succès"]);
        if($this->code->modepaiement =='Orange Money'){
            $this->closeModalOrangeMoney();
        }elseif($this->code->modepaiement=='Mobile Money'){
            $this->closeModalMomo();
        }
    }

    public function saveImportationDocumentTechnique()
    {
        $this->validate([
            'documents'=>'required'
        ]);

        $fileDoc = array();
        foreach ($this->documents as $key => $file) {
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            $fileDoc['media_id'] = $this->media->id;
            $fileDoc['document_type_promoteur_id'] =$key;
            $fileDoc['categorie'] = 'document_technique';
            $fileDoc['file_path'] = "/storage/".$filePath;

            DB::table('document')->insert($fileDoc);
        }

        $msg = count($this->documents) >1 ? "Les documents ont été importer avec succès":"Le document a été importer avec succès";

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>$msg]);
        $this->redirect('/detail-media/'.$this->media->uuid);

    }

    public function showSoumissionDocumentTechnique()
    {
        $this->dispatchBrowserEvent("showConfirmMessageSoumissionDocumentTechnique");
    }


    public function soumissionDocumentTechnique()
    {
        $dossierExist = Dossier::where('media_id',$this->media->id)->first();
        $media = Media::find($this->media->id);
        $media->en_attente_commission = true;
        $media->update();

        if($dossierExist){
            $dossierExist->status_commission ='revoir';
            $dossierExist->is_termine_commission =false;

            $dossierExist->save();
        }else{
            Dossier::create(
                ['media_id' => $this->media->id],
                ['is_termine_commission' => false],
                ['user_id' =>$this->media->user_id, 'status_commission' => 'en_cours']);
        }


        $tracking = Tracking::where('media_id',$this->media->id)->first();
        if($tracking){
            $tracking->date_soumis_pro = Carbon::now();
            $tracking->save();
        }
        $message = message_email("soummission_de_dossier", $this->media);
        $objet = "Soumission des documents";

        $commission = User::whereIn("role_id", function ($query){
            $query->from("role")->whereNom("Commission")->select("id")->get();
        })->where("is_deleted", false)->first();

        if($commission) send_notification($commission, $objet, $message, $this->media, config("app.url").':'.env("PORT","9000"));

        $this->redirect('/detail-media/'.$this->media->uuid);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Votre dossier a été soumis avec succès"]);

    }

    public function getDocument($id)
    {
        $this->firstDocument = Document::find($id);
    }

    public function getPreviewCahierCharge()
    {
        $this->recu = Paiement::where('media_id',$this->media->id)->where('type_paiement','cahierDesCharges')->first();
    }

    public function getPreviewCahierChargeRecu()
    {
        $this->firstDocument = Paiement::where('media_id',$this->media->id)->where('type_paiement','cahierDesCharges')->first();
        $this->currentPreview =true;
        $this->preview = "Recu";
    }

    public function remplacerDocumentTechnique() {
        $validateArr = [
            "filePath" => "required|max:2048",
        ];
        $this->validate($validateArr);

        $document = Document::find($this->firstDocument->id);
        $imagePath ="";

        $path = $this->filePath->store("documents", "public");
        $imagePath = "/storage/".$path;


        $document->file_path = $imagePath;
        $document->is_validated_commission = null;
        $document->is_validated_hac = null;
        $document->categorie= 'document_technique';
        $document->save();

        //update etat terminer

        $this->redirect('/detail-media/'.$this->media->uuid);
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Le document a été remplacé avec succès"]);


    }

    public function checkStatusHac($id)
    {
        $dossier = Dossier::where('media_id',$id)->first();
        return $dossier;
    }

    public function rapportCommissionHac($rapport)
    {
        $result = Document::where('media_id',$this->media->id)->where('categorie',$rapport)->first();

        return $result;
    }

    public function showPreviewFilesRapport($id,$rapport)
    {
        $this->firstDocument = Document::where('media_id',$id)->where('categorie',$rapport)->first();

        $this->currentPreview =true;
        $this->preview = "document";
    }


    public function paiementFraisAgrement()
    {
        $parametrePaiement = ParametrePaiement::where('nom','frais_agrement')->where('type_media_id',$this->media->type??null)->orderBy('created_at','DESC')->first();
        $paiement = new Paiement();
        $existPaiement = Paiement::where('media_id',$this->media->id)->where('type_paiement','fraisAgrement')->first();

        $validateArr = [
            "dateDePaiement" => "required",
            "recuPaiement" => "required|max:2048",
        ];
        $this->validate($validateArr);

        $imagePath ="";
        if($this->recuPaiement != null){
            $path = $this->recuPaiement->store("paiement_frais_agrement", "public");
            $imagePath = "storage/".$path;
        }
        if($parametrePaiement){
            if($existPaiement){
                $existPaiement->montant = $parametrePaiement->montant;
                $existPaiement->date_paiement = $this->dateDePaiement;
                $existPaiement->type_paiement = 'fraisAgrement';
                $existPaiement->is_valided = null;
                $existPaiement->is_deleted = false;
                $existPaiement->mode = 'Paiement Bancaire';
                $existPaiement->recu = $imagePath;
                $existPaiement->media_id = $this->media->id;
                $existPaiement->save();

                $message = message_email("paiement_agrement", $this->media);
                $objet = "Paiement agrément";

                $direction = User::whereIn("role_id", function ($query){
                    $query->from("role")->whereNom("Direction")->select("id")->get();
                })->where("is_deleted", false)->first();

                if($direction) send_notification($direction, $objet, $message, $this->media, config("app.url").':'.env("PORT","9000"), 0, 'Paiement');

                //Promoteur
                $message = message_email("msg_de_verification_de_paiement_agrement");

                send_notification($this->media->user, $objet, $message, $this->media, null);

                $tracking = Tracking::where('media_id',$this->media->id)->first();
                if($tracking){
                    $tracking->date_paiement_agrement = Carbon::now();
                    $tracking->save();
                }
            }else{
                $paiement->montant = $parametrePaiement->montant;
                $paiement->date_paiement = $this->dateDePaiement;
                $paiement->type_paiement = 'fraisAgrement';
                $paiement->mode = 'Paiement Bancaire';
                $paiement->is_valided = null;
                $paiement->is_deleted = false;
                $paiement->recu = $imagePath;
                $paiement->media_id = $this->media->id;
                $paiement->save();

                $message = message_email("paiement_agrement", $this->media);
                $objet = "Paiement agrément";

                $direction = User::whereIn("role_id", function ($query){
                    $query->from("role")->whereNom("Direction")->select("id")->get();
                })->where("is_deleted", false)->first();

                if($direction) send_notification($direction, $objet, $message, $this->media, config("app.url").':'.env("PORT","9000"),0,'Paiement');

                //Promoteur
                $message = message_email("msg_de_verification_de_paiement_agrement");

                send_notification($this->media->user, $objet, $message, $this->media, null);

                $tracking = Tracking::where('media_id',$this->media->id)->first();
                if($tracking){
                    $tracking->date_paiement_agrement = Carbon::now();
                    $tracking->save();
                }
            }

            $this->dateDePaiement = "";
            $this->recuPaiement = "";

            $this->redirect('/detail-media/'.$this->media->uuid);
            $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Paiement de frais d'agrement effecuté avec succès"]);
        }else{
            $this->dispatchBrowserEvent("showErrorMessage", ["message"=>"Le montant de frais d'agrement n'est pas parametré"]);
        }

    }

    public function stepperAction($id, $stape)
    {
        $media = Media::find($id);
        $media->current_stape = $stape;
        $media->save();

        $this->current_stape =$stape;
    }

    public function hasProjetAgrementInDocument($id)
    {
        $document = Document::where('media_id',$id)->where('categorie','projet_agrement')->first();
        return $document;
    }

    public function hasRapportCommissionHac($id,$rapport)
    {
        $result = Document::where('media_id',$id)->where('categorie',$rapport)->first();
        return $result;
    }

    public function telechargerAgrementSigne($id)
    {
        $this->media = Media::find($id);
    }

    public function previewAgrement()
    {

    }

    public function visualiseragreement()
    {
        $this->is_visualiseragreement = true;
    }
    public function closevisualiseragreement()
    {
        $this->is_visualiseragreement = false;
    }

    public function visualiserprojetagreement()
    {
        $this->is_visualiserprojetagreement = true;
    }
    public function closevisualiserprojetagreement()
    {
        $this->is_visualiserprojetagreement = false;
    }

    public function checkHac($id,$rapport)
    {
        $isValid = false;
        $result = Document::where('media_id',$id)->where('categorie',$rapport)->get();
        foreach ($result as $value) {
            if($value->is_validated_hac == false){
                $value->is_validated_hac == false;
                $isValid=true;
                break;
            }
        }

        return $isValid;
    }
}