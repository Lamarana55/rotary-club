<?php
namespace App\Gestions;

use App\Models\Document;
use App\Models\Media;
use App\Models\Paiement;
use App\Models\ParametrePaiement;
use App\Models\Tracking;
use App\Models\TypeDocument;
use App\Models\TypePaiement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class GestionMedia
{

    private function getDocuementInvalides(Media $media) {
        $typesDocument = TypeDocument::where([
            'is_document_technique' => true,
            'id_categorie_promoteur' => $media->user->id_categorie_promoteur
        ])->get();
        $ids = [];
        foreach($media->documents as $document) {
            array_push($ids, $document->type_document->id_type_document);
        }

        $documentsInvalides = $typesDocument->diff(TypeDocument::whereIn('id_type_document', $ids)->get());
        return $documentsInvalides;
    }

    private function autorisationSoumission(Media $media) {
        $documentsInvalides = $this->getDocuementInvalides($media);
        $soumission = false;

        if((count($documentsInvalides) == 0 && $media->dossier_commission === null) ||
        (count($documentsInvalides) == 0 && $media->dossier_commission !== null && $media->dossier_commission->valide === 0 && $media->hasDocumentRejeteCommission() == false)) {
            $soumission = true;
        }

        return $soumission;
    }

    public function activeStepper($data)
    {
        $media = Media::find($data->id_media);
        $media->level_current = $data->level_current;
        $media->save();
    }

    public function createMedia($data)
    {
        $count = DB::table('media')->where('id_user',auth()->user()->id_user)->get();

        if(count($count) <2){
            $personnel = Media::create([
                'nom_media' => $data->nom_media,
                'telephone' => $data->telephone,
                'email' => $data->email,
                'description' => $data->description,
                'id_forme_juridique' => $data->forme_juridique,
                'sigle' => $data->sigle,
                'id_type_media' => $data->type_media,
                'id_user' => Auth::user()->id_user,
                'isDelete' => 0,
            ]);

            $traking = new Tracking();
            $traking->date_create_media = Carbon::now();
            $traking->id_media = $personnel->id_media;
            $traking->id_user = auth()->user()->id_user;
            $traking->save();


            $this->uploadImage($personnel, $data);
            return $personnel;
        }else{
           return toast('Vous ne pouvez pas ajouter plus de 2 medias','info');
        }


    }

    public function store($data)
	{
		$this->createMedia($data);
		// return trans('Personnel creer avec success');
	}

    public function update($data, $key)
	{
		$media = Media::find($key);

        if($data->has('logo')){
            $media->update([
                'nom_media' => $data->nom_media,
                'telephone' => $data->telephone,
                'email' => $data->email,
                'description' => $data->description,
                'sigle' => $data->sigle,
                'id_forme_juridique' => $data->forme_juridique,
                'id_type_media' => $data->type_media,
                'id_user' => Auth::user()->id_user,
            ]);

            $this->uploadImage($media, $data);

            return $media;
        }else{
            $media->update([
                'nom_media' => $data->nom_media,
                'telephone' => $data->telephone,
                'description' => $data->description,
                'email' => $data->email,
                'sigle' => $data->sigle,
                'id_forme_juridique' => $data->forme_juridique,
                'id_type_media' => $data->type_media,
                'id_user' => Auth::user()->id_user,
            ]);

            return $media;
        }

	}

    public function uploadImage($media, $data)
    {
        if ($data->has('logo')) {

            if ($data->logo->isValid()) {
                $name = (string) Str::uuid();
                $extension = $data->logo->extension();

                $path = $data->logo->storeAs('upload', "$name.$extension", 'public');

                $media->update([
                    'logo' => 'storage/'.$path
                ]);
                // $img = ImageIntervention::make(storage_path("app/$path"));
                // $img->save(storage_path("app/$path"), 60, 'jpg');
            }
        }
    }

    public function delete($key)
	{
		$media = Media::find($key);
        $$media->isDelete = 1;
        $media->save();
		return true;
	}

    public function save_paiement_cachier_charge($data)
    {
        $typePaiement = TypePaiement::firstWhere('iscahiercharge', true);
        $param_paiement = ParametrePaiement::firstWhere('is_cahier_charge', true);
        $media = Media::find($data->id_media);
        $paiement = new Paiement();
        $exitPaiement = Paiement::where('id_media',$data->id_media)->first();
        if($exitPaiement){
            if($data->mode == 'Recu'){
                $fileName = time().'_'.$data->recu->getClientOriginalName();
                $filePath = $data->recu->storeAs('recus', $fileName, 'public');

                $exitPaiement->recu = "/storage/" . $filePath;
                $exitPaiement->mode = $data->mode;
                $exitPaiement->montant = $param_paiement->montant;
                $exitPaiement->id_media = $data->id_media;
                $exitPaiement->id_type_paiement = $typePaiement->id;
                $exitPaiement->valide = null;
                $exitPaiement->save();
                //update niveau
                $media->niveau = 'DAF';
                $media->update();
            }else{
                $exitPaiement->numero = $data->numero;
                $exitPaiement->mode = $data->mode;
                $exitPaiement->montant = $param_paiement->montant;
                $exitPaiement->id_media = $data->id_media;
                $exitPaiement->id_type_paiement = $typePaiement->id;
                $exitPaiement->valide = null;
                $exitPaiement->save();
                //update niveau
                $media->niveau = 'DAF';
                $media->update();
            }
        }else{
            if($data->mode == 'Recu'){
                $fileName = time().'_'.$data->recu->getClientOriginalName();
                $filePath = $data->recu->storeAs('recus', $fileName, 'public');

                $paiement->recu = "/storage/" . $filePath;
                $paiement->mode = $data->mode;
                $paiement->montant = $param_paiement->montant;
                $paiement->id_media = $data->id_media;
                $paiement->id_type_paiement = $typePaiement->id;
                $paiement->valide = null;
                $paiement->save();
                //update niveau
                $media->niveau = 'DAF';
                $media->update();
            }else{
                $paiement->numero = $data->numero;
                $paiement->mode = $data->mode;
                $paiement->montant = $param_paiement->montant;
                $paiement->id_media = $data->id_media;
                $paiement->id_type_paiement = $typePaiement->id;
                $paiement->valide = null;
                $paiement->save();
                //update niveau
                $media->niveau = 'DAF';
                $media->update();
            }
        }

    }

    public function save_importation_document_technique($data)
    {
        $media = Media::find($data->id_media);
        if($media == null) {
            return response()->json(['succes' => false, 'message' => "Vous ne possedez pas ce média"]);
        }

        if(Auth::user()->id_user !== $media->user->id_user) {
            return response()->json(['succes' => false, 'message' => "Vous n'êtes pas autorisé à importer des documents dans ce média"]);
        }

        $fileDoc = array();
        $typesDocument = TypeDocument::where('is_document_technique', true)->get();

        foreach ($data->document as $key => $file) {
            $fileName = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'public');

            $fileDoc['id_media'] = $data->id_media;
            $fileDoc['id_type_document'] =$key;
            $fileDoc['file_path'] = "/storage/".$filePath;

            DB::table('document')
                        ->insert($fileDoc);
        }

        $documents = Document::where('id_media',$data->id_media)->with('media','type_document')->get();


        $doc = Document::where('id_media',$data->id_media)->first();
        $typesDocument = TypeDocument::where('is_document_technique', true)->get();
        $documentsRequis = count($typesDocument);
        $documentEnvoye = count($media->documents);
        $documentsInvalides = $this->getDocuementInvalides($media);
        $soumission = $this->autorisationSoumission($media);

        return response()->json([
            'succes' => true,
            'documentsRequis' => $documentsRequis,
            'documentEnvoye' => $documentEnvoye,
            'file_path' => $doc->file_path,
            'nom_document' => $doc->type_document->libelle,
            'idDocument' => $doc->id_document,
            'soumission' => $soumission,
            'media'=>$data->id_media,
            'documentsInvalides' => $documentsInvalides,
            'documents'=>$documents,
            'action' => $media->dossier_commission === null || $media->dossier_commission->valide === 0,
            'message' => "Le document a été importer avec succès"
        ]);
    }
}