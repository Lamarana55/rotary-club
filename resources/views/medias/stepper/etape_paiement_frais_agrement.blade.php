@if($current_stape==4)
<div id="paiement-frais-agrement">
    <div class="card-body">
        <div>
            <p class="font-weight-bold text-center text-info" @if($fraisAgrement && $fraisAgrement->is_valided === null) @else hidden @endif>Votre reçu est en cours de validation par la Direction Nationale de la Communication et des Relations avec les Médias Privés (DNCRMP)</p>
        </div>
        <p class="font-weight-bold text-center text-info" @if($fraisAgrement && $fraisAgrement->is_valided) @else hidden @endif>Votre reçu a été validé</p>
        <p class="font-weight-bold text-center text-danger" @if($fraisAgrement && $fraisAgrement->is_valided === false) @else hidden @endif>Votre reçu a été rejeté</p>

        <div>
            @if($fraisAgrement === null)
            <p class="text-center">Temps restant : <b>{{suivu('étude des documents techniques a la hac',traking($media->id)->date_etude_hac??null)}} </b></p><br>

            <button class="btn btn-primary btn-md mr-1"  data-bs-toggle="modal" data-bs-target="#showModalPaiementFraisAgrement">Importer le reçu</button>
            @endif

            @if($fraisAgrement && $fraisAgrement->is_valided === false)
            <p class="text-center">Temps restant : <b>{{suivu('étude des documents techniques a la hac',traking($media->id)->date_etude_hac??null)}} </b></p><br>

            <button class="btn btn-primary btn-md mr-1"  data-bs-toggle="modal" data-bs-target="#showModalPaiementFraisAgrement">Importer le reçu</button>
            @endif
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <button class="btn btn-primary btn-md" value="{{$media->id}}, 3" wire:click="stepperAction({{$media->id}},3)">Précédent</button>
        </div>
        <div class="col-md-4">
            @if($fraisAgrement && $fraisAgrement->is_valided)
            <p>Veuillez cliquer sur le bouton suivant pour poursuivre le processus</p>
            @endif
        </div>
        <div class="col-md-4">
            @if($fraisAgrement && $fraisAgrement->is_valided)
            <button class="btn btn-primary btn-md float-right" wire:click="stepperAction({{$media->id}},5)">Suivant</button>
            @endif
        </div>
    </div>
</div>
@endif
