<div class="time-label">
    <span class="bg-{{delaisUilise2($traking->date_enregistrement_media??null,$traking->date_transmission_projet_agrement??null,'élaboration du projet d\'agrément') >= 0 ?'success':'danger'}}"> Enregistrement de l'agrément   (SGG) :
        {{delaisUilise($traking->date_enregistrement_media??null,$traking->date_transmission_projet_agrement??null,'élaboration du projet d\'agrément')}}
    </span>
</div>
<div>
<div class="timeline-item">
    <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title"> Enregistrement de l'agrément  </h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
            @if($media && $media->numero_registre_sgg)
                <p class="text-center font-weight-bold text-info">votre média a été enregistré et publié par le Secrétariat General du Gouvernement (SGG)</p>
                <div class="row"></div>
                <p class="text-center font-weight-bold text-info"> Votre numéro d’agrément est le : </p>
                <h3 class="text-center font-weight-bold mt-1 mb-3"> {{$media ? $media->numero_registre_sgg : ''}} </h3>
                <div class="row text-center">
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <button class="btn btn-info btn-sm btnShowAgrement" value="{{$media->id}}" wire:click='visualiseragreement' ><i class="fa fa-eye"></i> Visualiser </button>
                    </div>
                    <div class="col-md-3">
                        <p class="text-center font-weight-bold text-info">
                            <a target="_blank" class="btn btn-sm btn-info" href="{{asset($this->hasRapportCommissionHac($media->id,'agrement')->file_path)}}"><i class="fa fa-download" aria-hidden="true"></i> Telecharger l'agrement</a>
                        </p>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-12 mt-5" id="previewAgrement">
                    </div>
                </div>
                @if($is_visualiseragreement)
                    <div class="row justify-content-center mt-auto">
                        <div class="col-7 mt-2">
                            <div style="col">
                                <button class="btn btn-primary float-right mb-1" wire:click="closevisualiseragreement">Fermer </button>
                                <span class="float-right"></span>
                            </div>
                            <embed src="{{$this->hasRapportCommissionHac($media->id,'agrement')->file_path}} "  width="100%" height="600">
                        </div>
                    </div>
                @endif

            @else
                <p class="text-center font-weight-bold text-info">Votre média est en cours d'enregistrement au  Sécrétariat Général du Gouvernement (SGG)</p>
            @endif
        </div>
    </div>
</div>
</div>
