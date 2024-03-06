@foreach ($meetings as $meeting)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $meeting->programme->format_date_avec_jour }}</td>
    <td>{{ $meeting->media->nom_media }}</td>
    <td>{{ $meeting->media->email }}</td>
    <td>{{ number_format(str_replace(' ', '', $meeting->media->telephone), 0, '', '-') }}</td>
    <td>{{$meeting->nom }}</td>

    <td style="text-align: center">
        @if($meeting->agrement)
        <span class="text text-success"><i class="fa fa-check" aria-hidden="true"></i></span>
        @endif

        @if($meeting->annuler === 1)
        <span class="text text-warning"><i class="fa fa-exclamation" aria-hidden="true"></i></span>
        @endif
    </td>

    <td>
        <div class="row justify-content-center">
            <a class="btn btn-primary btn-sm mr-1" href="{{ route('details', ['id' => $meeting->media->id_media]) }}">Détails</a>
            @if($meeting->agrement === null && $meeting->annuler === 0)
            <button id="meeting-{{ $meeting->id_meeting}}" type="button" class="btn btn-danger btn-sm mr-1 meeting">
                Annuler
            </button>

            <button id="importAgrementSigne-{{$meeting->id_meeting}}" class="btn btn-primary btn-sm import-agrement-signe">
                Signer
            </button>
            @endif

            @if($meeting->annuler === 1)
            <button id="programme-{{ $meeting->programme->id_programme}}" type="button" class="btn btn-danger btn-sm programme">
                Supprimer
            </button>
            @endif
        </div>
    </td>

</tr>
@endforeach
