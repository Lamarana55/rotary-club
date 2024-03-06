<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        if(request('terme') != null){
            $roles = Role::where('nom', 'like', '%'.request('terme'). '%')->paginate(10);
            return response()->json([
                'roles'=>$roles,
            ]);
        }else{
            return $this->refresh();
        }
    }


    public function refresh()
    {
        return response()->json([
            'status'=>true,
            'roles'=> Role::latest()->paginate(10)
        ]);
    }

    public function roleRelation()
    {
        return response()->json(Role::all());
    }

    public function save(RoleRequest $request)
    {
        $role = new Role();
        $role->nom = strtoupper($request->nom);
        $result = $role->save();
        if($result){
            $roles = Role::orderBy('created_at', 'DESC')->paginate(10);
            return response()->json($roles);
        }else{
            return response()->json([
                'message' => 'Erreur',
            ], 422);
        }
    }

    public function edit($id)
    {
        $role = Role::find($id);
        return response()->json($role);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'nom' => 'required|unique:role,nom,'.$id.',id_role',
        ])->validate();

        $role = Role::find($id);
        $role->nom = strtoupper($request->nom);
        $result = $role->update();
        if($result){
            $roles = Role::orderBy('created_at', 'DESC')->paginate(10);
            return response()->json($roles);
        }else{
            return response()->json([
                'message' => 'Erreur',
            ], 422);
        }
    }

    public function assignRole(Request $request)
    {
        $this->validate($request, [
            'permission' => 'required',
            'id' => 'required',
        ]);
        return Role::where('id_role', $request->id)->update([
            'permission' => $request->permission,
        ]);
    }
}