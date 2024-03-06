<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\FormeJuridique as FormeJuridiqueModel;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class FormeJuridique extends Component
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
    public $description;
    public $search = "";
    public $editForme = [];

    protected function rules () {
        if($this->currentPage == PAGEEDITFORM)
        {
            return [
                'editForme.nom' => ['required', 'nom', Rule::unique("forme_juridique", "nom")->ignore($this->editForme['id_forme_juridique'])],
            ];
        }

    }

    public function render()
    {
        if(!hasPermission('afficher_forme_juridique')){
            $this->redirect("/page-not-permission");
        }

        $roleQuery = FormeJuridiqueModel::query();

        if($this->search != ""){
            $roleQuery->where("nom", "LIKE",  "%". $this->search ."%")
                ->where('is_deleted','=','0');
        }else{
            $roleQuery->where('is_deleted','=','0');
        }

        $data = [
            'forme_juridique'=> $roleQuery->latest()->paginate(30),
        ];

        return view('parametrage.forme_juridique.index', $data)
            ->extends("layouts.default",['title'=>'Gestion des formes juridiques'])
            ->section("content");
    }

    public function getFormeJuridique($id)
    {
        $this->editForme = FormeJuridiqueModel::find($id)->toArray();
    }

    public function save()
    {
        $validateArr = [
            "nom" => "required|unique:forme_juridique"
        ];
        $this->validate($validateArr);
        $type = new FormeJuridiqueModel();
        $type->nom = $this->nom;
        $type->is_deleted = 0;
        $type->description = $this->description;

        $type->save();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Forme Juridique crée avec succès!"]);

        $this->nom ="";
        $this->description ="";
        $this->dispatchBrowserEvent("closeSaveFormeJuridique");

    }

    public function confirmDeleteFormeJuridique($id){
        $forme_juridique = FormeJuridiqueModel::find($id);
        $this->dispatchBrowserEvent("showConfirmMessageDeleteFormeJuridique", ["message"=> [
            "text" => "Vous êtes sur le point de supprimer cet $forme_juridique->nom. Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "id" => $id,
        ]]);
    }

    public function deleteFormeJuridique($id){
        $type = FormeJuridiqueModel::find($id);
        $type->is_deleted = 1;
        $type->update();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Suppression effectué avec succès!"]);
        $this->dispatchBrowserEvent("closeModal");
    }

    public function updateFormeJuridique(){
        FormeJuridiqueModel::find($this->editForme["id"])->update($this->editForme);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Utilisateur mis à jour avec succès!"]);
        $this->dispatchBrowserEvent("closeEditFormeJuridique");
    }

}
