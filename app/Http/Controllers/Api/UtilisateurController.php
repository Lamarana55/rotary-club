<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UtilisateurRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UtilisateurController extends Controller
{
    public function index()
    {
        if (request('terme') != '') {
            $users = User::where('nom', 'like', '%' . request('terme') . '%')
                ->orWhere('prenom', 'like', '%' . request('terme') . '%')
                ->orWhere('telephone', 'like', '%' . request('terme') . '%')
                ->orderBy('created_at', 'DESC')
                ->with('role')->paginate(30);
            return response()->json([
                'users' => $users,
            ]);
        } else {
            $users = User::orderBy('created_at', 'DESC')->with('role')->paginate(30);
            return response()->json($users);
        }
    }

    public function save(UtilisateurRequest $request)
    {
        $user = new User();
        $user->nom = $request->nom;
        $user->id_role = $request->role;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        $user->password = Hash::make('password');

        $result = $user->save();
        if ($result) {
            $users = User::orderBy('created_at', 'DESC')->with('role')->paginate(30);
            return response()->json($users);
        } else {
            return response()->json([
                'message' => 'Erreur',
            ], 422);
        }
    }

    public function edit($id)
    {
        return response()->json(User::find($id));
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'telephone' => 'required|unique:user,telephone,' . $id . ',id_user',
            'email' => 'required|unique:user,email,' . $id . ',id_user',
            'nom' => 'required',
            'prenom' => 'required',
        ])->validate();

        $user =  User::find($id);
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->telephone = $request->telephone;

        $result = $user->save();
        if ($result) {
            $users = User::orderBy('created_at', 'DESC')->with('role')->paginate(30);
            return response()->json($users);
        } else {
            return response()->json([
                'message' => 'Erreur',
            ], 422);
        }
    }

    public function updatePassword(Request $request)
    {

        $status = false;
        $data = auth('api')->user();
        if (Hash::check($request->ancien, $data->password)) {
            $status = true;
            $data->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return response()->json([
            "status" => $status,
            'message' => $status ? "Le mot de passe a été changé avec succès" : "Mot de passe invalide"
        ]);
    }

    public function updatePhoto(Request $request)
    {
        $id = auth('api')->user()->id_user;
        $user = User::find($id);
        if ($request->image == '') {
            return response()->json([
                'status' => 422,
                'message' => 'Veuillez selectioner une image'
            ]);
        } else {
            $exploded = explode(',', $request->image);
            $decoded = base64_decode($exploded[1]);
            if (Str::contains($exploded[0], 'jpeg')) {
                $extension = 'jpg';
            } elseif (Str::contains($exploded[0], 'png'))
                $extension = 'png';
            else {
                $extension = 'Format invalide';
                return response()->json([
                    'status' => 422,
                    'message' => "le format de l'image est invalide"
                ]);
            }

            if ($extension != 'Format invalide') {
                $fileName = Str::random(10) . '.' . $extension;
                $path = public_path() . '/profile-users/' . $fileName;
                file_put_contents($path, $decoded);

                $user->photo = $fileName;
                $user->save();
            }
        }
    }

}
