<?php

namespace App\Http\Livewire;

use App\Models\GenerateAgreement;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use PDF;

class ModifierProjetAgrementComponent extends Component
{
    public $media;
    public $nomMinistre;
    public $genreMinistre;
    public $idMedia;
    public $projet_agrement;
    public $agrement;
    public $projetAgrementNoSigne;
    public $isEdit=false;

    public function mount($id)
    {

        $this->idMedia = Media::whereUuid($id)->first();
        $media = GenerateAgreement::where('media',$this->idMedia->id)->first();
        $this->nomMinistre = $media->nomMinistre ??null;
        $this->genreMinistre = $media->genreMinistre ??null;
        $this->projet_agrement = $media->projet_agrement ??null;
        $this->isEdit = $media ? true :false;
    }

    public function terminerBtn(){
        return $this->redirect('/liste-medias');
    }

    public function genererAgrement()
    {
        $validateArr = [
            "genreMinistre"=>"required",
            "nomMinistre"=>"required",
        ];

        $this->validate($validateArr);
        $agreement = GenerateAgreement::where('media', $this->media->id)->first();

        if($agreement) {
            $oldPath = substr_replace($agreement->document, 'public', 0, strlen('/storage'));
            Storage::delete($oldPath);
        }

        $data = [
            'imagePath'    => public_path('dist/img/momo.png'),
            'pathArmoirie' => convertBase64('public/assets/dist/img/armoirie.png'),
            'pathBranding' => convertBase64('public/assets/dist/img/branding.jpg'),
            'flag_guinnea' => convertBase64('public/assets/dist/img/flag_guinea.png'),
            'media' => $this->idMedia,
            'date' => date('d-m-Y'),
            'nomMinistre' => $this->nomMinistre,
            'genreMinistre' => $this->genreMinistre,
            'projet_agrement' => $this->projet_agrement,
        ];

        $pdf = null;
        if($this->projet_agrement==null){
            $pdf = PDF::loadView('template_documents.projet_agreement_copy',$data);

        }else{
            $pdf = PDF::loadView('template_documents.projet_agreement',$data);
        }
        utf8_decode($pdf->output());

        $content = $pdf->setPaper('a4')->download()->getOriginalContent();
        $pdf->set_option("isPhpEnabled", true);
        $path = 'projet_agreement/'. time().'projet_agreement.pdf';
        Storage::put('public/' . $path, $content);

        if($agreement){
            $agreement = GenerateAgreement::find($agreement->id);
            $agreement->media = $this->media->id;
            $agreement->nomMinistre = $this->nomMinistre;
            $agreement->genreMinistre = $this->genreMinistre;
            $agreement->document = "/storage/" . $path;
            $agreement->projet_agrement = $this->projet_agrement;
            $agreement->update();

            $this->dispatchBrowserEvent("showSuccessMessage", [
                "is_valided" => true,
                "message" => "Projet d'agreement a été edité avec succès"
             ]);
             $this->isEdit = true;
        }else{
            $agreement = new GenerateAgreement();
            $agreement->media = $this->media->id;
            $agreement->nomMinistre = $this->nomMinistre;
            $agreement->genreMinistre = $this->genreMinistre;
            $agreement->document = "/storage/" . $path;
            $agreement->projet_agrement = $this->projet_agrement;
            $agreement->save();
            $this->isEdit = true;
            // $this->redirect('/edit-projet-agrement/'.$agreement->id);
            $this->dispatchBrowserEvent("showSuccessMessage", [
                "is_valided" => true,
                "message" => "Projet d'agreement a été edité avec succès"
            ]);


        }
    }

    public function showProjetAgrement($id)
    {
        $this->projetAgrementNoSigne = GenerateAgreement::where('media',$id)->first();
    }

    public function render()
    {
        if(!hasPermission('editer_projet_agrement')){
            $this->redirect("/page-not-permission");
        }
        $this->media = Media::find($this->idMedia->id??null);
        $this->agrement = GenerateAgreement::where('media', $this->idMedia->id)->first();
        $this->isEdit = $this->agrement ? true :false;
        return view('medias.medias.etudes.edit_projet_agrement')
            ->extends("layouts.default", ['title' => 'Médias'])
            ->section("content");
    }
}
