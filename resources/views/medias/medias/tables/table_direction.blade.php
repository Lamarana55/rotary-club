<style>
    .btn-color{
        background-color: #808080 !important;
    }
</style>
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
            <th>Frais d’agrément</th>
            <th>Agréé</th>
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

            <td>{{ formatGNF($media->montant) }} </td>
            <td style="text-align: center;">
                @if($media->is_valided === null)
                <span class="text-warning"> Nouveau </span>
                @elseif($media->is_valided == true)
                <span class="text-success"> Paiement validé </span>
                @elseif($media->is_valided === false)
                <span class="text-danger"> Rejeté </span>
                @endif
            </td>
            <td class="text-center">
                <div class="btn-group">
                <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> Séléctionner une action <i class="mdi mdi-chevron-down"></i> </button>
                    <div class="dropdown-menu justify-content-between">
                        <a class="dropdown-item mt-1 btn btn-default btn-sm mr-1" href="{{route('detail-media',['id'=>$media->media->uuid])}}">Détails</a>
                        @if (hasPermission('valider_paiement_frais_agrement'))
                            <button @if($media->is_valided === null) @else hidden @endif class="dropdown-item mt-1 btn bg-success mr-1
                                btn-sm valider"
                                wire:click="showModalValideFraisAgrement({{$media->media_id}})">Valider
                            </button>
                        @endif
                        @if (hasPermission('rejeter_paiement_frais_agrement'))
                            <button @if($media->is_valided === null) @else hidden @endif class="dropdown-item mt-1 btn bg-danger
                                btn-sm"
                                wire:click='showModalRejetPaiementFraisAgrement({{ $media->media_id}})'>Rejeter
                            </button>
                        @endif
                        <button @if($media->is_valided === true || $media->recu !== null ) @else hidden @endif class="dropdown-item mt-1 btn-color text-white btn-sm"
                            wire:click='showModalPreviewRecuFraisAgrement({{$media->media_id}})'>Reçu trésor
                        </button>
                        @if(hasMeeting($media->media_id) && hasMeeting($media->media_id)->agrement !=null)
                        <button class="dropdown-item btn btn-sm btn-primary text-white mt-1" wire:click='showAgrementSigne({{$media->media_id}})' data-bs-toggle="modal" data-bs-target="#showModalProjetAgrement">Convention d’établissement</button>
                        @endif
                        @if(hasMeeting($media->media_id) && hasMeeting($media->media_id)->licence !=null)
                        <button class="dropdown-item btn btn-sm bg-dark mt-1" wire:click='showLicence({{$media->media_id}})' data-bs-toggle="modal" data-bs-target="#showModalLicence">Visualiser licence</button>
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


<div class="modal fade" id="showModelAddProjetAgrement" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="showModelAddProjetAgrementLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Importer le projet d'agrément de <strong>{{$firstMedia ? $firstMedia->media->nom :''}} </strong> </h4>
        </div>
        <form wire:submit.prevent="importProjetAgrement({{$firstMedia ? $firstMedia->id:''}})">
            <div class="card-body">
                <div class="form-group">
                    <label for="projetAgrement">Projet d'agrément</label><br>
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
