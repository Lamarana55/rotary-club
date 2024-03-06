<?php

namespace App\Http\Livewire;

use App\Mail\forgetPasswordEmail;
use App\Models\Commune;
use App\Models\Prefecture;
use App\Models\Region;
use App\Models\TypePromoteur;
use App\Models\User;
use Carbon\Carbon;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class GestionInscription extends Component
{
    use WithPagination;
    public $currentPage = PAGEINSCRIPTION;


    //variable pour l'inscription
    public $prenom;
    public $nom;
    public $email_promoteur;
    public $telephone;
    public $genre;
    public $profession;
    public $commune;
    public $adresse;
    public $categorie;
    public $categories;
    public $region;
    public $prefecture;
    public $prefectures=[];
    public $communes=[];
    public $regions=[];
    //variable de mot de passe oublier
    public $email_de_verification;

     protected function rules () {

        if($this->currentPage == PAGEINSCRIPTION)
        {
            return [
                'prenom' => ['required','min:2'],
                'nom' => ['required','min:2'],
                'email_promoteur' => ['required', 'email','regex:/(.+)@(.+)\.(.+)/i'],
                'telephone' => ['required', 'phone:GN'],
                'adresse' => ['required','min:2'],
                'categorie' => 'required',
                'genre' => ['required'],
            ];
        }

    }

    public function render()
    {
        $this->regions = Region::orderBy("nom")->get();
        $this->prefectures = Prefecture::where('region_id',$this->region)->get();
        $this->communes = Commune::where('prefecture_id',$this->prefecture)->get();


        $this->categories = TypePromoteur::all();
        $data = ["categories"=>$this->categories];
        return view('auth.index', $data)
        ->extends("layouts.register-master",['title'=>'Connexion'])
        ->section("content");
    }

    public function save_inscription()
    {

         $testCompte = User::where('email',$this->email_promoteur)->orWhere('telephone','+224'.$this->telephone)->first();

        if ($testCompte) {

            $testDelete = User::where(function ($query){
                $query->where('email',$this->email_promoteur)
                                    ->orWhere('telephone',$this->telephone);
            })->where('is_deleted',1)->first();
            if ($testDelete) {
                $this->validate($this->rules());
                session()->flash('message', "Votre compte a un problème, contacter l'administrateur");

            }else {
                $this->validate($this->rules());
                session()->flash('message', "Votre e-mail ou numero téléphone est déja utilisé par un utilisateur");

            }
        }else {
                $this->validate($this->rules());

                $user = new User();
                $user->nom = $this->nom;
                $user->prenom = $this->prenom;
                $user->telephone = $this->telephone;
                $user->adresse = $this->adresse;
                $user->email = $this->email_promoteur;
                $user->genre = $this->genre;
                $user->password = Hash::make(1234);
                $user->role_id = 2;
                $user->isvalide = true;
                $user->valide_compte = false;
                $user->type_promoteur_id = $this->categorie;
                $user->is_deleted = 0;

                $user->profession = $this->profession;

                $user->commune = $this->commune;

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
    }


}
