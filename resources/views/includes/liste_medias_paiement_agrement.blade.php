@foreach ($paiements as $paiement)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $paiement->media->nom_media }}</td>
    <td>{{ $paiement->media->type_media->libelle }}</td>
    <td>{{ $paiement->media->email }}</td>
    <td>{{ number_format(str_replace(' ', '', $paiement->media->telephone), 0, '', '-') }}</td>
    <td>
        @if($paiement->valide === null)
            <span class="text text-warning"><i class="fa fa-exclamation" aria-hidden="true"></i></span>
        @else
            @if($paiement->valide === 1)
            <span class="text text-success"><i class="fa fa-check"></i></span>
            @else
            <span class="text text-danger"><i class="fa fa-minus" aria-hidden="true"></i>
            </span>
            @endif
        @endif
    </td>
    <td>
        @if($paiement->media->meeting && $paiement->media->meeting->agrement)
        <span class="text text-success"><i class="fa fa-check"></i></span>
        @endif
    </td>

    <td style="width: 200px">
        <div class="row justify-content-center">
            <a class="btn btn-primary btn-sm mr-1" href="{{ route('details', ['id' => $paiement->media->id_media]) }}">Détails</a>
            @if($paiement->valide === null)
            <button class="btn btn-primary btn-sm mr-1 accepter" id="valider-{{$paiement->id_paiement}}">Valider</button>
            <button class="btn btn-danger btn-sm rejeter" id="rejeter-{{$paiement->id_paiement}}">Rejeter</button>
            @endif
        </div>
    </td>

</tr>
@endforeach
