<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MembreCommissionRequest;
use App\Models\Dossier;
use Illuminate\Support\Facades\Auth;
use App\Models\Media;
use App\Models\Role;
use App\Models\User;
use App\Models\DossiersCommission;
use App\Models\DossiersHac;
use App\Models\RevisionDossier;
use App\Models\MemberRapportCommissionMedia;
use App\Models\Membre;
use App\Models\MembreRapportMedia;

class MembreCommissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $membre_commissions = Membre::orderBy('id','desc')->get();
        return view('membre_commessions.index',compact('membre_commissions'));
    }

    public function show($id){
        $title = "Détail";
        $membre_commission = Membre::find($id);
        return view('membre_commessions.index',compact('membre_commission','title'));
    }

    public function edit($id){
        $title = "Edition";
        $membre_commission = Membre::find($id);
        return view('membre_commessions.createUpdate',compact('membre_commission','title'));
    }

    public function destroy(Request $request){
        $membre_commission = Membre::find($request['id']);
        $membre_commission->delete();
        return response()->json([
            'success'=> true,
            'message'=>'Supprimé avec succès']);
    }

    public function create(){
        $title = "Nouveau membre";
        $membre_commission = new Membre();
        return view('membre_commessions.createUpdate',compact('membre_commission','title'));
    }

    public function update(Request $request,$id){

        $membreCommission = Membre::find($id);
        $membreCommission->full_name = $request['full_name'];
        $membreCommission->fonction = $request['fonction'];
        $membreCommission->fonction_occupe = $request['fonction_occupe'];
        $membreCommission->category = $request['category'];
        $membreCommission->save();
        toast("Les informations du membre modifié avec succès.",'success');
        return redirect()->back();
    }

    public function  store(MembreCommissionRequest $request)
    {
        $membreCommission = new Membre();
        $membreCommission->full_name = $request['full_name'];
        $membreCommission->fonction = $request['fonction'];
        $membreCommission->fonction_occupe = $request['fonction_occupe'];
        $membreCommission->category = $request['category'];

        $membreCommission->save();

        return redirect()->route('membre-commission-index');

    }

    public function storeMembreForCommission(Request $request) {
        $user = Auth::user();

        if(!count($request['member']) > 0){
            return response()->json([
                'success'=> false,
                'message'=>'Veuillez sélectionner les membres de la commission.',
            ]);
        }
        if($request['type_commission'] == "HAC"){
            MembreRapportMedia::where('media_id',$request['media_id'])->where('category','HAC')->delete();
        }else{
            MembreRapportMedia::where('media_id',$request['media_id'])->where('category','Commission')->delete();
        }
        foreach ($request['member'] as $key => $value) {
            $membreRapportCommissionMedia = new MembreRapportMedia();
            $membreRapportCommissionMedia->media_id = $request['media_id'];
            $membreRapportCommissionMedia->member_commission_id = $value;
            $membreRapportCommissionMedia->category = $request['type_commission'] ==  "HAC" ? $request['type_commission'] : 'Commission';
            $membreRapportCommissionMedia->save();
        }

        if(Auth::user()->role->nom == 'HAC'){
            return response()->json([
                'success'=> true,
                'message'=>"Les membres de la commission sont ajoutés avec succès.",
            ]);
        }

        //supprimer le rapport
        if(Auth::user()->role->nom !== 'Commission') {
            return response()->json([
                'success'=> false,
                'message'=>'Vous n\'êtes pas autorisé à soumetre un dossier',
            ]);
        }

        $media = Media::find($request['media_id']);
        $dossier = Dossier::where('media_id', $media->media_id)->first();
        if($dossier === null) {
            return response()->json([
                'success'=> false,
                'message'=>'Ce dossier n\'existe',
            ]);
        }

        $dossier->etude_en_cours = true;
        $dossier->etude_termine = false;
        $dossier->valide = null;
        if($dossier->revoir === 1){
            $dossier->revoir = null;
        }else{
            $dossier->revoir = false;
        }
        $dossier->save();

        $media = $dossier->media;
        $media->niveau = 'Commission';
        $media->save();
        return response()->json([
            'success'=> true,
            'message'=>"Success",
            'response'=>$dossier
        ]);
    }
}
