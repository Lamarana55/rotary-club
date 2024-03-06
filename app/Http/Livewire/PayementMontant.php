<?php

namespace App\Http\Livewire;

use App\Models\ParametrePaiement;
use Livewire\Component;
use Livewire\WithPagination;

class PayementMontant extends Component
{
    use WithPagination;


    protected $paginationTheme = "bootstrap";
    public $currentPage = PAGELISTE;
    public $nom;
    public $description;
    public $type_media;
    public $montant;
    public $editMontant = [];
    public $is_affiche_historique = false;
    public $montantQuery ;
    protected $historiques = [];
    public $type_historique;

    protected function rules () {
        if($this->currentPage == PAGEEDITFORM)
        {
            return [
                'editMontant.nom' => ['required'],
                'editMontant.montant'=>'required'
            ];
        }

    }
    public function mount()
    {
        $this->historiques = ParametrePaiement::where('nom',$this->type_historique)->latest()->paginate(30);
    }
    public function render()
    {
        if(!hasPermission('afficher_montant_paiement')){
            $this->redirect("/page-not-permission");
        }

        $data_cahier_charge = ParametrePaiement::where('nom','cahier_de_charge')->latest()->first();
        $data_frais_agrement = ParametrePaiement::where('nom','frais_agrement')->where('type_media_id','Radio')->latest()->first();
        $data_frais_agrement2 = ParametrePaiement::where('nom','frais_agrement')->where('type_media_id','Télévision')->latest()->first();
        if($this->type_historique){
            $this->historiqueAgrement($this->type_historique);
        }
        $data = [
            'historiques' => $this->historiques,
            'data_cahier_charge' => $data_cahier_charge,
            'data_frais_agrement2' => $data_frais_agrement2,
            'data_frais_agrement' => $data_frais_agrement
        ];

        return view('parametrage.paiements.index', $data)
            ->extends("layouts.default",['title'=>'Gestion des frais à payer'])
            ->section("content");
    }

    public function getMontant($id)
    {
        $this->editMontant = ParametrePaiement::find($id)->toArray();
    }

    public function save()
    {
        $validateArr = [
            "nom" => "required",
            "montant"=>"required"
        ];

        if($this->nom =='frais_agrement'){
            $validateArr['type_media']='required';
        }
        $this->validate($validateArr);

        $type = new ParametrePaiement();
        $type->nom = $this->nom;
        $type->type_media_id = $this->type_media;
        $type->montant = str_replace(' ', '', $this->montant);
        $type->is_deleted = 0;
        $type->description = $this->description;

        $type->save();

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Montant du paiement crée avec succès!"]);

        $this->type_media ="";
        $this->nom ="";
        $this->description ="";
        $this->montant ="";

    }

    public function confirmDeleteMontant($id){
        $this->dispatchBrowserEvent("showConfirmMessageDeleteMontant", ["message"=> [
            "text" => "Vous êtes sur le point de supprimer cet type de media. Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "id" => $id,
        ]]);
    }

    public function deleteMontant($id){
        $type = ParametrePaiement::find($id);
        $type->is_deleted = 1;
        $type->update();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Suppression effectué avec succès!"]);
    }

    public function updateMontant(){
        ParametrePaiement::find($this->editMontant["id"])->update($this->editMontant);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Utilisateur mis à jour avec succès!"]);
        $this->dispatchBrowserEvent("closeModal");
    }

    public function historique($type_historique)
    {
        $this->type_historique = $type_historique;
        $this->historiques = ParametrePaiement::where('nom',$this->type_historique)->latest()->paginate(30);
        $this->is_affiche_historique = true;
    }

    public function historiqueAgrement($type_historique)
    {
        $this->type_historique = $type_historique;
        if($this->type_historique =='cahier_de_charge'){
            $this->historiques = ParametrePaiement::where('nom',$this->type_historique)->latest()->paginate(30);
            $this->is_affiche_historique = true;
        }else{
            $this->historiques = ParametrePaiement::whereNom('frais_agrement')->where('type_media_id',$this->type_historique)->latest()->paginate(30);
            $this->is_affiche_historique = true;
        }

    }

    public function fermer()
    {
        $this->type_historique=null;
        $this->is_affiche_historique = false;
    }

}
