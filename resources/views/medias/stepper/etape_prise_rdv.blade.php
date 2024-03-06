@if($current_stape==7)
<div id="prise-rdv">
    <div class="card-body">
        @if($media->meeting === null || $media->meeting->annuler === 1)
            <p class="text-center">
                Temps restant : <b>{{suivu('enregistrement du numéro de l\'agrément',traking($media->id)->date_enregistrement_media??null)}} </b>
            </p>
            @if ($media->meeting === null)
                <p class="text-center font-weight-bold">Prenez votre rendez-vous pour la signature</p>
                <div class="row" id="listeProgrammess">
                    <div class="col-md-12">
                        <p class="text-center">
                            <a class="btn btn-primary btn-md add-rdv" href="#" data-toggle="modal" data-target="#addEventModal" data-href="{{ route("meetings.create") }}">
                                <i class="fa fa-calendar" aria-hidden="true"></i> Selectionner une date
                            </a>
                        </p>
                    </div>
                </div>
            @else
                <p class="text-center font-weight-bold text-danger">Votre rendez-vous du {{ dateFormat($media->meeting->date).' de '.$media->meeting->heure }} a été annuler</p>
                <p class="text-center font-weight-bold text-danger">Motif: {{ $media->meeting->motif }}</p>
                <p class="text-center font-weight-bold">Prenez un autre rendez-vous</p>
                <p class="text-center">
                    <a class="btn btn-primary btn-md add-rdv" href="#" data-toggle="modal" data-target="#addEventModal" data-href="{{ route("meetings.create") }}">
                        <i class="fa fa-calendar" aria-hidden="true"></i> Selectionner une date
                    </a>
                </p>
            @endif
        @else
            @if($media->meeting->confirmer)
                <p class="text-center font-weight-bold text-info">
                    Votre rendez-vous pour la signature est le
                    {{ dateFormat($media->meeting->date).' de '.$media->meeting->heure }}
                </p>
            @else
                <p class="text-center font-weight-bold text-info">
                    Votre rendez-vous pour la signature est en attente de confirmation </b>
                </p>
                <p class="text-center font-weight-bold">
                    <b>{{ dateFormat($media->meeting->date) }}</b> à partir de <b>{{ explode(" ", $media->meeting->heure)[0] }}</b>
                </p>
                <p class="text-center">
                    <a class="btn btn-primary btn-md add-rdv" href="#" data-toggle="modal" data-target="#addEventModal" data-href="{{ route("meetings.create") }}">
                        <i class="fa fa-calendar" aria-hidden="true"></i> Modifier mon rendez-vous
                    </a>
                </p>
            @endif
        @endif
    </div><hr>
    <div class="row">
        <div class="col-md-4">
            <button class="btn btn-primary btn-md goToPrecedent" wire:click="stepperAction({{$media->id}},6)">Précédent</button>
        </div>
        <div class="col-md-4">
            @if($media->meeting && $media->meeting->agrement)
                <p>Veuillez cliquer sur le bouton suivant pour poursuivre le processus</p>
            @endif
        </div>
        <div class="col-md-4">
            @if($media->meeting && $media->meeting->agrement)
            <button class="btn btn-primary btn-md float-right goToSuivent" wire:click="stepperAction({{$media->id}},8)">Suivant</button>
            @endif
        </div>
    </div>
</div>
@endif
