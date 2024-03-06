<div class="row">
    <a href="{{url('/liste-medias')}}" class="btn btn-primary btn-sm m-3 float-end">Retour</a>

    <div class="col-md-12">
      <!-- The time line -->
      <div class="timeline mt-3">
        <!-- licence signé par ARPT -->
        @if(hasMeeting($media->id) && hasMeeting($media->id)->licence)
        @include('medias.medias.chronogrammes.licence_arpt')
        @endif
        <!-- agrement signé -->
        @if($media->meeting)
        @include('medias.medias.chronogrammes.agrement_signe_direction')
        @endif
        <!-- enregistrement agrément sgg -->
        @if($media && $media->numero_registre_sgg)
        @include('medias.medias.chronogrammes.prise_rendez_vous')
        @endif

        <!-- enregistrement agrément sgg -->
        @if($media && $media->numero_registre_sgg)
        @include('medias.medias.chronogrammes.enregistrement_sgg')
        @endif
        <!-- elaboration du projet d'agrément -->
        @if($this->hasProjetAgrementInDocument($media->id))
        @include('medias.medias.chronogrammes.conseiller_juridique')
        @endif
        <!-- paiement de frais d'agrément -->
        @if($fraisAgrement)
        @include('medias.medias.chronogrammes.frais_agrement')
        @endif
        <!-- hac -->
        @if($this->checkStatusHac($media->id))
        @include('medias.medias.chronogrammes.hac')
        @endif
        <!-- Commission -->
        @include('medias.medias.chronogrammes.commission')
        <!-- achat cachier des charges -->
        @if($cahierChargePayer)
        @include('medias.medias.chronogrammes.achat_cachier_charge')
        @endif
        <div>
          <i class="fas fa-clock bg-gray"></i>
        </div>
      </div>
    </div>
  </div>
