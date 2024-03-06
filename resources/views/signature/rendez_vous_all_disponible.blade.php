@foreach ($programmes as $programme)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $programme->format_date_avec_jour }}</td>
    <td>@if($programme->meeting){{ $programme->meeting->media->nom_media }}@endif</td>
    <td>@if($programme->meeting){{ $programme->meeting->media->email }}@endif</td>
    <td>@if($programme->meeting){{ number_format(str_replace(' ', '', $programme->meeting->media->telephone), 0, '', '-')  }}@endif</td>
    <td>@if($programme->meeting){{$programme->meeting->nom }}@endif</td>

    <td style="text-align: center">
        @if($programme->meeting)
            @if($programme->meeting->agrement)
            <span class="text text-success"><i class="fa fa-check" aria-hidden="true"></i></span>
            @endif

            @if($programme->meeting->annuler === 1)
            <span class="text text-warning"><i class="fa fa-exclamation" aria-hidden="true"></i></span>
            @endif
        @endif
    </td>

    <td>
        <div class="row justify-content-center">

            @if($programme->meeting)
                <a class="btn btn-primary btn-sm mr-1" href="{{ route('details', ['id' => $programme->meeting->media->id_media]) }}">Détails</a>
                @if($programme->meeting->agrement === null && $programme->meeting->annuler === 0)
                <button id="meeting-{{ $programme->meeting->id_meeting}}" type="button" class="btn btn-danger btn-sm mr-1 meeting">
                    Annuler
                </button>

                <button id="importAgrementSigne-{{$programme->meeting->id_meeting}}" class="btn btn-primary btn-sm import-agrement-signe">
                    Signer
                </button>
                @endif
            @else
                <button id="programme-{{ $programme->id_programme}}" type="button" class="btn btn-danger btn-sm programme">
                    Supprimer
                </button>
            @endif
        </div>
    </td>

</tr>
@endforeach
