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

class Mot_de_pass_oublier extends Component
{
    use WithPagination;
    public $currentPage = PAGEMOTDEPASSEOUBLIER;

    public $email_de_verification;

     protected function rules () {


        if($this->currentPage == PAGEMOTDEPASSEOUBLIER)
        {
            return [
                'email_de_verification' => ['required']
            ];
        }
    }
    public function mount()
    {

        $this->currentPage = PAGEMOTDEPASSEOUBLIER;

    }
    public function render()
    {

        $data = ["categories"=>TypePromoteur::all()];

        return view('auth.index', $data)
        ->extends("layouts.login-master",['title'=>'Connexion'])
        ->section("content");
    }

    public function envoyer_email_de_verification()
    {

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

}
