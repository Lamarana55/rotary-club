<?php

namespace App\Http\Livewire;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AsignationRolePermission extends Component
{
    public $rolePermissions = [];
    public $selectPermisions = [];
    public $select =[];
    public $editRole =[];
    public $role;



    public function mount($id)
    {
        $this->role = Role::whereUuid($id)->first()->id??null;
        $this->populateRolePermissions($this->role);
        $this->checkPermissions($this->role);
    }

    public function updateRoleAndPermissions($value)
    {
        $exit= DB::table('rolePermission')->where('role_id',$this->role)->where('permission',$value)->first();

        if($exit){
            DB::table("rolePermission")->where("role_id", $this->role)->where('permission',$value)->delete();
        }else{
            DB::table('rolePermission')->insert([
                'role_id'=>$this->role,
                'permission'=>$value
            ]);
        }
    }

    function checkPermissions($permission){
        return DB::table('rolePermission')->where('role_id',$this->role)->where('permission',$permission)->first();
    }

    public function populateRolePermissions($id){
        $this->rolePermissions["permissions"] = [];

        $mapForCB = function($value){
            return $value["id"];
        };

        $permissionIds = array_map($mapForCB, Role::find($id)->role_permissions->toArray());
        foreach(Permission::all() as $permission){
            if(in_array($permission->id, $permissionIds)){
                array_push($this->rolePermissions["permissions"], ["id"=>$permission->id, "nom"=>$permission->nom, "description"=>json_decode($permission->description), "active"=>true]);
            }else{
                array_push($this->rolePermissions["permissions"], ["id"=>$permission->id, "nom"=>$permission->nom, "description"=>json_decode($permission->description), "active"=>true]);
            }
        }
    }

    public function render()
    {
        if(!hasPermission('assignation_permission')){
            $this->redirect("/page-not-permission");
        }

        return view('gestionRolePermissions.permission')
            ->extends("layouts.default",['title'=>"Gestion des roles"])
            ->section("content");
    }


    public function updateRoleAndPermission($id){
        // DB::table("rolePermission")->where("role_id", $id)->delete();
        dump($this->selectPermisions);
        foreach($this->selectPermisions as $permission){
            dump($permission);
            // if($permission){
            //     DB::table('rolePermission')->insert([
            //         'role_id'=>$id,
            //         'permission'=>$permission
            //     ]);
            // }
        }



        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"permissions mis à jour avec succès!"]);
    }
}
