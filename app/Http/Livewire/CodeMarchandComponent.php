<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CodeMarchand;
use Illuminate\Http\Request;

class CodeMarchandComponent extends Component
{
    public $modePaiement;
    public $code;
    public $search;
    public $editCodePaiement = [];

    public function render()
    {
        if(!hasPermission('afficher_code_marchand')){
            $this->redirect("/page-not-permission");
        }

        $codeMarchand = CodeMarchand::orderBy('created_at', 'DESC')->get();
        $data = [
            "codeMarchand" => $codeMarchand,
        ];
        return view('parametrage.codeMarchand.codemarchand', $data)
            ->extends("layouts.default")->section("content");
    }

    public function store()
    {
        $this->validate([
            'code' => 'required|numeric|unique:code_marchands,code',
            'modePaiement' => 'required',
        ]);

        $dernierCode = CodeMarchand::where('modePaiement', $this->modePaiement)->where('status', 1)->first();
        $codeMarchand = new CodeMarchand;

        if ($dernierCode) :
            $dernierCode->status = 0;
            $dernierCode->save();

            $codeMarchand->code = $this->code;
            $codeMarchand->modePaiement = $this->modePaiement;
            $codeMarchand->status = 1;
            $codeMarchand->save();
        else :
            $codeMarchand->code = $this->code;
            $codeMarchand->modePaiement = $this->modePaiement;
            $codeMarchand->status = 1;
            $codeMarchand->save();
        endif;



        $this->code = "";
        $this->modePaiement = "";

        $this->dispatchBrowserEvent("closeModal");
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Opération effectuée avec succès!"]);

        // return redirect()->back()->with('success',"Opération effectuée avec succès!");

    }

    function get_edit_value($id)
    {
        $this->editCodePaiement = CodeMarchand::find($id)->toArray();
    }

    function update()
    {

        $codeMarchand = CodeMarchand::find($this->editCodePaiement['id']);
        $codeMarchand->code = $this->editCodePaiement['code'];
        $codeMarchand->modePaiement = $this->editCodePaiement['modepaiement'];
        $codeMarchand->save();

        $this->code = "";
        $this->modePaiement = "";

        $this->dispatchBrowserEvent("closeModalEdite");
        $this->dispatchBrowserEvent("showSuccessMessage", ["message" => "Modification effectuée avec succès!"]);
    }

    function deleteConfirmation($id)
    {
        $code_marchand = CodeMarchand::find($id);
        $this->dispatchBrowserEvent("showConfirmMessage", ["message" => [
            "text" => "Vous êtes sur le point de supprimer cet code ( $code_marchand->code ) <br> Voulez-vous continuer?",
            "title" => "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "id" => $id,
        ]]);
    }
    function delete($id)
    {
        $codeMarchand = CodeMarchand::find($id);
        $codeMarchand->status = 3;
        $codeMarchand->save();
        $this->dispatchBrowserEvent("showErrorMessage", ["message" => "Opération effectuée avec succès!"]);
    }
    function active($id)
    {
        $codeMarchand = CodeMarchand::find($id);
        if ($codeMarchand->status == 1) {
            $codeMarchand->status = 0;
        } elseif ($codeMarchand->status == 0) {
            $codeMarchand->status = 1;
        }

        $codeMarchand->save();

        return redirect()->back();
    }
}
