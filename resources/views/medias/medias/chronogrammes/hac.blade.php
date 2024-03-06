<div class="time-label">
    <span class="bg-{{delaisUilise2($traking->date_etude_hac??null,$traking->date_etude_commission??null,'étude des documents techniques a la commission') >= 0 ?'success':'danger'}}"> Commission Technique (HAC) :
        {{delaisUilise($traking->date_etude_hac??null,$traking->date_etude_commission??null,'étude des documents techniques a la commission')}}
    </span>
</div>
<div>
<div class="timeline-item">
    <div class="card card-default">
        <div class="card-header">
          <h3 class="card-title">Commission Technique (HAC) : validation des documents technique par la hac</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
            @if($this->checkStatusHac($media->id))
                @if($this->checkStatusHac($media->id)->status_hac === null)
                    <p class="text-center font-weight-bold text-info">Votre dossier technique est en cours d'analyse à la Haute Autorité de Communication (HAC).</p>
                @else
                    @if ($this->checkStatusHac($media->id)->status_hac === 'terminer')
                        <p class="text-center font-weight-bold text-info">Votre dossier technique a été validés par la Haute Autorité de Communication (HAC) </p>
                    @elseif($this->checkHac($media->id,'document_technique'))
                        <p class="text-center font-weight-bold text-danger">La Haute Autorité de Communication (HAC) a donné un avis défavorable à votre dossier technique. </p>
                        <p  class="text-center font-weight-bold text-danger">Veuillez consulter le raport pour plus de détails. </p>
                    @else
                    <p class="text-center font-weight-bold text-info">Votre dossier technique est en cours d'analyse à la Haute Autorité de Communication (HAC).</p>
                    @endif
                    @if($this->rapportCommissionHac('rapport_hac'))
                    <a target="_blank" class="btn btn-info btn-sm" href="{{asset($this->rapportCommissionHac('rapport_hac') ? $this->rapportCommissionHac('rapport_hac')->file_path :'')}}"><i class="fa fa-download" aria-hidden="true"></i> Télécharger rapport</a>
                    @endif
                @endif
                @else
            @endif
        </div>
    </div>
</div>
</div>
