 <table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Promoteur</th>
            <th>Media</th>
            <th>Type</th>
            <th>Téléphone</th>
            <th>Mode de paiement</th>
            <th>Montant</th>
            <th>Code marchand</th>
            <th>Etat</th>

            <th class="text-center">Action.s</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($medias as $key => $media)
        <tr>

            <td>{{ $key+1 }}</td>
            <td>{{ $media->media->user->prenom.' '.$media->media->user->nom  }}</td>
            <td>{{ $media->media->nom }}</td>
            <td>{{ $media->media->type_media  }}</td>
            <td>{{ number_format(str_replace(' ', '', $media->media->telephone), 0, '', '-') }}</td>
            <td>{{ $media->mode }}</td>
            <td>{{ formatGNF($media->montant) }}</td>
            <td>{{ $media->code_marchant }}</td>

            <td style="text-align: center;">
                @if($media->is_valided === null)
                <p class="badge bg-warning"> Nouveau </p>
                @elseif($media->is_valided == true)
                <p class="badge bg-success"> Paiement validé </p>
                @elseif($media->is_valided === false)
                <p class="badge bg-danger"> Rejeté </p>
                @endif
            </td>

            <td class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> Séléctionner une action <i class="mdi mdi-chevron-down"></i> </button>
                        <div class="dropdown-menu justify-content-between">
                            @if (hasPermission('valider_paiement_cahier_charge'))
                                <button @if($media->is_valided === null) @else hidden @endif class="dropdown-item mt-1 btn bg-success mr-1
                                    btn-sm valider"
                                    wire:click="showValideCahierChargeModal({{$media->id}})">Valider</button>
                            @endif
                            @if (hasPermission('rejeter_paiement_cahier_charge'))
                                <button @if($media->is_valided === null) @else hidden @endif class="dropdown-item mt-1 btn bg-danger
                                    btn-sm"
                                    wire:click='showRejetPaiementCahierChargeModal({{$media->id}})'>Rejeter</button>
                            @endif
                            <button @if($media->is_valided === true || $media->recu !== null ) @else hidden @endif class="dropdown-item mt-1 btn bg-info
                                btn-sm" wire:click='showPreviewRecu({{$media->id}})'>Reçu</button>
                            <a class="dropdown-item mt-1 btn bg-primary btn-sm mr-1"
                                    href="{{ route('detail-media', ['id' => $media->media->uuid]) }}">Vérifier</a>
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
