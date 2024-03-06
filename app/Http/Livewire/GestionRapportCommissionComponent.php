<?php

namespace App\Http\Livewire;

use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Media;
use App\Models\Membre;
use App\Models\Dossier;
use App\Models\Rapport;
use Livewire\Component;
use App\Models\Document;
use App\Models\Tracking;
use Livewire\WithFileUploads;
use App\Models\MembreRapportMedia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class GestionRapportCommissionComponent extends Component
{
    use WithFileUploads;

    public $member=[];
    public $members=[];
    public $countMembre;
    public $media;
    public $rapport_commission;
    public $member_rapport_commissions=[];
    public $membre_commissions =[];
    public $membre_hac_commissions = [];
    public $rapporteur;
    // les attributs
    public $capacite_financier_personnalise;
    public $nombre_present=1;
    public $forme_juridique;
    public $capital_social;
    public $capital_montant;
    public $capital_unite;
    public $nombre_depart;
    public $nombre_part_value;
    public $pourcentage_investisseur_signe;
    public $pourcentage_investisseur_value;
    public $nombre_certificat;
    public $nombre_certificat_resident;
    public $nombre_certificat_casier_dirigeant;
    public $nombre_journaliste=3;
    public $nombre_diplome_technicien;
    public $categorie_chaine;
    public $public_cible;
    public $equipement_reception;
    public $equipement_studio;
    public $equipement_emission;
    public $programme_provenant_exterieur;
    public $programme_provenant_exterieur_value;
    public $production_interne_signe;
    public $production_interne_value;
    public $coproduction_signe;
    public $coproduction_value;
    public $echange_programme_signe;
    public $echange_programme_value;
    public $exigence_unite_nationale;
    public $capacite_financiere;
    public $capacite_financiere_interval;
    public $etat_financier;
    public $orientation_chaine;
    public $conclusion;
    public $production_interne_label_value;
    public $programme_provenant_exterieur_label_value;
    public $coproduction_label_value;
    public $pourcentage_investisseur_label_value;
    public $echange_programme_label_value;
    public $date_debut;
    public $heure_debut;
    public $date_fin;
    public $heure_fin;
    public $type;
    public $type_commission;
    public $capacite_financiere_preuve;
    public $president;
    public $rapporteurFirst;


    public function AdminAuthCheck()
    {
        if(!Auth::guard()->check())
        {
            return redirect('/login');
        }
    }

    public function mount($id,$type_commission)
    {
        $this->type_commission = $type_commission;
        $this->date_debut = explode(' ',\Carbon\Carbon::now())[0];
        $this->media = Media::whereUuid($id)->first();

        $this->forme_juridique = $this->media->forme_juridique;
        // $this->media = Media::find($id);
        $this->getHac($this->media->id??null);
        $this->redactionRapportView($this->media->id??null);
    }

    public function getHac($media)
    {
        $rapport = Rapport::where('media_id',$media)->first();

        $this->capital_social = $rapport->capital_social??null;
        $this->capital_montant = $rapport->capital_montant??null;
        $this->capital_unite = $rapport->capital_unite??null;
        $this->nombre_depart = $rapport->nombre_depart??null;
        $this->nombre_part_value = $rapport->nombre_part_value??null;
        $this->pourcentage_investisseur_signe = $rapport->pourcentage_investisseur_signe??null;
        $this->pourcentage_investisseur_value = $rapport->pourcentage_investisseur_value??null;
        $this->nombre_certificat = $rapport->nombre_certificat??null;
        $this->nombre_certificat_resident = $rapport->nombre_certificat_resident??null;
        $this->nombre_certificat_casier_dirigeant = $rapport->nombre_certificat_casier_dirigeant??null;
        $this->nombre_journaliste = $rapport->nombre_journaliste??null;
        $this->nombre_diplome_technicien = $rapport->nombre_diplome_technicien??null;
        $this->categorie_chaine = $rapport->categorie_chaine??null;
        $this->public_cible = $rapport->public_cible??null;
        $this->equipement_reception = $rapport->equipement_reception??null;
        $this->equipement_studio = $rapport->equipement_studio??null;
        $this->equipement_emission = $rapport->equipement_emission??null;
        $this->programme_provenant_exterieur = $rapport->programme_provenant_exterieur??null;
        $this->programme_provenant_exterieur_value = $rapport->programme_provenant_exterieur_value??null;
        $this->production_interne_signe = $rapport->production_interne_signe??null;
        $this->production_interne_value = $rapport->production_interne_value??null;
        $this->coproduction_signe = $rapport->coproduction_signe??null;
        $this->coproduction_value = $rapport->coproduction_value??null;
        $this->echange_programme_signe = $rapport->echange_programme_signe??null;
        $this->echange_programme_value = $rapport->echange_programme_value??null;
        $this->exigence_unite_nationale = $rapport->exigence_unite_nationale??null;
        $this->capacite_financiere = $rapport->capacite_financiere??null;
        $this->capacite_financiere_preuve = $rapport->capacite_financiere_preuve??null;
        $this->capacite_financiere_interval = $rapport->capacite_financiere_interval??null;
        $this->etat_financier = $rapport->etat_financier??null;
        $this->orientation_chaine = $rapport->orientation_chaine??null;
        $this->conclusion = $rapport->conclusion??null;
        $this->production_interne_label_value = $rapport->production_interne_label_value??null;
        $this->programme_provenant_exterieur_label_value = $rapport->programme_provenant_exterieur_label_value??null;
        $this->coproduction_label_value = $rapport->coproduction_label_value??null;
        $this->pourcentage_investisseur_label_value = $rapport->pourcentage_investisseur_label_value??null;
        $this->echange_programme_label_value = $rapport->echange_programme_label_value??null;
        $this->date_debut = $rapport->date_debut??null;
        $this->heure_debut = $rapport->heure_debut??null;
        $this->date_fin = $rapport->date_fin??null;
        $this->heure_fin = $rapport->heure_fin??null;
    }

    public function render()
    {
        if(!hasPermission('editer_rapport')){
            $this->redirect("/page-not-permission");
        }

        $this->capacite_financiere = $this->media->type=='Radio' ? "Radio/illimité (en millions GNF)":"Télévision /4 milliards GNF";
        $this->categorie_chaine = $this->media->type_media;

        return view('medias.rapports.rapport_commission')
            ->extends("layouts.default")
            ->section("content");
    }

    public function getMember($data){
        $pos = array_search($data, $this->members);

        if($pos !== false){
            unset($this->members[$pos]);
        }else{
            array_push($this->members,$data);
        }
        $this->nombre_present = count($this->members)+1;
    }


    public function redactionRapportView($media_id)
    {
        $this->rapporteur = Auth::user();
        if ($this->type_commission != 'hac' && $this->type_commission != 'commission') {
            return redirect()->back()->withError('le rapport est géneré par la commission ou par la HAC');
        }
        // rapport commission
        $rapport_commission_exist = Rapport::where('media_id',$media_id)->where('type_commission',$this->type_commission)->first();

        $this->rapport_commission = Rapport::where('media_id',$media_id)->where('type_commission',$this->type_commission)->first();

        if(!$rapport_commission_exist){
            $this->rapport_commission = Rapport::where('media_id',$media_id)->first();
        }


        if ($this->type_commission == 'hac') {
            // $this->nombre_present = Membre::where('category', 'HAC')->count('id');
            // $this->nombre_present = count($this->member)+1;
            $this->president = Membre::where('category', 'HAC')->whereFonction('Président')->first();
            $this->rapporteurFirst = Membre::where('category', 'HAC')->where('id',auth()->user()->id)->first();

            $this->membre_hac_commissions = Membre::where('category', 'HAC')->where('fonction','!=','Rapporteur')->get();
        }

        if ($this->type_commission == 'commission') {
            $this->membre_commissions = Membre::where('category', 'Commission')->where('fonction','!=','Rapporteur')->get();
            $this->president = Membre::where('category', 'Commission')->whereFonction('Président')->first();
            $this->rapporteurFirst = Membre::where('category', 'Commission')->where('id',auth()->user()->id)->first();

            $this->member_rapport_commissions = MembreRapportMedia::where('media_id',$media_id)->get();
            // $this->nombre_present = Membre::where('category', 'Commission')->count('id');
            // $this->nombre_present = count($this->member)+1;
        }

    }

    public function postRedactionRapport(Request $request)
    {

        if($this->type_commission == 'commission'){
            $validateArr = [
                'forme_juridique' => 'required',
                'capital_social' => 'required',
                'capital_montant' => 'required',
                'capital_unite' => 'required',
                'nombre_present'=>'required|numeric|min:4',
                'nombre_depart' => 'required',
                'member'=>'required',
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
                'equipement_emission' => 'required|numeric|min:500|max:1000',
                'programme_provenant_exterieur' => 'required',
                'programme_provenant_exterieur_value' => 'required|numeric|max:100',
                'production_interne_signe' => 'required',
                'production_interne_value' => 'required|numeric|max:100',
                'coproduction_signe' => 'required',
                'coproduction_value' => 'required|numeric|max:100',
                'echange_programme_signe' => 'required',
                'echange_programme_value' => 'required|numeric|max:100',
                'exigence_unite_nationale' => 'required',
                'capacite_financiere' => 'required',
                'capacite_financiere_preuve' => 'required',
                'capacite_financiere_interval' => 'required',
                'etat_financier' => 'required',
                'orientation_chaine' => 'required',
                'conclusion' => 'required',
                'production_interne_label_value'  => 'required|numeric|max:100',
                'programme_provenant_exterieur_label_value'  => 'required|numeric|max:100',
                'coproduction_label_value'  => 'required|numeric|max:100',
                'pourcentage_investisseur_label_value'  => 'required',
                'echange_programme_label_value'  => 'required|numeric|max:100',
                'date_debut'  => 'required',
                'heure_debut'  => 'required',
                // 'date_fin'  => 'required',
                // 'heure_fin'  => 'required',
            ];
            $this->validate($validateArr);
        }

        if($this->capacite_financiere_interval == 'Personnaliser') {
            $validateArr['capacite_financier_personnalise'] = 'required';
        }

        if($this->type_commission == 'hac'){
            $validateArr = [
                'forme_juridique' => 'required',
                'capital_social' => 'required',
                'nombre_present'=>'required|numeric|min:4',
                'capital_montant' => 'required',
                'capital_unite' => 'required',
                'conclusion' => 'required',
                'pourcentage_investisseur_label_value'  => 'required',
                'nombre_depart' => 'required',
                'nombre_part_value' => 'required',
                'pourcentage_investisseur_signe' => 'required',
                'pourcentage_investisseur_value' => 'required',
                'nombre_certificat' => 'required',
                'member'=>'required',
                'nombre_certificat_resident' => 'required',
                'nombre_certificat_casier_dirigeant' => 'required',
            ];

            $this->validate($validateArr);
        }

        if($this->type_commission != 'hac' && $this->type_commission != 'commission')
        {
            return $this->dispatchBrowserEvent("showErrorMessage", ["message"=>"le rapport est géneré par la commission ou par la HAC"]);
        }


        Rapport::where('media_id',$this->media->id)->where('type_commission',$this->type_commission)->delete();

        $rapport_commission = Rapport::create(
            [
                'media_id' => $this->media->id,
                'nombre_present' => $this->nombre_present,
                'type_commission' => $this->type_commission,
                'forme_juridique' => $this->media->forme_juridique,
                'capital_social' => $this->capital_social,
                'capital_montant' => $this->capital_montant,
                'capital_unite' => $this->capital_unite,
                'nombre_depart' => $this->nombre_depart,
                'nombre_part_value' => $this->nombre_part_value,
                'pourcentage_investisseur_signe' => $this->pourcentage_investisseur_signe,
                'pourcentage_investisseur_value' => $this->pourcentage_investisseur_value,
                'nombre_certificat' => $this->nombre_certificat,
                'nombre_certificat_resident' => $this->nombre_certificat_resident,
                'nombre_certificat_casier_dirigeant' => $this->nombre_certificat_casier_dirigeant,
                'nombre_journaliste' => $this->nombre_journaliste,
                'nombre_diplome_technicien' => $this->nombre_diplome_technicien,
                'categorie_chaine' => $this->categorie_chaine,
                'public_cible' => $this->public_cible,
                'equipement_reception' => $this->equipement_reception,
                'equipement_studio' => $this->equipement_studio,
                'equipement_emission' => $this->equipement_emission,
                'programme_provenant_exterieur' => $this->programme_provenant_exterieur,
                'programme_provenant_exterieur_value' => $this->programme_provenant_exterieur_value,
                'production_interne_signe' => $this->production_interne_signe,
                'production_interne_value' => $this->production_interne_value,
                'coproduction_signe' => $this->coproduction_signe,
                'coproduction_value' => $this->coproduction_value,
                'echange_programme_signe' => $this->echange_programme_signe,
                'echange_programme_value' => $this->echange_programme_value,
                'exigence_unite_nationale' => $this->exigence_unite_nationale,
                'capacite_financiere' => $this->capacite_financiere,
                'capacite_financiere_preuve' => $this->capacite_financiere_preuve,
                'capacite_financiere_interval' => $this->capacite_financiere_interval,
                'etat_financier' => $this->etat_financier,
                'orientation_chaine' => $this->orientation_chaine,
                'conclusion' => $this->conclusion,
                'production_interne_label_value'  => $this->production_interne_label_value,
                'programme_provenant_exterieur_label_value'  => $this->programme_provenant_exterieur_label_value,
                'coproduction_label_value'  => $this->coproduction_label_value,
                'pourcentage_investisseur_label_value'  => $this->pourcentage_investisseur_label_value,
                'echange_programme_label_value'  => $this->echange_programme_label_value,
                'date_debut'  => $this->date_debut,
                'heure_debut'  => $this->heure_debut,
                'date_fin'  => Carbon::now()->format('d-m-Y'), //$this->date_fin,
                'heure_fin'  => Carbon::now()->format('h:m'), //$this->heure_fin,
            ]
        );

        $media_id = $this->media->id;

        if ($this->type_commission == 'hac') {

             if (Auth::user()->role->nom !== 'HAC') {
                return $this->dispatchBrowserEvent("showErrorMessage", ["message"=>"Vous n'êtes pas autorisé à effectuer cette action"]);
             }

            if(!(count($this->member) > 0)){
                return $this->dispatchBrowserEvent("showErrorMessage", ["message"=>"Veuillez sélectionner les membres de la commission"]);
            }

            $this->rapportHac($rapport_commission);
        } else {
            if (Auth::user()->role->nom !== 'Commission') {
                return $this->dispatchBrowserEvent("showErrorMessage", ["message"=>'Vous n\'êtes pas autorisé à effectuer cette action']);
            }

            $commission = Dossier::where('media_id', $media_id)->first();
            $this->rapportCommission($commission->id, $rapport_commission);
        }

        $this->redirect('/liste-medias');

        return $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>'Le rapport à été enregistré avec succès']);

    }

    private function rapportHac($rapport_hac)
    {

        $dossier = Dossier::where('media_id',$this->media->id)->first();
        $documents = Document::where('media_id',$this->media->id)->where('categorie','document_technique')->get();
        if ($dossier === null) {
            return $this->dispatchBrowserEvent("showErrorMessage", ["message"=>"Ce dossier n'existe pas"]);
        }

        MembreRapportMedia::where('media_id',$this->media->id)->where('category','HAC')->delete();

        Document::where('media_id',$this->media->id)->where('categorie','rapports_hac')->delete();
        $use = Membre::where('user_id',Auth::user()->id)->first();

        if($this->member){
            foreach ($this->member as $key => $value) {
                $membreRapportCommissionMedia = new MembreRapportMedia();
                $membreRapportCommissionMedia->media_id = $this->media->id;
                $membreRapportCommissionMedia->membre_id = $key;
                $membreRapportCommissionMedia->category = "HAC";
                $membreRapportCommissionMedia->save();
            }
            $membreRapportCommissionMedia = new MembreRapportMedia();
            $membreRapportCommissionMedia->media_id = $this->media->id;
            $membreRapportCommissionMedia->membre_id = $use->id;
            $membreRapportCommissionMedia->category = "HAC";
            $membreRapportCommissionMedia->save();
        }else{
            return $this->dispatchBrowserEvent("showErrorMessage", ["message"=>"veuillez selectionner une membre"]);

        }

        $levelExist = Media::find($dossier->media->id);
        $valide = true;
        foreach ($documents as $document) {
            if ($document->is_validated_hac === 0) {
                $valide = false;
                $document->is_validated_hac = null;
                $document->save();
                break;
            }else{
                $dossier->status_hac = 'terminer';
                $dossier->save();
            }
        }

        $membre_commissions = MembreRapportMedia::where('media_id',$dossier->media->id)->where('category','HAC')->get();

        $data = [
            'imagePath'    => public_path('dist/img/momo.png'),
            'pathArmoirie' => convertBase64('public/assets/dist/img/armoirie.png'),
            'pathBranding' => convertBase64('public/assets/dist/img/branding.jpg'),
            'logo_hac' => convertBase64('public/assets/dist/img/hac_logo.jpg'),
            'flag_guinnea' => convertBase64('public/assets/dist/img/flag_guinea.png'),
            'media' => $dossier->media,
            'date' => date('d-m-Y'),
            'rapport_hac' => $rapport_hac,
            'membre_commissions' => $membre_commissions,
        ];
        // return view('template_documents.rapport_hac',$data);
        // die();
        $pdf = PDF::loadView('template_documents.rapport_hac', $data);
        $content = $pdf->setPaper('a4')->download()->getOriginalContent();

        // if($dossier->rapport) {
        //     $oldPath = substr_replace($dossier->rapport, 'public', 0, strlen('/storage'));
        //     Storage::delete($oldPath);
        // }

        $path = 'rapports_hac/' . time() . '_rapport.pdf';
        Storage::put('public/' . $path, $content);


        $newDocument = new Document();
        $newDocument->file_path = "/storage/" . $path;
        $newDocument->media_id = $this->media->id;
        $newDocument->categorie = 'rapport_hac';
        $newDocument->save();

        $media = $dossier->media;

        if (!$valide) {
            $message = message_email("avis_consultatif", $media);
            $dossier_commission = $dossier->media->dossier_commission;
            if ($dossier_commission !== null) {
                $dossier_commission->revoir = true;
                $dossier_commission->etude_termine = false;
                $dossier_commission->save();
            }

            $levelExist->stape = 3;
            $levelExist->current_stape = 4;
            $levelExist->en_cours_hac = false;
            $levelExist->traite_hac = true;
            $levelExist->save();

            $commission = User::whereIn("role_id", function ($query) {
                $query->from("role")->whereNom("Commission")->select("id")->get();
            })->where("is_deleted", false)->first();

            if($commission) {
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
            $levelExist->stape = 3;
            $levelExist->current_stape = 4;
            $levelExist->en_cours_hac = false;
            $levelExist->traite_hac = true;
            $levelExist->save();

            $direction = User::whereIn("role_id", function ($query) {
                $query->from("role")->whereNom("Direction")->select("id")->get();
            })->where("is_deleted", false)->first();

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

        $tracking = Tracking::where('media_id', $dossier->media_id)->first();
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

    private function rapportCommission($id, $rapport_commission)
    {
        $dossier_commission = Dossier::find($id);
        $documents = Document::where('media_id',$this->media->id)->where('categorie','document_technique')->get();

        if ($dossier_commission === null) {
            return $this->dispatchBrowserEvent("showErrorMessage", ["message"=>"Ce dossier n'existe pas"]);
        }

        Document::where('media_id',$this->media->id)->where('categorie','rapport_commission')->delete();
        MembreRapportMedia::where('media_id',$this->media->id)->where('category','COMMISSION')->delete();
        $use = Membre::where('user_id',Auth::user()->id)->first();

        if($this->member){
            foreach ($this->member as $key => $value) {
                $membreRapportCommissionMedia = new MembreRapportMedia();
                $membreRapportCommissionMedia->media_id = $this->media->id;
                $membreRapportCommissionMedia->membre_id = $key;
                $membreRapportCommissionMedia->category = "COMMISSION";
                $membreRapportCommissionMedia->save();
            }

            $membreRapportCommissionMedia = new MembreRapportMedia();
            $membreRapportCommissionMedia->media_id = $this->media->id;
            $membreRapportCommissionMedia->membre_id = $use->id;
            $membreRapportCommissionMedia->category = "COMMISSION";
            $membreRapportCommissionMedia->save();
        }else{
            return $this->dispatchBrowserEvent("showErrorMessage", ["message"=>"veuillez selectionner une membre"]);

        }

        $valide = true;
        $media = $dossier_commission->media;
        $mediaExit = Media::where('id', $media->id)->first();
        $membre_commissions = MembreRapportMedia::where('media_id', $media->id)->where('category', 'Commission')->get();

        foreach ($documents as $document) {
            if ($document->is_validated_commission === 0) {
                $valide = false;
                break;
            }else{
                $dossier_commission->status_commission ='terminer';
                $dossier_commission->save();
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
            'rapport_commission' => $rapport_commission,
            'membre_commissions' => $membre_commissions,
        ];
        $pdf = PDF::loadView('template_documents.rapport_commission', $data);
        // $pdf->setWatermarkImage(convertBase64('public/assets/dist/img/branding.jpg'), $opacity = 0.6, $top = '30%', $width = '100%', $height = '100%');

        utf8_decode($pdf->output());

        $content = $pdf->setPaper('a4')->download()->getOriginalContent();

        $path = 'rapports_commission/' . time() . '_rapport.pdf';
        Storage::put('public/' . $path, $content);

        $newDocument = new Document();
        $newDocument->file_path = "/storage/" . $path;
        $newDocument->media_id = $this->media->id;
        $newDocument->categorie = 'rapport_commission';
        $newDocument->save();

        if ($valide) {
            $mediaExit->stape = 2;
            $mediaExit->current_stape = 3;
            $mediaExit->en_cours_commission = false;
            $mediaExit->traite_commission = true;
            $mediaExit->en_attente_hac = true;
            $mediaExit->save();
            Dossier::updateOrCreate(
                ['media_id' => $media->id],
                ['status_hac' => null]
            );

            $hac_user = User::whereIn("role_id", function ($query) {
                $query->from("role")->whereNom("HAC")->select("id")->get();
            })->where("is_deleted", false)->first();
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
            $mediaExit->stape = 1;
            $mediaExit->current_stape = 2;
            $mediaExit->save();

            $message = message_email("examen_terminer");
            $objet = "Examen de dossier technique";

            send_notification($media->user, $objet, $message, $media, config("app.url").':'.env("PORT","9000"));
        }
        $tracking = Tracking::where('media_id', $media->id)->first();
        if ($tracking) {
            $tracking->date_etude_commission = Carbon::now();
            $tracking->save();
        }
    }
}
