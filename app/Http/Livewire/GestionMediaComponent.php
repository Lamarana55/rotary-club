<?php

namespace App\Http\Livewire;

use App\Models\Document;
use App\Models\Dossier;
use App\Models\GenerateAgreement;
use App\Models\Media;
use App\Models\Paiement;
use App\Models\Tracking;
use App\Models\User;
use PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use App\Exports\ExportDataDaf;
use App\Models\Meeting;
use Maatwebsite\Excel\Facades\Excel;

class GestionMediaComponent extends Component
{
    use WithPagination;
    use WithFileUploads;


    protected $paginationTheme = "bootstrap";
    public $currentPage = PAGELISTE;
    public $projetAgrementNoSigne;
    public $filter;
    public $search = "";
    public $media;
    public $agreementMedia;
    public $date_enregistrement;
    public $valider;
    public $commentaire;
    public $paiement;
    public $recu_paiement;
    public $nomMinistre;
    public $genreMinistre;
    public $preview;
    public $projetAgrement;
    public $firstMedia;
    public $documentTechniques =[];
    public $numeroAgrement;
    public $agrementFile;
    public $agrement;
    protected $donner ;
    public $licence;
    public $file_licence;
    public $meetingId;

    public $options = [
        "Paiement non reçu",
        "Preuve non valide",
        "Montant incorrect",
        "Autres, veuillez contacter la DAF du MIC"
    ];

    public function AdminAuthCheck()
    {
        if (!Auth::guard()->check()) {
            return redirect('/login');
        }
    }

    public function showAgrementSigne($id){
        $this->agrement = Meeting::where('media_id',$id)->first();
    }

    public function showLicence($id){
        $this->agrement = Meeting::where('media_id',$id)->first();
    }

    public function getSaveLicence($id){
        $this->meetingId = Meeting::find($id);
    }

    public function enregistrerLicence($id)
    {
        $this->validate([
            'file_licence'=>'required'
        ]);

        $meeting = Meeting::find($id);
        $media = Media::find($meeting->media_id);

        $imagePath="";
        $path = $this->file_licence->store("licences", "public");
        $imagePath = "/storage/".$path;

        $meeting->licence = $imagePath;
        $meeting->update();

        $media->stape = 9;
        $media->status_arpt = true;
        $media->current_stape = 9;
        $media->traite = true;
        $media->update();

        $message2 = message_email("reception_licence_promoteur_et_direction");
        $objet2 = "Licence disponible";

        send_notification($media->user, $objet2, $message2, $media, null);

        $direction = User::whereIn("role_id", function ($query){
            $query->from("role")->whereNom("Direction")->select("id")->get();
        })->where("is_deleted", false)->first();

        // if($promoteur) send_notification($promoteur, $objet2, $message2, $media, config("app.url"));
        if($direction) send_notification($direction, $objet2, $message2, $media, config("app.url"));

        Tracking::where('media_id',$meeting->media_id)->update([
            'date_licence'=>Carbon::now()
        ]);


        $this->dispatchBrowserEvent("showSuccessMessage", [
            "is_valided" => true,
            "message" => "Le projet d'agrement est importé avec succès"
        ]);

        return redirect('/liste-medias');
    }

    public function checkedButtonRapport($id)
    {
        $documents = Document::where('media_id',$id)->where('categorie','document_technique')->get();
        $dossier = Dossier::where('media_id',$id)->first();
        $isValde = false;
        foreach ($documents as $key => $value) {
            if(Auth::guard()->check() && auth()->user()->role->nom='Commission')
            {
                if($value->is_validated_commission && $dossier->status_commission=='en_cours' || $value->is_validated_commission && $dossier->status_commission=='rejeter'){
                    $isValde = true;
                }

            }elseif(Auth::guard()->check() && auth()->user()->role->nom='HAC'){
                if($value->is_validated_hac && $dossier->status_hac=='en_cours'){
                    $isValde = true;
                }
            }
        }

        return $isValde;
    }

    public function render()
    {

        if(!hasPermission('afficher_media')){
            $this->redirect("/page-not-permission");
        }

        $data = [];


        if (Auth::guard()->check() && auth()->user()->role->nom == 'DAF' || auth()->user()->role->nom == 'Ministre' || auth()->user()->role->nom == 'Admin') {
            $paiement = Paiement::where('paiement.type_paiement', 'cahierDesCharges');
            if ($this->search != "") {
                $paiement = $paiement->join('media', 'paiement.media_id', '=', 'media.id')
                                     ->join('user', 'media.user_id', '=', 'user.id')
                ->where(function ($query) {
                        $query->orWhere("media.telephone", "LIKE", "%" . $this->search . "%")
                            ->orWhere("media.nom", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("media.type_media", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("user.nom", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("user.prenom", "LIKE", "%" . $this->search . "%")
                            ->orWhere("paiement.mode", "LIKE", "%" . $this->search . "%")
                            ->orWhere("paiement.montant", "LIKE", "%" . $this->search . "%")
                            ->orWhere("paiement.code_marchant", "LIKE", "%" . $this->search . "%");
                    });
                    if ($this->filter!="") {
                        if ($this->filter === "nouveaux") {
                            $paiement = $paiement->where("is_valided", null);
                        }elseif($this->filter === "acceptes"){
                            $paiement = $paiement->where("is_valided", true);
                        }elseif ($this->filter === "rejetes") {
                            $paiement = $paiement->where("is_valided", false);
                        }
                    }
            }else {
                if ($this->filter!="") {
                    if ($this->filter === "nouveaux") {
                        $paiement = $paiement->where("is_valided", null);
                    }elseif($this->filter === "acceptes"){
                        $paiement = $paiement->where("is_valided", true);
                    }elseif ($this->filter === "rejetes") {
                        $paiement = $paiement->where("is_valided", false);
                    }
                }
            }
            $paiement = $paiement->where("paiement.is_deleted", false)
                ->select('paiement.*')
                ->orderBy('paiement.created_at', 'DESC');
            $data = [
                'medias' =>  $paiement->paginate(NOMBRE_PAR_PAGE)
            ];
        }

        if (Auth::guard()->check() && auth()->user()->role->nom == 'Commission' || auth()->user()->role->nom == 'Admin') {
            $dossiers = new Dossier();
            if($this->search!="")
            {
            $dossiers = $dossiers->join("media","media.id","=","dossier.media_id")
                            ->join("user","user.id","=","media.user_id")->where(function ($query)
                        {
                          $query->orWhere("user.nom", "LIKE",  "%" . $this->search . "%")
                                ->orWhere("user.prenom", "LIKE",  "%" . $this->search . "%")
                                ->orWhere("media.nom", "LIKE",  "%" . $this->search . "%")
                                ->orWhere("media.type_media", "LIKE",  "%" . $this->search . "%")
                                ->orWhere("media.telephone", "LIKE",  "%" . $this->search . "%");
                        });
                if ($this->filter !="") {
                    $dossiers = $dossiers->where('dossier.status_commission',$this->filter);
                }
            }else{
                if ($this->filter !="") {
                    $dossiers = $dossiers->where('dossier.status_commission',$this->filter);
                }
            }
            $dossiers = $dossiers->select('dossier.*')->orderBy('dossier.created_at', 'DESC');
            $data = [
                'medias' => $dossiers->paginate(NOMBRE_PAR_PAGE)
            ];
        }
        if (Auth::guard()->check() && auth()->user()->role->nom == 'HAC' || auth()->user()->role->nom == 'Admin') {
            $dossiers = new Dossier();
            if($this->search!="")
            {
                $dossiers = $dossiers->join("media","media.id","=","dossier.media_id")
                    ->join("user","user.id","=","media.user_id")
                    ->where(function ($query)
                    {
                        $query->orWhere("user.nom", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("user.prenom", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("media.nom", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("media.type_media", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("media.telephone", "LIKE",  "%" . $this->search . "%");
                    });
                if($this->filter !="") {
                    $dossiers = $dossiers->where('dossier.status_hac',$this->filter);
                }
            }else{
                if ($this->filter !="") {
                    $dossiers = $dossiers->where('dossier.status_hac',$this->filter);
                }
            }
            $dossiers = $dossiers->where('dossier.status_commission','terminer')
                ->select('dossier.*')
                ->orderBy('dossier.created_at', 'DESC');
            $data = [
                'medias' => $dossiers->paginate(NOMBRE_PAR_PAGE)
            ];
        }
        if (Auth::guard()->check() && auth()->user()->role->nom == 'Direction' || auth()->user()->role->nom == 'Admin') {
            $is_valide = null;
            $paiements = Paiement::where('paiement.type_paiement','fraisAgrement');
            if ($this->filter=="" && $this->search=="") {
                $paiements = Paiement::where('paiement.type_paiement','fraisAgrement')
                    ->join("media",'media.id','=',"paiement.media_id")
                    ->join('user',"user.id","=","media.user_id")
                    ->where("paiement.type_paiement", "fraisAgrement");
             }elseif($this->filter=="" && $this->search!=""){
                $paiements = Paiement::join("media",'media.id','=',"paiement.media_id")
                    ->join('user',"user.id","=","media.user_id")
                    ->where("paiement.type_paiement", "fraisAgrement")
                    ->where(function ($query)
                    {
                    $query->orWhere("user.nom", "LIKE",  "%" . $this->search . "%")
                        ->orWhere("user.prenom", "LIKE",  "%" . $this->search . "%")
                        ->orWhere("media.nom", "LIKE",  "%" . $this->search . "%")
                        ->orWhere("media.type_media", "LIKE",  "%" . $this->search . "%")
                        ->orWhere("media.telephone", "LIKE",  "%" . $this->search . "%")
                        ->orWhere("paiement.montant", "LIKE",  "%" . $this->search . "%");
                    });
             } else{
                if ($this->filter=="nouveaux") {
                    $is_valide = null;
                }elseif ($this->filter=="acceptes") {
                    $is_valide = true;
                }elseif ($this->filter=="rejetes") {
                    $is_valide = false;
                }elseif($this->filter==""){

                }

                $paiements = Paiement::join("media",'media.id','=',"paiement.media_id")
                    ->join('user',"user.id","=","media.user_id")
                    ->where("paiement.type_paiement", "fraisAgrement")
                    ->where("paiement.is_valided", $is_valide)
                    ->where(function ($query)
                    {
                        $query->orWhere("user.nom", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("user.prenom", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("media.nom", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("media.type_media", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("media.telephone", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("paiement.montant", "LIKE",  "%" . $this->search . "%");
                    });

             }
            $paiements = $paiements->select('paiement.*')->orderBy('paiement.created_at', 'DESC');
            $data = [
                'medias' => $paiements->paginate(NOMBRE_PAR_PAGE)
            ];
        }

        if (Auth::guard()->check() && auth()->user()->role->nom == 'Conseiller' || auth()->user()->role->nom == 'Admin') {
            $is_valide = null;
            $paiements = Paiement::where('paiement.type_paiement','fraisAgrement')->where('paiement.is_valided',true);
            if ($this->filter=="" && $this->search=="") {
                $paiements = Paiement::join("media",'media.id','=',"paiement.media_id")
                    ->join('user',"user.id","=","media.user_id")
                    ->where("paiement.type_paiement", "fraisAgrement")->where('paiement.is_valided',true);
             }elseif($this->filter=="" && $this->search!=""){
                $paiements = Paiement::join("media",'media.id','=',"paiement.media_id")
                    ->join('user',"user.id","=","media.user_id")
                    ->where("paiement.type_paiement", "fraisAgrement")->where('paiement.is_valided',true)
                    ->where(function ($query)
                    {
                    $query->orWhere("user.nom", "LIKE",  "%" . $this->search . "%")
                        ->orWhere("user.prenom", "LIKE",  "%" . $this->search . "%")
                        ->orWhere("media.nom", "LIKE",  "%" . $this->search . "%")
                        ->orWhere("media.type_media", "LIKE",  "%" . $this->search . "%")
                        ->orWhere("media.telephone", "LIKE",  "%" . $this->search . "%")
                        ->orWhere("paiement.montant", "LIKE",  "%" . $this->search . "%");
                    });
             } else{
                $paiements = Paiement::join("media",'media.id','=',"paiement.media_id")
                    ->join('user',"user.id","=","media.user_id")
                    ->where("paiement.type_paiement", "fraisAgrement")->where('paiement.is_valided',true)
                    ->where(function ($query){
                        $query->orWhere("user.nom", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("user.prenom", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("media.nom", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("media.type_media", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("media.telephone", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("paiement.montant", "LIKE",  "%" . $this->search . "%");
                    });

             }
            $paiements = $paiements->select('paiement.*')->orderBy('paiement.created_at', 'DESC');
            $data = [
                'medias' => $paiements->paginate(NOMBRE_PAR_PAGE)
            ];
        }
        if (Auth::guard()->check() && auth()->user()->role->nom == 'SGG' || auth()->user()->role->nom == 'Admin') {
            $medias = DB::table('media')->join('document','media.id','document.media_id')
                ->where('document.categorie','projet_agrement')
                ->select('media.*','document.file_path as file_path');

                if($this->filter!="" && $this->search==""){
                    if ($this->filter=="agree") {
                        $medias = $medias->where('media.numero_registre_sgg',"<>",null);
                    }elseif ($this->filter=="nouveaux") {
                        $medias = $medias->where('media.numero_registre_sgg',"=",null);
                    }

                }elseif($this->search!=""){

                    $medias = $medias->where(function ($query)
                    {
                        $query->orWhere("media.nom", "LIKE",  "%" . $this->search . "%")
                        ->orWhere("media.type_media", "LIKE",  "%" . $this->search . "%")
                        ->orWhere("media.telephone", "LIKE",  "%" . $this->search . "%")
                        ->orWhere("media.email", "LIKE",  "%" . $this->search . "%");
                    });

                    if ($this->filter=="agree") {
                        $medias = $medias->where('media.numero_registre_sgg',"<>",null);
                    }elseif ($this->filter=="nouveaux") {
                        $medias = $medias->where('media.numero_registre_sgg',"=",null);
                    }

                }
            $medias = $medias->orderBy('media.created_at', 'DESC');
            $data = [
                'medias' => $medias->paginate(NOMBRE_PAR_PAGE)
            ];
        }

        if (Auth::guard()->check() && auth()->user()->role->nom == 'ARPT' || auth()->user()->role->nom == 'Admin') {
            $meeting = Meeting::where('meeting.agrement_signer', true);
            if ($this->search != "") {
                $meeting->join('media', 'meeting.media_id', '=', 'media.id')
                        ->join('user', 'media.user_id', '=', 'user.id')
                ->where(function ($query) {
                        $query->orWhere("media.telephone", "LIKE", "%" . $this->search . "%")
                            ->orWhere("media.nom", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("media.type_media", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("user.nom", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("user.prenom", "LIKE", "%" . $this->search . "%");
                    });
                    if($this->filter!="") {
                        if ($this->filter === "nouveaux") {
                            $meeting = $meeting->where("meeting.licence", null);
                        }
                    }

            }else {
                if ($this->filter!="") {
                    if ($this->filter === "nouveaux") {
                        $meeting = $meeting->where("meeting.licence", null);
                    }
                }
            }
            $meeting = $meeting->select('meeting.*')->orderBy('meeting.created_at', 'DESC');
            $data = [
                'medias' =>  $meeting->paginate(NOMBRE_PAR_PAGE)
            ];
        }

        return view('medias.medias.liste_des_medias', $data)
            ->extends("layouts.default", ['title' => 'Médias'])
            ->section("content");
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

    public function showPreviewRecu($id)
    {
        $this->paiement = Paiement::find($id);
        if ($this->paiement->recu !== null  && $this->paiement->recu_genere !== null) {
            $this->recu_paiement = $this->paiement->recu_genere;
        } elseif ($this->paiement->recu !== null) {
            $this->recu_paiement = $this->paiement->recu;
        } else {
            $this->recu_paiement = $this->paiement->recu_genere;
        }
        $this->dispatchBrowserEvent("showPreviewRecu");
    }

    public function showRejetPaiementCahierChargeModal($id)
    {
        $this->paiement = Paiement::find($id);
        $this->dispatchBrowserEvent("showRejetPaiementCahierChargeModal");
    }

    public function showRejetPaiementCahierChargeCloseModal()
    {
        $this->dispatchBrowserEvent("showRejetPaiementCahierChargeCloseModal");
    }

    public function checkGenerateProject($id)
    {
        $GenerateAgreement = GenerateAgreement::where('media',$id)->first();
        return $GenerateAgreement;
    }

    public function showProjetAgrement($id)
    {
        $this->projetAgrementNoSigne = GenerateAgreement::where('media',$id)->first();
    }

    public function closeModalgenererAgrement(){
        $this->resetValidation();
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
            'media' => $media,
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
        $types = $stape->type.' '.$stape->type_media;
        // $message = message_email("validation_paiement_cahier_de_charge_autre");
        $message =["La division des affaires financières du ministère de l’information et de la communication a validé votre paiement.", "Votre cahier des charges pour la <b>".$types."</b> est maintenant disponible sur la plateforme. <br> Vous avez 10 jours pour soumettre les pièces demandées qui seront examinés par la commission technique du MIC.", "Veuillez vous connecter pour plus d'informations."];

        $objet = "Paiement de cahier des charges";

        $paiement->save();
        $media = $paiement->media;

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

    public function showModalPreviewRecuFraisAgrement($id)
    {
        $this->paiement = Paiement::where('type_paiement','fraisAgrement')->where('media_id',$id)->first();
        $this->dispatchBrowserEvent("showModalPreviewRecuFraisAgrement");
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

            // $stape->status_sgg=false;
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
    }

    public function importProjetAgrement($id)
    {
        $validateArr = [
            "projetAgrement" => "required|max:2048",
        ];
        $this->validate($validateArr);

        try {
            $paiement = Paiement::find($id);
            $media = Media::where('id',$paiement->media_id)->first();
            Document::where('media_id',$paiement->media_id)->where('categorie','projet_agrement')->delete();

            $document = new Document();
            $imagePath ="";

            $path = $this->projetAgrement->store("projetAgrement", "public");
            $imagePath = "/storage/".$path;

            $document->media_id = $paiement->media_id;
            $document->categorie = 'projet_agrement';
            $document->file_path = $imagePath;
            $document->is_deleted = null;
            $document->save();

            $media->stape = 5;
            $media->status_conseiller = true;
            $media->status_sgg = false;
            $media->current_stape = 6;
            $media->save();

            $message = message_email("transmission_projet_d_agrement");
            $objet = "Transmission de projet d'agrément";

            $message2 = message_email("reception_projet_d_agrement_promoteur_et_direction");
            $objet2 = "Projet d'agrément signé";

            send_notification($media->user, $objet, $message, $media, null);

            $message = message_email('reception_projet_d_agrement_sgg', $media);


            $sgg = User::whereIn("role_id", function ($query){
                $query->from("role")->whereNom("SGG")->select("id")->get();
            })->where("is_deleted", false)->first();

            $direction = User::whereIn("role_id", function ($query){
                $query->from("role")->whereNom("Direction")->select("id")->get();
            })->where("is_deleted", false)->first();



            /* if($promoteur) send_notification($promoteur, $objet2, $message2, $media, config("app.url"));*/
            if($direction) send_notification($direction, $objet2, $message2, $media, config("app.url"));
            if($sgg) send_notification($sgg, $objet, $message, $media, config("app.url"));

            $tracking = Tracking::where('media_id',$paiement->media_id)->first();
            if($tracking){
                $tracking->date_transmission_projet_agrement = Carbon::now();
                $tracking->save();
            }

            $this->dispatchBrowserEvent("showSuccessMessage", [
                "is_valided" => true,
                "message" => "Le projet d'agrement est importé avec succès"
            ]);

            return redirect('/liste-medias');
        } catch (Exception $e) {
            $this->dispatchBrowserEvent("showSuccessMessage", [
                "is_valided" => false,
                "message" => "Erreur importation fichier"
            ]);
        }
    }

    public function getFirstMedia($id)
    {
        $this->firstMedia = Paiement::where('type_paiement','fraisAgrement')->where('media_id',$id)->first();
    }

    public function hasProjetAgrementInDocument($id)
    {
        $document = Document::where('media_id',$id)->where('categorie','projet_agrement')->first();
        return $document;
    }

    public function getDocumentTechniques($id)
    {
        $this->documentTechniques = Document::where('media_id',$id)->where('categorie','document_technique')->get();
    }

    public function hasRapportCommissionHac($id,$rapport)
    {
        $result = Document::where('media_id',$id)->where('categorie',$rapport)->first();
        return $result;
    }

    public function getMedia($id)
    {
        $this->agreementMedia = Media::find($id);
    }

    public function enregistrerAgrement($id) {

        $validateArr = [
            'numeroAgrement'=>'required|unique:media,numero_registre_sgg',
            'agrementFile'=>'required',
            'date_enregistrement'=>'required'
        ];
        $this->validate($validateArr);

        $media = Media::find($id);
        Document::where('media_id',$id)->where('categorie','agrement')->delete();

        $document = new Document();

        $imagePath="";
        $path = $this->agrementFile->store("agrements", "public");
        $imagePath = "/storage/".$path;

        $document->file_path = $imagePath;
        $document->media_id = $id;
        $document->categorie = 'agrement';
        $document->save();

        $media->numero_registre_sgg = $this->numeroAgrement;
        $media->date_enregistrement_agrement = $this->date_enregistrement;
        $media->stape = 6;
        $media->current_stape = 7;
        $media->en_cours = false;
        $media->traite = true;
        $media->status_sgg = true;
        $media->save();

        $type_media = $media->type." ".$media->type_media;
        $nom = $media->nom;
        $direction_user = User::whereIn("role_id", function ($query){
            $query->from("role")->whereNom("Direction")->select("id")->get();
        })->where("is_deleted", false)->first();

        if($direction_user){
            $message_direction = ["Le Secrétariat général du Gouvernement a enregistré et publié l’agrément de la  <b> $type_media $nom </b>."];
            $objet = "Enrégistrement et publication de l'agrement";
            // message_email('enregistrement_pour_direction');
            send_notification($direction_user, $objet, $message_direction, $media,null);
        }
        $object2 = "Agrément disponible";
        send_notification(
            $media->user,
            $object2,
            ["Votre agrément de la <b> $type_media $nom </b> est disponible sur la plateforme","Veuillez vous connecter afin de le télécharger et pour plus d’informations"],
            $media,
            config("app.url").':'.env("PORT","9000")
        );

        $tracking = Tracking::where('media_id',$id)->first();
        if($tracking){
            $tracking->date_enregistrement_media = Carbon::now();
            $tracking->save();
        }

        return redirect('/liste-medias');
        $this->dispatchBrowserEvent("showSuccessPersoMessage", [
            "message" => "L'agrément a été envoyé avec succès"
        ]);
    }

    public function etudeDocumentsTermineHac($id)
    {
        $documents = Document::where('media_id',$id)->where('categorie','document_technique')->get();

        $hasDocumentRejete = false;
        foreach($documents as $document) {
            if(Auth::guard()->check() && Auth::user()->role->nom === 'Commission') {
                if($document->is_validated_commission === null) {
                    $hasDocumentRejete = true;
                    break;
                }
            }elseif(Auth::guard()->check() && Auth::user()->role->nom === 'HAC'){
                if($document->is_validated_hac === null) {
                    $hasDocumentRejete = true;
                    break;
                }
            }

        }

		return $hasDocumentRejete;
    }

    public function FiltreDaf(){

        $paiement = Paiement::where('paiement.type_paiement', 'cahierDesCharges')
                        ->join('media', 'paiement.media_id', '=', 'media.id')
                        ->join('user', 'media.user_id', '=', 'user.id');
            if ($this->search != "") {
                $paiement = $paiement
                ->where(function ($query) {
                        $query->orWhere("media.telephone", "LIKE", "%" . $this->search . "%")
                            ->orWhere("media.nom", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("media.type_media", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("user.nom", "LIKE",  "%" . $this->search . "%")
                            ->orWhere("user.prenom", "LIKE", "%" . $this->search . "%")
                            ->orWhere("paiement.mode", "LIKE", "%" . $this->search . "%")
                            ->orWhere("paiement.montant", "LIKE", "%" . $this->search . "%")
                            ->orWhere("paiement.code_marchant", "LIKE", "%" . $this->search . "%");
                    });
                    if ($this->filter!="") {
                        if ($this->filter === "nouveaux") {
                            $paiement = $paiement->where("is_valided", null);
                        }elseif($this->filter === "acceptes"){
                            $paiement = $paiement->where("is_valided", true);
                        }elseif ($this->filter === "rejetes") {
                            $paiement = $paiement->where("is_valided", false);
                        }
                    }


            } else {
                if ($this->filter!="") {
                    if ($this->filter === "nouveaux") {
                        $paiement = $paiement->where("is_valided", null);
                    }elseif($this->filter === "acceptes"){
                        $paiement = $paiement->where("is_valided", true);
                    }elseif ($this->filter === "rejetes") {
                        $paiement = $paiement->where("is_valided", false);
                    }
                }
                }
        return $paiement->where("paiement.is_deleted", false)->orderBy('paiement.created_at', 'DESC');
    }
    public function FiltreCommission()
    {
        $dossiers = Dossier::join("media","media.id","=","dossier.media_id")->join("user","user.id","=","media.user_id");
            if($this->search!="")
            {
            $dossiers = $dossiers->where(function ($query)
                        {
                          $query->orWhere("user.nom", "LIKE",  "%" . $this->search . "%")
                                ->orWhere("user.prenom", "LIKE",  "%" . $this->search . "%")
                                ->orWhere("media.nom", "LIKE",  "%" . $this->search . "%")
                                ->orWhere("media.type_media", "LIKE",  "%" . $this->search . "%")
                                ->orWhere("media.telephone", "LIKE",  "%" . $this->search . "%");
                        });
                if ($this->filter !="") {
                    $dossiers = $dossiers->where('dossier.status_commission',$this->filter);
                }
            }else{
                if ($this->filter !="") {
                    $dossiers = $dossiers->where('dossier.status_commission',$this->filter);
                }
            }
            return $dossiers->orderBy('dossier.created_at', 'DESC');
    }
    public function FiltreHAC()
    {
        $dossiers = Dossier::where('dossier.status_commission','terminer')
                    ->join("media","media.id","=","dossier.media_id")
                    ->join("user","user.id","=","media.user_id");
            if($this->search!="")
            {
            $dossiers = $dossiers->where(function ($query)
                        {
                          $query->orWhere("user.nom", "LIKE",  "%" . $this->search . "%")
                                ->orWhere("user.prenom", "LIKE",  "%" . $this->search . "%")
                                ->orWhere("media.nom", "LIKE",  "%" . $this->search . "%")
                                ->orWhere("media.type_media", "LIKE",  "%" . $this->search . "%")
                                ->orWhere("media.telephone", "LIKE",  "%" . $this->search . "%");
                        });
                if ($this->filter !="") {
                    $dossiers = $dossiers->where('dossier.status_hac',$this->filter);
                }
            }else{
                if ($this->filter !="") {
                    $dossiers = $dossiers->where('dossier.status_hac',$this->filter);
                }
            }
         return   $dossiers = $dossiers->orderBy('dossier.created_at', 'DESC');

    }
    public function FiltreDirection()
    {
            $is_valide = null;
            $paiements = Paiement::where('paiement.type_paiement','fraisAgrement')
                                ->join("media",'media.id','=',"paiement.media_id")
                                ->join('user',"user.id","=","media.user_id")
                                ->where("paiement.type_paiement", "fraisAgrement");
            if ($this->filter=="" && $this->search=="") {
                $paiements = Paiement::where('paiement.type_paiement','fraisAgrement')
                                    ->join("media",'media.id','=',"paiement.media_id")
                                    ->join('user',"user.id","=","media.user_id")
                                    ->where("paiement.type_paiement", "fraisAgrement");
             }elseif($this->filter=="" && $this->search!=""){
                $paiements = Paiement::join("media",'media.id','=',"paiement.media_id")
                                    ->join('user',"user.id","=","media.user_id")
                                    ->where("paiement.type_paiement", "fraisAgrement")
                                    ->where(function ($query)
                                    {
                                          $query->orWhere("user.nom", "LIKE",  "%" . $this->search . "%")
                                                ->orWhere("user.prenom", "LIKE",  "%" . $this->search . "%")
                                                ->orWhere("media.nom", "LIKE",  "%" . $this->search . "%")
                                                ->orWhere("media.type_media", "LIKE",  "%" . $this->search . "%")
                                                ->orWhere("media.telephone", "LIKE",  "%" . $this->search . "%")
                                                ->orWhere("paiement.montant", "LIKE",  "%" . $this->search . "%");
                                    });
             } else{
                if ($this->filter=="nouveaux") {
                    $is_valide = null;
                }elseif ($this->filter=="acceptes") {
                    $is_valide = true;
                }elseif ($this->filter=="rejetes") {
                    $is_valide = false;
                }elseif($this->filter==""){

                }

                $paiements = Paiement::join("media",'media.id','=',"paiement.media_id")
                                    ->join('user',"user.id","=","media.user_id")
                                    ->where("paiement.type_paiement", "fraisAgrement")
                                    ->where("paiement.is_valided", $is_valide)
                                    ->where(function ($query)
                                    {
                                      $query->orWhere("user.nom", "LIKE",  "%" . $this->search . "%")
                                            ->orWhere("user.prenom", "LIKE",  "%" . $this->search . "%")
                                            ->orWhere("media.nom", "LIKE",  "%" . $this->search . "%")
                                            ->orWhere("media.type_media", "LIKE",  "%" . $this->search . "%")
                                            ->orWhere("media.telephone", "LIKE",  "%" . $this->search . "%")
                                            ->orWhere("paiement.montant", "LIKE",  "%" . $this->search . "%");
                                    });

             }
        return   $paiements = $paiements->orderBy('paiement.created_at', 'DESC');
    }

    public function FiltreSGG()
    {
        $medias = DB::table('media')
                ->join('document','media.id','document.media_id')
                ->join('user',"user.id","=","media.user_id")
                ->where('document.categorie','projet_agrement')
                ->select('media.*','document.file_path as file_path');

                if($this->filter!="" && $this->search==""){
                    if ($this->filter=="agree") {
                        $medias = $medias->where('media.numero_registre_sgg',"<>",null);
                    }elseif ($this->filter=="nouveaux") {
                        $medias = $medias->where('media.numero_registre_sgg',"=",null);
                    }

                }elseif($this->search!=""){

                    $medias = $medias->where(function ($query)
                    {
                        $query->orWhere("media.nom", "LIKE",  "%" . $this->search . "%")
                        ->orWhere("media.type_media", "LIKE",  "%" . $this->search . "%")
                        ->orWhere("media.telephone", "LIKE",  "%" . $this->search . "%")
                        ->orWhere("media.email", "LIKE",  "%" . $this->search . "%");
                    });

                    if ($this->filter=="agree") {
                        $medias = $medias->where('media.numero_registre_sgg',"<>",null);
                    }elseif ($this->filter=="nouveaux") {
                        $medias = $medias->where('media.numero_registre_sgg',"=",null);
                    }

                }
           return $medias = $medias->orderBy('document.created_at', 'DESC');
    }

    public function exportExcelDaf()
    {
        $don = "";
        $head = [];
        if (auth()->user()->role->nom == 'DAF') {
            $don = $this->FiltreDaf()->select(DB::Raw("CONCAT(user.prenom, ' ', user.nom) AS promoteur"),'media.nom AS media', "media.type_media","media.telephone","paiement.mode","paiement.montant","paiement.code_marchant",DB::raw('(CASE  WHEN paiement.is_valided is NULL THEN "Nouveau"  WHEN paiement.is_valided = "1" THEN "Paiement reçu" WHEN paiement.is_valided = "false"  THEN "Rejeté" END) AS paiement'));
            $head = ['Promoteur','Média','Type','Téléphone','Mode de paiement','Montant','Code','Etat'];
        }elseif (auth()->user()->role->nom == 'Commission') {
            $don = $this->FiltreCommission()->select(DB::Raw("CONCAT(user.prenom, ' ', user.nom) AS promoteur"),'media.nom AS media', "media.type_media","media.telephone",DB::raw('(CASE WHEN dossier.status_commission is NULL THEN "Nouveau" WHEN dossier.status_commission = "en_cours" THEN "En cours" WHEN dossier.status_commission = "terminer" THEN "Terminé" WHEN dossier.status_commission = "rejeter" THEN "Rejeté" WHEN dossier.status_commission = "revoir" THEN "Revoir" END) AS agree'));
            $head = ['Promoteur','Média','Type','Téléphone','Etat'];
        }elseif (auth()->user()->role->nom == 'HAC') {
            $don = $this->FiltreHAC()->select(DB::Raw("CONCAT(user.prenom, ' ', user.nom) AS promoteur"),'media.nom AS media', "media.type_media","media.telephone",DB::raw('(CASE WHEN dossier.status_hac is NULL THEN "Nouveau" WHEN dossier.status_hac = "en_cours" THEN "En cours" WHEN dossier.status_hac = "terminer" THEN "Terminé" WHEN dossier.status_hac = "rejeter" THEN "Rejeté" WHEN dossier.status_hac = "revoir" THEN "Revoir" END) AS agree'));
            $head = ['Promoteur','Média','Type','Téléphone','Etat'];
        }elseif (auth()->user()->role->nom == 'Direction') {
            $don = $this->FiltreDirection()->select(DB::Raw("CONCAT(user.prenom, ' ', user.nom) AS promoteur"),'media.nom AS media', "media.type_media","media.telephone","paiement.montant",DB::raw('(CASE  WHEN paiement.is_valided IS NULL THEN "Nouveau" WHEN paiement.is_valided = "1" THEN "Accepté" ELSE "Rejeté" END) AS agree'));
            $head = ['Promoteur','Média','Type','Téléphone','FA','Agrée'];
        }elseif (auth()->user()->role->nom == 'SGG') {
            $don = $this->FiltreSGG()->select(DB::Raw("CONCAT(user.prenom, ' ', user.nom) AS promoteur"),'media.nom AS media', "media.type_media","media.telephone",DB::raw('(CASE  WHEN media.numero_registre_sgg IS NULL THEN "Nouveau"  ELSE "Enregistré" END) AS agree'));
            $head = ['Promoteur','Média','Type','Téléphone',"Etat"];
        }


        $date = date('Y-m-d H:i:s');
        return Excel::download(new ExportDataDaf($don, $head), 'export_data_'.auth()->user()->role->nom.'_'.$date.'.xls');
    }
    public function exportPDFDaf()
    {
        //return Excel::download(new ExportDataDaf($this->search, $this->filter), 'DataDaf.pdf');
    }
}