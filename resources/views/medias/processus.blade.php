@extends('layouts.default')
@section('page')
Détails Médias
@endsection

@section('titre-page')
{{ $media->nom_media }}
@endsection
<?php use App\Models\Media;  ?>
@section('content')

<div class="container px-4 pb-5">
    @if ($media->if_cahier_charge_valide)
        <div class="my-5">
            <a target="_blank" href="{{asset($media->paiement_cahier_charge->recu_genere)}}" class="btn btn-primary py-2 fs-5 mr-2"> <i class="mdi mdi-download"></i> Reçu de paiement</a>
            <a  href="" class="btn btn-primary py-2 fs-5"> <i class="mdi mdi-download"></i> Cahier des charges</a><br>
        </div>
    @endif

<h3 class="me-0">Etat d'avancement</h3>
<div class="my-auto">
    <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success fw-bold " style="width: {{ $media->progression }}%;" role="progressbar" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100">{{ $media->progression }}%</div>
    </div>
</div>

<h2 class="pb-2 border-bottom"></h2>
@if (session('error_importation'))
<div class="row">
    <div class="col">
        <div class="alert alert-danger">{{ session('error_importation') }}</div>
    </div>
</div>
@endif

@if (session('succes_importation_document'))
<div class="row">
    <div class="col">
        <div class="alert alert-success">{{ session('succes_importation_document') }}</div>
    </div>
</div>
@endif

@if (session('succes_suppression_document'))
<div class="row">
    <div class="col">
        <div class="alert alert-success">{{ session('succes_suppression_document') }}</div>
    </div>
</div>
@endif

@if (session('erreur_suppression_document'))
<div class="row">
    <div class="col">
        <div class="alert alert-danger">{{ session('erreur_suppression_document') }}</div>
    </div>
</div>
@endif

@if (session('succes_soumission'))
<div class="row">
    <div class="col">
        <div class="alert alert-success">{{ session('succes_soumission') }}</div>
    </div>
</div>
@endif

@if (session('error_soumission'))
<div class="row">
    <div class="col">
        <div class="alert alert-danger">{{ session('error_soumission') }}</div>
    </div>
</div>
@endif

@if($errors->has('document'))
<div class="row">
    <div class="col">
    <p class="alert alert-danger">{{ $errors->first('document') }}</p>
    </div>
</div>
@endif

@if($errors->has('type'))
<div class="row">
    <div class="col">
    <p class="alert alert-danger">{{ $errors->first('type') }}</p>
    </div>
</div>
@endif

<div class="row">
    <!-- CAHIER DE CHARGE CONCU AVEC SUCCESS -->
    <div class="col-4">
        <div class="card card-processus @if ($media->if_cahier_charge_valide) card-success @else card-primary @endif">
            <div class="card-header">
                <h4 class="card-title"> Cahier des charges </h4>
            </div>

            <div class="card-body">
            @if ($media->paiement_cahier_charge == null)
                <p>
                    <a class="btn btn-primary" href="{{ route('form_paiement_cahier_charge', ['id'=> $media->id_media])}}">Acheter le Cahier de Charge</a>
                </p>
            @else
                @if ($media->paiement_cahier_charge->valide === null)
                    <p>Votre paiement est en cours de validation</p>
                @else
                    @if ($media->paiement_cahier_charge->valide === 1)
                        <p>Votre paiement a été validé<br>Téléchargement:<br></p>

                        <a target="_blank" href="" class="btn btn-primary mb-4 mr2">Cahier de charges</a>
                        <a target="_blank" href="{{asset($media->paiement_cahier_charge->recu_genere)}}" class="btn btn-primary mb-4">Reçu de paiement</a>
                    @else
                        <p>Votre paiement a été rejeté<p>
                        <p>
                            <a class="btn btn-primary" href="{{ route('form_paiement_cahier_charge', ['id'=> $media->id_media])}}">Acheter le Cahier de Charge</a>
                        </p>
                    @endif
                @endif
            @endif
            </div>
        </div>
    </div>

  <!-- DEPOT DES DOSSIERS DEMANDER DANS LE CAHIER DE CHARGE ET VALIDATION PAR LA COMMISSION-->
    @if ($media->if_cahier_charge_valide)
        <div class="col-4">
            <div class="card card-processus @if ($media->dossier_commission && $media->dossier_commission->valide) card-success @else card-primary @endif">
                <div class="card-header">
                    <h4 class="card-title"> Dépôt du dossier technique</h4>
                </div>

                <div class="card-body">
                    <p id="messageImportationDoc" @if(count($documentsInvalides) <= 0) hidden @endif>Importer vos dossiers techniques</p>

                    <div class="row justify-content-center">

                        <button @if(count($documentsInvalides) <= 0) hidden @endif id="importDocTechnique" type="button" class="btn btn-primary mr-1">Importation</button>

                        @if (count($typesDocument) > 0)
                        <button id="showDocTechnique" type="button" class="btn btn-primary mr-1" data-bs-toggle="modal" data-bs-target="#documentsImportes">{{count($media->documents)}} / {{ count($typesDocument) }} Documents</button>
                        @endif

                        <a id="soumissionDossier" @if (!$soumission) hidden @endif href="{{ route('depot_dossier', ['id' => $media->id_media]) }}" class="btn btn-primary">Soumettre</a>

                    </div>
                    @if ($media->dossier_commission)
                        @if ($media->dossier_commission->valide !== null)
                            @if ($media->dossier_commission->valide === 1)
                            <p class="validation-commission">Votre dossier a été validé</p>
                            @endif

                            @if ($media->dossier_commission->valide === 0)
                            <p class="validation-commission">Votre dossier a été rejeté</p>
                            @endif

                            <a target="_blank" class="btn btn-primary validation-commission" href="{{asset($media->dossier_commission->rapport)}}">Télécharger rapport</a>
                        @else
                            @if ($media->dossier_commission->etude_en_cours)
                                <p>Votre dossier est en cours étude par la commission</p>
                            @else
                                <p>Votre dossier sera soumi à la commission pour une étude</p>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- ETUDE DU DOSSIER PAR LA HAC -->
    @if ($media->dossier_commission && $media->dossier_commission->valide)
    <div class="col-4">
        <div class="card card-processus @if ($media->dossier_hac && $media->dossier_hac->valide) card-success @else card-primary @endif">
            <div class="card-header">
            <h4 class="card-title">Etude du dossier par la HAC</h4>
            </div>

            <div class="card-body">
                @if ($media->dossier_hac)
                    @if ($media->dossier_hac->valide === null)
                        <p>La HAC effectue l'étude de votre dossier</p>
                    @else
                        @if ($media->dossier_hac->valide)
                            <p>Votre dossier a été validé par HAC </p>
                        @else
                            <p>Votre dossier a été rejeté par HAC </p>
                        @endif

                        <a target="_blank" class="btn btn-primary" href="{{asset($media->dossier_hac->rapport)}}">Télécharger rapport</a>
                    @endif

                    @else
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- PAIEMENT FRAIS AGREMENT ET VALIDATION PAR LA DIRECTION -->
    @if ($media->dossier_hac && $media->dossier_hac->valide)
    <div class="col-4">
        <div class="card card-processus @if ($media->dossier_sgg) card-success @else card-primary @endif">
            <div class="card-header">
                <h4 class="card-title">Paiement des frais de l'agrément</h4>
            </div>

            <div class="card-body">

                <p @if($paiement && $paiement->valide === null) @else hidden @endif id="messageAttenteValidationFraisAgrement">Votre reçu sera validé par la direction</p>
                <p @if($paiement && $paiement->valide === 1) @else hidden @endif>Votre reçu a été validé</p>
                <p @if($paiement && $paiement->valide === 0) @else hidden @endif id="messageRejetFraisAgrement">Votre reçu a été rejeté</p>

                <button @if($hideImportFraisAgrement) hidden @endif id="importRecuFraisAgrement" class="btn btn-primary mr-1" data-bs-toggle="modal" data-bs-target="#modalImportRecuFraisAgrement">Importer le reçu</button>
            </div>
        </div>
    </div>
    @endif

    <!-- VALIDATION DOSSIERS PAR LE SGG -->
    @if ($media->dossier_sgg)
    <div class="col-4">
        <div class="card card-processus @if ($media->dossier_sgg && $media->dossier_sgg->agrement) card-success @else card-primary @endif">
            <div class="card-header">
            <h4 class="card-title">Sécretairat Général du Gouvernement</h4>
            </div>

            <div class="card-body">
                @if ($media->dossier_sgg->agrement)
                    <p>Votre numéro d'agrément est sortie</p>
                @else
                    <p>La création de votre numéro d'agrément est en cours</p>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- PRISE DE RENDEZ-VOUS -->
    @if ($media->dossier_sgg && $media->dossier_sgg->agrement)
    <div class="col-4">
        <div class="card card-processus @if ($media->meeting && $media->meeting->agrement) card-success @else card-primary @endif">
            <div class="card-header">
                <h4 class="card-title">Prise de rendez-vous</h4>
            </div>

            <div class="card-body">
                @if ($media->meeting === null || $media->meeting->annuler === 1)
                    @if ($media->meeting === null)
                    <p>Prenez votre rendez-vous pour la signature</p>
                    @else
                    <p>Votre rendez-vous du {{ $media->meeting->programme->format_date_avec_jour }} a été annuler</p>
                    <p>Prenez un autre rendez-vous</p>
                    @endif

                    <a class="btn btn-primary" href="{{ route('prise_rendez_vous', ['id' => $media->id_media])}}">Prendre</a>
                @else
                <p>
                    Votre rendez-vous pour la signature est le
                    {{ $media->meeting->programme->format_date_avec_jour }}
                </p>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- AGREMENT SIGNE -->
    @if ($media->meeting && $media->meeting->agrement)
    <div class="col-4">
        <div class="card card-processus card-success">
            <div class="card-header">
                <h4 class="card-title">Agrément signé</h4>
            </div>

            <div class="card-body">
                <a target="_blank" class="btn btn-primary" href="{{ $media->meeting->agrement }}">
                    <i class="fa fa-download" aria-hidden="true"></i>Télécharger
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
</div>

<div class="modal fade" id="modalImportDossier">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Importation dossier technique<i class="mdi mdi-book-edit"></i></h4>
          <button type="button" data-bs-dismiss="modal" class="btn btn-close btn-danger">x</button>
        </div>
        <div class="modal-body">
            <form id="formImportDoc" enctype="multipart/form-data" method="post" action="{{ route('importation_document_technique', ['id' => $media->id_media]) }}">
                @csrf
                <div class="form-group">
                    <label>Select</label>
                    <select id="typeDocument" name="type" class="form-control">
                        @foreach ($documentsInvalides as $type)
                            <option value="{{ $type->id_type_document }}">{{ $type->libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <div class="custom-file">
                        <input name="document" accept=".doc,.docx,.pdf" type="file" class="custom-file-input" id="documentTechnique">
                        <label class="custom-file-label" for="documentTechnique">importer</label>
                    </div>
                </div>
            </form>

            <div class="row justify-content-center">
                <button type="submit" class="btn btn-primary mr-1" id="confirmImportDoc">Importer</button>
                <button data-bs-dismiss="modal" class="btn btn-close btn-danger">Fermer</button>
            </div>
        </div>
      </div>
    </div>
</div>


<div class="modal fade" id="documentsImportes">
    <div class="modal-dialog modal-dialog-center modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Documents importés<i class="mdi mdi-book-edit"></i></h4>
          <button type="button" data-bs-dismiss="modal" class="btn btn-close btn-danger">x</button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 15px">#</th>
                        <th>Document</th>
                        <th style="width: 100px">Téléchargement</th>
                        <th style="width: 80px">Commission</th>
                        <th style="width: 80px">HAC</th>
                        @if ($media->dossier_commission === null || $media->dossier_commission->valide === 0)
                            <th style="width: 100px">Action.s</th>
                        @endif
                    </tr>
                </thead>

                <tbody id="listeDocumentImportes">
                    @foreach ($media->documents as $document)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $document->type_document->libelle }}</td>
                            <td>
                                <a target="_blank" href="{{ asset($document->file_path) }}">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td>
                                @if ($document->validation_commission !== null)
                                    @if ($document->validation_commission)
                                    <span class="text text-success"><i class="fa fa-check"></i></span>
                                    @else
                                    <span class="text text-danger"><i class="fa fa-exclamation"></i></span>
                                    @endif
                                @else
                                @endif

                            </td>
                            <td>
                                @if ($document->validation_hac !== null)
                                    @if ($document->validation_hac)
                                    <span class="text text-success"><i class="fa fa-check"></i></span>
                                    @else
                                    <span class="text text-danger"><i class="fa fa-exclamation"></i></span>
                                    @endif
                                @else
                                @endif

                            </td>
                            @if ($media->dossier_commission === null || $media->dossier_commission->valide === 0)
                                <td>
                                    @if ($document->validation_commission !== 1)
                                    <span id="supDoc-{{$document->id_document}}" class="text text-danger supprimer-document"><i class="fa fa-trash"></i></span>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalConfirmSupDoc">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-body">
            <p>Voulez-vous vraiment supprimer ce document?</p>

            <div class="row justify-content-center">
                <button type="button" class="btn btn-primary mr-1" id="confirmSupDoc">OUI</button>
                <button type="button" data-bs-dismiss="modal" class="btn btn-danger btn-close">NON</button>
            </div>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalImportRecuFraisAgrement">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Importation reçu frais d'agrément<i class="mdi mdi-book-edit"></i></h4>
          <button type="button" data-bs-dismiss="modal" class="btn btn-close btn-danger">x</button>
        </div>
        <div class="modal-body">
            <form id="formImportFraisAgrement" enctype="multipart/form-data" method="post" action="{{ route('paiement_frais_agrement', ['id' => $media->id_media]) }}">
                @csrf

                <div class="form-group">
                    <div class="custom-file">
                        <input accept=".pdf,png,.jpg" name="recu" type="file" class="custom-file-input" id="recuFraisAgrement">
                        <label class="custom-file-label" for="recuFraisAgrement">importer</label>
                    </div>
                </div>
            </form>

            <div class="row justify-content-center">
                <button class="btn btn-primary mr-1" id="confirmImportRecuFraisAgrement">Importer</button>
                <button data-bs-dismiss="modal" class="btn btn-close btn-danger">Fermer</button>
            </div>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalPriseRendezVous">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Prise de rendez-vous<i class="mdi mdi-book-edit"></i></h4>
          <button type="button" data-bs-dismiss="modal" class="btn btn-close btn-danger">x</button>
        </div>
        <div class="modal-body">

        </div>
      </div>
    </div>
</div>

<script src="{{asset('js/processus.js')}} "></script>
@endsection
