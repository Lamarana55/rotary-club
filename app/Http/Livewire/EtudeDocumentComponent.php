<?php

namespace App\Http\Livewire;

use App\Models\Document;
use App\Models\Dossier;
use App\Models\Media;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EtudeDocumentComponent extends Component
{
    public $documents;
    public $firstDocument;
    public $description;
    public $commentaires=[];
    public $selected =[];
    public $selectedAll = false;
    public $firstId=null;
    public $etudeDocumentsTermine = false;
    public $etudeDocumentsTermineHac = false;
    public $rejetAfterDoc = false;
    public $clotureEtude = false;
    public $media;
    public $dossier;
    public $preview = false;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount($id)
    {
        $this->media = Media::whereUuid($id)->first();
        $this->documents = Document::where('media_id',$this->media->id)->where('categorie','document_technique')->get();
        $this->dossier = Dossier::where('media_id',$this->media->id)->first();
    }

    public function checkButtonTermineCommissionHac($id)
    {
        $hasDocumentRejete = false;
        $documents = Document::where('media_id',$id)->where('categorie','document_technique')->get();
        foreach($documents as $document) {
            if(Auth::guard()->check() && Auth::user()->role->nom === 'HAC') {
                if($document->is_validated_hac === null) {
                    $hasDocumentRejete = true;
                }

            }elseif(Auth::guard()->check() && Auth::user()->role->nom === 'Commission'){
                if($document->is_validated_commission === null) {
                    $hasDocumentRejete = true;
                }
            }
        }

		return $hasDocumentRejete;
    }

    public function etudeTerminerCommission($id)
    {
        $valide=false;
        $documents = Document::where('media_id',$id)->where('categorie','document_technique')->get();
        foreach ($documents as $key => $value) {


           if(Auth::check() && Auth::user()->role->nom === 'Commission') {
                if($value->is_validated_commission===null){
                    $valide = true;
                }
            }elseif(Auth::check() && Auth::user()->role->nom === 'HAC'){
                if($value->is_validated_hac===null){
                    $valide = true;
                }
            }
        }

        return $valide;
    }

    public function etudeDocumentsTermineHac($id)
    {
        $documents = Document::where('media_id',$id)->where('categorie','document_technique')->get();
        $dossier = Dossier::where('media_id',$id)->first();
        $hasDocumentRejete = false;

        foreach($documents as $document) {
            if(Auth::check() && Auth::user()->role->nom === 'Commission') {
                if($document->is_validated_commission != null && $dossier->is_valided_commission==true) {
                    $hasDocumentRejete = true;
                    break;
                }
            }elseif(Auth::check() && Auth::user()->role->nom === 'HAC'){
                if($document->is_validated_hac != null && $dossier->is_valided_hac==true) {
                    $hasDocumentRejete = true;
                    break;
                }
            }

        }

		return $hasDocumentRejete;
    }

    public function etudeDocumentsTermine($id)
    {
        $documents = Document::where('media_id',$id)->where('categorie','document_technique')->get();

        $hasDocumentRejete = false;
        foreach($documents as $document) {
            if(Auth::guard()->check() && Auth::user()->role->nom === 'Commission') {
                if($document->is_validated_commission == null || $document->is_validated_commission == false) {
                    $hasDocumentRejete = true;
                    break;
                }
            }elseif(Auth::guard()->check() && Auth::user()->role->nom === 'HAC'){
                if($document->is_validated_hac == null || $document->is_validated_hac == false) {
                    $hasDocumentRejete = true;
                    break;
                }
            }

        }

		return $hasDocumentRejete;
    }

    private function checkedEtudeDocument()
    {

        $dossier = Dossier::where('media_id',$this->media->id)->first();
        foreach($this->documents as $document) {
            if(Auth::guard()->check() && Auth::user()->role->nom === 'Commission') {
                if($document->is_validated_commission=== null || $dossier && $dossier->status_commission == 'revoir') {
                    $this->etudeDocumentsTermine = true;
                }else{
                    $this->etudeDocumentsTermine = false;
                }
            }

            if(Auth::guard()->check() && Auth::user()->role->nom === 'HAC') {
                if($document->is_validated_hac != null && $dossier && $dossier->status_hac != 'terminer') {
                    $this->etudeDocumentsTermineHac = true;
                    break;
                }else{
                    $this->etudeDocumentsTermineHac = false;
                }
            }
        }

        if(Auth::guard()->check() && Auth::user()->role->nom === 'Commission') {
            if($dossier && $dossier->status_commission == 'en_cours' || $dossier && $dossier->status_commission == 'rejeter' || $dossier && $dossier->status_commission == 'revoir') {
                $this->clotureEtude = true;
            }
        }elseif(Auth::guard()->check() && Auth::user()->role->nom === 'HAC'){
            if($dossier && $dossier->status_hac === 'en_cours' || $dossier && $dossier->status_hac === 'rejeter' || $dossier && $dossier->status_hac === 'revoir' || $dossier && $dossier->status_hac === null) {
                $this->clotureEtude = true;
            }
        }


    }

    public function render()
    {
        if(!hasPermission('afficher_document')){
            $this->redirect("/page-not-permission");
        }

        $this->checkedEtudeDocument();
        return view('medias.medias.etudes.etude_document_technique')
            ->extends("layouts.default")
            ->section("content");
    }

    public function showDocument($id)
    {
        $this->firstDocument = Document::find($id);
        $this->preview = true;
    }

    public function closeDocument()
    {
        $this->preview = false;
    }

    public function updateMySeleted()
    {

        if(count($this->selected) == count($this->documents)){
            $this->selectedAll = true;
        }else{
            $this->selectedAll = false;
        }
    }

    public function selectedAllClick()
    {

        if($this->selectedAll){
            $this->selected = Document::where('media_id','>=',$this->media)->where('categorie','document_technique')->pluck('id');
        }else{
            $this->selected = [];
        }

    }

    public function showConfirmeAccepteFavorable()
    {

        $this->dispatchBrowserEvent("showConfirmAccepteExamenDocuments", ["message"=>$this->media->nom]);
    }

    public function showModalRejetDocument()
    {

        $this->commentaires = $this->selected;
        $this->dispatchBrowserEvent("showEditModalRejetDocumentCommentaire");
    }

    public function accepteFavorable()
    {
        $media = Media::find($this->media->id);
        $dossier = Dossier::where('media_id',$this->media->id)->first();
        foreach($this->selected as $select) {
            $document = Document::find($select);
            if(Auth::guard()->check() && Auth::user()->role->nom === 'Commission'){
                if($document) {
                    $document->is_validated_commission = true;
                    $document->save();
                    $media->en_attente_commission = false;
                    $media->en_cours_commission = true;
                    $media->update();
                }
            }elseif(Auth::guard()->check() && Auth::user()->role->nom === 'HAC'){
                if($document) {
                    $document->is_validated_hac = true;
                    $document->save();

                    $media->en_attente_hac = false;
                    $media->en_cours_hac = true;
                    $media->update();
                }
            }
        }

        if(Auth::check() && Auth::user()->role->nom === 'Commission'){
            $dossier->is_valided_commission = true;
            $dossier->save();
            $media->en_attente_commission = false;
            $media->en_cours_commission = true;
            $media->update();
        }elseif(Auth::check() && Auth::user()->role->nom === 'HAC'){
            $dossier->is_valided_hac = true;
            $dossier->save();

            $media->en_attente_hac = false;
            $media->en_cours_hac = true;
            $media->update();
        }

        $this->redirect('/etude-document/'.$this->media->uuid);
        $this->dispatchBrowserEvent("showSuccessPersoMessage", ["message"=>"Document.s validé.s"]);


    }

    public function showConfirmeTerminerEtude()
    {
        $this->dispatchBrowserEvent("showConfirmTerminerExamenDocuments", ["message"=>$this->media->nom]);
    }


    public function terminerEtudeDocumentsTechniques(){
        $media = Media::find($this->media->id);
        $this->documents = Document::where('media_id',$this->media->id)->where('categorie','document_technique')->get();
        $dossier = Dossier::where('media_id',$this->media->id)->first();

        if(Auth::guard()->check() && Auth::user()->role->nom === 'Commission') {
            $valide = true;
            foreach($this->documents as $document) {
                if($document->is_validated_commission == false) {
                    $valide = false;
                }
            }

            if($valide == false){
                $media->stape = 1;
                $media->save();

                $message = message_email("examen_terminer");
                $objet = "Examen de la commission technique ";
                send_notification($media->user, $objet, $message, $media, config("app.url").':'.env("PORT","9000"));
                $media->save();

                $dossier->status_commission = 'rejeter';
                $dossier->is_termine_commission = true;
                $dossier->save();
            }else{
                $dossier->status_commission = 'en_cours';
                $dossier->is_valided_commission = false;
                $dossier->is_termine_commission = true;
                if($dossier->is_termine_hac == 1){
                    $documents = Document::where('is_validated_hac',false)->where('categorie','document_technique')->where('media_id',$this->media->id)->get();
                    foreach($documents as $document) {
                        $documents = Document::where('is_validated_hac',false)->where('categorie','document_technique')->where('media_id',$this->media->id)->update([
                            'is_validated_hac'=>null
                        ]);
                    }
                    $dossier->is_termine_hac = false;
                }
                $dossier->save();
            }

        } elseif(Auth::guard()->check() && Auth::user()->role->nom === 'HAC') {
            $valide = true;
            foreach($this->documents as $document) {
                if($document->is_validated_hac == false) {
                    $valide = false;
                }
            }

            if($valide == false){
                $message = [
                    "Votre dossier technique a été rejeté par la Haute Autorité de Communication (HAC).",
                    "Veuillez consulter le raport pour plus de détails."
                ];

                $media->stape = 1;
                $media->current_stape = 2;
                $media->save();

                $commission = User::whereIn("role_id", function ($query){
                    $query->from("role")->whereNom("Commission")->select("id")->get();
                })->where("is_deleted", false)->first();

                if($commission) {
                    $message_commission = message_email("avis_consultatif", $media);

                    send_notification(
                        $commission,
                        "Haute autorité de la communication",
                        $message_commission,
                        $media,
                        config("app.url")
                    );
                }

                $dossier->status_hac = null;
                $dossier->status_commission ='revoir';
                $dossier->is_termine_hac = true;
                $dossier->is_valided_hac = false;
                $dossier->is_valided_commission = true;
                $dossier->is_termine_commission = false;
                $dossier->update();
            }else{

                $dossier->status_hac = 'en_cours';
                $dossier->is_termine_hac = true;
                $dossier->is_valided_hac = false;

                $dossier->save();
            }

        }

        $this->redirect('/etude-document/'.$this->media->uuid);
        $this->dispatchBrowserEvent("showSuccessPersoMessage", ["message"=>"Etude du dossier terminé avec succès"]);
    }

    public function rapportCommissionHac($rapport)
    {
        $result = Document::where('media_id',$this->media->id)->where('categorie',$rapport)->first();

        return $result;
    }

    public function showDocumentDescription($id)
    {
        $this->description = Document::find($id);
    }

}
