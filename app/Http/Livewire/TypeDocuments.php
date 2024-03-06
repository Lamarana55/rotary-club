<?php

namespace App\Http\Livewire;

use App\Models\DocumentTechnique;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TypeDocuments extends Component
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
    public $editDocument = [];

    protected function rules () {
        if($this->currentPage == PAGEEDITFORM)
        {
            return [
                'editDocument.nom' => ['required', 'nom', Rule::unique("document_technique", "nom")->ignore($this->editDocument['id'])],
            ];
        }

    }

    public function render()
    {
        if(!hasPermission('afficher_type_document')){
            $this->redirect("/page-not-permission");
        }

        $roleQuery = DocumentTechnique::query();

        if($this->search != ""){
            $roleQuery->where("nom", "LIKE",  "%". $this->search ."%")
            ->where('is_deleted','=','0');
        }

        $data = [
            'typeDocument'=> $roleQuery->where('is_deleted',0)->latest()->paginate(50),
        ];

        return view('parametrage.documents.index', $data)
            ->extends("layouts.default",['title'=>'Gestion des type de documents'])
            ->section("content");
    }

    public function getTypeDocument($id)
    {
        $this->editDocument = DocumentTechnique::find($id)->toArray();
    }

    public function save()
    {
        $validateArr = [
            "nom" => "required|unique:document_technique",
        ];
        $this->validate($validateArr);
        $type = new DocumentTechnique();
        $type->nom = $this->nom;
        $type->is_deleted = 0;
        $type->description = $this->description;

        $type->save();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Type de media crée avec succès!"]);

        $this->nom ="";
        $this->description ="";
    }

    public function confirmDeleteTypeDocument($id){
        $this->dispatchBrowserEvent("showConfirmMessageDeleteTypeDocument", ["message"=> [
            "text" => "Vous êtes sur le point de supprimer cet type de media. Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "id" => $id,
        ]]);
    }

    public function deleteTypeDocument($id){
        $TYPE = DocumentTechnique::find($id);
        $TYPE->is_deleted = 1;
        $TYPE->update();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Suppression effectué avec succès!"]);
    }

    public function updateTypeDocument(){
        DocumentTechnique::find($this->editDocument["id"])->update($this->editDocument);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Utilisateur mis à jour avec succès!"]);
        $this->dispatchBrowserEvent("closeModal");
    }
}
