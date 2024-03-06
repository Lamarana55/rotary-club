@if (auth()->user()->role->nom === "Promoteur")

  @foreach ($notification as $item)
  <a href="{{route('promoteur', $item->id_notification)}}" class="dropdown-item pt-3">
    <!-- Message Start -->
    <?php $media = get_contenus_nom_promoteur($item->id_medias);
          $verifaction = filtre_contenu($item->contenu);?>
    <b class="dropdown-item-title">
      {{$item->objet }}
    </b>
    <p class="text-md mb-0">
      {{-- {{$item->contenu}} --}}
      @if ($verifaction == "DAF rejete")
          <?php $message =  get_message_notification_promoteur(1) ?>
          {{ $message }} <b> {{$media ?  $media->nom_media : ''}} </b>
      @elseif ($verifaction == "comission rejet")
          <?php $message =  get_message_notification_promoteur("comission rejet") ?>
          {{ $message }} <b> {{$media ?  $media->nom_media : ''}} </b>
      @elseif ($verifaction == "Transmission a la hac")
          <?php $message =  get_message_notification_promoteur("Transmission a la hac") ?>
          {{ $message }} <b> {{$media ?  $media->nom_media : ''}} </b> à la HAC
      @elseif ($verifaction == "Votre dossier technique a été rejeté par la Haute Autorité de Communication (HAC)")
          <?php $message =  get_message_notification_promoteur("Votre dossier technique a été rejeté par la Haute Autorité de Communication (HAC)") ?>
          {{ $message }} <b> {{$media ?  $media->nom_media : ''}} </b> qui lui a été transmis
      @elseif ($verifaction == "la HAC est terminée par une validation")
          <?php $message =  get_message_notification_promoteur("la HAC est terminée par une validation") ?>
          {{ $message }} <b> {{$media ?  $media->nom_media : ''}} </b> qui lui a été transmis
      @elseif ($verifaction == "Le réçu de paiement que vous aviez importé a été rejeté")
          <?php $message =  get_message_notification_promoteur("Le réçu de paiement que vous aviez importé a été rejeté") ?>
          {{ $message }} <b> {{$media ?  $media->nom_media : ''}} </b>
      @elseif ($verifaction == "Votre reçu a été validé")
          <?php $message =  get_message_notification_promoteur("Votre reçu a été validé") ?>
          {{ $message }} <b> {{$media ?  $media->nom_media : ''}} </b>
      @elseif ($verifaction == "Votre projet d'agrément a été transmis au Secrétariat Général")
          <?php $message =  get_message_notification_promoteur("Votre projet d'agrément a été transmis au Secrétariat Général") ?>
          {{ $message }} <b> {{$media ?  $media->nom_media : ''}} </b> a été transmis <br> au sécrétariat général du gouvernement
      @elseif ($verifaction == "Votre projet d'agrément a été transmis au Secrétariat Général")
          <?php $message =  get_message_notification_promoteur("Votre projet d'agrément a été transmis au Secrétariat Général") ?>
          {{ $message }} <b> {{$media ?  $media->nom_media : ''}} </b> a été transmis <br> au sécrétariat général du gouvernement
      @elseif ($verifaction == "Votre média a été enregistré au secrétariat général du gouvernement")
          <?php $message =  get_message_notification_promoteur("Votre média a été enregistré au secrétariat général du gouvernement") ?>
          {{ $message }} <b> {{ $media ?  $media->nom_media : ''}} </b> a été enrégistré et publié
      @elseif ($verifaction == "Votre rendez-vous pris pour le")
          <?php $message =  get_message_notification_promoteur("Votre rendez-vous pris pour le"); ?>
          {{ $message }} <b> {{$media ?  $media->nom_media : ''}} </b> a été rejeté
      @elseif ($verifaction == "a été confirmer")
          <?php $message =  get_message_notification_promoteur("a été confirmer"); ?>
          {{ $message }} <b> {{ $media ?  $media->nom_media : '' }} </b> a été confirmé
      @elseif ($verifaction == "Votre paiement a bien été effectué")
          <?php $message =  get_message_notification_promoteur("Votre paiement a bien été effectué"); ?>
          {{ $message }} <b> {{$media ?  $media->nom_media : ''}} </b> a été enrégistré
      @elseif ($verifaction == "Votre importation est en cours de verification")
          <?php $message =  get_message_notification_promoteur("Votre importation est en cours de verification"); ?>
          {{ $message }} <b> {{$media ?  $media->nom_media : ''}} </b> <br> Est en cours de verification
      @elseif ($verifaction == "Votre agréement a été signée")
          <?php $message =  get_message_notification_promoteur("Votre agréement a été signée"); ?>
          {{ $message }} <b> {{$media->nom_media}} </b> est maintenant disponible
      @else
      <?php $message =  get_message_notification_promoteur(0) ?>
          {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b>
      @endif
    </p>
    <p class="text-sm text-muted">
      {{-- <i class="far fa-clock mr-1"></i> --}}
      <?php $datetime1 = new DateTime($item->created_at);
      $datetime2 = new DateTime(date("Y-m-d H:i:s"));
      $interval = $datetime1->diff($datetime2);
      $interval->format('%i minutes');?></p>
    <!-- Message End -->
  </a>
  <div class="dropdown-divider my-0"></div>
  @endforeach

  @elseif(auth()->user()->role->nom === "DAF")

  @foreach ($notification as $item)
  <a href="/previewDAF/{{$item->id_notification}}" class="dropdown-item pt-3">
      <?php $sender = get_contenus_paiement_promoteur($item->id_medias) ?>
          <p class="text-md mb-0">
          <b>{{$sender->user->nom." ".$sender->user->prenom}}</b>,
          <span>{{get_contenus_paiement_promoteur()}}</span>
          <b>{{$sender->nom_media}}</b>
          </p>
          <p class="text-xs text-muted">
              {{-- <i class="far fa-clock mr-1"></i> --}}
          <?php $datetime1 = new DateTime($item->created_at);
          $datetime2 = new DateTime(date("Y-m-d H:i:s"));
          $interval = $datetime1->diff($datetime2);
          $interval->format('%i minutes');?>
          </p>
  </a>
  <div class="dropdown-divider my-0"></div>
  @endforeach

  @elseif(auth()->user()->role->nom === "Commission")

  @foreach ($notification as $item)
  <?php $verifaction = filtre_contenu($item->contenu);  ?>
  @if ($verifaction == "L'avis consultatif des documents")
  <a href="/previewCommission/{{$item->id_notification}}" class="dropdown-item">
      <!-- Message Start -->
      <?php $sender = get_contenus_rejet_recu_document_hac($item->id_medias) ?>
            <p class="text-md mb-0">
            <span>{{get_contenus_rejet_recu_document_hac()}}</span>
            <b>{{$sender->nom_media}}</b>
            </p>
            <p class="text-xs text-muted">
                {{-- <i class="far fa-clock mr-1"></i> --}}
            <?php $datetime1 = new DateTime($item->created_at);
            $datetime2 = new DateTime(date("Y-m-d H:i:s"));
            $interval = $datetime1->diff($datetime2);
            $interval->format('%i minutes');?>
            </p>
      <!-- Message End -->
    </a>
  @else
  <a href="/previewCommission/{{$item->id_notification}}" class="dropdown-item">
      <!-- Message Start -->
      <?php $sender = get_contenus_soumission($item->id_medias) ?>
            <p class="text-md mb-0">
            <b>{{$sender->user->nom." ".$sender->user->prenom}}</b>,
            <span>{{get_contenus_soumission()}}</span>
            <b>{{$sender->nom_media}}</b>
            </p>
            <p class="text-xs text-muted">
                {{-- <i class="far fa-clock mr-1"></i> --}}
            <?php $datetime1 = new DateTime($item->created_at);
            $datetime2 = new DateTime(date("Y-m-d H:i:s"));
            $interval = $datetime1->diff($datetime2);
            $interval->format('%i minutes');?>
            </p>
      <!-- Message End -->
    </a>
  @endif

  <div class="dropdown-divider my-0"></div>
  @endforeach

  @elseif(auth()->user()->role->nom === "HAC")

  @foreach ($notification as $item)
  <a href="/previewHAC/{{$item->id_notification}}" class="dropdown-item">
    <!-- Message Start -->
    <?php $sender = get_contenus_rapport_validation_hac($item->id_medias) ?>
          <p class="text-md mb-0">
          <span>{{get_contenus_rapport_validation_hac()}}</span>
          <b>{{$sender->nom_media}}</b>
          </p>
          <p class="text-xs text-muted">
              {{-- <i class="far fa-clock mr-1"></i> --}}
          <?php $datetime1 = new DateTime($item->created_at);
          $datetime2 = new DateTime(date("Y-m-d H:i:s"));
          $interval = $datetime1->diff($datetime2);
          $interval->format('%i minutes');?>
          </p>
    <!-- Message End -->
  </a>
  <div class="dropdown-divider my-0"></div>
  @endforeach

  @elseif(auth()->user()->role->nom === "Direction")
  @foreach ($notification as $item)
  <?php $verifaction = filtre_contenu($item->contenu);    ?>
  @if ($verifaction == "Le média transmis au Secrétariat Général du Gouvernement a été enregistré avec succès")
  <a href="/previewDirection/{{$item->id_notification}}" class="dropdown-item">
      <!-- Message Start -->
      <?php $sender = get_contenus_enregistrement_direction($item->id_medias) ?>
            <p class="text-md mb-0">
            <span>{{get_contenus_enregistrement_direction()}}</span>
            <b>{{$sender->nom_media}}</b> a été enrégistré et publié
            </p>
            <p class="text-xs text-muted">
              {{-- <i class="far fa-clock mr-1"></i> --}}
              <?php $datetime1 = new DateTime($item->created_at);
            $datetime2 = new DateTime(date("Y-m-d H:i:s"));
            $interval = $datetime1->diff($datetime2);
            $interval->format('%i minutes');?>
            </p>
      <!-- Message End -->
    </a>
  @elseif($verifaction == "a pris un rendez-vous pour la convention d'etablissement du média : ")
  <a href="/previewRDV/{{$item->id_notification}}" class="dropdown-item">
      <!-- Message Start -->
      <?php $sender = get_contenus_prise_rdv_promoteur_direction($item->id_medias);?>
            <p class="text-md mb-0">
            <b>{{$sender->user->nom." ".$sender->user->prenom}}</b>,
            <span>{{get_contenus_prise_rdv_promoteur_direction()}}</span>
            <b>{{$sender->nom_media}}</b>
            </p>
            <p class="text-xs text-muted">
              {{-- <i class="far fa-clock mr-1"></i> --}}
            <?php $datetime1 = new DateTime($item->created_at);
            $datetime2 = new DateTime(date("Y-m-d H:i:s"));
            $interval = $datetime1->diff($datetime2);
            $interval->format('%i minutes');?>
            </p>
      <!-- Message End -->
    </a>
  @else
  <a href="/previewDirection/{{$item->id_notification}}" class="dropdown-item">
      <!-- Message Start -->
      <?php $sender = get_contenus_importation_promoteur_direction($item->id_medias) ?>
            <p class="text-md mb-0">
            <b>{{$sender->user->nom." ".$sender->user->prenom}}</b>,
            <span>{{get_contenus_importation_promoteur_direction()}}</span>
            <b>{{$sender->nom_media}}</b>
            </p>
            <p class="text-xs text-muted">
              {{-- <i class="far fa-clock mr-1"></i> --}}
            <?php $datetime1 = new DateTime($item->created_at);
            $datetime2 = new DateTime(date("Y-m-d H:i:s"));
            $interval = $datetime1->diff($datetime2);
            $interval->format('%i minutes');?>
            </p>
      <!-- Message End -->
    </a>
  @endif

  <div class="dropdown-divider my-0"></div>
  @endforeach

  @elseif(auth()->user()->role->nom === "SGG")

  @foreach ($notification as $item)
  <a href="/previewSGG/{{$item->id_notification}}" class="dropdown-item">
    <!-- Message Start -->
    <?php $sender = get_contenus_transmission_promoteur($item->id_medias) ?>
          <p class="text-md mb-0">
          <span>{{get_contenus_transmission_promoteur()}}</span>
          <b>{{$sender->nom_media}}</b>
          </p>
          <p class="text-xs text-muted">
              {{-- <i class="far fa-clock mr-1"></i> --}}
          <?php $datetime1 = new DateTime($item->created_at);
          $datetime2 = new DateTime(date("Y-m-d H:i:s"));
          $interval = $datetime1->diff($datetime2);
          $interval->format('%i minutes');?>
          </p>
    <!-- Message End -->
  </a>
  <div class="dropdown-divider my-0"></div>
  @endforeach

  @elseif(auth()->user()->role->nom === "ADMIN")

  @foreach ($notification as $item)
    <a href="/previewADMIN/{{$item->id_notification}}" class="dropdown-item">
      <!-- Message Start -->
      <div class="media">
        <div class="media-body">
          <b class="dropdown-item-title">
            {{$item->objet}}
          </b>
          <p class="text-sm"> {{$item->contenu}} </p>
          <p class="text-sm text-muted">
            {{-- <i class="far fa-clock mr-1"></i> --}}
            <?php $datetime1 = new DateTime($item->created_at);
            $datetime2 = new DateTime(date("Y-m-d H:i:s"));
            $interval = $datetime1->diff($datetime2);
            $interval->format('%i minutes');?></p>
        </div>
      </div>
      <!-- Message End -->
    </a>
    <div class="dropdown-divider my-0"></div>
  @endforeach

  @endif