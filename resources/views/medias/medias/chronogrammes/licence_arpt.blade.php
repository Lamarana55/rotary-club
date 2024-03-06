<div class="time-label">
    <span class="bg-{{delaisUilise2($traking->date_licence??null,$traking->date_importer_agrement??null,'signature de l\'agrément a la direction') >= 0 ?'success':'danger'}}"> Licence signé (ARPT) :
        {{delaisUilise($traking->date_licence??null,$traking->date_importer_agrement??null,'signature de l\'agrément a la direction')}}
    </span>
</div>
<div>
<div class="timeline-item">
    <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title"> Licence signé par ARPT </h3>
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
                    @if(hasMeeting($media->id) && hasMeeting($media->id)->licence==null)
                    <p class="font-weight-bold text-info">Votre licence est en cours d'elaboration à l'ARTP</p>
                    @endif

                    @if(hasMeeting($media->id) && hasMeeting($media->id)->licence)
                        <p class="font-weight-bold text-info">Votre licence signé est disponible</p>
                        <button type="button" class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#showModalProjetLicence">
                            </i>Visualiser la licence signé
                        </button>

                        <a target="_blank" class="btn btn-primary btn-md" wire:click="telechargerAgrementSigne({{$media->id}})" href="{{asset($media->meeting->agrement)}}">
                            <i class="fa fa-download" aria-hidden="true"></i>Télécharger
                        </a>
                    @endif
                </div>
            </div>

            <div class="modal fade" id="showModalProjetLicence" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" wire:ignore.self>
                <div class="modal-dialog" style="max-width:900px;">
                    <div class="modal-content">
                        <div class="modal-body m-3">
                            <embed src="{{asset($media->meeting->licence ??null) }}"  width="100%" height="600">
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
