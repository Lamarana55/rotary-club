@extends('/../layouts.default')
@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Notifications</h3>
      <a href='/' class="btn btn-primary  float-right m-)">Retour</a>
      <div class="card-tools">
        {{ $notification->links() }}
      </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="col-3">Objet</th>
                    <th>Descriptions</th>
                    {{-- <th>Status</th> --}}
                    <th>Action.s</th>
                  </tr>
                </thead>
                <tbody>
                @if (auth()->user()->role->nom === "Promoteur")
                    @foreach ($notification as $item)
                  <tr>
                    <td> {{$item->objet}} </td>
                    <td>
                        <?php $media = get_contenus_nom_promoteur($item->id_medias);
                        $verifaction = filtre_contenu($item->contenu); ?>
                  <p class="text-md mb-0">
                    {{-- {{$item->contenu}} --}}
                    @if ($verifaction == "DAF rejete")
                        <?php $message =  get_message_notification_promoteur(1) ?>
                        {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b>
                    @elseif ($verifaction == "comission rejet")
                        <?php $message =  get_message_notification_promoteur("comission rejet") ?>
                        {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b>
                    @elseif ($verifaction == "Transmission a la hac")
                        <?php $message =  get_message_notification_promoteur("Transmission a la hac") ?>
                        {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b> à la HAC
                    @elseif ($verifaction == "Votre dossier technique a été rejeté par la Haute Autorité de Communication (HAC)")
                        <?php $message =  get_message_notification_promoteur("Votre dossier technique a été rejeté par la Haute Autorité de Communication (HAC)") ?>
                        {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b> qui lui a été transmis
                    @elseif ($verifaction == "la HAC est terminée par une validation")
                        <?php $message =  get_message_notification_promoteur("la HAC est terminée par une validation") ?>
                        {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b> qui lui a été transmis
                    @elseif ($verifaction == "Le réçu de paiement que vous aviez importé a été rejeté")
                        <?php $message =  get_message_notification_promoteur("Le réçu de paiement que vous aviez importé a été rejeté") ?>
                        {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b>
                    @elseif ($verifaction == "Votre reçu a été validé")
                        <?php $message =  get_message_notification_promoteur("Votre reçu a été validé") ?>
                        {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b>
                    @elseif ($verifaction == "Votre projet d'agrément a été transmis au Secrétariat Général")
                        <?php $message =  get_message_notification_promoteur("Votre projet d'agrément a été transmis au Secrétariat Général") ?>
                        {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b> a été transmis <br> au sécrétariat général du gouvernement
                    @elseif ($verifaction == "Votre projet d'agrément a été transmis au Secrétariat Général")
                        <?php $message =  get_message_notification_promoteur("Votre projet d'agrément a été transmis au Secrétariat Général") ?>
                        {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b> a été transmis <br> au sécrétariat général du gouvernement
                    @elseif ($verifaction == "Votre média a été enregistré au secrétariat général du gouvernement")
                        <?php $message =  get_message_notification_promoteur("Votre média a été enregistré au secrétariat général du gouvernement") ?>
                        {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b> a été enrégistré et publié
                    @elseif ($verifaction == "Votre rendez-vous pris pour le")
                        <?php $message =  get_message_notification_promoteur("Votre rendez-vous pris pour le"); ?>
                        {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b> a été rejeté
                    @elseif ($verifaction == "a été confirmer")
                        <?php $message =  get_message_notification_promoteur("a été confirmer"); ?>
                        {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b> a été confirmé
                    @elseif ($verifaction == "Votre paiement a bien été effectué")
                        <?php $message =  get_message_notification_promoteur("Votre paiement a bien été effectué"); ?>
                        {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b> a été enrégistré
                    @elseif ($verifaction == "Votre importation est en cours de verification")
                        <?php $message =  get_message_notification_promoteur("Votre importation est en cours de verification"); ?>
                        {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b> <br> Est en cours de verification
                    @elseif ($verifaction == "Votre agréement a été signée")
                        <?php $message =  get_message_notification_promoteur("Votre agréement a été signée"); ?>
                        {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b> est maintenant disponible
                    @else
                    <?php $message =  get_message_notification_promoteur(0) ?>
                        {{ $message }} <b> {{$media ? $media->nom_media : ''}} </b>
                    @endif
                 </p>

                    </td>
                    <td>
                        <a href="{{route('promoteur', $item->id_notification)}}"  class="btn btn-primary rounded-circle"> <i class="fa fa-eye"></i>
                        </a>
                    </td>
                  </tr>
                  @endforeach
                  @elseif(auth()->user()->role->nom === "DAF")
                    @foreach ($notification as $item)
                    <tr>
                        <td> {{$item->objet}} </td>
                        <td>
                            <?php $sender = get_contenus_paiement_promoteur($item->id_medias) ?>
                            <p class="text-md mb-0">
                            {{"Mr/Mme "}} <b>{{$sender->user->nom." ".$sender->user->prenom}}</b>,
                            <span>{{get_contenus_paiement_promoteur()}}</span>
                            <b>{{$sender->nom_media}}</b>
                            </p>
                        </td>
                        <td>
                            <a href="/previewDAF/{{$item->id_notification}}"  class="btn btn-primary rounded-circle"> <i class="fa fa-eye"></i>
                            </a>
                        </td>
                      </tr>
                    @endforeach
                  @elseif(auth()->user()->role->nom === "Commission")
                    @foreach ($notification as $item)
                    <?php $verifaction = filtre_contenu($item->contenu);  ?>
                    @if ($verifaction == "L'avis consultatif des documents")
                    <tr>
                        <td> {{$item->objet}} </td>
                        <td>
                            <?php $sender = get_contenus_rejet_recu_document_hac($item->id_medias) ?>
                            <p class="text-md mb-0">
                            <span>{{get_contenus_rejet_recu_document_hac()}}</span>
                            <b>{{$sender->nom_media}}</b>
                            </p>
                        </td>
                        <td>
                            <a href="/previewCommission/{{$item->id_notification}}"  class="btn btn-primary rounded-circle"> <i class="fa fa-eye"></i>
                            </a>
                        </td>
                      </tr>
                    @else
                    <tr>
                        <td> {{$item->objet}} </td>
                        <td>
                            <?php $sender = get_contenus_soumission($item->id_medias) ?>
                          <p class="text-md mb-0">
                          <b>{{$sender->user->nom." ".$sender->user->prenom}}</b>,
                          <span>{{get_contenus_soumission()}}</span>
                          <b>{{$sender->nom_media}}</b>
                          </p>
                        </td>
                        <td>
                            <a href="/previewCommission/{{$item->id_notification}}"  class="btn btn-primary rounded-circle"> <i class="fa fa-eye"></i>
                            </a>
                        </td>
                      </tr>
                    @endif
                    @endforeach
                  @elseif(auth()->user()->role->nom === "HAC")
                    @foreach ($notification as $item)
                    <tr>
                        <td> {{$item->objet}} </td>
                        <td>
                            <?php $sender = get_contenus_rapport_validation_hac($item->id_medias) ?>
                            <p class="text-md mb-0">
                            <span>{{get_contenus_rapport_validation_hac()}}</span>
                            <b>{{$sender->nom_media}}</b>
                            </p>
                        </td>
                        <td>
                            <a href="/previewHAC/{{$item->id_notification}}"  class="btn btn-primary rounded-circle"> <i class="fa fa-eye"></i>
                            </a>
                        </td>
                      </tr>
                    @endforeach
                  @elseif(auth()->user()->role->nom === "Direction")
                  @foreach ($notification as $item)
                  <?php $verifaction = filtre_contenu($item->contenu);    ?>
                    @if ($verifaction == "Le média transmis au Secrétariat Général du Gouvernement a été enregistré avec succès")
                    {{-- <a href="/previewDirection/{{$item->id_notification}}" class="dropdown-item"> --}}
                        <!-- Message Start -->
                        <tr>
                            <td> {{$item->objet}} </td>
                            <td>
                                <?php $sender = get_contenus_enregistrement_direction($item->id_medias) ?>
                                <p class="text-md mb-0">
                                <span>{{get_contenus_enregistrement_direction()}}</span>
                                <b>{{$sender->nom_media}}</b> a été enrégistré et publié
                                </p>
                            </td>
                            <td>
                                <a href="/previewDirection/{{$item->id_notification}}" class="btn btn-primary rounded-circle"> <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @elseif($verifaction == "a pris un rendez-vous pour la convention d'etablissement du média : ")
                    {{-- <a href="/previewSGG/{{$item->id_notification}}" class="dropdown-item"> --}}
                        <!-- Message Start -->
                        <tr>
                            <td> {{$item->objet}} </td>
                            <td>
                                <?php $sender = get_contenus_prise_rdv_promoteur_direction($item->id_medias);?>
                                <p class="text-md mb-0">
                                <b>{{$sender->user->nom." ".$sender->user->prenom}}</b>,
                                <span>{{get_contenus_prise_rdv_promoteur_direction()}}</span>
                                <b>{{$sender->nom_media}}</b>
                                </p>
                            </td>
                            <td>
                                <a href="/previewRDV/{{$item->id_notification}}" class="btn btn-primary rounded-circle"> <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @else
                    {{-- <a href="/previewDirection/{{$item->id_notification}}" class="dropdown-item"> --}}
                        <!-- Message Start -->
                        <tr>
                            <td> {{$item->objet}} </td>
                            <td>
                                <?php $sender = get_contenus_importation_promoteur_direction($item->id_medias) ?>
                                <p class="text-md mb-0">
                                <b>{{$sender->user->nom." ".$sender->user->prenom}}</b>,
                                <span>{{get_contenus_importation_promoteur_direction()}}</span>
                                <b>{{$sender->nom_media}}</b>
                                </p>
                            </td>
                            <td>
                                <a href="/previewDirection/{{$item->id_notification}}" class="btn btn-primary rounded-circle"> <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endif
                  @endforeach
                  @elseif(auth()->user()->role->nom === "SGG")
                   @foreach ($notification as $item)
                   <tr>
                       <td> {{$item->objet}} </td>
                       <td>
                           <?php $sender = get_contenus_rapport_validation_hac($item->id_medias) ?>
                           <p class="text-md mb-0">
                           <span>{{get_contenus_rapport_validation_hac()}}</span>
                           <b>{{$sender->nom_media}}</b>
                           </p>
                       </td>
                       <td>
                           <a href="/previewSGG/{{$item->id_notification}}"  class="btn btn-primary rounded-circle"> <i class="fa fa-eye"></i>
                           </a>
                       </td>
                     </tr>
                   @endforeach
                  @elseif(auth()->user()->role->nom === "ADMIN")

                  @endif
                    {{-- @if()
                    {{-- @elseif(auth()->user()->role->nom === "Admin") --}}

                        {{-- <td> <a href="{{route('processus',['id'=>$item->id_media])}}" class="btn btn-dark rounded-circle"> <i class="fa fa-eye"></i> </a> </td> --}
                    @elseif (!$item->id_medias)

                        <td> <a href="{{url('/utilisateurs')}}"  class="btn btn-dark rounded-circle"> <i class="fa fa-eye"></i> </a> </td>

                    @elseif(auth()->user()->role->nom === "DAF")

                        <td> <a href="/previewDAF/{{$item->id_notification}}" class="btn btn-dark rounded-circle"> <i class="fa fa-eye"></i> </a> </td>

                    @elseif(auth()->user()->role->nom === "Commission")

                        <td> <a href="/previewCommission/{{$item->id_notification}}" class="btn btn-dark rounded-circle"> <i class="fa fa-eye"></i> </a> </td>

                    @elseif(auth()->user()->role->nom === "HAC")

                        <td> <a href="/previewHAC/{{$item->id_notification}}" class="btn btn-dark rounded-circle"> <i class="fa fa-eye"></i> </a> </td>

                    @elseif(auth()->user()->role->nom === "Direction")

                        <td>
                            <a href="/previewDirection/{{$item->id_notification}}" class="btn btn-dark rounded-circle"> <i class="fa fa-eye"></i> </a>
                        </td>

                    @elseif(auth()->user()->role->nom === "SGG")

                        <td> <a href="/previewSGG/{{$item->id_notification}}" class="btn btn-dark rounded-circle"> <i class="fa fa-eye"></i> </a> </td>

                    @endif --}}
                  {{-- @endforeach --}}
                </tbody>
              </table>
        </div>
    </div>
  </div>
    {{-- <div class="card">
        <div class="card-header mb-2">
            <h1>Notifications</h1>

        </div>
        <div class="mx-2">

            @foreach($notification as $noti)
            @if ($noti->isUpdate === 1)

            <div class="row align-items-center py-2" style="background-color:rgba(100, 148, 237, 0.295);">
                <div class="col-2 col-md-1 text-center" style="margin-right: 15px;">
                    <img class="profile-user-img img-circle" style="width: 50px; height:50px" src="{{ asset('assets/dist/img/armoirie.png') }}" alt="User profile">
                </div>
                <div class="col col-md-9">
                    <p class="card-title d-inline d-md-none">M I C ({{$noti->nomMedia}}) <br> <span class="textMuted"> {{$noti->created_at}} </span></p>
                    <p class="card-title d-none d-md-inline">Ministère de l'information et de la communication ({{$noti->nomMedia}}) <br> <span class="textMuted"> {{$noti->created_at}} </span></p>
                </div>
                <div class="col col-md-1">
                    <button type="button" class="btn btn-dark float-right rounded-circle" data-bs-toggle="modal" data-bs-target="#noti{{$noti->id_notification}}"> <i class="fa fa-eye"></i></button>
                </div>
            </div>
            <hr class="my-2">
            <div class="modal fade" id="noti{{$noti->id_notification}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-bell"></i> Noti-{{$noti->id_notification}}</h5>
                    </div>
                    <div class="modal-body text-center">
                        <p class="fw-5"> {{$noti->contenu}} </p>
                    </div>
                    <div class="modal-footer justify-content-center">
                    <form action="/notification/{{$noti->id_notification}}/lecture" method="post">
                        @method('put')
                        @csrf
                        <input type="submit" class="form-control bg-dark" value="Quitter">
                    </form>
                    </div>
                </div>
                </div>
            </div>
            @else
            <div class="row align-items-center">
                <div class="col-2 col-md-1 text-center" style="margin-right: 15px;">
                    <img class="profile-user-img img-circle" style="width: 50px; height:50px" src="{{ asset('assets/dist/img/armoirie.png') }}" alt="User profile">
                </div>
                <div class="col col-md-9">
                    <p class="card-title d-inline d-md-none">M I C ({{$noti->nomMedia}}) <br> <span class="textMuted"> {{$noti->created_at}} </span></p>
                    <p class="card-title d-none d-md-inline">Ministère de l'information et de la communication ({{$noti->nomMedia}}) <br> <span class="textMuted"> {{$noti->created_at}} </span></p>
                </div>
                <div class="col col-md-1">
                    <button type="button" class="btn btn-dark float-right rounded-circle" data-bs-toggle="modal" data-bs-target="#noti{{$noti->id_notification}}"> <i class="fa fa-eye"></i></button>
                </div>
            </div>
            <hr class="my-2">

            <div class="modal fade" id="noti{{$noti->id_notification}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-bell"></i> Noti-{{$noti->id_notification}}</h5>
                        <button type="button" class="btn btn-sm text-white" data-bs-dismiss="modal"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body text-center">
                        <p class="fw-5"> {{$noti->contenu}} </p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Quitter</button>
                    </div>
                </div>
                </div>
            </div>
            @endif
        @endforeach
        </div>
    </div> --}}
@endsection
