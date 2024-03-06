<?php

namespace App\Http\Controllers;

use App\Models\DossiersSGG;
use App\Models\Media;
use App\Models\{Meeting, User, GenerateAgreement};
use App\Models\Paiement;
use App\Models\TypePaiement;
use App\Models\Tracking;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class DirectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save_projet_agrement(Request $request)
    {
        try {
            $paiement = Paiement::find($request->id);
            $sgg = DossiersSGG::where('id_media',$paiement->id_media)->first();
            $media = Media::where('id_media',$paiement->id_media)->first();
            $fileName = time().'_'.$request->projetAgrement->getClientOriginalName();
            $filePath = $request->file('projetAgrement')->storeAs('projetAgrement', $fileName, 'public');

            //update DossierSGG
            $sgg->id_media = $paiement->id_media;
            $sgg->isAgrement = true;
            $sgg->projetAgrement = "/storage/".$filePath;
            $sgg->save();

            $paiement->isAgrement = true;
            $paiement->save();

            $media->level = 5;
            $media->level_current = 6;
            $media->save();

            $message = message_email("transmission_projet_d_agrement");
            $objet = "Transmission de projet d'agrément";

            send_notification($media->user, $objet, $message, $media, null);

            $message = message_email('reception_projet_d_agrement_sgg', $media);

            $sgg = User::whereIn("id_role", function ($query){
                $query->from("role")->whereNom("SGG")->select("id_role")->get();
            })->where("isDelete", false)->first();

            if($sgg) send_notification($sgg, $objet, $message, $media, config("app.url"));

            $tracking = Tracking::where('id_media',$paiement->id_media)->first();
            if($tracking){
                $tracking->date_transmission_projet_agrement = Carbon::now();
                $tracking->save();
            }

            return response()->json([
                'status'=>true
            ]);
        } catch (Exception $e) {
            return response()->json([
                'succes' => false,
                'data'=>$e,
                'message' => "Erreur importation fichier"
            ]);
        }
    }

    public function listeMedias(Request $request) {
        if(Auth::user()->role->nom !== 'Direction') {
            return view('404');
        }

        $medias = Media::join('user', 'user.id_user', '=', 'media.id_user')
        ->orderBy('user.prenom')->paginate(NOMBRE_PAR_PAGE);
        $meetings = null;
        $paiements = null;
        return view('dossiers.etude_direction', compact('medias', 'meetings', 'paiements'));
    }

    public function filtreMedias(Request $request, $statut) {
        if(Auth::user()->role->nom !== 'Direction') {
            return response()->json([
                'succes' => false,
                'message' => "Vous n'êtes pas autorisé à voir cette page"
            ]);
        }
        $typePaiement = TypePaiement::firstWhere('isagrement', true);
        $medias = null;
        $paiements = null;
        $meetings = null;

        $ids = [];
        if($request->nom) {
            $listeMedias = Media::where('nom_media', 'LIKE', '%'.$request->nom.'%')->get();

            foreach($listeMedias as $media) {
                array_push($ids, $media->id_media);
            }
        }

        if($statut == 'agrees') {

            if(count($ids) > 0) {
                $meetings = Meeting::join('media', 'media.id_media', '=', 'meeting.id_media')
                ->join('user', 'user.id_user', '=', 'media.id_user')
                ->orderBy('user.prenom')->whereIn('id_media', $ids)->where('meeting.agrement', '!=', null)->paginate(NOMBRE_PAR_PAGE);
            } else {
                $meetings = Meeting::join('media', 'media.id_media', '=', 'meeting.id_media')
                ->join('user', 'user.id_user', '=', 'media.id_user')
                ->orderBy('user.prenom')->where('meeting.agrement', '!=', null)->paginate(NOMBRE_PAR_PAGE);
            }
        } else if($statut == 'rendez-vous') {

            if(count($ids) > 0) {
                $meetings = Meeting::join('media', 'media.id_media', '=', 'meeting.id_media')
                ->join('user', 'user.id_user', '=', 'media.id_user')
                ->orderBy('user.prenom')->whereIn('media.id_media', $ids)->where('meeting.agrement', null)->paginate(NOMBRE_PAR_PAGE);
            } else {
                $meetings = Meeting::join('media', 'media.id_media', '=', 'meeting.id_media')
                ->join('user', 'user.id_user', '=', 'media.id_user')
                ->orderBy('user.prenom')->where('meeting.agrement', null)->paginate(NOMBRE_PAR_PAGE);
            }
        } else if(in_array($statut, ['acceptes', 'rejetes', 'nouveaux'])) {
            if(count($ids) > 0) {
                $paiements = Paiement::join('media', 'media.id_media', '=', 'paiement.id_media')
                ->join('user', 'user.id_user', '=', 'media.id_user')
                ->orderBy('user.prenom')->whereIn('media.id_media', $ids)->where(['paiement.id_type_paiement' => $typePaiement->id]);
            } else {
                //$paiements = Paiement::orderBy('created_at', 'DESC')->where(['id_type_paiement' => $typePaiement->id]);
                $paiements = Paiement::join('media', 'media.id_media', '=', 'paiement.id_media')
                ->join('user', 'user.id_user', '=', 'media.id_user')
                ->orderBy('user.prenom')->where(['paiement.id_type_paiement' => $typePaiement->id]);
            }

            if($statut === "nouveaux") {
                $paiements = $paiements->where(['paiement.valide' => null]);
            } else if($statut === "acceptes") {
                $paiements = $paiements->where(['paiement.valide' => true]);
            } else {
                $paiements = $paiements->where(['paiement.valide' => false]);
            }

            $paiements = $paiements->paginate(NOMBRE_PAR_PAGE);

        } else {
            if(count($ids) > 0) {
                $medias = Media::join('user', 'user.id_user', '=', 'media.id_user')
                ->whereIn('media.id_media', $ids)
                ->orderBy('user.prenom')->paginate(NOMBRE_PAR_PAGE);
            } else {
                $medias = Media::join('user', 'user.id_user', '=', 'media.id_user')
                ->orderBy('user.prenom')->paginate(NOMBRE_PAR_PAGE);
            }
        }

        return response()->json([
            'succes' => true,
            'medias' => $medias,
            'paiements' => $paiements,
            'meetings' => $meetings,
            'statut' => $statut
        ]);
    }

    public function checkAgrementMedia(Request $request, $id)
    {
        $meeting = Meeting::firstWhere([['id_media', '=', $id], ['agrement', '!=', null]]);

        return response()->json(['agree' => $meeting !== null]);
    }

    public function checkPaiementAgrementMedia(Request $request, $id)
    {
        $typePaiement = TypePaiement::firstWhere('isagrement', true);
        $paiement = Paiement::firstWhere(['id_media' => $id, 'id_type_paiement' => $typePaiement->id]);

        return response()->json(['paiement' => $paiement]);
    }



    public function getMeetingMedia(Request $request, $id)
    {
        $meeting = Meeting::firstWhere('id_media', $id);
        return response()->json(['meeting' => $meeting]);
    }

    public function genererAgrement(Request $request, $id)
    {
        $media = Media::where('id', $id)->first();

        $agreement = GenerateAgreement::where('media', $id)->first();

        if($agreement) {
            $oldPath = substr_replace($agreement->document, 'public', 0, strlen('/storage'));
            Storage::delete($oldPath);
        } else {
            $agreement = new GenerateAgreement();
            $agreement->media = $media->id;
        }

        $data = [
            'imagePath'    => public_path('dist/img/momo.png'),
            'pathArmoirie' => convertBase64('public/assets/dist/img/armoirie.png'),
            'pathBranding' => convertBase64('public/assets/dist/img/branding.jpg'),
            'flag_guinnea' => convertBase64('public/assets/dist/img/flag_guinea.png'),
            'media' => $media,
            'date' => date('d-m-Y'),
            'nomMinistre' => $request->nomMinistre,
            'genreMinistre' => $request->genreMinistre,
        ];

        $pdf = PDF::loadView('template_documents.projet_agreement', $data);

        utf8_decode($pdf->output());

        $content = $pdf->setPaper('a4')->download()->getOriginalContent();


        $path = 'projet_agreement/'. time().'projet_agreement.pdf';
        Storage::put('public/' . $path, $content);


        $agreement->document = "/storage/" . $path;

        $agreement->save();


        return response()->json([
            'media' => $media,
            'succes' => true,
            'data'=>$agreement,
            'message' => "Projet d'agreement generé avec succès"
        ]);
    }

}
