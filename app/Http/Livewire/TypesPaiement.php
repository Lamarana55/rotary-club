<?php

namespace App\Http\Livewire;

use App\Models\TypePaiement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TypesPaiement extends Component
{
    use WithPagination;

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
    public $search = "";
    public $editTypePaiement = [];

    protected function rules () {
        if($this->currentPage == PAGEEDITFORM)
        {
            return [
                'editTypePaiement.nom' => ['required', 'nom', Rule::unique("type_paiement", "nom")->ignore($this->editTypePaiement['id'])],
            ];
        }

    }

    public function render()
    {
        if(!hasPermission('afficher_type_paiement')){
            $this->redirect("/page-not-permission");
        }
        $montantQuery = TypePaiement::query();

        if($this->search != ""){
            $montantQuery->where("nom", "LIKE",  "%". $this->search ."%");
        }

        $data = [
            'types'=> $montantQuery->latest()->paginate(50),
        ];

        return view('parametrage.types.index', $data)
            ->extends("layouts.default",['title'=>'Gestion des type de paiement'])
            ->section("content");
    }

    public function getTypePaiement($id)
    {
        $this->AdminAuthCheck();
        $this->editTypePaiement = TypePaiement::find($id)->toArray();
    }

    public function save()
    {
        $this->AdminAuthCheck();
        $validateArr = [
            "nom" => "required|unique:type_paiement",
        ];
        $this->validate($validateArr);
        $type = new TypePaiement();
        $type->nom = $this->nom;

        $type->save();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Type de paiement crée avec succès!"]);

        $this->nom ="";

    }

    public function confirmDeleteTypePaiement($id){
        $this->AdminAuthCheck();
        $this->dispatchBrowserEvent("showConfirmMessageDeleteTypePaiement", ["message"=> [
            "text" => "Vous êtes sur le point de supprimer cet type de paiement. Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "id" => $id,
        ]]);
    }

    public function deleteTypePaiement($id){
        $this->AdminAuthCheck();
        $type = typePaiement::find($id);
        //$type->delete();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Suppression effectué avec succès!"]);
    }

    public function updateTypePaiement(){
        $this->AdminAuthCheck();
        TypePaiement::find($this->editTypePaiement["id"])->update($this->editTypePaiement);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Utilisateur mis à jour avec succès!"]);
        $this->dispatchBrowserEvent("closeModal");
    }
}
