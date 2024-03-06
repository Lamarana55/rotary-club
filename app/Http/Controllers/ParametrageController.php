<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TypeMedia;
use App\Models\TypeDocument;
use App\Models\TypePaiement;
use Illuminate\Http\Request;
use App\Models\ParametrePaiement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\TypeMediaRequest;
use App\Http\Requests\typeDocumentRequest;
use App\Models\CahierDeCharge;

use Illuminate\Pagination\Paginator;

class ParametrageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function type_media()
    {
        $data = typeMedia::paginate(5);
        return view('parametrage.type_media.typemedia',['data'=>$data]);
    }
    public function add_type_media()
    {
        return view('parametrage.type_media.add',['message'=>false]);
    }

    public function show_type_media($id)
    {

        $typemedia = TypeMedia::find($id);
        return view('parametrage.type_media.edit',['data'=>$typemedia,'message'=>false]);
    }


    public function save_type_media(TypeMediaRequest $request)
    {

        $typemedia = new TypeMedia;
        $typemedia->libelle = $request->libelle;
        $typemedia->description = $request->description;
        $typemedia->save();
        return view('parametrage.type_media.add',['message'=>true]);


    }

    public function update_type_media(TypeMediaRequest $request, $id)
    {
        $typemedia = TypeMedia::find($id);
        $typemedia->libelle = $request->libelle;
        $typemedia->description = $request->description;
        $typemedia->update();
        return view('parametrage.type_media.edit',['data'=>$typemedia,'message'=>true]);

    }







    //Gestion des documents
    public function type_document()
    {

        $data = typeDocument::paginate(5);
        return view('parametrage.type_document.typedocument',['data'=>$data]);
    }
    public function add_type_document()
    {
        return view('parametrage.type_document.add',['alert'=>false,'message'=>false]);
    }

    public function show_type_document($id)
    {

        $typeDocument = typeDocument::find($id);
        return view('parametrage.type_document.edit',['data'=>$typeDocument,'message'=>false, 'alert'=>false]);
    }


    public function save_type_document(typeDocumentRequest $request)
    {
        $typeDocument = new typeDocument;
        $typeDocument->libelle = $request->libelle;
        $typeDocument->is_document_technique = $request->is_document_technique;
        $typeDocument->description = $request->description;
        $typeDocument->save();
        return redirect()->route('show-all-type-document');
        //return view('parametrage.type_document.add',['message'=>true,'alert'=>false]);


    }

    public function update_type_document(Request $request, $id)
    {
        $lib = typeDocument::where('libelle',$request['libelle'])
                        ->whereNotIn('id_type_document',[$request->id])
                        ->first();

                if ($lib) {
                    $typeDocument = typeDocument::find($id);
                    return view('parametrage.type_document.edit',['lib'=>true, 'data'=>$typeDocument ,'alert'=>true,'message'=>true]);
                }

        $typeDocument = typeDocument::find($id);
        $typeDocument->libelle = $request->libelle;
        $typeDocument->is_document_technique = $request->is_document_technique;
        $typeDocument->description = $request->description;
        $typeDocument->update();
        return redirect()->route('show-all-type-document');

    }






    // parametrage du paiement

    public function ParametrePaiement()
    {
        $data = DB::table('parametre_paiement')->select('*')->where('isDelete',0)->paginate(5);
        return view('parametrage.parametre_paiement.paiement',['data'=>$data]);
    }

    public function editParametrePaiement(Request $request)
    {
        $data = ($request->id==null) ? null : ParametrePaiement::find($request->id) ;
        switch ($request->method()) {
            case 'GET':

                return view('parametrage.parametre_paiement.edit',['lib'=>false,'data'=>$data,'alert'=>False,'id'=>$request->id]);
                break;
            case 'POST':

                $valided = $request->validate([
                    'libelle' => ['required'],
                    'montant' => ['required'],
                ]);
                $lib = DB::table('parametre_paiement')->select('*')->where('libelle',$request['libelle'])->first();
                if ($lib) {
                    return view('parametrage.parametre_paiement.edit',['lib'=>true, 'data'=>$data,'id'=>$request->id, 'alert'=>False,'message'=>'Enregistrement effectué avec success!']);
                }
                $ParametrePaiement = new ParametrePaiement;
                $ParametrePaiement->libelle = $request['libelle'];
                $ParametrePaiement->montant = $request['montant'];
                $ParametrePaiement->description = $request['description'];
                $ParametrePaiement->save();
                return view('parametrage.parametre_paiement.edit',['lib'=>false,'data'=>$data,'id'=>$request->id, 'alert'=>True,'message'=>'Enregistrement effectué avec success!']);

                break;



            case 'PUT':

                $valided = $request->validate([
                    'libelle' => ['required'],
                    'montant' => ['required'],
                ]);
                $lib = DB::table('parametre_paiement')->select('*')
                        ->where('libelle',$request['libelle'])
                        ->whereNotIn('id_parametre_paiement',[$request->id])
                        ->first();
                if ($lib) {
                    return view('parametrage.parametre_paiement.edit',['lib'=>true, 'data'=>$data,'id'=>$request->id, 'alert'=>False,'message'=>'Enregistrement effectué avec success!']);
                }
                $ParametrePaiement = ParametrePaiement::find($request->id);
                $ParametrePaiement->libelle = $request['libelle'];
                $ParametrePaiement->montant = $request['montant'];
                $ParametrePaiement->description = $request['description'];
                $ParametrePaiement->save();

                //return Redirect::back()->withErrors($validator)->withInput(); */
                //return redirect()->route('edit_documents', ['data'=>$data,'type_document'=>$ParametrePaiement, 'message'=>'Mise ajour effectuée avec success!', 'id'=>$request->id])->with('alerte', True);
                return view('parametrage.parametre_paiement.edit',['lib'=>false,'id'=>$request->id, 'data'=>$ParametrePaiement, 'alert'=>True, 'message'=>'Mise ajour effectuée avec success!' ]);
                break;

            default:
                return back();
                break;
    }
        return view('parametrage.parametre_paiement.edit');
    }



    //gestion de type paiements

    public function typePaiement()
    {
        $data = DB::table('type_paiement')->select('*')->paginate(5);
        return view('parametrage.type_paiement.typepaiement',['data'=>$data]);
    }

    public function editTypePaiement(Request $request)
    {
        $data = ($request->id==null) ? null : TypePaiement::find($request->id) ;
        switch ($request->method()) {
            case 'GET':
                return view('parametrage.type_paiement.edit',['lib'=>false,'data'=>$data,'alert'=>False,'id'=>$request->id]);
                break;
            case 'POST':

                $valided = $request->validate([
                    'libelle' => ['required'],
                ]);
                $lib = DB::table('type_paiement')->select('*')->where('libelle',$request['libelle'])->first();
                if ($lib) {
                    return view('parametrage.type_paiement.edit',['lib'=>true, 'data'=>$data,'id'=>$request->id, 'alert'=>False,'message'=>'Enregistrement effectué avec success!']);
                }


                $typepaiement = new TypePaiement;
                $typepaiement->libelle = $request['libelle'];

                $typepaiement->save();
                return view('parametrage.type_paiement.edit',['lib'=>false,'data'=>$data,'id'=>$request->id, 'alert'=>True,'message'=>'Enregistrement effectué avec success!']);

                break;



            case 'PUT':

                $valided = $request->validate([
                    'libelle' => ['required'],
                ]);
                $lib = DB::table('type_paiement')->select('*')
                        ->where('libelle',$request['libelle'])
                        ->whereNotIn('id',[$request->id])
                        ->first();
                if ($lib) {
                    return view('parametrage.type_paiement.edit',['lib'=>true, 'data'=>$data,'id'=>$request->id, 'alert'=>False,'message'=>'Enregistrement effectué avec success!']);
                }


                $typepaiement = TypePaiement::find($request->id);
                $typepaiement->libelle = $request['libelle'];
                $typepaiement->save();

                //return Redirect::back()->withErrors($validator)->withInput(); */
                //return redirect()->route('edit_paiements', ['data'=>$data,'type_paiement'=>$typepaiement, 'message'=>'Mise ajour effectuée avec success!', 'id'=>$request->id])->with('alerte', True);
                return view('parametrage.type_paiement.edit',['lib'=>false,'id'=>$request->id, 'data'=>$typepaiement, 'alert'=>True, 'message'=>'Mise ajour effectuée avec success!' ]);
                break;

            default:
                return back();
                break;
    }
        return view('parametrage.type_paiement.edit');
    }
    // gestion de cahier de charge
    public function cahier_de_charge(Request $request)
    {
        $data = CahierDeCharge::where('isCurrent',true)->get();

        $type_media = TypeMedia::get();
        $document_id = $request->get('id');
                $document = null;
                if($document_id){
                    $document = CahierDeCharge::find($document_id);
                }
                return view('parametrage.cahier_de_charge.index',
                    [
                        'cahier_de_charges' => $data,
                        'type_media' => $type_media,
                        'document' => $document
                    ]
                );


    }
    public function save_cahier_de_charge(Request $request)
    {
        $valided = $request->validate([
            'type_media' => ['required'],
            'nom' => ['required'],
        ]);

        $fileName = time().'_'.$request->nom->getClientOriginalName();
        $filePath = $request->file('nom')->storeAs('docs_cahier_charge', $fileName, 'public');

        $cahierDeCharge = new CahierDeCharge;
        $cahierDeCharge->nom = "/storage/" . $filePath;
        $cahierDeCharge->isCurrent = true;
        $cahierDeCharge->type_media_id = $request['type_media'];
        $cahierDeCharge->save();
        CahierDeCharge::where('type_media_id', $request['type_media'])
            ->where('id','!=', $cahierDeCharge->id)
            ->update(['isCurrent'=>false]);
        return redirect('cahier-de-charge')->with("info","Cahier de charge ajouter!");
    }

}
