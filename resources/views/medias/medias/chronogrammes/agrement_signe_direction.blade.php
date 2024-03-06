<div class="time-label">
    <span class="bg-{{delaisUilise2($traking->date_confirme_rdv??null,$traking->date_prise_rdv??null,'confirmation de rendez-vous') >= 0 ?'success':'danger'}}"> Agrément signé (DNCRMP) :
        {{delaisUilise($traking->date_confirme_rdv??null,$traking->date_prise_rdv??null,'confirmation de rendez-vous')}}
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
            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-8">
                    @if($media->meeting && $media->meeting->agrement)
                        <p class="font-weight-bold text-info">Votre projet d'agrement signé est disponible</p>
                        <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#showModalProjetAgrementSigne">
                            </i>Visualiser le projet d'agrement signé
                        </button>

                        <a target="_blank" class="btn btn-primary btn-md" wire:click="telechargerAgrementSigne({{$media->id}})" href="{{asset($media->meeting->agrement)}}">
                            <i class="fa fa-download" aria-hidden="true"></i>Télécharger
                        </a>
                    @endif
                </div>
            </div>

            <div class="modal fade" id="showModalProjetAgrementSigne" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" wire:ignore.self>
                <div class="modal-dialog" style="max-width:900px;">
                    <div class="modal-content">
                        <div class="modal-body m-3">
                            <embed src="{{asset($media->meeting->agrement ??null) }}" width="100%" height="600">
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary float-end" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
