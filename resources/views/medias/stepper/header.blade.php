<style>
    .active-label{
        color: #3788d8;
    }
    .active-stepper {
        background-color: orange !important;
        color-interpolation-filters: #ffffff !important;
    }
</style>
<div class="table-responsive">
    <div class="bs-stepper-header">
        <div class="step {{$cahierChargePayer && $cahierChargePayer->is_valided ? 'active':''}} ">
            @if($cahierChargePayer && $cahierChargePayer->is_valided)
            <button type="button" class="step-trigger" wire:click="stepperAction({{$media->id}},1)">
                <span class="bs-stepper-circle {{$media->stape == null ? 'active-stepper':''}}">1</span>
                <span class="bs-stepper-label text-center {{$current_stape==1 || $media->stape == null ? 'active-label':''}}" >Achat de cahier <br> des charge (DAF) </span>
            </button>
            @else
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle {{$media->stape == null ? 'active-stepper':''}}">1</span>
                <span class="bs-stepper-label text-center {{$current_stape==1 || $media->stape == null ? 'active-label':''}}" >Achat de cahier <br> des charge (DAF) </span>
            </button>
            @endif
        </div>

        <div class="step {{$this->checkStatusHac($media->id) && $this->checkStatusHac($media->id)->status_commission === 'terminer' ? 'active':''}}">
            @if($this->checkStatusHac($media->id) && $this->checkStatusHac($media->id)->status_commission)
            <button type="button" class="step-trigger" wire:click="stepperAction({{$media->id}},2)">
                <span class="bs-stepper-circle {{$media->stape == 1 ? 'active-stepper':''}}">2</span>
                <span class="bs-stepper-label {{$current_stape==2 ? 'active-label':''}}" >Examen technique <br> (MIC) </span>
            </button>
            @else
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle {{$media->stape == 1 ? 'active-stepper':''}}">2</span>
                <span class="bs-stepper-label {{$current_stape==2 ? 'active-label':''}}" >Examen technique <br> (MIC) </span>
            </button>
            @endif
        </div>

        <div class="step {{$this->checkStatusHac($media->id) && $this->checkStatusHac($media->id)->status_hac === 'terminer' ? 'active' :''}}">
            @if($this->checkStatusHac($media->id) && $this->checkStatusHac($media->id)->status_hac === 'terminer')
            <button type="button" class="step-trigger" wire:click="stepperAction({{$media->id}},3)">
                <span class="bs-stepper-circle {{$media->stape == 2 ? 'active-stepper':''}}">3</span>
                <span class="bs-stepper-label {{$current_stape==3 ? 'active-label':''}}" >Examen technique <br> (HAC)</span>
            </button>
            @else
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle {{$media->stape == 2 ? 'active-stepper':''}}">3</span>
                <span class="bs-stepper-label {{$current_stape==3 ? 'active-label':''}}" >Examen technique <br> (HAC)</span>
            </button>
            @endif
        </div>

        <div class="step {{$fraisAgrement && $fraisAgrement->is_valided ? 'active' : ''}}">
            @if($fraisAgrement && $fraisAgrement->is_valided)
            <button type="button" class="step-trigger" wire:click="stepperAction({{$media->id}},4)">
                <span class="bs-stepper-circle {{$media->stape == 3 ? 'active-stepper':''}} ">4</span>
                <span class="bs-stepper-label text-center {{$current_stape==4 ? 'active-label':''}}" >Paiement Agrément <br> (Promoteur)</span>
            </button>
            @else
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle {{$media->stape == 3 ? 'active-stepper':''}} ">4</span>
                <span class="bs-stepper-label text-center {{$current_stape==4 ? 'active-label':''}}" >Paiement Agrément <br> (Promoteur)</span>
            </button>
            @endif
        </div>

        <div class="step {{hasProjetAgrement($media->id) ? 'active' : ''}}">
            @if(hasProjetAgrement($media->id))
            <button type="button" class="step-trigger" wire:click="stepperAction({{$media->id}},5)">
                <span class="bs-stepper-circle {{$media->stape == 4 ? 'active-stepper':''}}">5</span>
                <span class="bs-stepper-label text-center {{$current_stape==5 ? 'active-label':''}}" >Transmission Agrément <br> (CJ)</span>
            </button>
            @else
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle {{$media->stape == 4 ? 'active-stepper':''}}">5</span>
                <span class="bs-stepper-label text-center {{$current_stape==5 ? 'active-label':''}}" >Transmission Agrément <br> (CJ)</span>
            </button>
            @endif
        </div>

        <div class="step {{$this->hasProjetAgrementInDocument($media->id) ? 'active' : ''}}">
            @if($this->hasProjetAgrementInDocument($media->id))
            <button type="button" class="step-trigger" wire:click="stepperAction({{$media->id}},6)">
                <span class="bs-stepper-circle {{$media->stape == 5 ? 'active-stepper':''}}">6</span>
                <span class="bs-stepper-label text-center {{$current_stape==6 ? 'active-label':''}}" >Enregistrement de <br> l'agrément (SGG)</span>
            </button>
            @else
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle {{$media->stape == 5 ? 'active-stepper':''}}">6</span>
                <span class="bs-stepper-label text-center {{$current_stape==6 ? 'active-label':''}}" >Enregistrement de <br> l'agrément (SGG)</span>
            </button>
            @endif
        </div>

        <div class="step {{$media->meeting && $media->meeting->agrement ? 'active' : ''}}">
            @if($media->meeting && $media->meeting->agrement)
            <button type="button" class="step-trigger" wire:click="stepperAction({{$media->id}},7)">
                <span class="bs-stepper-circle {{$media->stape == 6 ? 'active-stepper':''}}">7</span>
                <span class="bs-stepper-label text-center {{$current_stape==7 ? 'active-label':''}}" >Prise de RDV <br> (Promoteur)</span>
            </button>
            @else
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle {{$media->stape == 6 ? 'active-stepper':''}}">7</span>
                <span class="bs-stepper-label text-center {{$current_stape==7 ? 'active-label':''}}" >Prise de RDV <br> (Promoteur)</span>
            </button>
            @endif
        </div>

        <div class="step {{$media->stape == 8 || hasMeeting($media->id) && hasMeeting($media->id)->licence!=null ? 'active':''}}">
            @if($media->meeting && $media->meeting->agrement)
            <button type="button" class="step-trigger" wire:click="stepperAction({{$media->id}},8)">
                <span class="bs-stepper-circle {{$media->stape == 7 ? 'active-stepper':''}}">8</span>
                <span class="bs-stepper-label text-center {{$current_stape==8 ? 'active-label':''}}" >Signature de la convention <br>(DNCRMP)</span>
            </button>
            @else
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle {{$media->stape == 7 ? 'active-stepper':''}}">8</span>
                <span class="bs-stepper-label text-center {{$current_stape==8 ? 'active-label':''}}" >Signature de la convention <br>(DNCRMP)</span>
            </button>
            @endif
        </div>

        <div class="step {{hasMeeting($media->id) && hasMeeting($media->id)->licence!=null ? 'active':''}}">
            @if($media->meeting && $media->meeting->licence)
            <button type="button" class="step-trigger" wire:click="stepperAction({{$media->id}},9)">
                <span class="bs-stepper-circle {{$media->stape == 8 && hasMeeting($media->id)->licence==null ? 'active-stepper':''}}">9</span>
                <span class="bs-stepper-label text-center {{$current_stape==9 ? 'active-label':''}}" >Délivrance de la licence <br>(ARPT)</span>
            </button>
            @else
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle {{$media->stape == 8 && hasMeeting($media->id) && hasMeeting($media->id)->licence==null? 'active-stepper':''}}">9</span>
                <span class="bs-stepper-label text-center {{$current_stape==9 ? 'active-label':''}}" >Délivrance de la licence <br>(ARPT)</span>
            </button>
            @endif
        </div>

        <div class="step {{hasMeeting($media->id) && hasMeeting($media->id)->licence!=null ? 'active':''}}">
            @if($media->meeting && $media->meeting->licence)
            <button type="button" class="step-trigger" wire:click="stepperAction({{$media->id}},10)">
                <span class="bs-stepper-circle">10</span>
                <span class="bs-stepper-label text-center {{$current_stape==10 ? 'active-label':''}}" >Sommaire</span>
            </button>
            @else
            <button type="button" class="step-trigger">
                <span class="bs-stepper-circle">10</span>
                <span class="bs-stepper-label text-center {{$current_stape==10 ? 'active-label':''}}" >Sommaire</span>
            </button>
            @endif
        </div>
    </div>
</div>
