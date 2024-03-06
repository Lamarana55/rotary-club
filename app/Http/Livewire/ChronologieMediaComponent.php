<?php

namespace App\Http\Livewire;

use App\Models\{
    CahierDeCharge,
    Document,
    DocumentTypePromoteur,
    Dossier,
    TypeMedia,
    Media,
    Paiement,
    Tracking,
};
use Livewire\Component;

class ChronologieMediaComponent extends Component
{
    public $currentPreview = PREVIEWCOMMISSION;

    public $media;
    public $cahierChargePayer;
    public $fraisAgrement;
    public $dossier;
    public $typeDoc;
    public $recu;
    public $listDocuments;
    public $documentsRequis;
    public $firstDocument;
    public $preview;
    public $is_visualiserprojetagreement = false;
    public $is_visualiseragreement = false;
    public $traking;


    public function mount($id)
    {
        $this->media = Media::whereUuid($id)->first();
        $type_media = TypeMedia::whereNom($this->media->type_media??null)->first();
        $this->typeDoc  = CahierDeCharge::where('isCurrent',true)
            ->where('type_media_id',$type_media->id)->first();
    }

    public function getPreviewCahierCharge()
    {
        $this->recu = Paiement::where('media_id',$this->media->id??null)->where('type_paiement','cahierDesCharges')->first();
    }

    public function render()
    {
        if(!hasPermission('chronologie')){
            $this->redirect("/page-not-permission");
        }

        $this->traking = Tracking::where('media_id',$this->media->id)->first();
        $this->listDocuments = Document::where('media_id',$this->media->id)->where('categorie','document_technique')->with('media','document_type_promoteur')->get();
        $this->documentsRequis = DocumentTypePromoteur::where('type_promoteur_id',$this->media->user->type_promoteur_id)->get();

        $this->cahierChargePayer = Paiement::where('media_id',$this->media->id??null)->where('type_paiement','cahierDesCharges')->first();
        $this->fraisAgrement = Paiement::where('media_id',$this->media->id??null)->where('type_paiement','fraisAgrement')->first();
        $this->dossier = Dossier::where('media_id',$this->media->id??null)->first();
        return view('medias.medias.etudes.chronologie')
            ->extends("layouts.default", ['title' => 'Médias'])
            ->section("content");
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

    public function getPreviewCahierChargeRecu()
    {
        $this->firstDocument = Paiement::where('media_id',$this->media->id)->where('type_paiement','cahierDesCharges')->first();
        $this->currentPreview =true;
        $this->preview = "Recu";
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

    public function hasRapportCommissionHac($id,$rapport)
    {
        $result = Document::where('media_id',$id)->where('categorie',$rapport)->first();
        return $result;
    }

    public function showPreviewFilesRapport($id,$rapport)
    {
        $this->firstDocument = Document::where('media_id',$id)->where('categorie',$rapport)->first();

        $this->currentPreview =true;
        $this->preview = "document";
    }

    public function hasProjetAgrementInDocument($id)
    {
        $document = Document::where('media_id',$id)->where('categorie','projet_agrement')->first();
        return $document;
    }

    public function visualiserprojetagreement()
    {
        $this->is_visualiserprojetagreement = true;
    }
    public function closevisualiserprojetagreement()
    {
        $this->is_visualiserprojetagreement = false;
    }

    public function visualiseragreement()
    {
        $this->is_visualiseragreement = true;
    }
    public function closevisualiseragreement()
    {
        $this->is_visualiseragreement = false;
    }

    public function telechargerAgrementSigne($id)
    {
        $this->media = Media::find($id);
    }
}
