<?php

namespace App\Http\Livewire;

use App\Mail\forgetPasswordEmail;
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

class GestionAuth extends Component
{
    use WithPagination;
    public $currentPage = PAGELOGINS;
    public $email;
    public $password;



    public $email_de_verification;

     protected function rules () {
        if($this->currentPage == PAGELOGINS)
        {
            return [
                'email' => ['required'],
                'password' => ['required'],
            ];
        }

        if($this->currentPage == PAGEMOTDEPASSEOUBLIER)
        {
            return [
                'email_de_verification' => ['required']
            ];
        }
    }
    public function mount()
    {

        $this->currentPage = PAGELOGINS;

    }
    public function render()
    {
        $data = ["categories"=>TypePromoteur::all()];
        return view('auth.index', $data)
        ->extends("layouts.login-master",['title'=>'Connexion'])
        ->section("content");
    }


    public function connexion()
    {
        $testDelete = User::where(function ($query) {
            $query->where('email',$this->email);
        })->where('is_deleted',1)
        ->first();
        if ($testDelete) {
            return redirect('/login')->with('msg',"Votre compte a un problème, contacter l'administrateur");
        }
        $valide_compte = User::where('email',$this->email)->where('valide_compte',false)->first();
        if ($valide_compte) {
            return redirect('/login')->with('msg',"Votre compte n'est pas encore valide");

        }
        $data = User::where('email',$this->email)->where('isvalide',false)->first();
        if ($data) {
            return redirect('/login')->with('msg',"Veiller patienter le temps que l'administrateur active votre compte");

        }

        $credentials = $this->validate([
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
        $this->email = "";
        $this->password = "";
        //$this->currentPage = PAGELOGINS;
        return back()->with('msg', "Email ou mot de passe invalide");
    }



    public function mot_de_passe_oublier()
    {

        $this->currentPage = PAGEMOTDEPASSEOUBLIER;
        $this->email = "";
        $this->password = "";
    }
    public function envoyer_email_de_verification()
    {
        $this->email = "";
        $this->password = "";
        $this->validate($this->rules());

        $use = User::where('email',$this->email_de_verification)->first();

        if ($use) {
            $date1 = Carbon::createFromFormat('d-m-Y H:i:s',Carbon::now()->format("d-m-Y H:i:s"));

            $token_update_password = Str::upper(Str::random(9));

            $user = User::find($use->id);//dd(Carbon::now()->format("d-m-Y H:i:s"));
            $user->token_update_password = $token_update_password;
            $user->date_validated_token_password = $date1;
            $user->save();

            $url = request()->getSchemeAndHttpHost()."/get_new_password/".$token_update_password;
            $data = ["url"=>$url,"user"=>$user];

            Mail::to($user->email)->send(new forgetPasswordEmail($data));
            return redirect('/login')->with('messageemail',"Consulter votre G-mail");
        } else {
            session()->flash('message', "Adresse email invalide.");
        }


    }
    public function login()
    {
        $this->currentPage = PAGELOGINS;
    }
}