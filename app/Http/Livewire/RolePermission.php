<?php

namespace App\Http\Livewire;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;

class RolePermission extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";
    public $currentPage = PAGELISTE;
    public $showEditForm = false;

    public $isAdd = false;
    public $isAddPermission =false;
    public $nom;
    public $search = "";
    public $editRole = [];
    public $rolePermissions = [];
    public $selectPermisions;
    public $rolePermis;

    protected $listeners = ['selectDate'=>'getSelectPermisions'];

    // public function getSelectPermisions($perms)
    // {
    //     $this->selectPermisions = $perms;

    // }

    public function AdminAuthCheck()
    {
        if(Auth::guard()->check()){
            return;
        }else{
            return redirect('/login');
        }
    }

    protected function rules () {
        if($this->currentPage = PAGEPERMISSION)
        {
            return [
                'editRole.nom' => ['required', 'nom', Rule::unique("role", "nom")->ignore($this->editRole['id'])],
            ];
        }

    }

    public function updatePermi()
    {
    }

    public function goToPermissionUser($id)
    {
        $this->AdminAuthCheck();
        $this->currentPage = PAGEPERMISSION;
        $this->editRole = Role::find($id)->toArray();
        $this->populateRolePermissions();

    }

    public function populateRolePermissions(){
        $this->AdminAuthCheck();
        $this->rolePermissions["permissions"] = [];

        $mapForCB = function($value){
            return $value["id"];
        };

        $permissionIds = array_map($mapForCB, Role::find($this->editRole["id"])->permissions->toArray());

        foreach(Permission::all() as $permission){
            if(in_array($permission->id, $permissionIds)){
                array_push($this->rolePermissions["permissions"], ["id"=>$permission->id, "permission_nom"=>$permission->nom, "description"=>json_decode($permission->description), "active"=>true]);
            }else{
                array_push($this->rolePermissions["permissions"], ["id"=>$permission->id, "permission_nom"=>$permission->nom,"description"=>json_decode($permission->description), "active"=>false]);
            }
        }
    }

    public function updateRoleAndPermissions(){
        $this->AdminAuthCheck();


        // $pos = array_search($this->selectPermisions, $this->selectPermisions);

        // if($pos !== false) {
        //   unset($this->selectPermisions[$pos]);
        // }else{
        //    $result = array_push($this->selectPermisions,$this->selectPermisions);
        // }



        // DB::table("rolePermission")->where("role_id", $this->editRole["id"])->delete();

        // foreach($this->rolePermissions["permissions"] as $permission){
        //     if($permission["active"]){
        //         Role::find($this->editRole["id"])->permissions()->attach($permission["id"]);
        //     }
        // }

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"permissions mis à jour avec succès!"]);
    }

    public function goToListUtilisateur()
    {
        $this->AdminAuthCheck();
        $this->currentPage = PAGELISTE;
    }

    public function goToRoles()
    {
        $this->currentPage = PAGELISTE;
    }

    public function render()
    {
        $this->AdminAuthCheck();
        $roleQuery = Role::query();
        $cart = array();
        $this->rolePermis = array_push($cart,$this->selectPermisions);
        // dump($resu);

        if($this->search != ""){
            $roleQuery->where("nom", "LIKE",  "%". $this->search ."%");
        }
        $data = [
            'roles'=> $roleQuery->latest()->paginate(50),
        ];

        return view('gestionRolePermissions.index', $data)
            ->extends("layouts.default",['title'=>"Gestion des roles"])
            ->section("content");
    }

    public function isShowAdd(){
        $this->AdminAuthCheck();
        $this->isAdd = true;
    }

    public function isShowAddPermission()
    {
        $this->AdminAuthCheck();
        $this->isAddPermission = true;
    }

    public function closeForm()
    {
        $this->AdminAuthCheck();
        $this->isAdd = false;
    }

    public function closeFormPermission()
    {
        $this->AdminAuthCheck();
        $this->isAddPermission = false;
    }

    public function closeModal(){
        $this->AdminAuthCheck();
        $this->dispatchBrowserEvent("closeModal");
    }

    public function ajoutRole()
    {
        $this->AdminAuthCheck();
        $validateArr = [
            "nom" => "required|unique:role"
        ];
        $this->validate($validateArr);
        $role = new Role();
        $role->nom = $this->nom;

        $role->save();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"role crée avec succès!"]);

        $this->nom ="";

    }

    public function ajoutPermission()
    {
        $this->AdminAuthCheck();
        $validateArr = [
            "nom" => "required|unique:permission"
        ];
        $this->validate($validateArr);
        $permission = new Permission();
        $permission->nom = $this->nom;

        $permission->save();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"permission crée avec succès!"]);

        $this->nom ="";
    }

}
