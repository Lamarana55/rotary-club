<?php

namespace App\Http\Livewire;

use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GestionStatistiqueComponent extends Component
{
    public $nbMediaCreer =0;
    public $nbMediaRejeter =0;
    public $nbMediaTerminer =0;
    public $nbMediaEncours =0;
    public $nbDocumentMedias =0;
    public $filterEncours ="";

    public $sggTitleList = ['En attente','Terminé'];
    public $sggData;
    public $arptData;
    public $days = [];
    public $type_media = [];
    public $nombreTypeMedia = [];
    public $type_promoteur = [];
    public $nombreTypePromoteur = [];
    public $nombrePaiementCahierCharge = [];
    public $nombrePaiementFraisAgrement = [];
    public $cahierCharges = ['Validé','Rejeté','En attente'];
    public $FraisAgrement = ['Validé','Rejeté','En attente'];
    public $etudeCommission = ['En attente', 'En cours','Terminé'];
    public $nombreEtudeCommission = [];
    public $nombreEtudeHac = [];
    public $filter;
    public $terminer;
    public $en_cours;
    public $en_attente;
    public $agree;

    public $subscribers = [30, 36, 42, 78, 88, 109, 205, 325, 349, 480, 556];

    public $recentSubscribers = 556;

    public function AdminAuthCheck()
    {
        $this->days = collect(range(13, 24))->map(function ($number) {
            return 'Jun ' . $number;
        });

        if (!Auth::check()) {
            return redirect('/login');
        }elseif(Auth::check() && Auth::user()->role->nom === 'Promoteur') {
            return redirect('/mes-medias');
        }
    }


    public function fetchData()
    {
        $subscribers = array_replace($this->subscribers, [10 => $this->recentSubscribers += 10]);

        $this->emit('refreshChart', ['seriesData' => $subscribers]);
    }

    public function stateEtatMedia()
    {
        if($this->filter){
            $this->nbMediaCreer = DB::table('media')->where('date_create',$this->filter)->count('id');
        }else{
            $this->nbMediaCreer = DB::table('media')->count('id');
            $this->terminer = DB::table('media')->where('traite',true)->count('id');
            $this->agree = DB::table('media')->where('agree',true)->count('id');

            $this->en_cours = DB::table('media')->where('en_cours',true)->count('id');

            $this->en_attente = DB::table('media')->where('en_attente',true)->count('id');
        }

    }

    public function getSggAndArpt(){
        $media = new Media();
        $this->sggData = [$media->where('status_sgg',0)->count(),$media->where('status_sgg',1)->count()];
        $this->arptData = [$media->where('status_arpt',0)->count(),$media->where('status_arpt',1)->count()];
        // dump($media->where('status_sgg',1)->count());
    }

    public function render()
    {
        if(!hasPermission('afficher_statistique')){
            $this->redirect("/page-not-permission");
        }

        $this->AdminAuthCheck();
        $this->nombreMediaCreerType();
        $this->nombrePromoteurByType();
        $this->paiementByCahierCharge();
        $this->paiementByFraisAgrement();
        $this->etudeCommission();
        $this->etudeHac();
        $this->getSggAndArpt();
        $this->stateEtatMedia();
        return view('statistiques.index')
            ->extends("layouts.default")
            ->section("content");
    }

    public function nombreMediaCreerType()
    {
        $chart = DB::table('media')
            ->select(
                DB::raw('count(media.id) as `quantite`'),
                DB::raw('(media.type_media) as `type_media`'),
            )
            ->groupby('media.type_media')
            ->get();

        $this->type_media = collect($chart)->map(function ($data) {
            return $data->type_media;
        });

        $this->nombreTypeMedia = collect($chart)->map(function ($data) {
            return $data->quantite;
        });

    }

    public function nombrePromoteurByType()
    {
        $chart = DB::table('user')
            ->join('type_promoteur','user.type_promoteur_id','=','type_promoteur.id')
            ->where('user.is_deleted',0)
            ->where('user.isvalide',1)
            ->select(
                DB::raw('count(user.id) as `nombre`'),
                DB::raw('(type_promoteur.nom) as `type_promoteur`'),
            )
            ->groupBy('type_promoteur')
            ->orderBy('type_promoteur.nom', 'DESC')
            ->get();

        $this->type_promoteur = collect($chart)->map(function ($data) {
            return $data->type_promoteur;
        });

        $this->nombreTypePromoteur = collect($chart)->map(function ($data) {
            return $data->nombre;
        });

    }

    public function paiementByCahierCharge()
    {
        $valideCahier = DB::table('paiement')
            ->where('type_paiement','cahierDesCharges')
            ->where('is_valided',1)
            ->count('id');

        $rejeterCahier = DB::table('paiement')
            ->where('type_paiement','cahierDesCharges')
            ->where('is_valided',0)
            ->count('id');

        $attenteCahier = DB::table('paiement')
            ->where('type_paiement','cahierDesCharges')
            ->where('is_valided',null)
            ->count('id');

        $this->nombrePaiementCahierCharge = [$valideCahier,$rejeterCahier,$attenteCahier];
    }

    public function paiementByFraisAgrement()
    {
        $valideCahier = DB::table('paiement')
            ->where('type_paiement','fraisAgrement')
            ->where('is_valided',1)
            ->count('id');

        $rejeterCahier = DB::table('paiement')
            ->where('type_paiement','fraisAgrement')
            ->where('is_valided',0)
            ->count('id');

        $attenteCahier = DB::table('paiement')
            ->where('type_paiement','fraisAgrement')
            ->where('is_valided',null)
            ->count('id');

        $this->nombrePaiementFraisAgrement = [$valideCahier,$rejeterCahier,$attenteCahier];
    }

    public function etudeCommission()
    {
        if($this->filter){
            $terminer = DB::table('media')->where('date_create',$this->filter)->where('traite_commission',true)->count('id');

            $en_cours = DB::table('media')->where('date_create',$this->filter)->where('en_cours_commission',true)->count('id');

            $en_attente = DB::table('media')->where('date_create',$this->filter)->where('en_attente_commission',true)->count('id');

            $this->nombreEtudeCommission = [$en_attente,$en_cours,$terminer];
        }else{
            $terminer = DB::table('media')->where('traite_commission',true)->count('id');

            $en_cours = DB::table('media')->where('en_cours_commission',true)->count('id');

            $en_attente = DB::table('media')->where('en_attente_commission',true)->count('id');

            $this->nombreEtudeCommission = [$en_attente,$en_cours,$terminer];
        }

    }

    public function etudeHac()
    {
        if($this->filter){
            $terminer = DB::table('media')->where('date_create',$this->filter)->where('traite_hac',true)->count('id');

            $en_cours = DB::table('media')->where('date_create',$this->filter)->where('en_cours_hac',true)->count('id');

            $en_attente = DB::table('media')->where('date_create',$this->filter)->where('en_attente_hac',true)->count('id');
            $this->nombreEtudeHac = [$en_attente,$en_cours,$terminer];
        }else{
            $terminer = DB::table('media')->where('traite_hac',true)->count('id');

            $en_cours = DB::table('media')->where('en_cours_hac',true)->count('id');

            $en_attente = DB::table('media')->where('en_attente_hac',true)->count('id');

            $this->nombreEtudeHac = [$en_attente,$en_cours,$terminer];
        }

    }
}
