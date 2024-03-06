<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Media;
use App\Models\Message;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\regeneratePasswordUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\RequestInsertionUser;


class usersController extends Controller
{

    public function test(){
        // $message = Message::first();
        $ReceverHac = DB::table('user')
                    ->join('role','user.id_user','=','role.id')
                    ->select('email', 'role.nom','role.id')
                    ->where('is_deleted',0)
                    ->where('role.nom','HAC')
                    ->get();
    }
    /**
     * @method liste des utilisateurs (SELECT)
     * @param aucun parametres
     * @return une vues de liste des utilisateurs
     * @author Jean Pierre Lory TOLNO
     */
    public function liste_des_utilisateurs(Request $request){

        if($request->filled('search')):
            $valSearch = $request->search;

            $utilisateurs = DB::table('user')
                                ->join('role','user.role_id','=','role.id')
                                ->select('user.*','role.nom as roleNom')
                                ->where('user.nom','LIKE',"%{$valSearch}%")
                                ->orWhere('prenom','LIKE',"%{$valSearch}%")
                                ->orWhere('email','LIKE',"%{$valSearch}%")
                                ->orWhere('role.nom','LIKE',"%{$valSearch}%")
                                ->paginate(10);
        else:
            $utilisateurs= DB::table('user')
                ->join('role','user.role_id','=','role.id')
                ->select('user.*','role.nom as roleNom')
                ->where('role.nom','!=','Promoteur')
                ->paginate(10);
        endif;
      return view('users.liste', compact('utilisateurs'));

    }
    public function getDetailsUser($id){
        $user = User::find($id);
        $role = Role::orderBy('nom', 'asc')->get();

        return view('users.details_user', compact('user', 'role'));
    }
    public function getDetailsPromoteur($id){
        $user = User::find($id);
        $role = Role::orderBy('nom', 'asc')->get();
        $ajout = 1;

        return view('users.details_user', compact('user', 'role', 'ajout'));
    }
    /**
     * @method liste des promoteurs (SELECT)
     * @param aucun parametres
     * @return une vues de liste des utilisateurs
     * @author Jean Pierre Lory TOLNO
     */
    public function liste_des_promoteurs(Request $request){
        if($request->filled('search')):
            $valSearch = $request->search;

            $utilisateurs = DB::table('user')
                                ->join('role','user.role_id','=','role.id')
                                ->select('user.*','role.nom as roleNom')
                                ->where('user.nom','LIKE',"%{$valSearch}%")
                                ->orWhere('prenom','LIKE',"%{$valSearch}%")
                                ->orWhere('email','LIKE',"%{$valSearch}%")
                                ->paginate(10);
        else:
            $utilisateurs= DB::table('user')
                ->join('role','user.role_id','=','role.id')
                ->select('user.*','role.nom as roleNom')
                ->where('role.nom','=','Promoteur')
                ->paginate(10);
        endif;
        $promoteur = 1;
        // dd($utilisateurs);
        return view('users.liste', compact('utilisateurs', 'promoteur'));
    }
    /**
     * @method ajouter_un_utilisateurs (FORMULAIRE)
     * @param aucune valeur entrée de la method
     * @return Une vue qui est le formulaire d'ajout d'utilisateurs ainsi que tous les roles
     * @author Jean Pierre Lory TOLNO
     */
    public function ajouter_un_utilisateurs(){

        $role = Role::orderBy('nom', 'asc')->get();
        return view('users.form_add_user', compact('role'));

    }
    public function ajouter_un_promoteurs(){
        $promoteur = 1;
        return view('users.form_add_user', compact('promoteur'));
    }
    /**
     * @method insertion_des_donnees_utilisateurs (CREATE)
     * @param $data_user qui as pour type l'objet request de laravel qui controle les données envoiyés par l'utilisateurs
     * @return un message de creation avec success ou revien sur la page principale si il y a erreur de verification des donnees
     * @author Jean Pierre Lory TOLNO
     */
    public function insertion_des_donnees_utilisateurs(RequestInsertionUser $data_user){

            // if(empty($data_user->photo)):

            //     $photo = "1675436822.jpg.jpg";
            // else:
            //     $photo = time().'.'.$data_user->photo->extension();
            //     $data_user->photo->move(public_path('photo_users'), $photo);// $photo = Storage::disk('public')->put('photo_users', $data_user -> photo);
            // endif;

           User::create([
                'nom' => $data_user->nom,
                'prenom' => $data_user->prenom,
                'adresse' => $data_user->adresse,
                'role_id' => $data_user->role,
                'email' => $data_user->email,
                'is_deleted' => '0',
                'photo' => "1675436822.jpg",
                'telephone' => $data_user->telephone,
                'password' => Hash::make('1234'),
            ]);
            return redirect()->back()->with('success', 'Ajout effectué avec succes');


    }
    /**
     * @method forme_mofification (SELECT)
     * @param $id_user qui reçois en paramètres l'identifiant de l'utilisateur
     * @return la vue ainsi que tous les utilisateur et tous les roles
     * @author Jean Pierre Lory TOLNO
     */
    public function forme_mofification($id_user){

        $user = User::find($id_user);
        $role = Role::orderBy('nom', 'asc')->get();
        // dd($user);

        return view('users.form_update_user', compact('user', 'role'));

    }
    /**
     * @method modification_des_donnees_utilisateurs (UPDATE)
     * @param $id_user qui reçois en paramètres l'identifiant de l'utilisateur, et la variable $date_update_user pour controlle des donnees utilisateur
     * @return la vue et le message de succes si tous se passe bien ou returne les erreurs
     * @author Jean Pierre Lory TOLNO
     */
    public function modification_des_donnees_utilisateurs($id, RequestInsertionUser $request){
        $user = User::find($id);

        if(empty($request->photo)):
            $photo = $user->photo;
        else:
            // dd('okey');
            $photo = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('photo_users'), $photo);// $photo = Storage::disk('public')->put('photo_users', $data_user -> photo);
        endif;
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->adresse = $request->adresse;
        $user->role_id = $request->role;
        $user->email = $request->email;
        $user->photo = $photo;
        $user->telephone = $request->telephone;

        $user->save();

        return redirect()->route('affichage')->with('success', "Modifier avec succès");

    }
    /**
     * @method suppression_utilisateur (DELETE)
     * @param $id_user qui reçoie en parametre l'ID de l'element selectionné
     * @return la vue qui affiche la liste de tout les utilisateurs avec un message de suppression avec succes
     * @author Jean Pierre Lory TOLNO
     */
    public function suppression_utilisateur($id_user){

        $user = User::find($id_user);
        $user->is_deleted = 1;
        $user->save();

        return redirect()->route('affichage')->with('success', "Supprimer avec succès");;
    }

    /**
     * @method forme_de_reinitialisation(SELECT)
     * @param $id_user qui reçois en paramètres l'identifiant de l'utilisateur
     * @return la vue qui permet de reinitialiser le mot de passe
     * @author Jean Pierre Lory TOLNO
     */
    public function forme_de_reinitialisation($id_user){

        $user = User::find($id_user);
        $passwordReinit = Str::upper(Str::random(4));

        $user->password = Hash::make($passwordReinit);
        $user->save();

        Mail::to($user->email)->send(new regeneratePasswordUser($user, $passwordReinit));

        return redirect()->back()->with("success", "Mot de passe reinitialisé");

    }

    /**
     * @method envoie_du_lien_de_reinitialisation (UPDATE)
     * @param $id_user qui reçois en paramètres l'identifiant de l'utilisateur, et l'addresse mail qui doit modifier les users
     * @return la vue et le message de succes si tous se passe bien ou returne les erreurs
     * @author Jean Pierre Lory TOLNO
     */
    public function envoie_du_lien_de_reinitialisation(Request $request){ // PAS UTILISER

        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);

    }

    /**
     * @method reitialisation_du_mot_de_passe (UPDATE)
     * @param $request recoit le nouveau mot de passe et le token
     * @return la vue du dashbord connecté avec succes
     * @author Jean Pierre Lory TOLNO
     */
    public function reitialisation_du_mot_de_passe(Request $request){ // PAS UTILISER

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);

    }
    

}