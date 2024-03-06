<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\RequestInsertionUser;
use App\Http\Requests\updatePassword;

class profileUtilisateur extends Controller
{
    public function profile(){

        $user = User::find(auth()->user()->id);
        $role = Role::orderBy('nom', 'asc')->get();

        // return view('users.details_user', compact('user', 'role'));
        return view('profile.profile', compact('user', 'role'));
    }

    public function calback(){
        return redirect("/");
    }

    public function updateProfile(){
        $user = User::find(auth()->user()->id);
        // dd($user);
        return view('profile.modificationProfile', compact('user'));
    }

    public function sauvegarderModificationProfil($id, RequestInsertionUser $request){
        $user = User::find($id);

        if(empty($request->photo)):
            $photo = $user->photo;
        else:
            $photo = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('photo_users'), $photo);
        endif;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->adresse = $request->adresse;
        $user->email = $request->email;
        $user->photo = $photo;
        $user->telephone = $request->telephone;
        $user->adresse = $request->adresse;
        $user->commune = $request->commune;
        $user->profession = $request->profession;
        $user->genre = $request->genre;


        $user->save();


        Alert::success('Modification', 'effectuee avec succes');

        return redirect()->route('profile')->with('success', "Modifier avec succès");
    }

    public function updatePasseword(){
        $user = User::find(auth()->user()->id);
        return view('profile.changerMotDePasse', compact('user'));
    }

    public function reinitialisationDuMotDePasse(updatePassword $request)
    {
        $user = User::find(auth()->user()->id);

        if(Hash::check($request->mdpActuel,$user->password)):
            if($request->password === $request->password_confirmation):
                $password = Hash::make($request->password_confirmation);
                $user->password = $password;
                $user->save();
                Alert::success('Mot de passe', 'Changement de mot passe éffectué avec succès');

                return redirect()->route('profile');
            else:
                Alert::error("Mot de passe","Erreur de conformitée du mot de passe");
                return redirect()->back();
            endif;
        else:
            Alert::error("Mot de passe","Le mot de passe actuel saisi ne figure pas dans nos donnée");
            return redirect()->back();
        endif;
    }
}
