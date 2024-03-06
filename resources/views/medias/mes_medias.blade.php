@extends('layouts.default')
@section('page')
Mes Médias
@endsection

@section('titre-page')
Mes Médias
@endsection

@section('content')
<div class="row">
    @foreach ($medias as $media)
    <div class="col-4">
        <div class="card shadow">
        <img src="" alt="LOGO" class="bd-placeholder-img card-img-top" width="100%" height="225">
        <div class="card-body">

        <div class="my-auto">
            <p class="text-center fw-bold text-uppercase fs-2 my-0">{{ $media->nom_media }}</p>
            <div class="row">
            <p class="card-text col my-0">Type de médias<br> <small class="fw-bold text-uppercase">{{ $media->type_media->libelle }}</small></p>
            <p class="card-text col border-start my-0">Forme juridique<br> <small class="fw-bold text-capitalize">{{ $media->forme_juridique->libelle }}</p>
            </div>
            <div class="row">
            <p class="card-text col my-0">Date d'ajout <br> <small class="fw-bold text-uppercase">{{ $media->created_at }}</small></p>
            </div>
        </div>


        <div class="row">
            <div class="col-3">
                <p class="card-text border-start col my-0">
                    <a class="float-end btn btn-outline-success w-100 fs-5" href="{{ route('details-medias', ['id'=> $media->id_media])}}"> <i class="mdi mdi-folder-eye mdi-24px"></i> Détails</a>
                </p>
            </div>

            @if (!$media->if_cahier_charge_paye)
                <div class="col-3">
                <p class="card-text border-start col my-0">
                    <a class="float-end btn btn-outline-success w-100 fs-5" href="{{ route('form_paiement_cahier_charge', ['id'=> $media->id_media])}}"> <i class="mdi mdi-folder-eye mdi-24px"></i> Acheter le Cahier de Charge</a>
                </p>
                </div>
            @endif

            @if ($media->if_cahier_charge_valide)
                <div class="col-3">
                    <p class="card-text border-start col my-0">
                        <a class="float-end btn btn-outline-success w-100 fs-5" href="">Cahier de Charges</a>
                    </p>
                </div>
            @endif
        </div>

        </div>
    </div>
    @endforeach
</div>
@endsection

