<?php

namespace App\Http\Livewire;

use App\Mail\EmailActiveCompteUser;
use App\Models\Role;
use App\Models\TypePromoteur;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;

class Utilisateurs extends Component
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
    public $showEditForm = false;

    public $isAdd = false;
    public $nom;
    public $prenom;
    public $adresse;
    public $telephone;
    public $role;
    public $email;
    public $genre;
    public $valide_compte;
    public $search = "";
    public $filter = "";
    public $editUser = [];

    protected function rules () {
        if($this->currentPage == PAGEEDITFORM)
        {
            return [
                'editUser.email' => ['required', 'email', Rule::unique("user", "email")->ignore($this->editUser['id'])],
                'editUser.telephone' => ['required', 'numeric', Rule::unique("user", "telephone")->ignore($this->editUser['id'])],
                'editUser.prenom' => 'required',
                'editUser.nom' => 'required',
                'editUser.adresse' => 'required',
                //'editUser.genre' => 'required',
                'editUser.role_id'=>'required|exists:role,id',
            ];
        }

    }

    public function render()
    {
        $this->AdminAuthCheck();
        $userQuery = User::query();

        if($this->search != ""){
            $userQuery->where(function ($query) {
                $query->orWhere("prenom", "LIKE",  "%". $this->search ."%")
                ->orWhere("nom","LIKE","%". $this->search ."%")
                ->orWhere("email","LIKE","%". $this->search ."%")
                ->orWhere("telephone","LIKE","%". $this->search ."%")
                ->orWhere("genre","LIKE","%". $this->search ."%");
            });


        }

        if($this->filter !=""){
            $userQuery->where("role_id",$this->filter);
        }

        if($this->filter !="" && $this->search != ""){

            $userQuery->where(function ($query) {
                $query->Where("role_id",$this->filter)
                ->orWhere("nom", "LIKE",  "%". $this->search ."%")
                ->orWhere("prenom","LIKE","%". $this->search ."%")
                ->orWhere("email","LIKE","%". $this->search ."%")
                ->orWhere("telephone","LIKE","%". $this->search ."%")
                ->orWhere("genre","LIKE","%". $this->search ."%");
            });


        }

        $data = [
            'users'=> $userQuery->where("is_deleted",false)->latest()->paginate(50),
            'roles'=> Role::all(),
            'categoriesPromoteur' => TypePromoteur::all()
        ];

        return view('utilisateurs.index', $data)
            ->extends("layouts.default",['title'=>'Gestion des utilisateurs'])
            ->section("content");
    }

    public function goToListUtilisateur()
    {
        $this->AdminAuthCheck();
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
        $this->genre = null;
        $this->role = null;
        $this->dispatchBrowserEvent("showModal",[]);
    }

    public function ajoutUser()
    {
        $this->AdminAuthCheck();
        $phone_number = preg_match('/^[0-9]{9,9}$/',$this->telephone);
        $validateArr = [
            "email" => "string|required|email|unique:user,email",
            "telephone" => "required|numeric|unique:user,telephone",
            "prenom" => "required",
            'role'=>'required|exists:role,id',
            "nom" => "required",
            //"genre" => "required",
        ];
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
        $user->telephone = $this->telephone;
        $user->password = Hash::make('1234');
        //$user->genre = $this->genre;
        $user->is_deleted = 0;
        $user->photo = "1675436822.jpg";
        $user->uuid = Str::uuid();

        $user->save();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Utilisateur crée avec succès!"]);

        $this->currentPage = PAGELISTE;

    }

    public function goToEditUser($id)
    {
        $this->AdminAuthCheck();
        $this->currentPage = PAGEEDITFORM;
        $this->editUser = User::with('role')->find($id)->toArray();
    }

    public function goToDetailUser($id){
        $this->AdminAuthCheck();
        $this->currentPage = PAGEDETAILFORM;
        $this->editUser = User::with('role','media')->find($id)->toArray();
    }

    public function updateUser(){
        $this->AdminAuthCheck();
        User::find($this->editUser["id"])->update($this->editUser);


        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Utilisateur mis à jour avec succès!"]);
        $this->currentPage = PAGELISTE;
    }

    public function confirmDeleteUser($id){
        $this->AdminAuthCheck();
        $this->dispatchBrowserEvent("showConfirmMessageDeleteUser", ["message"=> [
            "text" => "Vous êtes sur le point de supprimer cet utilisateur. Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "id" => $id,
        ]]);
    }

    public function deleteUser($id){
        $this->AdminAuthCheck();
        $user = User::find($id);
        $user->is_deleted = 1;
        $user->update();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Suppression effectué avec succès!"]);
    }

    public function confirmPwdReset($id){
        $this->AdminAuthCheck();
        $this->dispatchBrowserEvent("showConfirmMessage", ["message"=> [
            "text" => "Vous êtes sur le point de réinitialiser le mot de passe de cet utilisateur. Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "id"=>$id,
        ]]);
    }

    public function resetPassword($id){
        $this->AdminAuthCheck();
        User::find($id)->update(["password" => Hash::make(DEFAULTPASSOWRD)]);

        $date1 = Carbon::createFromFormat('d-m-Y H:i:s',Carbon::now()->format("d-m-Y H:i:s"));

        $token_update_password = Str::upper(Str::random(9));

        $user = User::find($id);
        $user->token_update_password = $token_update_password;
        $user->date_validated_token_password = $date1;
        $user->update();

        $url = request()->getSchemeAndHttpHost()."/get_new_password_user_active/".$token_update_password;
        // dd($user);
        send_notification(
            $user,
            "reinitialisation du mot de passe",
            message_email("reinitialisation_password"),
            null,
            $url,
            1
        );

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Mot de passe utilisateur réinitialisé avec succès!"]);
    }

    public function valideUser($id,$isValid)
    {
        $res = ($isValid)?false:true;
        $user = User::find($id);
        $user->isvalide = $res;
        $user->save();
        //========================
        if (!$isValid) {
            $date1 = Carbon::createFromFormat('d-m-Y H:i:s',Carbon::now()->format("d-m-Y H:i:s"));

            $token_update_password = Str::upper(Str::random(9));

            $user = User::find($id);
            $user->token_update_password = $token_update_password;
            $user->date_validated_token_password = $date1;
            $user->save();

            $url = request()->getSchemeAndHttpHost()."/get_new_password_user_active/".$token_update_password;
        }

        $this->currentPage = PAGELISTE;
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Opération effectuée avec succès"]);
    }

    public function showConfirmMessageValider($id)
    {
        $this->AdminAuthCheck();
        $this->dispatchBrowserEvent("showConfirmMessageActiveUser", ["message"=> [
            "text" => "Vous êtes sur le point de active cet utilisateur supprimer. Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "id"=>$id,
        ]]);
    }

    public function showConfirmMessageActiveUser($id)
    {
        $this->AdminAuthCheck();
        $this->dispatchBrowserEvent("showConfirmMessageActiveUser", ["message"=> [
            "text" => "Vous êtes sur le point de active cet utilisateur supprimer. Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "id"=>$id,
        ]]);
    }

    public function showConfirmMessageActiveValider($id,$isValid)
    {
        $this->AdminAuthCheck();

        $this->dispatchBrowserEvent("showConfirmMessageActiveValider", ["message"=> [
            "text" => ($isValid==1) ? 'Voulez-vous desactiver ce compte?':'Voulez-vous activer ce compte?',
            "title" => "Confirmation",
            "type" => "warning",
            "isValid" => $isValid,
            "id"=>$id,
        ]]);
    }

    public function activeUser($id)
    {
        $user = User::find($id);
        $user->is_deleted = 0;
        $user->save();
        $this->currentPage = PAGELISTE;
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Opération effectuée avec succès"]);
    }

     public function modalvalideCompte($iduser)
    {
        $this->dispatchBrowserEvent("showvalideCompte", ["message"=> [
            "text" => 'Voulez-vous activer ce compte?',
            "title" => "Confirmation",
            "type" => "warning",
            "id"=>$iduser,
        ]]);
    }
    public function valideCompteUser($id)
    {
        $user = User::find($id);
        $user->valide_compte = true;
        $user->update();

        $date1 = Carbon::createFromFormat('d-m-Y H:i:s',Carbon::now()->format("d-m-Y H:i:s"));

        $token_update_password = Str::upper(Str::random(9));

        $user = User::find($id);
        $user->token_update_password = $token_update_password;
        $user->date_validated_token_password = $date1;
        $user->update();

        $url = request()->getSchemeAndHttpHost()."/get_new_password_user_active/".$token_update_password;
        // if(config("app.env")== 'local'){
        // }else{
        //     send_notification($user, "Activation de compte",message_email("activation_compte"), null,$url,1);
        // }
        send_notification($user, "Activation de compte",message_email("activation_compte"), null,$url,1);



        $this->currentPage = PAGELISTE;
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Opération effectuée avec succès"]);

    }

}