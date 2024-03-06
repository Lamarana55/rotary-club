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
                            <option value="etude">Études</option>
                            <option value="acceptes">Acceptés</option>
                            <option value="rejetes">Rejetés</option>
                            <option value="revoir">Revoir</option>
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

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        @include('dossiers.header_commission')

                        <tbody id="listeDossiers" class="listeDossiers">
                        @foreach ($dossiers as $dossier)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                @if(!in_array($dossier->media->id_user, $userIds))
                                <td class="align-middle" rowspan="{{count($dossier->media->user->media)}}">{{ $dossier->media->user->prenom }} {{ $dossier->media->user->nom }}</td>
                                @endif
                                <td>{{ $dossier->media->nom_media }}</td>
                                <td>{{ $dossier->media->type_media->libelle }}</td>
                                <td>{{ $dossier->media->email }}</td>
                                <td>{{ number_format(str_replace(' ', '', $dossier->media->telephone), 0, '', '-') }}</td>
                                <td style="text-align: center">
                                    <span id="statutNouveau-{{ $dossier->id }}" @if ($dossier->etude_en_cours === 0) @else hidden @endif>
                                    Nouveau
                                    </span>

                                    <span id="statutEtude-{{ $dossier->id }}" @if($dossier->revoir === 0 && $dossier->etude_en_cours === 1 && $dossier->valide === null) @else hidden @endif>
                                     En cours
                                    </span>

                                    <span id="statutRevoir-{{ $dossier->id }}" @if($dossier->revoir === 1) @else hidden @endif>
                                        Revoir
                                    </span>

                                    <span id="statutAccepte-{{ $dossier->id }}" @if($dossier->valide === 1 && $dossier->revoir !== 1) @else hidden @endif>
                                        Accepté
                                    </span>

                                    <span id="statutRejete-{{ $dossier->id }}" @if($dossier->valide === 0) @else hidden @endif>
                                        Rejeté


                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="row justify-content-end">
                                        <a class="btn btn-info btn-sm mr-1" href="{{ route('details', ['id' => $dossier->media->id_media]) }}">Détails</a>


                                        <button @if ($dossier->etude_en_cours === 0 || $dossier->revoir === 1) @else hidden @endif class="btn btn-primary btn-sm soumission" id="soumission-{{ $dossier->media->id_media }}">
                                            @if($dossier->revoir === 1)
                                            Revoir
                                            @else
                                            Demarrer
                                            @endif
                                        </button>

                                        <a href="/medias/{{ $dossier->media->id_media }}/etudes-documents" @if (($dossier->etude_en_cours && $dossier->revoir === 0)) @else hidden @endif
                                            id="etudier-{{$dossier->id}}" class="btn btn-primary btn-sm mr-1 Examiner">
                                            @if($dossier->etude_termine) Voir documents @else Examiner @endif
                                        </a>
                                        <a href="/medias/{{ $dossier->media->id_media }}/etudes-documents" @if (($dossier->etude_en_cours && $dossier->revoir === null)) @else hidden @endif
                                            id="etudier-{{$dossier->id}}" class="btn btn-primary btn-sm mr-1 Examiner">
                                            @if($dossier->etude_termine) Voir documents @else Re-examiner @endif
                                        </a>

                                        <a  href="{{ route('redaction-rapport-commission',[$dossier->media->id_media,'type_commission'=>'commission'] ) }}" @if ($dossier->etude_termine && $dossier->valide === null) @else hidden @endif
                                            class="btn btn-primary btn-sm mr-1 rapport">
                                            Rapport
                                        </a>
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
          <button type="button" data-bs-dismiss="modal" class="btn btn-close btn-danger">x</button>
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
        </div>

        <div class="modal-footer justify-content-end">
            <button id="fermerDocuments" type="button" class="btn btn-danger">Annuler</button>
            <button hidden id="terminerEtudeDocument" type="button" class="btn btn-primary mr-1">Etude Terminée</button>
        </div>
      </div>
    </div>
</div>


<div class="modal fade" id="modalRapport">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Rapport</h4>
        </div>
        <div class="modal-body">
            <p>Rapport du média <strong id="nomMediaRapport"></strong></p>
            <form enctype="multipart/form-data" method="post" id="formRapport">
                @csrf

                <div class="form-group">
                    <label>Rapport</label>
                    <textarea id="documentRapport" name="rapport" class="form-control" rows="5" placeholder="Tapez le rapport "></textarea>
                </div>
            </form>
        </div>

        <div class="modal-footer justify-content-end">
            <button type="button" data-bs-dismiss="modal" id="fermerRapport" class="btn btn-danger btn-close">Fermer</button>
            <button type="button" class="btn btn-primary mr-1" id="validerRapport">Valider</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalSoumission">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content modal-lg">
        <div class="modal-header text-center">
          <h4 id="notfound_title" align="center">Choisissez les membres de la commission<i class="mdi mdi-book-edit"></i></h4>
        </div>
        <form action="{{ route('membre-commission-presence') }}" method="POST" id="form_action_membre">
            @csrf
            <input type="hidden" id="media_id" value="" name="media_id" />
            <div class="modal-body" id="commission_membre_list_input">
                <div class="form-row">
                    <div class="col-12">
                        <div class="alert alert-danger" id="error_message" hidden></div>
                    </div>
                </div>
                @if($membreCommissions->count() > 0)
                    @foreach($membreCommissions as $membre)
                    <div class="form-row" >
                        <div class="col-md-12">
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input"  value="{{$membre->id}}" name="member[]" id="membre-{{$membre->id}}" placeholder="Nombre du membre de la commission"/>
                                <label class="form-check-label-{{$membre->id}}" for="membre-{{$membre->id}}">{{$membre->full_name}} - {{$membre->fonction}}</label>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                 <div class="alert alert-warning">
                    Les membres de la commission technique doivent être ajouté dépuis le compte administrateur
                </div>
                @endif
            </div>
            <div class="modal-footer justify-content-right">
                @if($membreCommissions->count() == 0)
                    <button type="button" data-bs-dismiss="modal" class="btn btn-danger btn-close">Fermer</button>
                @else
                    <button type="button" data-bs-dismiss="modal" class="btn btn-danger btn-close">Non</button>
                @endif
                @if($membreCommissions->count() > 0)
                    <button type="submit" class="btn btn-success mr-1" id="validationSoumission">Oui</button>
                @endif
            </div>
        </form>
      </div>
    </div>
</div>

<script src="{{asset('js/dossier_commission.js')}} "></script>

@endsection

