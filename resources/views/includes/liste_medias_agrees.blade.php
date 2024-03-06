@foreach ($meetings as $meeting)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $meeting->media->nom_media }}</td>
    <td>{{ $meeting->media->type_media->libelle }}</td>
    <td>{{ $meeting->media->email }}</td>
    <td>{{ number_format(str_replace(' ', '', $meeting->telephone), 0, '', '-') }}</td>
    <td>
        @if($meeting->media->paiement_agrement)
            @if($meeting->media->paiement_agrement->valide === null)
            <span class="text text-warning"><i class="fa fa-exclamation" aria-hidden="true"></i></span>
            @else
                @if($meeting->media->paiement_agrement->valide === 1)
                <span class="text text-success"><i class="fa fa-check"></i></span>
                @else
                <span class="text text-danger"><i class="fa fa-minus" aria-hidden="true"></i>
                </span>
                @endif
            @endif
        @endif
    </td>
    <td>
        <span class="text text-success"><i class="fa fa-check"></i></span>
    </td>

    <td class="text-right">
        <a class="btn btn-primary btn-sm mr-1" href="{{ route('details', ['id' => $meeting->media->id_media]) }}">Détails</a>
    </td>

</tr>
@endforeach
