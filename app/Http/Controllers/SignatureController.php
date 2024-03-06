<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\{Meeting, User};
use App\Models\Programme;
use App\Models\Tracking;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SignatureController extends Controller
{
    public function listeRendezVous(Request $request) {
        if(Auth::user()->role->nom !== 'Direction') {
            return view('404');
        }

        return view('signature.disponibilite', [
            'disponibilites' => Programme::whereNotNull("jour")->paginate(15)
        ]);
    }

    public function disponibles(Request $request) {
        if(Auth::user()->role->nom !== 'Direction') {
            return view('404');
        }

        $programmes = Programme::where('pris', false)->orderBy("date")->paginate(50);
        $jours = Programme::getJours();
        $mois = Programme::getMois();
        $page = "disponibles";
        $titrePage = "Programmes disponibles";
        return view('signature.rendez_vous_disponible', compact('programmes', 'titrePage', 'page', 'mois', 'jours'));
    }

    public function pris(Request $request) {
        if(Auth::user()->role->nom !== 'Direction') {
            return view('404');
        }

        $meetings = Meeting::where([
            ['annuler', '=', false],
            ['agrement', '=', null]
        ])->paginate(50);
        $jours = Programme::getJours();
        $mois = Programme::getMois();
        $page = "pris";
        $titrePage = "Rendez-vous pour signature";
        return view('signature.rendez_vous_pris', compact('meetings', 'titrePage', 'page', 'mois', 'jours'));
    }

    public function ajouterProgramme(Request $request)
    {

        if(Auth::user()->role->nom !== 'Direction') {
            return response()->json([
                'status' => false,
                'message' => "Vous n'êtes pas autorisé a effectué cette action"
            ]);
        }

        Validator::make($request->all(), [
            'jour' => 'required',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
        ])->validate();

        $programme = Programme::create([
            'jour' => $request->jour,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
        ]);

        return response()->json([
            'status' => true,
            'programme' => $programme,
            'close' =>  true,
            'message' => "Le programme a été ajouté"
        ]);
    }

    public function createProgrammeForm()
    {
        return view('signature.rdv.create');
    }

    public function supprimerProgramme(Request $request, $id)
    {
        if(Auth::user()->role->nom !== 'Direction') {
            return response()->json([
                'succes' => false,
                'message' => "Vous n'êtes pas autorisé a effectué cette action"
            ]);
        }

        $programme = Programme::find($id);
        if($programme == null) {
            return response()->json([
                'succes' => false,
                'message' => "Ce programme n'est pas enregistré"
            ]);
        }

        if(Auth::user()->role->nom !== 'Direction') {
            return response()->json([
                'succes' => false,
                'message' => "Vous n'êtes pas autorisé à effectuer cette action"
            ]);
        }

        $programme->delete();
        return response()->json([
            'succes' => true,
            'message' => 'Le programme a été supprimé avec succès'
        ]);
    }

    public function priseRendezVous(Request $request, $id)
    {
        $programmes = Programme::where('pris', false)->paginate(50);
        $jours = Programme::getJours();
        $mois = Programme::getMois();
        $idMedia = $id;

        return view('signature.prise_rendez_vous', compact('programmes', 'mois', 'jours', 'idMedia'));
    }

    public function confirmerRendezVous(Request $request, $id)
    {
        $programme = Programme::find($id);
        if($programme == null) {
            return response()->json([
                'succes' => false,
                'message' => "Ce programme n'est pas enregistré"
            ]);
        }

        if($programme->pris) {
            return response()->json([
                'succes' => false,
                'message' => "Ce programme n'est pas disponible"
            ]);
        }

        $media = Media::find($request->media);
        if($media == null || $media->user->id != Auth::user()->id) {
            return response()->json([
                'succes' => false,
                'message' => "Vous ne disposer pas ce média"
            ]);
        }

        $programme->pris = true;
        $programme->save();

        $media->niveau = 'Direction';
        $media->save();

        $meeting = Meeting::updateOrCreate(
            ['media_id' => $request->media],
            ['nom' => $request->representant, 'programme_id' => $id]
        );
        $meeting->annuler = false;
        $meeting->save();

        $direction = User::whereIn("role_id", function ($query){
            $query->from("role")->whereNom("Direction")->select("id")->get();
        })->where("isvalide", false)->first();

        if($direction) {
            send_notification(
                $direction,
                "Nouveau rendez-vous",
                message_email("prise_de_rdv", $media),
                $meeting->media,
                config("app.url").':'.env("PORT","9000")
            );
        }

        return response()->json([
            'succes' => true,
            'message' => "Votre rendez-vous a été enregistré"
        ]);
    }

    public function signatureAgrement(Request $request, $id)
    {
        $meeting = Meeting::find($id);
        $media = Media::find($meeting->media_id);
        if($meeting == null) {
            return response()->json([
                'status' => false,
                'message' => "Ce rendez-vous n'est pas enregistré"
            ]);
        }

        if(Auth::user()->role->nom !== 'Direction') {
            return response()->json([
                'status' => false,
                'message' => "Vous n'êtes pas autorisé à effectuer cette action"
            ]);
        }

        if($request->file()) {
            $fileName = time().'_'.$request->agrement->getClientOriginalName();
            $filePath = $request->file('agrement')->storeAs('agrments_signes', $fileName, 'public');
        } else {
            return response()->json(['status' => false, 'message' => "Erreur importation fichier"]);
        }

        $meeting->agrement = "/storage/" . $filePath;
        $meeting->save();

        $media->stape = 8;
        $media->current_stape = 9;
        $media->traite = false;
        $media->status_arpt = false;
        $media->agree = true;
        $media->save();

        send_notification(
            $meeting->media->user,
            "Convention d’établissement disponible",
            message_email("signature_agrement"),
            $meeting->media,
            config("app.url").':'.env("PORT","9000")
        );

        if($media->meeting()) $media->meeting()->update(['agrement_signer' => true]);

        $tracking = Tracking::where('media_id',$meeting->media_id)->first();
        if($tracking){
            $tracking->date_importer_agrement = Carbon::now();
            $tracking->save();
        }

        return response()->json([
            'status' => true,
            'refresh' => true,
            'message' => "Le document a été envoyé avec succès"
        ]);

    }

    public function importAgrementForm($id)
    {

        $meeting = Meeting::find($id);
        return view('signature.agrement', [
            'meeting' => $meeting
        ]);
    }

    public function meetingCancelForm($id)
    {
        $meeting = Meeting::find($id);
        return view('meeting.cancel', [
            'meeting' => $meeting
        ]);
    }

    public function previewAgrementReiceip($id)
    {
        $meeting = Meeting::find($id);
        return view('meeting.preview', [
            'meeting' => $meeting
        ]);
    }

    public function meetingCancelPost(Request $request, $id)
    {
        Validator::make($request->all(), [
            'motif' => 'required',
        ])->validate();

        $meeting = Meeting::find($id);
        $meeting->update([
            "annuler" => true,
            "motif" => $request->motif
        ]);

        send_notification(
            $meeting->media->user,
            "Annulation de rendez-vous",
            message_email("annulation_rdv", $meeting),
            $meeting->media,
            config("app.url").':'.env("PORT","9000")
        );

        return response()->json([
            'status' => true,
            'refresh' => true,
            'message' => "Rendez-vous annulé avec succès"
        ]);
    }
}
