<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Media;
use App\Models\Meeting;
use App\Models\Paiement;
use App\Models\TypePaiement;
use Illuminate\Support\Facades\Auth;

class DossiersDirection extends Component
{
    public $statut = "";
    public $nom = "";

    public function filtreMedias($statut) {
        if(Auth::user()->role->nom !== 'Direction') {
            return response()->json([
                'succes' => false,
                'message' => "Vous n'êtes pas autorisé à voir cette page"
            ]);
        }
        
    }

    public function render()
    {

        $typePaiement = TypePaiement::firstWhere('isagrement', true);
        $medias = null;
        $paiements = null;
        $meetings = null;

        $ids = [];    

        
        /* if($request->nom) {
            $listeMedias = Media::where('nom_media', 'LIKE', '%'.$request->nom.'%')->get();
            
            foreach($listeMedias as $media) {
                array_push($ids, $media->id_media);
            }   
        }  */

        if($this->statut == 'tous') {
            if(count($ids) > 0) {
                $medias = Media::whereIn('id_media', $ids)->paginate(NOMBRE_PAR_PAGE);
            } else {
                $medias = Media::paginate(NOMBRE_PAR_PAGE);
            }
            
        }else if($this->statut == 'agrees') {
            
            if(count($ids) > 0) {
                $meetings = Meeting::whereIn('id_media', $ids)->paginate(NOMBRE_PAR_PAGE);
            } else {
                $meetings = Meeting::paginate(NOMBRE_PAR_PAGE);
            }
        }else if(in_array($this->statut, ['acceptes', 'rejetes', 'nouveaux'])) {
            
            if(count($ids) > 0) {
                $paiements = Paiement::whereIn('id_media', $ids)->where(['id_type_paiement' => $typePaiement->id]);
            } else {
                $paiements = Paiement::where(['id_type_paiement' => $typePaiement->id]);
            }
            
            if($this->statut === "nouveaux") {
                $paiements = $paiements->where(['valide' => null]);
            } else if($this->statut === "acceptes") {
                $paiements = $paiements->where(['valide' => true]);
            } else {
                $paiements = $paiements->where(['valide' => false]);
            }

            $paiements = $paiements->paginate(NOMBRE_PAR_PAGE);
            
        } else {
            if(count($ids) > 0) {
                $medias = Media::whereIn('id_media', $ids)->paginate(NOMBRE_PAR_PAGE);
            } else {
                $medias = Media::paginate(NOMBRE_PAR_PAGE);
            }
        }
        
        return view('dossiers.direction', compact('medias', 'paiements', 'meetings'))
        ->extends("layouts.default",['title'=>'Utilisateur'])
            ->section("content");
    }
}
