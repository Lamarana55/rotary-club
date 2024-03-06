<div class="time-label">
    <span class="bg-{{delaisUilise2($traking->date_paiement_agrement??null,$traking->date_etude_hac??null,'paiement de frais d\'agrément') >= 0 ?'success':'danger'}}"> Paiement de frais d'agrément  (Promoteur) :
        {{delaisUilise($traking->date_paiement_agrement??null,$traking->date_etude_hac??null,'paiement de frais d\'agrément')}}
    </span>
</div>
<div>
<div class="timeline-item">
    <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title"> Paiement de frais d'agrément </h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
            <div>
                <p class="font-weight-bold text-center text-info" @if($fraisAgrement && $fraisAgrement->is_valided === null) @else hidden @endif>Votre reçu est en cours de validation par la Direction Nationale de la Communication et des Relations avec les Médias Privés (DNCRMP)</p>
            </div>
            <p class="font-weight-bold text-center text-info" @if($fraisAgrement && $fraisAgrement->is_valided) @else hidden @endif>Votre reçu a été validé</p>
            <p class="font-weight-bold text-center text-danger" @if($fraisAgrement && $fraisAgrement->is_valided === false) @else hidden @endif>Votre reçu a été rejeté</p>

            <div>
                @if($fraisAgrement === null)
                <button class="btn btn-primary btn-md mr-1"  data-bs-toggle="modal" data-bs-target="#showModalPaiementFraisAgrement">Importer le reçu</button>
                @endif

                @if($fraisAgrement && $fraisAgrement->is_valided === false)
                <button class="btn btn-primary btn-md mr-1"  data-bs-toggle="modal" data-bs-target="#showModalPaiementFraisAgrement">Importer le reçu</button>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
