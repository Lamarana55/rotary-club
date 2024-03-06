<?php

namespace App\Http\Livewire;

use App\Models\Role;
use App\Models\TypePromoteur;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AddUtilisateur extends Component
{
    protected $paginationTheme = "bootstrap";
    public $currentPage = PAGELISTE;
    public $showEditForm = false;

    public $isAdd = false;
    public $nom;
    public $prenom;
    public $adresse;
    public $telephone;
    public $role;
    public $categoriePromoteur;
    public $email;
    public $search = "";
    public $filter = "";
    public $editUser = [];


    public function AdminAuthCheck()
    {
        if(Auth::guard()->check()){
            return;
        }else{
            return redirect('/login');
        }
    }


    public function render()
    {
        if(!hasPermission('créer_utilisateur')){
            $this->redirect("/page-not-permission");
        }

        $data = [
            'roles'=> Role::all(),
            'categoriesPromoteur' => TypePromoteur::all()
        ];

        return view('utilisateurs.add', $data)
            ->extends("layouts.default",['title'=>'Ajouter un utilisateur'])
            ->section("content");
    }

    public function goToListUtilisateur()
    {
        $this->currentPage = PAGELISTE;
    }

    public function showAddUserModal(){
        $this->currentPage = PAGECREATEFORM;
        $this->resetValidation();
        $this->nom = null;
        $this->prenom = null;
        $this->email = null;
        $this->telephone = null;
        $this->adresse = null;
        $this->role = null;
        $this->categoriePromoteur =  null;
        $this->dispatchBrowserEvent("showModal",[]);
    }

    public function ajoutUser()
    {
        $phone_number = preg_match('/^[0-9]{9,9}$/',$this->telephone);
        $validateArr = [
            "email" => "string|required|email|unique:user,email",
            "telephone" => "required|numeric|unique:user,telephone",
            "prenom" => "required",
            'role'=>'required|exists:role,id',
            "nom" => "required",
        ];

        if($this->role == 2) {
            $validateArr['categoriePromoteur'] = 'required|exists:type_promoteur,id';
        }
        // Validation des erreurs
        $this->validate($validateArr);

        if(!$phone_number){
            return $this->dispatchBrowserEvent("showErrorMessage", ["message"=>"Le champ telephone incorrect"]);
        }

        $user = new User();

        $user->nom = $this->nom;
        $user->prenom = $this->prenom;
        $user->adresse = $this->adresse;
        $user->email = $this->email;
        $user->role_id = $this->role;
        if($this->role == 2) {
            $user->type_promoteur_id = $this->categoriePromoteur;
        }
        $user->telephone = $this->telephone;
        $user->password = Hash::make('1234');
        $user->is_deleted = 0;
        $user->photo = "1675436822.jpg";
        $user->uuid = Str::uuid();

        $user->save();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Utilisateur crée avec succès!"]);
        $this->nom = null;
        $this->prenom = null;
        $this->email = null;
        $this->telephone = null;
        $this->adresse = null;
        $this->role = null;

    }


}
