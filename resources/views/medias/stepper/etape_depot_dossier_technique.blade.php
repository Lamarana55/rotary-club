@if($current_stape==2)
<div id="depot-dossier-technique">
    @include('medias.medias.show-modal-recu')
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                @if(count($listDocuments)==0)
                    <p>
                        Reçu de paiement de cahier des charges  <button class="btn btn-primary" data-toggle="modal" data-target="#showModalRecu" wire:click="getPreviewCahierCharge"><i class="fa fa-eye"></i> Visualiser </button>
                    </p>
                @endif
                @if (count($listDocuments) != count($documentsRequis))
                <div class="card-default">
                    {{-- Vous avez 10 jours pour soumettre les pièces demandées qui seront examinés par la commission technique du MIC --}}
                    <h4>Vous avez : <b>{{suivu('validation du paiement de cahier des charges',traking($media->id)->date_valide_cahier??null)}}</b> pour soumettre les pièces demandées qui seront examinés par la commission technique du MIC</h4>

                    <div class="card-header">
                        <h3 class="card-title">{{count($listDocuments)}} / {{ count($documentsRequis) }} Importer les documents <strong>(Taille maximale par document 5 MB)</strong> </h3>
                    </div>
                    <form wire:submit.prevent="saveImportationDocumentTechnique" class="authenticate-form">
                        <div class="card-body">
                            <div class="row">
                                @foreach($documentsTechniques as $item)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">{{$item->document_technique->nom}} </label>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <input type="file" wire:model="documents.{{$item->id}}" class="form-control documents" accept=".pdf,.jpg,.png," />
                                        </div>
                                    </div>
                                        <div class="col-md-3">
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#showModelDescriptionTypeDocument" wire:click='afficherDescription({{$item->document_technique_id}})' type="button"> Description</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer" >
                            <button type="submit" class="btn btn-primary float-right btn-submit" >Importer</button>
                        </div>
                    </form>
                    </div>
                @endif
            </div>
        </div>
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
        @if(count($listDocuments)>0)
        <div class="row">
            <div class="col-md-12">
                <div class="card-content">
                    <div class="card-header row">
                        <div class="col-md-4">
                            <h4>Documents importés  <i class="mdi mdi-book-edit"></i></h4>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-6 float-reght mt-1 mb-2">
                            @if(count($listDocuments) == count($documentsRequis))
                            <div>
                                <button @if(!$soumission) hidden @endif type="button" wire:click="showSoumissionDocumentTechnique" class="btn btn-success btn-md float-right">Terminer </button>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body row">
                        <div class="{{$currentPreview ? 'col-lg-6':'col-lg-12'}}">
                            <table class="table table-bordered m-0">
                                <thead>
                                    <tr>
                                        <th>Document</th>
                                        <th>MIC</th>
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
                                                    <button @if(!$soumission) hidden @endif type="button" data-toggle="modal" data-target="#showRemplaceDocumentTechniqueModal" wire:click="getDocument({{$document->id}})"
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
                            Reçu de paiement de cahier des charge  <button class="btn btn-primary" wire:click="getPreviewCahierChargeRecu({{$media->id}})"><i class="fa fa-eye"></i> Visualiser </button>
                        </p>
                    </div>
                    <div class="col-md-4">
                        @if($this->checkStatusHac($media->id) && $this->checkStatusHac($media->id)->status_commission === 'terminer')
                        <p>Rapport Commission
                            <button class="btn btn-primary" wire:click="showPreviewFilesRapport({{$media->id}},'rapport_commission')">Afficher</button>
                            <a target="_blank" href="{{asset($this->rapportCommissionHac('rapport_commission')->file_path)}} " class="btn btn-primary">Télécharger</a>
                        </p>
                        @endif
                    </div>
                    <div class="col-md-4">
                        @if($this->checkStatusHac($media->id) && $this->checkStatusHac($media->id)->status_hac === 'terminer')
                        <p>Rapport HAC
                            <button id="afficherRapportHac" class="btn btn-primary" wire:click="showPreviewFilesRapport({{$media->id}},'rapport_hac')">Afficher</button>
                            <a target="_blank" href="{{asset($this->rapportCommissionHac('rapport_hac')->file_path)}} " class="btn btn-primary">Télécharger</a>
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <button class="btn btn-primary btn-md goToPrecedent btnpre" wire:click="stepperAction({{$media->id}},1)">Précédent</button>
        </div>
        <div class="col-md-4">
            @if($this->checkStatusHac($media->id) && $this->checkStatusHac($media->id)->status_commission === 'terminer')
                <p class="text-center">Veuillez cliquer sur le bouton suivant pour poursuivre le processus</p>
            @endif
        </div>
        <div class="col-md-4">
            @if($this->checkStatusHac($media->id) && $this->checkStatusHac($media->id)->status_commission === 'terminer')
                <button class="btn btn-primary float-right btn-md goToSuivent" wire:click="stepperAction({{$media->id}},3)">Suivant</button>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="showModelDescriptionTypeDocument" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="showModelDescriptionTypeDocument" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4>{{$showDescription->nom ?? null}} </h4>
        </div>
        <div class="modal-body">
            <p>
                {!! $showDescription->description ?? null !!}
            </p>
            <div class="card-footer">
                <button data-dismiss="modal" type="button" class="btn btn-danger float-right">Fermer</button>
            </div>
        </div>
      </div>
    </div>
</div>
@endif
