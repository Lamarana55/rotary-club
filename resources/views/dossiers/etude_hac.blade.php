@extends('layouts.default')
<?php $userIds = [] ?>
@section('page')
Médias
@endsection

@section('content')
<div class="row justify-content-center mb-2">
    <div class="col-10">
        <div class="row">
            <div class="col-3">
                <form>
                    <div class="form-group">
                        <select id="statut" class="form-control">
                            <option value="tous">Tous</option>
                            <option value="nouveaux">Nouveaux</option>
                            <option value="acceptes">Acceptés</option>
                            <option value="rejetes">Rejetés</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-2">
        <form>
            <div class="input-group mb-3">
                <input id="nomMedia" name="nom" type="text" class="form-control" placeholder="Nom du média">
                <div class="input-group-append">
                    <button id="rechercheMedia" type="submit" class="btn btn-primary">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>

<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Promoteur</th>
                            <th>Média</th>
                            <th>Type</th>
                            <th style="width: 270px">Email</th>
                            <th style="width: 150px">Téléphone</th>
                            <th style="width: 100px">Etat</th>
                            <th style="width: 300px" class="text-right">Action.s</th>
                        </tr>
                    </thead>

                    <tbody id="listeDossiers">
                    @foreach ($dossiers as $dossier)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            @if(!in_array($dossier->media->id_user, $userIds))
                                <td class="align-middle" rowspan="{{count($dossier->media->user->media)}}">{{ $dossier->media->user->prenom }} {{ $dossier->media->user->nom }}</td>
                            @endif
                            <td>{{ $dossier->media->nom_media }}</td>
                            <td>{{ $dossier->media->type_media->libelle }}</td>
                            <td>{{ $dossier->media->email }}</td>
                            <td>{{ number_format(str_replace(' ', '', $dossier->media->telephone), 0, '', ' ') }}</td>
                            <td style="text-align: center">

                                <span id="statutNouveau-{{ $dossier->id }}" @if($dossier->valide === null) @else hidden @endif>
                                    En Cours
                                </span>

                                <span id="statutAccepte-{{ $dossier->id }}" @if($dossier->valide === 1) @else hidden @endif>
                                    Accepté
                                </span>

                                <span id="statutRejete-{{ $dossier->id }}" @if($dossier->valide === 0) @else hidden @endif>
                                    Rejeté
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="row justify-content-end">
                                    <a class="btn btn-info btn-sm mr-2" href="{{ route('details', ['id' => $dossier->media->id_media]) }}">Détails</a>

                                    <a href="/medias/{{ $dossier->media->id_media }}/etudes-documents" id="etudier-{{$dossier->id}}" class="btn btn-primary btn-sm mr-1 etude-hac">
                                        @if($dossier->etude_termine) Voir documents
                                        @else {{$dossier->media->analyse_hac_text_button}}
                                        @endif
                                    </a>
                                    <a class="btn btn-primary btn-sm mr-1 rapport-hac" href="{{ route('redaction-rapport-hac',[$dossier->media->id_media,'dossier_hac_id'=>$dossier->id,'type_commission'=>'hac']) }}"  @if ($dossier->etude_termine && $dossier->valide === null) @else hidden @endif >Rapport</a>
                                </div>
                            </td>
                        </tr>
                        <?php array_push($userIds, $dossier->media->id_user); ?>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix" id="pagination">
                {{ $dossiers->links()}}
            </div>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEtudeDossier">
    <div class="modal-dialog modal-dialog-center modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Documents<i class="mdi mdi-book-edit"></i></h4>
        </div>
        <div class="modal-body">
            <p id="erreurChargement"></p>
            <table id="tableDocuments" class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 15px">#</th>
                        <th>Document</th>
                        <th style="width: 80px">Téléchargement</th>
                        <th style="width: 250px">Action.s</th>
                    </tr>
                </thead>

                <tbody id="listeDocuments">

                </tbody>
            </table>

            <div class="row justify-content-end">
                <button id="fermerDocuments" type="button" class="btn btn-danger">Annuler</button>
                <button hidden id="terminerEtudeDocument" type="button" class="btn btn-primary mr-1">Analyse terminée</button>
            </div>
        </div>
      </div>
    </div>
</div>


<div class="modal fade" id="modalRapport">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Commission Technique</h4>
          {{-- <button type="button" data-bs-dismiss="modal" class="btn btn-close btn-danger">x</button> --}}
        </div>
        <div class="modal-body">
            <p>Rapport du média <strong id="nomMediaRapport"></strong></p>
            <form enctype="multipart/form-data" method="post" id="formRapport">
                @csrf
                <div class="form-group">
                    <label>Avis</label>
                    <textarea id="documentRapport" name="rapport" class="form-control" rows="5" placeholder="Tapez le rapport "></textarea>
                </div>
            </form>
        </div>

        <div class="modal-footer justify-content-end">
            <button type="button" data-bs-dismiss="modal" id="fermerRapport" class="btn btn-danger btn-close">Fermer</button>
            <button type="button" class="btn btn-success mr-1" id="validerRapport">Valider</button>
        </div>
      </div>
    </div>
</div>


<script src="{{asset('js/dossiers_hac.js')}} "></script>

@endsection

