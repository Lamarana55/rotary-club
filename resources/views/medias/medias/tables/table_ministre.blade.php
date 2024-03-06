<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Promoteur</th>
            <th>Media</th>
            <th>Type</th>
            <th>Téléphone</th>
            <th>Localité</th>
            <th>Agrée</th>

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
            <td>{{ $media->media->commune->nom??null }}</td>

            <td style="text-align: center;">
                @if($media->media->agree)
                <p class="badge bg-success"> Agrée </p>
                @else
                <p class="badge bg-warning"> En cours de traitement</p>
                @endif
            </td>

            <td class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> Séléctionner une action <i class="mdi mdi-chevron-down"></i> </button>
                        <div class="dropdown-menu justify-content-between">
                            <a class="dropdown-item mt-1 btn bg-primary btn-sm"
                                    href="{{ route('chronologie-media', ['id' => $media->media->uuid]) }}">Chronologie</a>
                            <a class="dropdown-item mt-1 btn btn-default btn-sm"
                                    href="{{ route('detail-media', ['id' => $media->media->uuid]) }}">Detail</a>
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
