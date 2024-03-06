@if($current_stape==3)
<div id="etude-dossier-hac">
    @if ($this->checkStatusHac($media->id))
        @if($this->checkStatusHac($media->id)->status_hac === null)
            <p class="text-center font-weight-bold text-info">Votre dossier technique est en cours d'analyse à la Haute Autorité de Communication (HAC).</p>
        @else
            @if ($this->checkStatusHac($media->id)->status_hac === 'terminer')
                <p class="text-center font-weight-bold text-info">Votre dossier technique a été validés par la Haute Autorité de Communication (HAC) </p>
            @elseif($this->checkHac($media->id,'document_technique'))
                <p class="text-center font-weight-bold text-danger">La Haute Autorité de Communication (HAC) a donné un avis défavorable à votre dossier technique. </p>
                <p  class="text-center font-weight-bold text-danger">Veuillez consulter le raport pour plus de détails. </p>
            @else
            <p class="text-center font-weight-bold text-info">Votre dossier technique est en cours d'analyse à la Haute Autorité de Communication (HAC).</p>
            @endif
            @if($this->rapportCommissionHac('rapport_hac'))
            <a target="_blank" class="btn btn-info btn-sm" href="{{asset($this->rapportCommissionHac('rapport_hac') ? $this->rapportCommissionHac('rapport_hac')->file_path :'')}}"><i class="fa fa-download" aria-hidden="true"></i> Télécharger rapport</a>
            @endif
        @endif
        @else
    @endif
    <hr>
    <div class="row">
        <div class="col-md-4">
            <button class="btn btn-primary btn-md goToPrecedent" wire:click="stepperAction({{$media->id}},2)">Précédent</button>
        </div>
        <div class="col-md-4">
            @if($this->checkStatusHac($media->id) && $this->checkStatusHac($media->id)->status_hac === 'terminer')
            <p class="text-center">Veuillez cliquer sur le bouton suivant pour poursuivre le processus</p>
            @endif
        </div>
        <div class="col-md-4">
            @if($this->checkStatusHac($media->id) && $this->checkStatusHac($media->id)->status_hac === 'terminer')
            <button class="btn btn-primary float-right btn-md goToSuivent" wire:click="stepperAction({{$media->id}},4)">Suivant</button>
            @endif
        </div>
    </div>
</div>
@endif
