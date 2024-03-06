<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Media;
use DateTimeImmutable;
use App\Models\Paiement;
use App\Models\DossiersSGG;
use App\Models\TypePaiement;
use Illuminate\Http\Request;
use App\Models\ParametrePaiement;
use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaiementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function paiementCahierCharger(Request $request, $id) {
        $media = Media::firstWhere('id_media', $id);
        $paiement = ParametrePaiement::firstWhere('is_cahier_charge', true);
        $origin = new DateTimeImmutable(date('Y-m-d'));
        $target = new DateTimeImmutable(date('Y-m-d'));
        $interval = $origin->diff($target);

        return view('paiements.paiement_cahier_charge', compact('media', 'interval', 'paiement'));
    }

    public function enregistrementPaiementCahierCharge(Request $request, $id) {

        if($request->mode == 'orange' || $request->mode == 'momo') {
            if(!preg_match('/^[0-9]{9}$/', $request->numero)) {
                return response()->json([
                    'succes' => false,
                    'message' => "Le numéro doit comporter 9 chiffre"
                ]);
            }


            if($request->mode == 'orange' && !preg_match('/^6[12]/', $request->numero)) {
                return response()->json([
                    'succes' => false,
                    'message' => "Vous devez saisir un numéro Orange"
                ]);
            }

            if($request->mode == 'momo' && !preg_match('/^66/', $request->numero)) {
                return response()->json([
                    'succes' => false,
                    'message' => "Vous devez saisir un numéro MTN"
                ]);
            }
        }

        if($request->mode == 'recu' && !$request->file()) {
            return response()->json([
                'succes' => false,
                'message' => "Vous devez importer le reçu"
            ]);
        }

        $typePaiement = TypePaiement::firstWhere('iscahiercharge', true);
        $paiement = ParametrePaiement::firstWhere('is_cahier_charge', true);

        $data = [
            'montant' => $paiement->montant,
            'mode' => $request->mode,
            'id_type_paiement' => $typePaiement->id,
            'valide' => null
        ];

        if($request->mode == 'orange' || $request->mode == 'momo') {
            $data['numero'] = $request->numero;
        }

        if($request->mode == 'recu') {
            $fileName = time().'_'.$request->recu->getClientOriginalName();
            $filePath = $request->file('recu')->storeAs('recus', $fileName, 'public');
            $data['recu'] = "/storage/" . $filePath;
        }

        $paiement = Paiement::updateOrCreate(['id_media' => $id], $data);
        $paiement->valide = null;
        $paiement->save();

        $media = $paiement->media;
        $media->niveau = 'DAF';
        $media->save();

        return response()->json([
            'succes' => true,
            'message' => "La paiement a été effectué avec succès"
        ]);
    }

    public function paiementsCahierCharges(Request $request) {
        if(Auth::user()->role->nom !== 'DAF') {
            return view('404');
        }

        $typePaiement = TypePaiement::firstWhere('iscahiercharge', true);
        $paiements = Paiement::orderBy('created_at', 'DESC')->where(['id_type_paiement' => $typePaiement->id]);
        $paiements = $paiements->paginate(NOMBRE_PAR_PAGE);

        $modes = [
            'momo' => 'Mobile Money',
            'orange' => 'Orange Money',
            'recu' => 'Importation reçu'
        ];

        return view('paiements.chahier_de_charge', compact('paiements', 'modes'));
    }

    public function filtrePaiementsCahierCharges(Request $request, $statut) {
        if(Auth::user()->role->nom !== 'DAF') {
            return response()->json([
                'succes' => false,
                'message' => "Vous n'êtes pas autorisé à aceder à cette page"
            ]);
        }

        $typePaiement = TypePaiement::firstWhere('iscahiercharge', true);

        if($request->nom) {
            $medias = Media::where('nom_media', 'LIKE', '%'.$request->nom.'%')->get();
            $ids = [];
            foreach($medias as $media) {
                array_push($ids, $media->id_media);
            }
            $paiements = Paiement::orderBy('created_at', 'DESC')->whereIn('id_media', $ids)->where(['id_type_paiement' => $typePaiement->id]);
        } else {
            $paiements = Paiement::orderBy('created_at', 'DESC')->where(['id_type_paiement' => $typePaiement->id]);
        }

        if($statut === 'nouveaux') {
            $paiements = $paiements->where(['valide' => null])->paginate(NOMBRE_PAR_PAGE);
        } else if($statut === 'acceptes') {
            $paiements = $paiements->where(['valide' => true])->paginate(NOMBRE_PAR_PAGE);
        } else if($statut === 'rejetes') {
            $paiements = $paiements->where(['valide' => false])->paginate(NOMBRE_PAR_PAGE);
        } else {
            $paiements = $paiements->paginate(NOMBRE_PAR_PAGE);
        }

        return response()->json([
            'succes' => true,
            'paiements' => $paiements
        ]);
    }

    public function validationPaiementCahierCharger(Request $request, $id) {
        if(Auth::user()->role->nom !== 'DAF') {
            return response()->json(['succes' => false, 'message' => "Vous n'êtes pas autorisé à importer le reçu dans ce média"]);
        }
        $paiement = Paiement::find($id);
        $level = Media::find($paiement->id_media);
        if($paiement == null) {
            return response()->json([
                'succes' => false,
                'message' => "Ce paiement n'est pas enregistré"
            ]);
        }
        $valider = $request->valider == 1;
        $paiement->valide = $valider;
        $paiement->commentaire = $request->commentaire;
        $Recever= DB::table('media')
                ->select('id_user')->where('id_media',$id)
                ->first();
        if($valider) {
            $media = $paiement->media;
            $level->level=1;
            $level->level_current =2;
            $level->save();
            $data = [
                'imagePath'    => public_path('dist/img/momo.png'),
                'pathArmoirie' => convertBase64('public/assets/dist/img/armoirie.png'),
                'pathBranding' => convertBase64('public/assets/dist/img/branding.jpg'),
                'flag_guinnea' => convertBase64('public/assets/dist/img/flag_guinea.png'),
                'media' => $media->nom_media,
                'montant' => $paiement->montant,
                'date' => date('d-m-Y'),
                'mode' => $paiement->mode
            ];
            $pdf = PDF::loadView('template_documents.recu_cahier_charge', $data);
            // $content = $pdf->download()->getOriginalContent();
            $content = $pdf->setPaper('a4')->download()->getOriginalContent();

            $path = 'recus_cahier_charge_genere/'. time().'_recu.pdf';
            Storage::put('public/' . $path, $content);
            $paiement->recu_genere = "/storage/" .$path;
            $message = message_email("validation_paiement_cahier_de_charge_autre");
            $objet = "Paiement de cahier des charges";
        }else{

            if($paiement->commentaire == "Montant incorrect") {
                $message = message_email("rejet_paiement_cahier_de_charge_montant_incorrect");

            } else {
                $message = message_email("rejet_paiement_cahier_de_charge_autre", null, $paiement->commentaire);

            }

            $objet = "Paiement de cahier des charges";
            $level->level=0;
            $level->save();
        }


        $paiement->save();
        $media = $paiement->media;
        $media->niveau = 'Promoteur';
        $media->save();

        send_notification($media->user, $objet, $message, $media, config("app.url").':'.env("PORT","9000"));

        $tracking = Tracking::where('id_media',$paiement->id_media)->first();
        if($tracking){
            $tracking->date_valide_cahier = Carbon::now();
            $tracking->save();
        }

        return response()->json([
            'succes' => true,
            'valide' => $valider,
            'message' => "Le paiement a été " . ($valider ? 'validé' : 'rejeté')
        ]);
    }

    public function paiementsCahierChargerAcceptes(Request $request) {
        if(Auth::user()->role->nom !== 'DAF' && Auth::user()->role->nom !== 'Direction') {
            return view('404');
        }

        $typePaiement = TypePaiement::firstWhere('iscahiercharge', true);

        if($request->nom) {
            $medias = Media::where('nom_media', 'LIKE', '%'.$request->nom.'%')->get();
            $ids = [];
            foreach($medias as $media) {
                array_push($ids, $media->id_media);
            }
            $paiements = Paiement::whereIn('id_media', $ids)->where(['valide' => true, 'id_type_paiement' => $typePaiement->id])->paginate(20);
        } else {
            $paiements = Paiement::where(['valide' => true, 'id_type_paiement' => $typePaiement->id])->paginate(20);
        }
        $page = 'accepte';
        $titrePage = "Paiement Cahier de charge validés";
        return view('paiements.chahier_de_charge', compact('paiements', 'page', 'titrePage'));
    }

    public function paiementsCahierChargerRejetes(Request $request) {
        if(Auth::user()->role->nom !== 'DAF' && Auth::user()->role->nom !== 'Direction') {
            return view('404');
        }

        $typePaiement = TypePaiement::firstWhere('iscahiercharge', true);

        if($request->nom) {
            $medias = Media::where('nom_media', 'LIKE', '%'.$request->nom.'%')->get();
            $ids = [];
            foreach($medias as $media) {
                array_push($ids, $media->id_media);
            }

            $paiements = Paiement::whereIn('id_media', $ids)->where(['valide' => false, 'id_type_paiement' => $typePaiement->id])->paginate(20);
        } else {
            $paiements = Paiement::where(['valide' => false, 'id_type_paiement' => $typePaiement->id])->paginate(20);
        }

        $page = 'rejete';
        $titrePage = "Paiement Cahier de charge rejetés";
        return view('paiements.chahier_de_charge', compact('paiements', 'page', 'titrePage'));
    }

    public function paiementFraisAgrement(Request $request, $id) {
        $media = Media::find($id);
        if($media == null) {
            return response()->json([
                'succes' => false,
                'message' => "Vous ne disposer pas de ce média"
            ]);
        }

        if(Auth::user()->id_user !== $media->user->id_user) {
            return response()->json(['succes' => false, 'message' => "Vous n'êtes pas autorisé à importer le reçu dans ce média"]);
        }

        $parametrePaiement = $media->type_media->parametre_paiement;
        $typePaiement = TypePaiement::firstWhere('isagrement', true);

        if($typePaiement == null) {
            return response()->json([
                'succes' => false,
                'message' => "Une erreur s'est produit lors de l'importation du reçu"
            ]);
        }

        if($request->file()) {
            $fileName = time().'_'.$request->recu->getClientOriginalName();
            $filePath = $request->file('recu')->storeAs('recus_agrement', $fileName, 'public');

            $paiement = Paiement::updateOrCreate(
                ['id_media' => $id, 'id_type_paiement' => $typePaiement->id],
                [
                    'montant' => $parametrePaiement->montant,
                    'mode' => 'Recu',
                    'recu' => "/storage/" . $filePath,
                ]
            );

            $paiement->valide = null;
            $paiement->save();

            $media = $paiement->media;
            $media->niveau = 'Direction';
            $media->save();

            return response()->json([
                'succes' => true,
                'message' => "Le paiement a été effectué avec succes"
            ]);
        } else {
            return response()->json([
                'succes' => false,
                'message' => "Vous devez importer le reçu de paiement"
            ]);
        }
    }

    public function validationPaiementFraisAgrement(Request $request, $id) {
        if(Auth::user()->role->nom !== 'Direction') {
            return response()->json(['succes' => false, 'message' => "Vous n'êtes pas autorisé à importer le reçu dans ce média"]);
        }

        $paiement = Paiement::find($id);
        $level = Media::find($paiement->id_media);

        if($paiement == null) {
            return response()->json([
                'succes' => false,
                'message' => "Ce paiement n'est pas enregistré"
            ]);
        }

        $valide = $request->valider == 1;
        $paiement->valide =  $valide;
        $paiement->save();

        $media = $paiement->media;
        $media->niveau = 'SGG';
        $media->save();

        if($valide) {

            $message = message_email('validation_recu_de_paiement_agrement');
            $objet = "Paiement agrément(Trésor public)";
            DossiersSGG::create(['id_media' => $paiement->media->id_media]);
            $level->level = 4;
            $level->save();
        }else{
            $message = message_email("rejet_recu_de_paiement_agrement");
            $objet = "Paiement agrément(Trésor public)";
            $level->level = 3;
            $level->save();
        }

        send_notification($media->user, $objet, $message, $media);

        return response()->json([
            'succes' => true,
            'valide' => $valide,
            'idMedia' => $media->id_media,
            'message' => "Le paiement des frais a été " . ($valide ? 'validé' : 'rejeté')
        ]);
    }
}