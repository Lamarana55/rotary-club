<?php

namespace App\Http\Controllers;

use App\Models\CodeMarchand;
use Illuminate\Http\Request;

class codeMarchandController extends Controller
{
    function afficher(){
        $codeMarchand = CodeMarchand::orderBy('created_at', 'DESC')->get();

        return view('parametrage.codeMarchand.codemarchand', compact('codeMarchand'));
    }

    function store(Request $request){
        $request->validate([
            'code' => 'required|numeric|unique:code_marchands,code',
            'modePaiement' => 'required',
        ]);
        dd($request);

        $dernierCode = CodeMarchand::where('modePaiement',$request->modePaiement)->where('status',1)->first();
        $codeMarchand = new CodeMarchand;

        if($dernierCode):
            $dernierCode->status = 0;
            $dernierCode->save();

            $codeMarchand->code = $request->code;
            $codeMarchand->modePaiement = $request->modePaiement;
            $codeMarchand->status = 1;
            $codeMarchand->save();
        else:
            $codeMarchand->code = $request->code;
            $codeMarchand->modePaiement = $request->modePaiement;
            $codeMarchand->status = 1;
            $codeMarchand->save();
        endif;

        return redirect()->back()->with('success',"Opération effectuée avec succès!");

    }

    function update(Request $request, $id){

        $codeMarchand = CodeMarchand::find($id);
        $codeMarchand->code = $request->code;
        $codeMarchand->modePaiement = $request->modePaiement;
        $codeMarchand->save();

        return redirect()->back()->with('success',"Opération effectuée avec succès!");
    }

    function delete($id){
        $codeMarchand = CodeMarchand::find($id);
        $codeMarchand->status = 3;
        $codeMarchand->save();
        return redirect()->back()->with('success',"Opération effectuée avec succès!");
    }

    function active($id){
        $codeMarchand = CodeMarchand::find($id);
        if($codeMarchand->status == 1){
            $codeMarchand->status = 0;
        }elseif($codeMarchand->status == 0){
            $codeMarchand->status = 1;
        }

        $codeMarchand->save();

        return redirect()->back();
    }
}
