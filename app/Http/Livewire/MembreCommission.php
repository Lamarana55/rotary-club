<?php

namespace App\Http\Livewire;

use App\Mail\forgetPasswordEmail;
use App\Models\Membre;
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

class MembreCommission extends Component
{
    use WithPagination;
    public $id_membre;
    public $full_name;
    public $fonction;
    public $fonction_occupe;
    public $category;
    public $isAdd = true;
    public $search;
    public function AdminAuthCheck()
    {
        if(Auth::guard()->check()){
            return;
        }else{
            return redirect('/login');
        }
    }
    protected function rules () {
            return [
                'full_name' => ['required','min:2'],
                'fonction' => ['required','min:2'],
                'fonction_occupe' => ['required','min:2'],
                'category' => 'required'
            ];
    }

    public function render()
    {
        if(!hasPermission('afficher_membre')){
            $this->redirect("/page-not-permission");
        }
        $this->AdminAuthCheck();
        $membre_commissions =  Membre::query();

        if($this->search != ""){
            $membre_commissions->where(function ($query) {
                $query->orWhere("full_name","LIKE","%". $this->search ."%")
                ->orWhere("fonction","LIKE","%". $this->search ."%")
                ->orWhere("fonction_occupe","LIKE","%". $this->search ."%")
                ->orWhere("category","LIKE","%". $this->search ."%");
            });


        }


        $data = ["membre_commissions"=>$membre_commissions->orderBy('id','desc')->simplePaginate(10)];
        return view('membre_commessions.index', $data)
        ->extends("layouts.default",['title'=>'Membre de la commission'])
        ->section("content");
    }
    public function save()
    {
        $this->validate($this->rules());
        $membreCommission = ($this->isAdd)? new Membre():Membre::find($this->id_membre);
        $membreCommission->full_name = $this->full_name;
        $membreCommission->fonction = $this->fonction;
        $membreCommission->fonction_occupe = $this->fonction_occupe;
        $membreCommission->category = $this->category;

        $membreCommission->save();

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>($this->isAdd)?"Les informations du membre ajouté avec succès":"Les informations du membre modifié avec succès"]);
        return redirect()->route('membre-commission-index');
    }

    public function getMembre($id)
    {
        $this->rules();
        $this->isAdd = false;
        $this->id_membre = $id;
        $membreCommission = Membre::find($id);
        $this->full_name = $membreCommission->full_name;
        $this->fonction = $membreCommission->fonction;
        $this->fonction_occupe = $membreCommission->fonction_occupe;
        $this->category = $membreCommission->category;

    }

}
