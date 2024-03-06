<?php

namespace App\Http\Livewire;
use Livewire\WithFileUploads;

use App\Gestions\GestionMedia;
use App\Http\Requests\MediaCreateRequest;
use App\Models\Commune;
use App\Models\FormeJuridique;
use App\Models\Media;
use App\Models\Prefecture;
use App\Models\Region;
use App\Models\TypeMedia;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class MediaPromoteur extends Component
{
    use WithPagination;
    use WithFileUploads;

    public function AdminAuthCheck()
    {
        if(!Auth::guard()->check()){
            return redirect('/login');
        }
    }
    public $media;

    public $id_media;
    public $type_media;
    public $nom;
    public $email;
    public $telephone;
    public $forme_juridique;
    public $sigle;
    public $description;
    public $logo;
    public $type;
    public $isAdd = true;
    public $commune;
    public $prefecture;
    public $region;
    public $communes;
    public $prefectures;
    public $regions;
    public $type_medias;
    public $forme_juridiques;

    protected function rules()
    {
        return [
            'nom' => 'required|unique:media,nom,'.$this->id_media,
            'telephone' => 'required|min:9|max:9',
            'region'=>'required',
            'email'=>'required',
            'prefecture'=>'required',
            'commune'=>'required',
            'forme_juridique' => ['required'],
            'description' => 'required|min:20',
            'type_media'=>['required'],
        ];
    }
    public function mount()
    {
        $this->media = null;
    }

    public function render()
    {
        if(!hasPermission('mes_medias')){
            $this->redirect("/page-not-permission");
        }

        $this->regions = Region::orderBy("nom")->get();
        $this->prefectures = Prefecture::where('region_id',$this->region)->get();
        $this->communes = Commune::where('prefecture_id',$this->prefecture)->get();
        //SELECT COMMUN CONAKRY DEFAULT
        $conakry = Prefecture::where('region_id',$this->region)->whereNom('Conakry')->first();
        if($conakry){
            $this->prefecture=$conakry->id??null;
            $this->communes = Commune::where('prefecture_id',$this->prefecture)->get();

        }
        $this->type_medias = TypeMedia::whereNotIn("id", function ($query) {
            $query->from("media")->where("user_id", Auth::user()->id_user)
            ->select("id")->get();
        })->get();
        $this->forme_juridiques = FormeJuridique::all();
        $media = Media::where('is_deleted',0)->where('user_id',auth()->user()->id)->orderBy('created_at','desc')->get();
        $data = ["medias"=>$media, "media"=>$this->media, "type_medias"=>$this->type_medias, "form_juridiques"=>$this->forme_juridiques ];
        return view('medias.medias.liste', $data)
        ->extends("layouts.default",['title'=>'Mes medias'])
        ->section("content");
    }
    public function addmedia($id)
    {
        $this->isAdd = true;
        $this->type=$id;

    }
    public function save()
    {
        $this->validate($this->rules());

        $media = ($this->isAdd)? new Media():Media::find($this->id_media);

        $media->type_media = $this->type_media;
        $media->nom = $this->nom;
        $media->uuid = Str::uuid();
        $media->date_create = Carbon::now();
        $media->email = $this->email;
        $media->region_id = $this->region;
        $media->prefecture_id = $this->prefecture;
        $media->commune_id = $this->commune;
        $media->type = $this->type??$media->type;
        $media->telephone = $this->telephone;
        $media->forme_juridique = $this->forme_juridique;
        $media->sigle = $this->sigle;
        $media->description = $this->description;
        $media->user_id = auth()->user()->id;
        if ($this->logo) {
            if (!is_string($this->logo)) {
                $name = (string) Str::uuid();
                $extension = $this->logo->extension();

                $this->logo->storeAs('upload',$name.".".$extension,"public");
                $media->logo = "storage/upload/".$name.".".$extension;
            }
        }

        $media->save();

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>($this->isAdd)?"Enregistrement effectué avec succes!":"mise à jour effectuée avec succes!"]);
          if ($this->isAdd) {
            $objet = "Information de création d'un média";
            $users = User::whereIn('role_id', function ($query) {
                $query->from('role')->where('nom','=','Direction')->select('id')->get();
            })->get();

            foreach ($users as $user) {
                send_notification(
                    $user,
                    $objet,
                    "Merci de recevoir l'information portant sur la création d'une nouvelle <b>".$this->type." ".$this->type_media."</b> nommé: <b>".$media->nom."</b> ",
                    $media,
                    null,
                );
            }

        }
        return redirect('mes-medias');

    }

    public function resetForm()
    {
        $this->reset();
        $this->isAdd = false;
    }

    public function editmedia($id)
    {

        $this->isAdd = false;
        $this->id_media = $id;
        $media = Media::find($this->id_media);

        $this->type_media = $media->type_media??null;
        $this->nom = $media->nom??null;
        $this->email = $media->email??null;
        $this->region = $media->region_id??null;
        $this->prefecture = $media->prefecture_id??null;
        $this->commune = $media->commune_id??null;
        $this->telephone = $media->telephone??null;
        $this->forme_juridique = $media->forme_juridique??null;
        $this->sigle = $media->sigle??null;
        $this->description = $media->description??null;
        $this->logo = $media->logo??null;

        $this->type_medias = TypeMedia::whereNotIn("id", function ($query) use ($media) {
            $query->from("media")->where("id", "<>", $media->id)->where("user_id", Auth::user()->id)
            ->select("type_media")->get();
        })->get();

    }

}

