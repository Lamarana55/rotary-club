@if($current_stape==5)
<div id="transmission-agrement">
    <div class="card-body">
        @if($this->hasProjetAgrementInDocument($media->id))
            <p class="text-center font-weight-bold text-info">Votre projet d'agrement a été transmis au Sécrétariat Général du Gouvernement (SGG)</p>
            <div class="row text-center">
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    <button class="btn btn-info btn-sm btnShowProjetAgrement" wire:click='visualiserprojetagreement' value="{{$media->id}}"><i class="fa fa-eye"></i> Visualiser </button>
                </div>
                <div class="col-md-3">
                    <p class="text-center font-weight-bold text-info">
                        <a target="_blank" class="btn btn-info btn-sm" href="{{asset($this->hasProjetAgrementInDocument($media->id)->file_path)}}"><i class="fa fa-download" aria-hidden="true"></i> Telecharger projet d'agrement</a>
                    </p>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-12 mt-5" id="previewProjetAgrement">
                </div>
            </div>
            @if ($is_visualiserprojetagreement)
                <div class="row justify-content-center mt-auto">
                    <div class="col-7 mt-2">
                        <div style="col">
                            <button class="btn btn-primary float-right mb-1" wire:click="closevisualiserprojetagreement">Fermer </button>
                            <span class="float-right"></span>
                        </div>
                        <embed src="{{$this->hasProjetAgrementInDocument($media->id)->file_path}} "  width="100%" height="600">
                    </div>
                </div>
            @endif
        @else
            <p class="text-center font-weight-bold text-info">Votre projet d'agrément est en cours d'élaboration par le conseiller juridique (CJ)</p>
        @endif
    </div><hr>
    <div class="row">
        <div class="col-md-4">
            <button class="btn btn-primary btn-md goToPrecedent" wire:click="stepperAction({{$media->id}},4)">Précédent</button>
        </div>
        <div class="col-md-4">
            @if($this->hasRapportCommissionHac($media->id,'projet_agrement'))
            <p>Veuillez cliquer sur le bouton suivant pour poursuivre le processus</p>
            @endif
        </div>
        <div class="col-md-4">
            @if($this->hasRapportCommissionHac($media->id,'projet_agrement'))
            <button class="btn btn-primary btn-md float-right goToSuivent" wire:click="stepperAction({{$media->id}},6)">Suivant</button>
            @endif
        </div>
    </div>
</div>
@endif
