<?php

namespace App\Http\Livewire;

use App\Gestions\GestionDelaisTraitement;
use App\Models\DelaisTraitement;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class GestionDelaisTraitementComponent extends Component
{
    public $etape;
    public $delais;
    public $unite;
    public $search;
    public $delaisId;

    public function render()
    {
        if(!hasPermission('afficher_delai_traitement')){
            $this->redirect("/page-not-permission");
        }

        $delais_traitements = DelaisTraitement::where('is_deleted',false)->orderBy('created_at', 'DESC')->paginate(20);
        $data = [
            "delais_traitements" => $delais_traitements,
        ];
        return view('parametrage.delais_traitements.index', $data)
            ->extends("layouts.default")->section("content");
    }

    public function store(){
        $this->validate([
            'etape'=>'required',
            'delais'=>'required|numeric',
            'unite'=>'required'
        ]);

        $delais = DelaisTraitement::whereEtape($this->etape)->where('is_deleted',false)->first();
        if($this->delaisId){
            if($delais && $delais->id !=$this->delaisId){return throw ValidationException::withMessages(['etape' => 'Cette etape existe déjà']);}
        }else{
            if($delais){return throw ValidationException::withMessages(['etape' => 'Cette etape existe déjà']);}
        }
        $gestion = new GestionDelaisTraitement();
        $gestion->save_delais_traitement($this);
        $this->dispatchBrowserEvent("closeModal");
        $this->reset();
        $this->resetValidation();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Opération effectuée avec succès!"]);
    }

    public function getDelaisTraitement($id){
        $delais = DelaisTraitement::find($id);
        $this->etape = $delais->etape??null;
        $this->delais = $delais->delais??null;
        $this->unite = $delais->unite??null;
        $this->delaisId = $delais->id??null;
    }

    public function fermer(){
        $this->reset();
        $this->resetValidation();
    }

    function deleteConfirmation($id){
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer cet delais de traitement <br> Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "id" => $id,
        ]]);
    }

    function delete($id){
        $delais = DelaisTraitement::find($id);
        $delais->is_deleted=true;
        $delais->update();
        $this->dispatchBrowserEvent("showErrorMessage", ["message" => "Opération effectuée avec succès!"]);
    }
}
