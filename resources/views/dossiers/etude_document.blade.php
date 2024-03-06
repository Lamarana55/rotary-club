@extends('layouts.default')
@section('page')
@if (auth()->check() && auth()->user()->role->nom == 'HAC')
Analyse du dossier technique du média ({{$media->nom_media}})
@else
Examen du dossier technique du média ({{$media->nom_media}})
@endif
@endsection

@section('content')


<div class="row">
    <div class="col-6">
        <div class="row mb-2">

            <div class="col-12">
                <div style="display: flex;align-items: center;Justify-content: space-between">
                    <div>

                    <button @if($etudeDocumentsTermine === 1 && $clotureEtude === 0) @else hidden @endif id="terminerEtudeDocument" type="button" class="btn btn-success mr-4">Terminer</button>

                    <button @if( $clotureEtude === 1) hidden @endif id="accepter" class="btn btn-success mr-1">Accepter</button>
                    <button @if( $clotureEtude === 1) hidden @endif id="rejeter" class="btn btn-danger mr-1">Rejeter</button>


                    </div>
                    @if(auth()->check() && auth()->user()->role->nom == 'DAF')
                    <a href="{{url('paiements/cahier-de-charges')}}" class="btn btn-primary  float-right">Retour</a>
                    @elseif(auth()->check() && auth()->user()->role->nom == 'Commission')
                    <a href="{{url('medias/etudes/commission')}}" class="btn btn-primary  float-right">Retour</a>
                    @elseif(auth()->check() && auth()->user()->role->nom == 'HAC')
                    <a href="{{url('medias/etudes/hac')}}" class="btn btn-primary  float-right">Retour</a>
                    @elseif(auth()->check() && auth()->user()->role->nom == 'Direction')
                    <a href="{{url('medias/direction')}}" class="btn btn-primary  float-right">Retour</a>
                    @elseif(auth()->check() && auth()->user()->role->nom == 'SGG')
                    <a href="{{url('medias/etudes/sgg')}}" class="btn btn-primary  float-right">Retour</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Documents</h3>
                        <div @if( $clotureEtude===1) hidden @endif id="divTousCocher" class="form-group">
                            <div class="custom-control custom-checkbox float-right">
                                <input class="custom-control-input" type="checkbox" id="tousCocher">
                                <label for="tousCocher" class="custom-control-label">Tous cocher</label>
                            </div>
                        </div>
                    </div>

                    <div class="card-body table-responsive">
                        <table id="tableDocuments" class="table table-bordered" style="width: 100%">
                            <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th>Nom</th>
                                    <th style="width: 13%">Statut</th>
                                    @if( auth()->user()->role->nom == 'Commission')
                                    <th style="width: 13%">HAC </th>
                                    @endif

                                    <th style="width: 20%">Action.s</th>
                                </tr>
                            </thead>

                            <tbody id="listeDocuments">
                                @foreach($media->documents as $document)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $document->type_document->libelle }}</td>

                                    <td style="text-align: center">
                                        <span id="statutAccepte-{{$document->id_document}}"
                                            @if((auth()->user()->role->nom == 'Commission' &&
                                            $document->validation_commission === 1) ||
                                            (auth()->user()->role->nom == 'HAC' && $document->validation_hac === 1))
                                            @else hidden @endif
                                            class="text text-success">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </span>

                                        <span id="statutRejete-{{$document->id_document}}"
                                            @if((auth()->user()->role->nom == 'Commission' &&
                                            $document->validation_commission === 0) ||
                                            (auth()->user()->role->nom == 'HAC' && $document->validation_hac === 0))
                                            @else hidden @endif class="text text-danger">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </span>
                                    </td>



                                    @if(auth()->user()->role->nom == 'Commission')
                                    <td style="text-align: center">
                                        <span @if($document->validation_hac === 0) @else hidden @endif class="text
                                            text-danger">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </span>

                                        <span @if($document->validation_hac === 1) @else hidden @endif class="text
                                            text-success">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                        </span>
                                    </td>
                                    @endif

                                    <td style="text-align: center">
                                        <div style="display: flex;justify-content: center">
                                            <div @if( $clotureEtude===1) hidden @endif
                                                class="form-group selection-document mr-1">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input document" type="checkbox"
                                                        id="document-{{ $document->id_document }}">
                                                    <label for="document-{{ $document->id_document }}"
                                                        class="custom-control-label"></label>
                                                </div>
                                            </div>

                                            <a target="_blank" rel="noopener noreferrer"
                                                href="{{ asset($document->file_path) }}" class="mr-1">
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                            </a>

                                            <span id="{{ $document->type_document->libelle }}" class="text text-primary view">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </span>
                                            @if($document->validation_commission === 0 || $document->validation_hac ===
                                            0)
                                            <a type="button" class="ml-1" data-toggle="modal"
                                                data-target="#infosRejetModal">
                                                <i class="fa fa-info" aria-hidden="true"></i>
                                            </a>
                                            <!-- Modal Infos Rejet-->
                                            <div class="modal fade" id="infosRejetModal" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Description
                                                                Rejet</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="list-group">
                                                                @if($document->validation_commission === 0)
                                                                <h5 class="mb-1">Message de la commission</h5>
                                                                <a href="#"
                                                                    class="list-group-item list-group-item-action list-group-item-danger">
                                                                    <div class="d-flex w-100 justify-content-between">
                                                                    </div>
                                                                    <p class="mb-1">{{ $document->commentaire_commission
                                                                        }}</p>
                                                                </a>
                                                                @endif
                                                                @if($document->validation_hac === 0)
                                                                <h5 class="mb-1">Message de la HAC</h5>
                                                                <a href="#"
                                                                    class="list-group-item list-group-item-action list-group-item-danger">
                                                                    <div class="d-flex w-100 justify-content-between">
                                                                    </div>
                                                                    <p class="mb-1">{{ $document->commentaire_hac }}</p>
                                                                </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger"
                                                                data-dismiss="modal">Fermer</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->role->nom == 'HAC')
        <div class="row mt-2">
            <div class="col-6">
                <h5>Rapport Commission</h5>
                <div class="row">
                    <div class="col-12">
                        <button id="afficherRapport" class="btn btn-primary">Visualiser</button>
                        <button hidden id="fermerRapport" class="btn btn-primary">Fermer</button>
                        <a target="_blank" rel="noopener noreferrer" class="btn btn-primary"
                            href="{{ asset($document->media->dossier_commission->rapport) }}" class="mr-1">
                            <i class="fa fa-download" aria-hidden="true"></i>Télécharger
                        </a>
                    </div>
                </div>
            </div>
            @if($media->dossier_hac && $media->dossier_hac->valide !== null)
            {{-- <div class="row mt-2"> --}}
                <div class="col-6">
                    <h5>Rapport HAC</h5>
                    <div class="row">
                        <div class="col-12">
                            <button id="afficherRapportHac" class="btn btn-primary">Visualiser</button>
                            <button hidden id="fermerRapportHac" class="btn btn-primary">Fermer</button>
                            <a target="_blank" href="{{ $media->dossier_hac->rapport }}" class="btn btn-primary"><i
                                    class="fa fa-download" aria-hidden="true"></i> Télécharger</a>
                        </div>
                    </div>
                </div>
                {{--
            </div> --}}
            @endif
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <embed hidden id="previewRapport" src="{{ asset($document->media->dossier_commission->rapport) }}"
                    width="100%" height="800">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <embed hidden id="previewRapportHac" src="{{ asset($document->media->dossier_hac->rapport) }}"
                    width="100%" height="800">
            </div>
        </div>
        @endif

        @if(auth()->user()->role->nom == 'Commission' && $document->media->dossier_hac &&
        $document->media->dossier_hac->valide !== null)
        <div class="row mt-2">
            <div class="col-12">
                <h5>Rapport HAC</h5>

                <div class="row">
                    <div class="col-12">
                        @foreach($media->documents as $document)
                        @if($document->validation_hac === 0)
                        <p>
                            Motif rejet du document {{ $document->type_document->libelle}}:<br />
                            {{$document->commentaire_hac}}

                        </p>
                        @endif
                        @endforeach
                    </div>
                </div>

                <div class="row">
                    @if ($document->media->dossier_hac->rapport)
                        <div class="col-12">
                            <button id="afficherRapportHac" class="btn btn-primary">Visualiser</button>
                            <button hidden id="fermerRapport" class="btn btn-primary">Fermer</button>

                            <a target="_blank" rel="noopener noreferrer" id="telecharger_rapport_hac" class="btn btn-primary"
                                href="{{ asset($document->media->dossier_hac->rapport) }}" class="mr-1">
                                <i class="fa fa-download" aria-hidden="true"></i>Télécharger
                            </a>
                        </div>
                    @endif
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <embed hidden id="previewRapport" src="{{ asset($document->media->dossier_hac->rapport) }}"
                            width="100%" height="800">
                    </div>
                </div>

            </div>
        </div>
        @endif
    </div>

    <div class="col-6">
        <div class="d-flex justify-content-between">
            <button hidden id="fermerDocument" class="btn btn-primary mb-1">Fermer</button>
            <p hidden id="nomRapport">test</p>
        </div>
        <embed id="previewDocument"  width="100%" height="800">
    </div>
</div>

<div class="modal fade" id="modalEtudeDocuments">
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">
            <div class="modal-header">
                @if (auth()->check() && auth()->user()->role->nom == 'HAC')
                <h4 id="notfound_title">Analyse du dossier</h4>
                @else
                <h4 id="notfound_title">Examen du dossier</h4>
                @endif
            </div>
            <div class="modal-body">
                <input type="hidden" id="idMedia" value="{{ $media->id_media }}" />
                <div hidden id="motifsRejet">
                    @foreach ($media->documents as $document)
                    <div hidden id="divCommentaire-{{ $document->id_document }}" class="form-group divCommentaire">
                        <label>Motif de rejet {{ $document->type_document->libelle}}</label>
                        <textarea id="commentaire-{{ $document->id_document }}" class="form-control" rows="2" placeholder="Entrer le motif de rejet"></textarea>
                        <span id="commentaireError-{{ $document->id_document }}" hidden>Votre commentaire doit avoir quatre(4) caractères au minimum</span>
                    </div>
                    @endforeach
                </div>

                <p hidden id="messageValidations">Confirmez-vous la validation des documents du média <strong>{{
                        $media->nom_media }}</strong>?</p>
            </div>

            <div class="modal-footer justify-content-end">
                <button id="annuler" data-bs-dismiss="modal" type="button" class="btn bg-gris-fonce">Annuler</button>
                <button id="valider" type="button" class="btn btn-success mr-1">Valider</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalConfirmationTerminerEtude">
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">
            <div class="modal-header">
                @if (auth()->check() && auth()->user()->role->nom == 'HAC')
                <h4 id="notfound_title">Terminer l'analyse du dossier technique</h4>
                @else
                <h4 id="notfound_title">Terminer l'examen du dossier technique</h4>
                @endif
            </div>
            <div class="modal-body">
                @if (auth()->check() && auth()->user()->role->nom == 'HAC')
                <p>Confirmez-vous la fin de l'analyse du dossier technique du média <strong>{{ $media->nom_media }}
                    </strong></p>
                @else
                <p>Confirmez-vous la fin de l'examen du dossier technique du média <strong>{{ $media->nom_media }}
                    </strong></p>

                @endif
            </div>

            <div class="modal-footer justify-content-end">
                <button data-bs-dismiss="modal" type="button" class="btn btn-danger">NON</button>
                <button id="confirmationTerminerEtude" type="button" class="btn btn-success mr-1">OUI</button>
            </div>
        </div>
    </div>
</div>


<script src="{{asset('js/etude_documents.js')}} "></script>

@endsection
