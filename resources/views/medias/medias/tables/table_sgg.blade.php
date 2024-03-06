<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th style="width: 50px">#</th>
            <th>Média</th>
            <th>Type</th>
            {{-- <th>Email</th> --}}
            <th>Téléphone</th>
            <th>Statut</th>
            <th>Projet agrément</th>
            <th>Dossier Technique</th>
            <th>Rapport Commission</th>
            <th>Rapport HAC</th>
            <th class="text-center">Action.s</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($medias as $key=> $media)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $media->nom }}</td>
                <td>{{ $media->type_media??null }}</td>
                {{-- <td>{{ $media->email }}</td> --}}
                <td>{{ number_format(str_replace(' ', '', $media->telephone), 0, '', '-') }}</td>
                <td>
                    @if($media->numero_registre_sgg == null)
                    <span class="text-warning">
                        Encours
                    </span>
                    temps restant : <b>{{suivu('élaboration du projet d\'agrément',traking($media->id)->date_transmission_projet_agrement??null)}} </b>
                    @else
                    <span class="text-success"> Terminé </span>
                    @endif
                </td>
                <td style="text-align: center">
                    <a target="_blank" rel="noopener noreferrer" href="{{asset($media->file_path)}}">
                        <i class="fa fa-download" aria-hidden="true"></i>
                    </a>
                </td>
                <td style="text-align: center">
                    <button type="button" class="btn btn-primary btn-sm" wire:click='getDocumentTechniques({{$media->id}})' data-bs-toggle="modal" data-bs-target="#showModalDocumentsDocumentTechnique">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </button>
                </td>
                <td style="text-align: center">
                    <a target="_blank" rel="noopener noreferrer" href="{{asset($this->hasRapportCommissionHac($media->id,'rapport_commission')->file_path ?? null)}}">
                        <i class="fa fa-download" aria-hidden="true"></i>
                    </a>
                </td>
                <td style="text-align: center">
                    <a target="_blank" rel="noopener noreferrer" href="{{asset($this->hasRapportCommissionHac($media->id,'rapport_hac')->file_path ?? null)}}">
                        <i class="fa fa-download" aria-hidden="true"></i>
                    </a>
                </td>
                <td class="text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> Séléctionner une action <i class="mdi mdi-chevron-down"></i> </button>
                            <div class="dropdown-menu justify-content-between">
                            <a class="dropdown-item btn btn-default btn-sm mr-1" href="{{route('detail-media',['id'=>$media->uuid])}}">Détails</a>
                            @if($media->numero_registre_sgg == null)
                            <button class="dropdown-item btn mt-1 bg-primary btn-sm" wire:click='getMedia({{$media->id}})' data-bs-toggle="modal" data-bs-target="#showModelEnregistrementNumeroAgrement">Enregistrer </button>
                            @endif

                            @if(hasMeeting($media->id) && hasMeeting($media->id)->agrement !=null)
                            <button class="dropdown-item btn btn-sm btn-primary text-white mt-1" wire:click='showAgrementSigne({{$media->id}})' data-bs-toggle="modal" data-bs-target="#showModalProjetAgrement">Convention d’établissement</button>
                            @endif
                            @if(hasMeeting($media->id) && hasMeeting($media->id)->licence !=null)
                            <button class="dropdown-item btn btn-sm bg-dark mt-1" wire:click='showLicence({{$media->id}})' data-bs-toggle="modal" data-bs-target="#showModalLicence">Visualiser licence</button>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="showModelEnregistrementNumeroAgrement" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="showModelEnregistrementNumeroAgrementLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Enregistrement du média <strong>{{$agreementMedia ? $agreementMedia->nom :''}} </strong> </h4>
        </div>
        <form wire:submit.prevent="enregistrerAgrement({{$agreementMedia ? $agreementMedia->id:''}})">
            <div class="card-body">
                <div class="form-group">
                    <label for="numeroAgrement">Numero d'agrément <i class="text-danger">*</i></label><br>
                    <input type="text" wire:model='numeroAgrement' class="form-control @error('numeroAgrement') is-invalid @enderror">
                    @error("numeroAgrement")
                        <span class="text-danger numeroAgrement">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="date_enregistrement">Date d'agrément <i class="text-danger">*</i></label><br>
                    <input type="date" wire:model='date_enregistrement' class="form-control @error('date_enregistrement') is-invalid @enderror">
                    @error("date_enregistrement")
                        <span class="text-danger date_enregistrement">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="agrementFile">Agrément signé <i class="text-danger">*</i></label><br>
                    <input type="file" wire:model='agrementFile' class="form-control @error('agrementFile') is-invalid @enderror">
                    @error("agrementFile")
                        <span class="text-danger agrementFile">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" wire:click='closeModalgenererAgrement'>Fermer</button>
                <button type="submit" class="btn btn-primary mr-1 float-right">Enregistrer</button>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="showModalDocumentsDocumentTechnique" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="showModalDocumentsDocumentTechniqueLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4>Documents Techniques</h4>
        </div>
        <div class="modal-body">
            <p id="erreurChargement"></p>
            <table id="tableDocuments" class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 15px">#</th>
                        <th>Document</th>
                        <th>Telecharger</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($documentTechniques as $key=> $document)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $document->document_type_promoteur->document_technique->nom }}</td>
                            <td class="text-center">
                                <a target="_blank" rel="noopener noreferrer" href="{{asset($document->file_path)}}">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-footer">
                <button data-bs-dismiss="modal" type="button" class="btn btn-danger float-right">Fermer</button>
            </div>
        </div>
      </div>
    </div>
</div>
