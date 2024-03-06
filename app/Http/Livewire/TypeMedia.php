<?php

namespace App\Http\Livewire;

use App\Models\CahierDeCharge;
use App\Models\TypeMedia as ModelsTypeMedia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class TypeMedia extends Component
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
    public $description;
    public $search = "";
    public $editType = [];
    public $cahierDeCharge;

    protected function rules () {
        if($this->currentPage == PAGEEDITFORM)
        {
            return [
                'editType.nom' => ['required', 'nom', Rule::unique("type_media", "nom")->ignore($this->editType['id'])],
            ];
        }

    }

    public function render()
    {
        if(!hasPermission('afficher_type_media')){
            $this->redirect("/page-not-permission");
        }

        $roleQuery = ModelsTypeMedia::query();

        if($this->search != ""){
            $roleQuery->where("nom", "LIKE",  "%". $this->search ."%")
            ->where('is_deleted','=','0');
        }

        $data = [
            'typeMedia'=> $roleQuery->latest()->paginate(50),
        ];

        return view('parametrage.media.index', $data)
            ->extends("layouts.default",['title'=>'Gestion des Types de Média'])
            ->section("content");
    }

    public function getTypeMedia($id)
    {
        $this->AdminAuthCheck();
        $this->editType = ModelsTypeMedia::find($id)->toArray();
    }

    public function save()
    {
        $this->AdminAuthCheck();
        $validateArr = [
            "nom" => "required|unique:type_media",
            "cahierDeCharge" => "required|mimes:pdf"
        ];
        $this->validate($validateArr);
        $type = new ModelsTypeMedia();
        $type->nom = $this->nom;
        $type->is_deleted = 0;
        $type->description = $this->description;

        $type->save();



        //Enregistrement du cahier de charge
        $fileName = time().'_'.$this->cahierDeCharge->getClientOriginalName();
        $filePath = $this->cahierDeCharge->storeAs('docs_cahier_charge', $fileName, 'public');

        $cahierDeCharge = new CahierDeCharge();
        $cahierDeCharge->nom = "/storage/" . $filePath;
        $cahierDeCharge->isCurrent = true;
        $cahierDeCharge->type_media_id = $type->id;
        $cahierDeCharge->save();
        CahierDeCharge::where('type_media_id', $type->id)
            ->where('id','!=', $cahierDeCharge->id)
            ->update(['isCurrent'=>false]);

        $this->nom ="";
        $this->description ="";
        $this->cahierDeCharge = "";

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Type de media crée avec succès!"]);



    }

    public function confirmDeleteTypeMedia($id){
        $this->AdminAuthCheck();
        $this->dispatchBrowserEvent("showConfirmMessageDeleteTypeMedia", ["message"=> [
            "text" => "Vous êtes sur le point de supprimer cet type de media. Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "id" => $id,
        ]]);
    }

    public function deleteTypeMedia($id){
        $this->AdminAuthCheck();
        $TYPE = ModelsTypeMedia::find($id);
        $TYPE->is_deleted = 1;
        $TYPE->update();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Suppression effectué avec succès!"]);
    }

    public function updateTypeMedia(){
        $this->AdminAuthCheck();
        ModelsTypeMedia::find($this->editType["id"])->update($this->editType);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Utilisateur mis à jour avec succès!"]);
        $this->dispatchBrowserEvent("closeModal");
    }


}
