<div class="time-label">
    <span class="bg-{{delaisUilise2($traking->date_transmission_projet_agrement??null,$traking->date_paiement_agrement??null,'validation de frais d\'agrément') >= 0 ?'success':'danger'}}"> Conseiller Juridique (CJ)
        {{delaisUilise($traking->date_transmission_projet_agrement??null,$traking->date_paiement_agrement??null,'validation de frais d\'agrément')}}
    </span>
</div>
<div>
<div class="timeline-item">
    <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title"> Élaboration du projet d'agrément</h3>
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
            @if($this->hasProjetAgrementInDocument($media->id))
                <p class="text-center font-weight-bold text-info">Votre projet d'agrement a été transmis au Sécrétariat Général du Gouvernement (SGG)</p>
                <div class="row text-center">
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <button class="btn btn-info btn-sm btnShowProjetAgrement" wire:click='visualiserprojetagreement' value="{{$media->id}}"><i class="fa fa-eye"></i> Visualiser </button>
                    </div>
                    <div class="col-md-3">
                        <p class="text-center font-weight-bold text-info">
                            <a target="_blank" class="btn btn-info btn-sm" href="{{asset($this->hasProjetAgrementInDocument($media->id)->file_path)}}"><i class="fa fa-download" aria-hidden="true"></i> Telecharger projet d'agrement</a>
                        </p>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-12 mt-5" id="previewProjetAgrement">
                    </div>
                </div>
                @if ($is_visualiserprojetagreement)
                    <div class="row justify-content-center mt-auto">
                        <div class="col-7 mt-2">
                            <div style="col">
                                <button class="btn btn-primary float-right mb-1" wire:click="closevisualiserprojetagreement">Fermer </button>
                                <span class="float-right"></span>
                            </div>
                            <embed src="{{$this->hasProjetAgrementInDocument($media->id)->file_path}} "  width="100%" height="600">
                        </div>
                    </div>
                @endif
            @else
                <p class="text-center font-weight-bold text-info">Votre projet d'agrément est en cours d'élaboration par le conseiller juridique (CJ)</p>
            @endif
        </div>
    </div>
</div>
</div>
