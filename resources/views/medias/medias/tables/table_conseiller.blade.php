<div>
    @include('medias.medias.show-modal-projet-agrement')
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Promoteur</th>
            <th>Media</th>
            <th>Type</th>
            <th>Téléphone</th>
            <th>Statut</th>
            <th class="text-center">Action.s</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($medias as $key => $media)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $media->media->user->prenom.' '.$media->media->user->nom }}</td>
            <td>{{ $media->media->nom }}</td>
            <td>{{ $media->media->type_media }}
            </td>
            <td>{{ number_format(str_replace(' ', '', $media->media->telephone), 0, '', '-') }}</td>

            <td>
                @if($this->hasProjetAgrementInDocument($media->media_id)==null)
                <span class="text-warning">
                    Encours
                </span>
                temps restant : <b>{{suivu('validation de frais d\'agrément',traking($media->media_id)->date_valide_paiement_agrement??null)}} </b>
                @else
                <span class="text-success"> Terminé </span>
                @endif
            </td>
            <td class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> Séléctionner une action <i class="mdi mdi-chevron-down"></i> </button>
                    <div class="dropdown-menu justify-content-between">
                        <a class="dropdown-item mt-1 btn btn-default btn-sm" href="{{route('detail-media',['id'=>$media->media->uuid])}}">Détails</a>

                        <button @if($media->is_valided === true || $media->recu !== null ) @else hidden @endif class="dropdown-item mt-1 btn bg-info
                            btn-sm" wire:click='showModalPreviewRecuFraisAgrement({{$media->media_id}})'>Reçu
                        </button>
                        @if($this->hasProjetAgrementInDocument($media->media_id)==null)
                            @if($media->is_valided && $this->checkGenerateProject($media->media_id))
                                <button type="button" class="dropdown-item mt-1 btn bg-dark btn-sm" wire:click='getFirstMedia({{$media->media_id}})' data-bs-toggle="modal" data-bs-target="#showModelAddProjetAgrement">
                                        importer projet d'agrément
                                </button>
                            @endif

                            @if($media && $media->is_valided)
                                @if (hasPermission('editer_projet_agrement'))
                                    <a href="{{ route('edit-projet-agrement', ['id'=> $media->media->uuid ]) }}" class="dropdown-item mt-1 btn bg-success btn-sm">
                                        Editer projet d'agrément
                                    </a>
                                @endif
                            @endif
                            @if($media->is_valided && $this->checkGenerateProject($media->media_id))
                                <a data-toggle="modal" data-target="#showModalProjetAgrementGenerer" wire:click="showProjetAgrement({{$media->media_id}})" class="dropdown-item mt-1 btn bg-dark btn-sm m-1">
                                    Visualiser
                                </a>
                            @endif
                        @endif
                        @if(hasMeeting($media->media_id) && hasMeeting($media->media_id)->agrement !=null)
                        <button type="button" class="dropdown-item btn btn-sm btn-primary text-white mt-1" wire:click='showAgrementSigne({{$media->media_id}})' data-bs-toggle="modal" data-bs-target="#showModalProjetAgrement">Convention d’établissement</button>
                        @endif
                        @if(hasMeeting($media->media_id) && hasMeeting($media->media_id)->licence !=null)
                        <button type="button" class="dropdown-item btn btn-sm bg-dark mt-1" wire:click='showLicence({{$media->media_id}})' data-bs-toggle="modal" data-bs-target="#showModalLicence">Visualiser licence</button>
                        @endif
                    </div>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="10">
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-ban"></i> Information!</h5>
                    Aucune donnée trouvée par rapport aux éléments de recherche entrés.
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="modal fade" id="showModalValidationFraisAgrement" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Validation des frais d'agrément</h4>
        </div>
        <div class="modal-body">
          <p>Confirmez-vous la validation du paiement des frais d'agrément du média <strong>{{$paiement ? $paiement->media->nom :'' }} </strong> </p>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">NON</button>
          <button type="button" class="btn btn-success" wire:click="validationRejetPaiementFraisAgrement('{{$paiement ? $paiement->id :''}}',{{true}})" data-bs-dismiss="modal">OUI</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="showModalRejetFraisAgrement" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Le réjet des frais d'agrément</h4>
        </div>
        <div class="modal-body">
            <p>
                Confirmez-vous le rejet du paiement des frais d'agrément du média
                <strong>{{$paiement ? $paiement->media->nom :'' }} </strong>
            </p>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" class="btn btn-success" data-bs-dismiss="modal">NON</button>
          <button type="button" class="btn btn-danger" wire:click="validationRejetPaiementFraisAgrement('{{$paiement ? $paiement->id :null}}',{{0}})" data-bs-dismiss="modal">OUI</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="showModalPreviewRecuFraisAgrement" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Reçu frais d'agrément</h4>
        </div>
        <div class="modal-body">
          <p>Reçu frais d'agrément du média <strong id="nomMediaPreview"></strong></p>
          <embed id="previewRecu" src="{{asset($paiement ? $paiement->recu :'')}}"  width="100%" height="600">
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" class="btn btn-default" data-bs-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="showModalProjetAgrementGenerer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog" style="max-width:900px;">
        <div class="modal-content">
            <div class="modal-body m-3">
                <embed src="{{asset($projetAgrementNoSigne ? $projetAgrementNoSigne->document : '') }}"  width="100%" height="600">
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary float-end" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="showModelAddProjetAgrement" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="showModelAddProjetAgrementLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Importer le projet d'agrément de <strong>{{$firstMedia ? $firstMedia->media->nom :''}} </strong> </h4>
        </div>
        <form wire:submit.prevent="importProjetAgrement({{$firstMedia ? $firstMedia->id:''}})">
            <div class="card-body">
                <div class="form-group">
                    <label for="projetAgrement">Projet d'agrément <i class="text-danger">*</i></label><br>
                    <input type="file" wire:model='projetAgrement' class="form-control @error('projetAgrement') is-invalid @enderror">
                    @error("projetAgrement")
                        <span class="text-danger projetAgrement">{{ $message }}</span>
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
</div>
