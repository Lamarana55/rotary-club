@if($current_stape==10)
<div id="sommaire">
    <div class="row">
        <div class="col-md-12">
          <div class="timeline">
            <div class="time-label">
                {{-- @if(round($resutl1) == 18) --}}
                <span class="bg-success">Achat Cahier de charge (DAF)
                    {{-- {{round($resutl1).' h'}} --}}
                </span>
                {{-- @elseif(round($resutl1) >= 24)
                <span class="bg-danger">Achat Cahier de charge (DAF)
                    {{round($resutl1).' h'}}
                </span>
                @else
                <span class="bg-success">Achat Cahier de charge (DAF)
                    {{round($resutl1).' h'}}
                </span>
                @endif --}}
            </div>
            <div>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">Paiement</a> de cahier des charges</h3>
                <div class="timeline-body">
                    @if($cahierChargePayer && $cahierChargePayer->is_valided == true)
                    <p class="text-center font-weight-bold text-info">Votre paiement a été validé</p>
                    <p class="text-center">
                        <a target="_blank" href="{{asset($cahierChargePayer->recu_genere)}}" class="btn btn-primary btn-md mb-4 text-center">
                            Télécharger le reçu
                        </a>
                        {{-- @if($typeDoc)
                        <a target="_blank" class="btn btn-primary btn-md mb-4 text-center" href="{{ asset($typeDoc->nom)}}">
                            Télécharger votre cahier des charges
                        </a>
                        @else
                            <h5 class="text-info mb-4 text-center">Votre cahier de charge n'est pas parametrer pour l'instant!</h5>
                        @endif --}}
                    </p>
                    @endif
                </div>
              </div>
            </div>

            <div class="time-label">
                {{-- @if($joursCom == 8)
                <span class="bg-warning">
                    Delais dossier technique (Promoteur )
                    {{$joursCom}}
                </span>
                @elseif($joursCom >= 10)
                <span class="bg-danger">
                    Delais dossier technique (Promoteur )
                    {{$joursCom}}
                </span>
                @else --}}
                <span class="bg-success">
                    Delais dossier technique (Promoteur )
                    {{-- {{$joursCom .' Jours '}} --}}
                </span>
                {{-- @endif --}}
            </div>

            <div class="time-label">
                {{-- @if(round($resutl2) == 70)
                <span class="bg-warning">Commission technique (MIC)
                    {{round($resutl2).' h'}}
                </span>
                @elseif(round($resutl2) >= 72)
                <span class="bg-danger">Commission technique (MIC)
                    {{round($resutl2).' h'}}
                </span>
                @else --}}
                <span class="bg-success">Commission technique (MIC)
                    {{-- {{round($resutl2).' h'}} --}}
                </span>
                {{-- @endif --}}
            </div>
            <div>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">Commission technique (MIC) </a>validation des documents techniques</h3>
                <div class="timeline-body">
                    @if($media->dossier)
                        @if($media->dossier->status_commission !== null)
                            @if ($media->dossier->status_commission === 1)
                            <p class="validation-commission text-center mt-2 font-weight-bold text-info">Vos documents ont été validés</p>
                            @endif

                            @if ($media->dossier->status_commission === 0)
                            <p class="validation-commission text-center mt-2 font-weight-bold text-danger">Votre dossier technique a été rejeté par la commission</p>
                            <p class="validation-commission text-center mt-2 font-weight-bold text-danger">Veuillez consulter les infos du rejet</p>
                            @endif
                        @else
                            <p class="text-center mt-2 font-weight-bold text-info">Vos documents ont été soumis à la commission technique pour examen.</p>
                        @endif
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-content">
                                <div class="card-header row">
                                    <div class="col-md-4">
                                        <h4>Documents importés  <i class="mdi mdi-book-edit"></i></h4>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-6 float-reght mt-1 mb-2">
                                    </div>
                                </div>
                                <div class="card-body row">
                                    <div class="{{$currentPreview ? 'col-lg-6':'col-lg-12'}}">
                                        <table class="table table-bordered m-0">
                                            <thead>
                                                <tr>
                                                    <th>Document</th>
                                                    <th>Commission</th>
                                                    <th>HAC</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="listeDocumentImportes">
                                                @foreach ($listDocuments as $document)
                                                    <tr>
                                                        <td>{{ $document->document_type_promoteur->document_technique->nom }}</td>
                                                        <td>
                                                            @if($document->is_validated_commission !== null && $this->checkStatusHac($document->media_id)->status_commission == 'terminer')
                                                                @if($document->is_validated_commission)
                                                                <span class="text text-success"><i class="fa fa-check"></i></span>
                                                                @else
                                                                <span class="text text-danger"><i class="fa fa-times"></i></span>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($document->is_validated_hac != null && $this->checkStatusHac($document->media_id)->status_hac =='terminer')
                                                                @if($document->is_validated_hac)
                                                                <span class="text text-success"><i class="fa fa-check"></i></span>
                                                                @else
                                                                <span class="text text-danger"><i class="fa fa-times"></i></span>
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($document->is_validated_commission != true)
                                                                <button type="button" data-toggle="modal" data-target="#showRemplaceDocumentTechniqueModal" wire:click="getDocument({{$document->id}})"
                                                                    class="btn btn-primary btn-sm m-1">
                                                                    <i class="fa fa-edit mr-2"></i> Remplacer
                                                                </button>
                                                            @endif
                                                            <button type="button" wire:click="showPreviewFiles({{$document->id}})" class="btn btn-info btn-sm m-1">
                                                                <i class="fa fa-eye mr-2"></i> &nbsp; Visualiser
                                                            </button>
                                                            @if($document->is_validated_commission !== null && $document->is_validated_commission === 0)
                                                                <a type="button" class="btn btn-warning btn-sm m-1" data-toggle="modal" data-target="#infosRejetModal">
                                                                    <i class="fa fa-info" aria-hidden="true"></i> infos rejet
                                                                </a>
                                                                <!-- Modal Infos Rejet-->
                                                                <div class="modal fade" id="infosRejetModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Description Rejet</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {{ $document->comment_rejet_commission }}
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @if($currentPreview)
                                    <div class="col mt-2">
                                        <div style="col">
                                            <button class="btn btn-primary float-right" wire:click="closeCurrentPreview">Fermer </button>
                                            <span class="float-right"></span>
                                        </div>
                                        <embed src="{{$preview =='Recu'? $firstDocument->recu_genere : $firstDocument->file_path}} "  width="100%" height="600">
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <p>
                                        Reçu de paiement de cahier des charge : <button class="btn btn-primary" wire:click="getPreviewCahierChargeRecu({{$media->id}})"><i class="fa fa-eye"></i> Visualiser </button>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    @if($this->checkStatusHac($media->id) && $this->checkStatusHac($media->id)->status_commission === 'terminer')
                                    <p>Rapport Commission:
                                        <button class="btn btn-primary" wire:click="showPreviewFilesRapport({{$media->id}},'rapport_commission')">Afficher</button>
                                        <a target="_blank" href="{{asset($this->rapportCommissionHac('rapport_commission')->file_path)}} " class="btn btn-primary">Télécharger</a>
                                    </p>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    @if($this->checkStatusHac($media->id) && $this->checkStatusHac($media->id)->status_hac === 'terminer')
                                    <p>Rapport HAC:
                                        <button id="afficherRapportHac" class="btn btn-primary" wire:click="showPreviewFilesRapport({{$media->id}},'rapport_hac')">Afficher</button>
                                        <a target="_blank" href="{{asset($this->rapportCommissionHac('rapport_hac')->file_path)}} " class="btn btn-primary">Télécharger</a>
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>

            <div class="time-label">
                {{-- @if(round($resutl3) == 70)
                <span class="bg-warning">Commission Technique (Hac)
                    {{round($resutl3).' h'}}
                </span>
                @elseif(round($resutl3) >= 72)
                <span class="bg-danger">Commission Technique (Hac)
                    {{round($resutl3).' h'}}
                </span>
                @else --}}
                <span class="bg-success">Commission Technique (Hac)
                    {{-- {{round($resutl3).' h'}} --}}
                </span>
                {{-- @endif --}}
            </div>

            <div>
                <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#">Commission Technique (HAC)</a> : validation des documents technique par la hac</h3>
                    <div class="timeline-body">
                        @if ($this->checkStatusHac($media->id))
                            @if($this->checkStatusHac($media->id)->status_hac === null)
                                <p class="text-center font-weight-bold text-info">Votre dossier technique est en cours d'analyse à la Haute Autorité de Communication (HAC).</p>
                            @else
                                @if ($this->checkStatusHac($media->id)->status_hac === 'terminer')
                                    <p class="text-center font-weight-bold text-info">Votre dossier technique a été validés par la Haute Autorité de Communication (HAC) </p>
                                @else
                                    <p class="text-center font-weight-bold text-danger">La Haute Autorité de Communication (HAC) a donné un avis défavorable à votre dossier technique. </p>
                                    <p  class="text-center font-weight-bold text-danger">Veuillez consulter le raport pour plus de détails. </p>
                                @endif
                                @if($this->rapportCommissionHac('rapport_hac'))
                                <a target="_blank" class="btn btn-info btn-sm" href="{{asset($this->rapportCommissionHac('rapport_hac') ? $this->rapportCommissionHac('rapport_hac')->file_path :'')}}"><i class="fa fa-download" aria-hidden="true"></i> Télécharger rapport</a>
                                @endif
                            @endif
                            @else
                        @endif
                    </div>
                </div>
            </div>

            <div class="time-label">
                {{-- @if(round($resutl4) == 44)
                <span class="bg-warning">Paiement d'agrement
                    {{round($resutl4).' h'}}
                </span>
                @elseif(round($resutl4) >= 48)
                <span class="bg-danger">Paiement d'agrement
                    {{round($resutl4).' h'}}
                </span>
                @else --}}
                <span class="bg-success">Paiement d'agrement
                    {{-- {{round($resutl4).' h'}} --}}
                </span>
                {{-- @endif --}}
            </div>
            <div>
                <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#"> Paiement : </a> le paiement de frais d'agrement</h3>
                    <div class="timeline-body">
                        <div>
                            <p class="font-weight-bold text-center text-info" @if($fraisAgrement && $fraisAgrement->is_valided === null) @else hidden @endif>Votre reçu est en cours de validation par la Direction Nationale de la Communication et des Relations avec les Médias Privés (DNCRMP)</p>
                        </div>
                        <p class="font-weight-bold text-center text-info" @if($fraisAgrement && $fraisAgrement->is_valided) @else hidden @endif>Votre reçu a été validé</p>
                        <p class="font-weight-bold text-center text-danger" @if($fraisAgrement && $fraisAgrement->is_valided === false) @else hidden @endif>Votre reçu a été rejeté</p>

                        <div>
                            @if($fraisAgrement === null)
                            <button class="btn btn-primary btn-md mr-1"  data-bs-toggle="modal" data-bs-target="#showModalPaiementFraisAgrement">Importer le reçu</button>
                            @endif

                            @if($fraisAgrement && $fraisAgrement->is_valided === false)
                            <button class="btn btn-primary btn-md mr-1"  data-bs-toggle="modal" data-bs-target="#showModalPaiementFraisAgrement">Importer le reçu</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="time-label">
                {{-- @if(round($resutl5) == 70)
                <span class="bg-warning">Transmission d'agrement (DNCRMP)
                    {{round($resutl5).' h'}}
                </span>
                @elseif(round($resutl5) >= 72)
                <span class="bg-danger">Transmission d'agrement (DNCRMP)
                    {{round($resutl5).' h'}}
                </span>
                @else --}}
                <span class="bg-success">Conseiller Juridique (CJ)
                    {{-- {{round($resutl5).' h'}} --}}
                </span>
                {{-- @endif --}}
            </div>
            <div>
                <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#"> CJ </a> : Votre projet d'agrement a été transmis au Sécrétariat Général du Gouvernement (SGG)</h3>
                    <div class="timeline-body">
                        @if($this->hasProjetAgrementInDocument($media->id))
                            <p class="text-center font-weight-bold text-info">Votre projet d'agrement a été transmis au Sécrétariat Général du Gouvernement (SGG)</p>
                            <div class="row text-center">
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <button class="btn btn-info btn-sm btnShowProjetAgrement" wire:click='visualiserprojetagreement' value="{{$media->id}}"><i class="fa fa-eye"></i> Visualiser </button>
                                </div>
                                <div class="col-md-3">
                                    <p class="text-center font-weight-bold text-info">
                                        <a target="_blank" class="btn btn-info btn-sm" href="{{asset($this->hasProjetAgrementInDocument($media->id)->file_path)}}"><i class="fa fa-download" aria-hidden="true"></i> Telecharger projet d'agrement</a>
                                    </p>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-12 mt-5" id="previewProjetAgrement">
                                </div>
                            </div>
                            @if ($is_visualiserprojetagreement)
                                <div class="row justify-content-center mt-auto">
                                    <div class="col-7 mt-2">
                                        <div style="col">
                                            <button class="btn btn-primary float-right mb-1" wire:click="closevisualiserprojetagreement">Fermer </button>
                                            <span class="float-right"></span>
                                        </div>
                                        <embed src="{{$this->hasProjetAgrementInDocument($media->id)->file_path}} "  width="100%" height="600">
                                    </div>
                                </div>
                            @endif
                        @else
                            <p class="text-center font-weight-bold text-info">Votre projet d'agrement est en cours de préparation à la direction nationale de la communication et des relations avec les médias privés </p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="time-label">
                {{-- @if(round($resutl6) == 70)
                <span class="bg-warning">Enregistrement d'agrement (SGG)
                    {{round($resutl6).' h'}}
                </span>
                @elseif(round($resutl6) >= 72)
                <span class="bg-danger">Enregistrement d'agrement (SGG)
                    {{round($resutl6).' h'}}
                </span>
                @else --}}
                <span class="bg-success">Enregistrement d'agrement (SGG)
                    {{-- {{round($resutl6).' h'}} --}}
                </span>
                {{-- @endif --}}
            </div>
            <div>
            <div class="timeline-item">
                <h3 class="timeline-header"><a href="#"> Enregistrement de l'agrement </a></h3>
                <div class="timeline-body">
                    @if ($media && $media->numero_registre_sgg)
                        <p class="text-center font-weight-bold text-info">votre média a été enregistré et publié par le Secrétariat General du Gouvernement (SGG)</p>
                        <div class="row"></div>
                        <p class="text-center font-weight-bold text-info"> Votre numéro d’agrément est le : </p>
                        <h3 class="text-center font-weight-bold mt-1 mb-3"> {{$media ? $media->numero_registre_sgg : ''}} </h3>
                        <div class="row text-center">
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <button class="btn btn-info btn-sm btnShowAgrement" value="{{$media->id}}" wire:click='visualiseragreement' ><i class="fa fa-eye"></i> Visualiser </button>
                            </div>
                            <div class="col-md-3">
                                <p class="text-center font-weight-bold text-info">
                                    <a target="_blank" class="btn btn-sm btn-info" href="{{asset($this->hasRapportCommissionHac($media->id,'agrement')->file_path)}}"><i class="fa fa-download" aria-hidden="true"></i> Telecharger l'agrement</a>
                                </p>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-12 mt-5" id="previewAgrement">
                            </div>
                        </div>
                        @if ($is_visualiseragreement)
                            <div class="row justify-content-center mt-auto">
                                <div class="col-7 mt-2">
                                    <div style="col">
                                        <button class="btn btn-primary float-right mb-1" wire:click="closevisualiseragreement">Fermer </button>
                                        <span class="float-right"></span>
                                    </div>
                                    <embed src="{{$this->hasRapportCommissionHac($media->id,'agrement')->file_path}} "  width="100%" height="600">
                                </div>
                            </div>
                        @endif

                    @else
                        <p class="text-center font-weight-bold text-info">Votre média est en cours d'enregistrement au  Sécrétariat Général du Gouvernement (SGG)</p>
                    @endif
                </div>
            </div>
            </div>

            <div class="time-label">
                {{-- @if(round($resutl6) == 70)
                <span class="bg-warning">Prise de rendez-vous (Promoteur)
                    {{round($resutl6).' h'}}
                </span>
                @elseif(round($resutl6) >= 72)
                <span class="bg-danger">Prise de rendez-vous (Promoteur)
                    {{round($resutl6).' h'}}
                </span>
                @else --}}
                <span class="bg-success">Prise de rendez-vous (Promoteur)
                    {{-- {{round($resutl6).' h'}} --}}
                </span>
                {{-- @endif --}}
            </div>
            <div>
                <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#"> Prise de rendez-vous </a> par le promoteur</h3>
                    <div class="timeline-body">
                        @if($media->meeting === null || $media->meeting->annuler === 1)
                            @if($media->meeting === null)
                                <p class="text-center font-weight-bold">Prenez votre rendez-vous pour la signature</p>

                                <div class="row" id="listeProgrammess">
                                    <div class="col-md-12">
                                        <p class="text-center">
                                            <a class="btn btn-primary btn-md add-rdv" href="#" data-toggle="modal" data-target="#addEventModal" data-href="{{ route("meetings.create") }}">
                                                <i class="fa fa-calendar" aria-hidden="true"></i> Selectionner une date
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @else
                                <p class="text-center font-weight-bold text-danger">Votre rendez-vous du {{ dateFormat($media->meeting->date).' de '.$media->meeting->heure }} a été annuler</p>
                                <p class="text-center font-weight-bold text-danger">Motif: {{ $media->meeting->motif }}</p>
                                <p class="text-center font-weight-bold">Prenez un autre rendez-vous</p>
                                <p class="text-center">
                                    <a class="btn btn-primary btn-md add-rdv" href="#" data-toggle="modal" data-target="#addEventModal" data-href="{{ route("meetings.create") }}">
                                        <i class="fa fa-calendar" aria-hidden="true"></i> Selectionner une date
                                    </a>
                                </p>
                            @endif
                        @else
                            @if($media->meeting->confirmer)
                                <p class="text-center font-weight-bold text-info">
                                    Votre rendez-vous pour la signature est le
                                    {{ dateFormat($media->meeting->date).' de '.$media->meeting->heure }}
                                </p>
                            @else
                                <p class="text-center font-weight-bold text-info">
                                    Votre rendez-vous pour la signature est en attente de confirmation
                                </p>
                                <p class="text-center">
                                    <a class="btn btn-primary btn-md add-rdv" href="#" data-toggle="modal" data-target="#addEventModal" data-href="{{ route("meetings.create") }}">
                                        <i class="fa fa-calendar" aria-hidden="true"></i> Modifier mon rendez-vous
                                    </a>
                                </p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <div class="time-label">
                {{-- @if(round($resutl6) == 70)
                <span class="bg-warning">Prise de rendez-vous (Promoteur)
                    {{round($resutl6).' h'}}
                </span>
                @elseif(round($resutl6) >= 72)
                <span class="bg-danger">Prise de rendez-vous (Promoteur)
                    {{round($resutl6).' h'}}
                </span>
                @else --}}
                <span class="bg-success"> Agrément signé (DNCRMP)
                    {{-- {{round($resutl6).' h'}} --}}
                </span>
                {{-- @endif --}}
            </div>
            <div>
                <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#"> Votre projet d'agrement signé est disponible</h3>
                    <div class="timeline-body">
                        @if($media->meeting && $media->meeting->agrement)
                            {{-- <p class="font-weight-bold text-info">Votre projet d'agrement signé est disponible</p> --}}
                            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#showModalProjetAgrementSigne" wire:click='previewAgrement'>
                                </i>Visualiser le projet d'agrement signé
                            </button>

                            <a target="_blank" class="btn btn-primary btn-md" wire:click="telechargerAgrementSigne({{$media->id}})" href="{{asset($media->meeting->agrement)}}">
                                <i class="fa fa-download" aria-hidden="true"></i>Télécharger
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="time-label">
                <span class="bg-success"> Licence signé (ARPT)</span>
            </div>
            <div>
                <div class="timeline-item">
                    <h3 class="timeline-header"><a href="#"> Votre projet d'agrement signé est disponible</h3>
                    <div class="timeline-body">
                        @if(hasMeeting($media->id) && hasMeeting($media->id)->licence==null)
                        <p class="font-weight-bold text-info">Votre licence est en cours d'elaboration à l'ARTP</p>
                        @endif

                        @if(hasMeeting($media->id) && hasMeeting($media->id)->licence)
                            <p class="font-weight-bold text-info">Votre licence signé est disponible</p>
                            <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#showModalProjetLicence" wire:click='previewAgrement'>
                                </i>Visualiser la licence signé
                            </button>

                            <a target="_blank" class="btn btn-primary btn-md" wire:click="telechargerAgrementSigne({{$media->id}})" href="{{asset($media->meeting->agrement)}}">
                                <i class="fa fa-download" aria-hidden="true"></i>Télécharger
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div>
              <i class="fas fa-clock bg-gray"></i>
            </div>
          </div>
        </div>
      </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <button class="btn btn-primary btn-md" wire:click="stepperAction({{$media->id}},9)">Précédent</button>
        </div>
        <div class="col-md-6">
            <a href="{{url('/mes-medias')}}" class="btn btn-primary float-right btn-md">Fermer</a>
        </div>
    </div>
</div>

<div class="modal fade" id="showModalProjetAgrementSigne" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog" style="max-width:900px;">
        <div class="modal-content">
            <div class="modal-body m-3">
                <embed src="{{asset($media->meeting->agrement ??null) }}"  width="100%" height="600">
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary float-end" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showModalProjetLicence" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog" style="max-width:900px;">
        <div class="modal-content">
            <div class="modal-body m-3">
                <embed src="{{asset($media->meeting->licence ??null) }}"  width="100%" height="600">
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary float-end" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
@endif
