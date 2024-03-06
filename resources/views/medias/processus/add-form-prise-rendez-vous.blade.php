<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEventModalLabel">Prenez un rendez-vous</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($media->meeting AND (!$media->meeting->confirmer AND !$media->meeting->annuler))
                    <h5>
                        Votre rendez-vous actuel est prévu pour le <b>{{ dateFormat($media->meeting->date) }}</b> à partir de <b>{{ explode(" ", $media->meeting->heure)[0] }}</b>
                    </h5>
                @endif
                <h5 class="message"></h5>
                <div class='calendar'></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
