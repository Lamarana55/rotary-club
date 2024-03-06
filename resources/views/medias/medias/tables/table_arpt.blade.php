<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th style="width: 50px">#</th>
            <th>Média</th>
            <th>Type</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Statut</th>
            <th class="text-center">Action.s</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($medias as $key=> $media)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $media->media->nom }}</td>
                <td>{{ $media->media->type_media }}</td>
                <td>{{ $media->media->email }}</td>
                <td>{{ number_format(str_replace(' ', '', $media->media->telephone), 0, '', '-') }}</td>
                <td>
                    @if($media->licence == null)
                    <span class="text-warning">
                        Encours
                    </span>
                    temps restant : <b>{{suivu('signature de l\'agrément a la direction',traking($media->media_id)->date_importer_agrement??null)}} </b>
                    @else
                    <span class="text-success"> Terminé </span>
                    @endif
                </td>
                <td class="text-center">
                    <div class="row justify-content-end">
                        <button type="button" class="btn btn-primary btn-sm" wire:click='showAgrementSigne({{$media->media_id}})' data-bs-toggle="modal" data-bs-target="#showModalProjetAgrement">Convention d’établissement</button>&nbsp;
                        <a class="btn btn-default btn-sm mr-1" href="{{route('detail-media',['id'=>$media->media->uuid])}}">Détails</a>
                        @if($media->licence == null)
                        <button type="button" class="btn btn-primary text-white btn-sm" wire:click='getSaveLicence({{$media->id}})' data-bs-toggle="modal" data-bs-target="#showModelEnregistrementLicence">Importer licence </button>
                        @elseif($media->licence !=null)
                        <button type="button" class="btn btn-dark btn-sm" wire:click='showLicence({{$media->media_id}})' data-bs-toggle="modal" data-bs-target="#showModalLicence">Visualiser licence</button>&nbsp;
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

