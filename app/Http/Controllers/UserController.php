<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Region;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\TypePromoteur;
use Propaganistas\LaravelPhone\PhoneNumber;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class UserController extends Controller
{

    public function formAddPromoteur(Request $request)
    {
        $categories = TypePromoteur::all();
        $regions = Region::orderBy("nom")->get();
        return view('auth.register', compact('categories','regions'));
    }

    public function inscriptionPromoteur(Request $request)
    {
        $testCompte = User::where('email',$request->email)->orWhere('telephone','+224'.$request->telephone)->first();

        if ($testCompte) {
            $testDelete = User::where(function ($query) use ($request){
                $query->where('email',$request->email)
                                    ->orWhere('telephone',$request->telephone);
            })->where('is_deleted',1)->first();
            if ($testDelete) {
                return redirect('inscription')->with('msg',"Votre compte a un problème, contacter l'administrateur")
                ->with('valided',$request->validate([
                    'prenom' => ['required','min:2'],
                    'nom' => ['required','min:2'],
                    'email' => ['required', 'email','regex:/(.+)@(.+)\.(.+)/i'],
                    'telephone' => ['required', 'phone:GN'],
                    'adresse' => ['required','min:2'],
                    'categorie' => 'required|exists:type_promoteur,id'
                ]));
            }
            return redirect('inscription')->with('msg',"Votre e-mail ou numero téléphone est déja utilisé par un utilisateur")
            ->with('valided',$request->validate([
                'prenom' => ['required','min:2'],
                'nom' => ['required','min:2'],
                'email' => ['required', 'email','regex:/(.+)@(.+)\.(.+)/i'],
                'telephone' => ['required', 'phone:GN'],
                'adresse' => ['required','min:2'],
                'categorie' => 'required|exists:type_promoteur,id'
            ]));
        }



        $request->validate([
            'prenom' => ['required','min:2'],
            'nom' => ['required','min:2'],
            'email' => ['required', 'email','regex:/(.+)@(.+)\.(.+)/i'],
            'telephone' => ['required', 'phone:GN'],
            'adresse' => ['required','min:2'],
            'categorie' => 'required|exists:type_promoteur,id'
        ]);

        $phone = new PhoneNumber($request->telephone, 'GN');

        $request->merge(['telephone' => $phone->formatE164()]);

        $user = new User();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->telephone = $request->telephone;
        $user->adresse = $request->adresse;
        $user->email = $request->email;
        $user->genre = $request->genre;
        $user->password = Hash::make(1234);
        $user->role_id = 2;
        $user->isvalide = true;
        $user->valide_compte = false;
        $user->type_promoteur_id = $request->categorie;
        $user->is_deleted = 0;
        $user->profession = $request->profession;
        // $user->quartier;

        $user->save();

        $objet = "Demande de création de compte";

        send_notification(
            $user,
            $objet,
            message_email("demande_creation_compte"),
            null,
            null,
            1
        );

        $admin = User::whereIn("role_id", function ($query){
            $query->from("role")->whereNom("Admin")->select("id")->get();
        })->where("is_deleted", false)->first();

        if($admin) {
            send_notification(
                $admin,
                $objet,
                message_email("inscription"),
                null,
                config("app.url").':'.env("PORT","9000")
            );
        }

        return redirect('login')->with('message_success', "Votre demande de création de compte a été enregistrée avec succès. Veuillez patienter le temps que votre demande soit validée.");

    }

    public function authenticate(Request $request)
    {
        $testDelete = User::where(function ($query) use ($request){
            $query->where('email',$request->email)
            ->orWhere('telephone',$request->telephone);
        })->where('is_deleted',1)
        ->first();
        if ($testDelete) {
            return redirect('/login')->with('msg',"Votre compte a un problème, contacter l'administrateur");
        }
        $valide_compte = User::where('email',$request->email)->where('valide_compte',false)->first();
        if ($valide_compte) {
            return redirect('/login')->with('msg',"Votre compte n'est pas encore valide");

        }
        $data = User::where('email',$request->email)->where('isvalide',false)->first();
        if ($data) {
            return redirect('/login')->with('msg',"Veiller patienter le temps que l'administrateur active votre compte");

        }

        $credentials = $request->validate([
            'email' => ['required', 'email','regex:/(.+)@(.+)\.(.+)/i'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            //$request->session()->regenerate();
            if(Auth::user()->role->nom !== 'Promoteur') {
                return redirect('/');
            } else {
                return redirect('mes-medias');
            }

        }

        return back()->with('msg', "Email ou mot de passe invalide");
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/login');
    }

    public function isvalideuser(Request $request)
    {
        $res = ($request->isactive)?false:true;
        $user = User::find($request->id);
        $user->isvalide = $res;
        //$user->save();

        return response()->json([
            'succes' => $res
        ]);
    }

    public function save_email(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email','regex:/(.+)@(.+)\.(.+)/i']
        ]);

        $use = User::where('email',$request->email)->first();

         if (!$use) return back()->withInput()->with("msg", "Adresse email invalide.");
        //dd(Carbon::now()->format("d-m-Y H:i:s"));
        $date1 = Carbon::createFromFormat('d-m-Y H:i:s',Carbon::now()->format("d-m-Y H:i:s"));

        $token_update_password = Str::upper(Str::random(9));

        $user = User::find($use->id);
        $user->token_update_password = $token_update_password;
        $user->date_validated_token_password = $date1;
        $user->update();

        $url = request()->getSchemeAndHttpHost()."/get_new_password/".$token_update_password;
        /////////

        // dd($user);
        send_notification(
            $user,
            "reinitialisation du mot de passe",
            message_email("reinitialisation_password"),
            null,
            $url,
            1
        );
        /////
        return redirect('/login')->with('messageemail',"Consulter votre email");
    }

    public function get_new_password(Request $request)
    {
        $use = User::where('token_update_password',$request->number)->first();

        if ($use) {
        $date1 = Carbon::createFromFormat('Y-m-d H:i:s',$use->date_validated_token_password)->addMinute(15);
        $date2 = Carbon::createFromFormat('Y-m-d H:i:s',Carbon::now()->format("Y-m-d H:i:s"));

        if ($date1->lte($date2)) {
            return redirect('/email_verified')->with('expiration_token',"Votre lien a expiré");
        }else{
            return view('auth.form_update_password')->with('email',$use->email);
        }
        } else {
            return redirect('/email_verified')->with('expiration_token',"Votre lien a expiré");
        }
    }
    public function get_new_password_user_active(Request $request)
    {
        $use = User::where('token_update_password',$request->number)->first();

        if ($use) {

            return view('auth.form_update_password')->with('email',$use->email);
        }
    }
    public function save_new_password(Request $request, $email)
    {

        $credentials = $request->validate([
            'newpassword' => 'string|min:2|required_with:confirmpassword|same:confirmpassword',
            'confirmpassword' => 'required|string|min:2'
        ]);
        $use = User::where('email',$email)->first();

        if ($use) {
            $data = User::find($use->id);
            $data->password = Hash::make($request->newpassword) ;
            $data->token_update_password = null;
            $data->date_validated_token_password = null;
            $data->save();
            return redirect('login')->with('teste_update_password',"Mise à jour effectuée avec succè!!!");
        } else {
            return redirect('/email_verified')->with('testemail',"Verifier votre email!!!");
        }
    }
    /* public function files() {
        $infosRecu = ["infosRecu"=>"Hamza","nom_media"=>"Barry", "type"=>"Barry"];
        view()->share('template_documents.rapport_hac',$infosRecu);
        $pdf = PDF::loadView('template_documents.rapport_hac',$infosRecu);
        $pdf->setPaper('A4');
        return $pdf->download("rapport_hac.pdf");

    } */
}
