<?php

namespace App\Http\Livewire;

use App\Models\Message;
use App\Models\Stepper;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;


class Messages extends Component
{

    use WithPagination;

    public function AdminAuthCheck()
    {
        if(Auth::guard()->check()){
            return;
        }else{
            return redirect('/login');
        }
    }

    protected $paginationTheme = "bootstrap";
    public $currentPage = PAGELISTE;
    public $stepper;
    public $message;
    public $type_message;
    public $search = "";
    public $editMessage = [];
    public $type_options;

    protected function rules () {
        if($this->currentPage == PAGEEDITFORM)
        {
            return [
                'editMessage.stepper' => 'required',
                'editMessage.message' => 'required',
                'editMessage.type_message' => 'required',
            ];
        }

    }

    public function render()
    {
        if(!hasPermission('afficher_message')){
            $this->redirect("/page-not-permission");
        }
        $this->AdminAuthCheck();
        $roleQuery = Message::query();
        $stepperQuery = Stepper::query();

        $roleQuery->where('is_deleted','=','0');


        $data = [
            'messages'=> $roleQuery->latest()->paginate(10),
        ];

        return view('parametrage.message.index', $data)
            ->extends("layouts.default",['title'=>'Gestion des messages'])
            ->section("content");
    }


    public function mount( )
    {
        $this->type_options = ["INFO", "EN COURS", "VALIDER", "REJETTER"];
    }

    public function getMessage($id)
    {
        $this->AdminAuthCheck();
        $this->editMessage = Message::find($id)->toArray();
    }

    public function save()
    {
        $this->AdminAuthCheck();
        $validateArr = [
            "stepper" => "required",
            "message"=>"required",
            "type_message"=>"required",
        ];
        $this->validate($validateArr);
        $exist_message = Message::where(['stepper_id' => $this->stepper, 'type_message' => $this->type_message]);

        $message = new Message();
        $message->stepper_id = $this->stepper;
        $message->is_deleted = 0;
        $message->message = $this->message;
        $message->type_message = $this->type_message;

        $message->save();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Message crée avec succès!"]);

        $this->stepper ="";
        $this->message ="";
        $this->type_message ="";
        $this->dispatchBrowserEvent("closeModal");

    }

    public function confirmDeleteMessage($id){
        $message = Message::find($id);
        $this->AdminAuthCheck();
        $this->dispatchBrowserEvent("showConfirmMessageDeleteMessage", ["message"=> [
            "text" => "Vous êtes sur le point de supprimer le message de l'etape. Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "id" => $id,
        ]]);
    }

    public function deleteMessage($id){
        $this->AdminAuthCheck();
        $message = Message::find($id);
        $message->is_deleted = 1;
        $message->update();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Suppression effectué avec succès!"]);
    }

    public function updateMessage(){
        $this->AdminAuthCheck();
        Message::find($this->editMessage["id"])->update($this->editMessage);

        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Message mis à jour avec succès!"]);
        $this->dispatchBrowserEvent("closeModal");
    }

}
