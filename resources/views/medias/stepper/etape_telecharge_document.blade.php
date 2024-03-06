@if($current_stape==8)
<div id="telecharge-document">
    <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-8">
            @if($media->meeting && $media->meeting->agrement)
                <p class="font-weight-bold text-info">Votre projet d'agrement signé est disponible</p>
                <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#showModalProjetAgrementSigne" wire:click='previewAgrement'>
                    </i>Visualiser le projet d'agrement signé
                </button>

                <a target="_blank" class="btn btn-primary btn-md" wire:click="telechargerAgrementSigne({{$media->id}})" href="{{asset($media->meeting->agrement)}}">
                    <i class="fa fa-download" aria-hidden="true"></i>Télécharger
                </a>
            @endif
        </div>
    </div><hr>
    <div class="row">
        <div class="col-md-4">
            <button class="btn btn-primary btn-md" wire:click="stepperAction({{$media->id}},7)">Précédent</button>
        </div>
        @if($media->meeting && $media->meeting->agrement)
        <div class="col-md-4">
            <p>Veuillez cliquer sur terminé pour voir le résumé</p>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary btn-md float-right" wire:click="stepperAction({{$media->id}},9)">Suivant</button>
        </div>
        @endif
    </div>
</div>

<div class="modal fade" id="showModalProjetAgrementSigne" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog" style="max-width:900px;">
        <div class="modal-content">
            <div class="modal-body m-3">
                <embed src="{{asset($media->meeting->agrement ??null) }}"  width="100%" height="600">
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary float-end" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
@endif
