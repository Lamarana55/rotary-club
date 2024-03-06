@foreach ($medias as $media)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $media->nom_media }}</td>
    <td>{{ $media->type_media->libelle }}</td>
    <td>{{ $media->email }}</td>
    <td>{{ number_format(str_replace(' ', '', $media->telephone), 0, '', '-') }}</td>
    <td>
        @if($media->paiement_agrement)
            @if($media->paiement_agrement->valide === null)
            <span class="text text-warning"><i class="fa fa-exclamation" aria-hidden="true"></i></span>
            @else
                @if($media->paiement_agrement->valide === 1)
                <span class="text text-success"><i class="fa fa-check"></i></span>
                @else
                <span class="text text-danger"><i class="fa fa-minus" aria-hidden="true"></i>
                </span>
                @endif
            @endif
        @endif
    </td>
    <td>
        @if($media->meeting && $media->meeting->agrement)
        <span class="text text-success"><i class="fa fa-check"></i></span>
        @endif
    </td>

    <td>
        <div class="row justify-content-center">
            <a class="btn btn-primary btn-sm mr-1" href="{{ route('details', ['id' => $media->id_media]) }}">Détails</a>
            @if($media->paiement_agrement && $media->paiement_agrement->valide === null)
            <button class="btn btn-primary btn-sm mr-1 accepter" id="valider-{{$media->paiement_agrement->id_paiement}}">Valider</button>
            <button class="btn btn-danger btn-sm rejeter" id="rejeter-{{$media->paiement_agrement->id_paiement}}">Rejeter</button>
            @endif
        </div>
    </td>

</tr>
@endforeach
