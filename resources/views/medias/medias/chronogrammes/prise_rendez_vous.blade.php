<div class="time-label">
    <span class="bg-{{delaisUilise2($traking->date_prise_rdv??null,$traking->date_enregistrement_media??null,'enregistrement du numéro de l\'agrément') >= 0 ?'success':'danger'}}"> Prise de rendez-vous  (Promoteur) :
        {{delaisUilise($traking->date_prise_rdv??null,$traking->date_enregistrement_media??null,'enregistrement du numéro de l\'agrément')}}
    </span>
</div>
<div>
<div class="timeline-item">
    <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title"> Prise de rendez-vous pour la signature </h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
            @if($media->meeting === null || $media->meeting->annuler === 1)
            @if ($media->meeting === null)
                <p class="text-center font-weight-bold">Prenez votre rendez-vous pour la signature</p>
            @else
                <p class="text-center font-weight-bold text-danger">Votre rendez-vous du {{ dateFormat($media->meeting->date).' de '.$media->meeting->heure }} a été annuler</p>
                <p class="text-center font-weight-bold text-danger">Motif: {{ $media->meeting->motif }}</p>
                <p class="text-center font-weight-bold">Prenez un autre rendez-vous</p>
            @endif
            @else
                @if($media->meeting->confirmer)
                    <p class="text-center font-weight-bold text-info">
                        Votre rendez-vous pour la signature est le
                        {{ dateFormat($media->meeting->date).' de '.$media->meeting->heure }}
                    </p>
                @else
                    <p class="text-center font-weight-bold text-info">
                        Votre rendez-vous pour la signature est en attente de confirmation
                    </p>
                @endif
            @endif
        </div>
    </div>
</div>
</div>
