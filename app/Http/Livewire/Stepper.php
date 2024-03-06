<?php

namespace App\Http\Livewire;

use App\Models\Stepper as ModelsStepper;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Stepper extends Component
{
    use WithPagination;
    use WithFileUploads;
    public function AdminAuthCheck()
    {
        if(Auth::guard()->check()){
            return;
        }else{
            return redirect('/login');
        }
    }

    protected $paginationTheme = "bootstrap";
    public $currentPage = PAGELISTE;
    public $nom;
    public $level;
    public $description;
    public $search = "";
    public $editStepper = [];
    public $cahierDeCharge;

    protected function rules () {
        if($this->currentPage == PAGEEDITFORM)
        {
            return [
                'editStepper.nom' => ['required', 'nom', Rule::unique("stepper", "nom")->ignore($this->editStepper['id'])],
            ];
        }

    }

    public function render()
    {
        $this->AdminAuthCheck();
        $roleQuery = ModelsStepper::query();

        if($this->search != ""){
            $roleQuery->where("nom", "LIKE",  "%". $this->search ."%");
        }

        $data = [
            'stepper'=> $roleQuery->latest()->paginate(50),
        ];

        return view('parametrage.stepper.index', $data)
            ->extends("layouts.default",['title'=>'Gestion des Steppers'])
            ->section("content");
    }

    public function getStepper($id)
    {
        $this->AdminAuthCheck();
        $this->editStepper = ModelsStepper::find($id)->toArray();
    }

    public function save()
    {
        $this->AdminAuthCheck();
        $validateArr = [
            "nom" => "required|unique:stepper",
            "level" => "required|unique:stepper"
        ];
        $this->validate($validateArr);
        $type = new ModelsStepper();
        $type->nom = $this->nom;
        $type->level = $this->level;
        $type->description = $this->description;

        $type->save();

        $this->nom ="";
        $this->description ="";
        $this->level = "";

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Stepper crée avec succès!"]);
        $this->dispatchBrowserEvent("closeSaveStepper");


    }

    public function confirmDeleteStepper($id){
        $stepper= ModelsStepper::find($id);
        $this->dispatchBrowserEvent("showConfirmMessageDeleteStepper", ["message"=> [
            "text" => "Vous êtes sur le point de supprimer ce stepper $stepper->nom. Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "id" => $id,
        ]]);
    }

    public function deleteStepper($id){
        $this->AdminAuthCheck();
        $TYPE = ModelsStepper::find($id);
        $TYPE->update();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Suppression effectué avec succès!"]);
    }

    public function updateStepper(){
        $this->AdminAuthCheck();
        ModelsStepper::find($this->editStepper["id"])->update($this->editStepper);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Utilisateur mis à jour avec succès!"]);
        $this->dispatchBrowserEvent("closeEditStepper");
    }

}