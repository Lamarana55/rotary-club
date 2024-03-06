<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="row g-0">
                <div class="col-md-12">
                    <a href="{{url('/liste-medias')}}" class="btn btn-primary btn-sm m-3 float-right">Retour</a>
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="{{asset($media->logo ? $media->logo : 'logo-google.png')}}" style="border: 1px solid #a4a4a5; border-radius: 10px; height: 120px; width:120px; overflow:hidden;" class="img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-md-8">

                                        <p class="text-center fw-bold text-uppercase fs-2"><strong>{{$media->nom}}</strong> </p>
                                        <div class="row">
                                            <p class="card-text col my-0"><strong>Type de média</strong> <br> <small class="fw-bold">{{$media->type_media}}</small></p>
                                            <p class="card-text col my-0"><strong>Date d'ajout</strong>  <br> <small class="fw-bold">{{$media->created_at}}</small></p>
                                        </div>
                                        <div class="row">
                                            <p class="card-text col my-0"><strong>Téléphone</strong> <br> <small class="fw-bold">{{$media->telephone}}</small></p>
                                            <p class="card-text col my-0"><strong>Email</strong>  <br> <small class="fw-bold">{{$media->email}}</small></p>

                                        </div>
                                        <div class="row">
                                            <p class="card-text col my-0"><strong>Forme juridique</strong> <br> <small class="fw-bold">{{$media->forme_juridique}}</small></p>
                                            <p class="card-text col my-0"><strong>Sigle</strong> <br> <small class="fw-bold">{{$media->sigle}}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <p class="card-text col my-0">
                                    <strong>Localité : </strong> {{$media->commune->nom??null}}
                                </p>
                                <p class="card-text col my-0">
                                    <strong>Description</strong><br>
                                    <span class="fw-bold">
                                        {{strlen($media->description) <= 600 ? $media->description : substr($media->description, 0, 600).' ...'; }} @if(strlen($media->description) >600)
                                        <button type="button" value="{{ $media->id }}" data-toggle="modal" data-target="#exampleModal" class="btn btn-md btn-info editbtn">voir plus</button>@endif
                                    </span>
                                </p>
                            </div>

                            <div>
                                @if (auth()->user()->role->nom =='Commission')
                                    @if($dossier && $dossier->status_commission !='revoir' && $dossier->status_commission !='terminer' && $dossier->status_commission !='en_cours')
                                    <p>Temps restant : <b>{{suivu('soumission des documents technique',traking($media->id)->date_soumis_pro??null)}} </b></p><br>
                                    @if (hasPermission('valider_document'))
                                    <a href="{{ route('etude-document', ['id'=> $cahierChargePayer->media->uuid ]) }}" class="btn btn-primary btn-sm mr-1">
                                        Examiner
                                    </a>
                                    @endif
                                    @endif
                                @endif
                                @if(auth()->user()->role->nom =='HAC')
                                @if($dossier && $dossier->status_hac !='revoir' && $dossier->status_hac !='terminer' && $dossier->status_hac !='en_cours')
                                <p>Temps restant : <b>{{suivu('étude des documents techniques a la commission',traking($media->id)->date_etude_commission??null)}} </b></p><br>
                                @if (hasPermission('valider_document'))
                                    <a href="{{ route('etude-document', ['id'=> $cahierChargePayer->media->uuid ]) }}" class="btn btn-primary btn-sm mr-1">
                                            Examiner
                                        </a>
                                @endif
                                @endif
                                @endif
                                @if ($cahierChargePayer)
                                    @if (hasPermission('valider_paiement_cahier_charge'))
                                        <button @if($cahierChargePayer && $cahierChargePayer->is_valided === null) @else hidden @endif class="btn btn-success mr-1
                                        btn-sm valider"
                                        wire:click="showValideCahierChargeModal({{$cahierChargePayer->id}})">Valider</button>
                                    @endif
                                    @if (hasPermission('rejeter_paiement_cahier_charge'))
                                        <button @if($cahierChargePayer && $cahierChargePayer->is_valided === null) @else hidden @endif class="btn btn-danger
                                        btn-sm"
                                        wire:click='showRejetPaiementCahierChargeModal({{$cahierChargePayer->id}})'>Rejeter</button>&nbsp;
                                    @endif

                                @endif

                                <button @if($fraisAgrement && $fraisAgrement->is_valided === null) @else hidden @endif class="btn btn-success mr-1
                                    btn-sm valider"
                                    wire:click="showModalValideFraisAgrement({{$fraisAgrement && $fraisAgrement->media_id}})">Valider
                                </button>

                                <button @if($fraisAgrement && $fraisAgrement->is_valided === null) @else hidden @endif class="btn btn-danger
                                    btn-sm"
                                    wire:click='showModalRejetPaiementFraisAgrement({{ $fraisAgrement && $fraisAgrement->media_id}})'>Rejeter
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
    @if (auth()->check() && auth()->user()->role->nom == 'DAF' || auth()->check() && auth()->user()->role->nom == 'Direction' || auth()->check() && auth()->user()->role->nom == 'Ministre')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Paiements</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($cahierChargePayer && !$cahierChargePayer->is_valided)
                        <div class="col-md-6">
                            <p>
                                Temps restant : <b>{{suivu('validation du paiement de cahier des charges',traking($media->id)->date_achat_cahier??null)}} </b>
                            </p>
                            <p class="h5"> <strong>Paiement cahier des charges</strong></p>
                            <p class="card-text col my-0">
                                <strong>Montant : </strong>
                                <span class="fw-bold">{{formatGNF($cahierChargePayer->montant)}}</span>
                            </p>

                            <p class="card-text col my-0">
                                <strong>Statut du paiement : </strong>
                                @if($cahierChargePayer->is_valided === null)
                                <span class="badge bg-warning"> Nouveau </span>
                                @elseif($cahierChargePayer->is_valided == true)
                                <span class="badge bg-success"> Paiement validé </span>
                                @elseif($cahierChargePayer->is_valided === false)
                                <span class="badge bg-danger"> Rejeté </span>
                                @endif
                            </p>

                            <p class="card-text col my-0">
                                <strong>Date de paiement : </strong>
                                <span class="fw-bold">{{$cahierChargePayer->created_at->format('d/m/Y') }}</span>
                            </p>

                            <p class="card-text col my-0">
                                <strong>Mode de paiement : </strong>
                                <span class="fw-bold">{{$cahierChargePayer->mode}}</span>
                            </p>

                            <p class="card-text col my-0">
                                <strong>Numéro de paiement : </strong>
                                <span class="fw-bold">{{ phone($cahierChargePayer->telephone, ["GN"]) }}</span>
                            </p>

                            <p class="card-text col my-0">
                                <strong>Code marchand : </strong>
                                <span class="fw-bold">{{$cahierChargePayer->code_marchant}}</span>
                            </p>

                            <p class="card-text col my-0">
                                <strong>Montant : </strong>
                                <span class="fw-bold">{{formatGNF($cahierChargePayer->montant)}}</span>
                            </p>

                            @if($cahierChargePayer && $cahierChargePayer->is_valided)
                            <p class="card-text col my-0">
                                <strong>Reçu : </strong>
                                <a target="_blank" rel="noopener noreferrer" href="{{ asset($cahierChargePayer->recu_genere)}}">
                                    Télécharger
                                </a>
                            </p>
                            @endif

                        </div>
                        @endif
                        @if($fraisAgrement && !$fraisAgrement->is_valided)
                        <div class="col-md-6">
                            <p>
                                Temps restant : <b>{{suivu('paiement de frais d\'agrément',traking($media->id)->date_paiement_agrement??null)}} </b>
                            </p>
                            <p class="h5" > <strong>Paiement frais d'agrément</strong></p>
                            <p class="card-text col my-0">
                                <strong>Statut du paiement : </strong>
                                {{-- <span class="fw-bold">{{formatGNF($fraisAgrement->montant)}}</span> --}}
                                @if($fraisAgrement->is_valided === null)
                                <span class="badge bg-warning"> Nouveau </span>
                                @elseif($fraisAgrement->is_valided == true)
                                <span class="badge bg-success"> Paiement validé </span>
                                @elseif($fraisAgrement->is_valided === false)
                                <span class="badge bg-danger"> Rejeté </span>
                                @endif
                            </p>
                            <p class="card-text col my-0">
                                <strong>Date de paiement : </strong>
                                <span class="fw-bold">{{$fraisAgrement->created_at->format('d/m/Y') }}</span>
                            </p>

                            <p class="card-text col my-0">
                                <strong>Montant : </strong>
                                <span class="fw-bold">{{formatGNF($fraisAgrement->montant)}}</span>
                            </p>

                            @if($fraisAgrement->valide)
                            <p class="card-text col my-0">
                                <strong>Reçu : </strong>
                                <a target="_blank" rel="noopener noreferrer" href="{{ asset($fraisAgrement->recu)}}">
                                    Télécharger
                                </a>
                            </p>
                            @endif
                        </div>
                        @endif
                        @if($cahierChargePayer && $cahierChargePayer->is_valided)
                        <div class="col-md-6">
                            <p class="h5"> <strong>Paiement cahier des charges</strong></p>
                            <p class="card-text col my-0">
                                <strong>Date de paiement : </strong>
                                <span class="fw-bold">{{$cahierChargePayer->created_at->format('d/m/Y') }}</span>
                            </p>

                            <p class="card-text col my-0">
                                <strong>Mode de paiement : </strong>
                                <span class="fw-bold">{{$cahierChargePayer->mode}}</span>
                            </p>

                            <p class="card-text col my-0">
                                <strong>Numéro de paiement : </strong>
                                <span class="fw-bold">{{ phone($cahierChargePayer->telephone, ["GN"]) }}</span>
                            </p>

                            <p class="card-text col my-0">
                                <strong>Code marchand : </strong>
                                <span class="fw-bold">{{$cahierChargePayer->code_marchant}}</span>
                            </p>

                            <p class="card-text col my-0">
                                <strong>Montant : </strong>
                                <span class="fw-bold">{{formatGNF($cahierChargePayer->montant)}}</span>
                            </p>

                            @if($cahierChargePayer && $cahierChargePayer->is_valided)
                            <p class="card-text col my-0">
                                <strong>Reçu : </strong>
                                <a target="_blank" rel="noopener noreferrer" href="{{ asset($cahierChargePayer->recu_genere)}}">
                                    Télécharger
                                </a>
                            </p>
                            @endif

                        </div>
                        @endif

                        @if($fraisAgrement && $fraisAgrement->is_valided)
                        <div class="col-md-6">
                            <p class="h5" > <strong>Paiement frais d'agrément</strong></p>
                            <p class="card-text col my-0">
                                <strong>Date de paiement : </strong>
                                <span class="fw-bold">{{$fraisAgrement->created_at->format('d/m/Y') }}</span>
                            </p>

                            <p class="card-text col my-0">
                                <strong>Montant : </strong>
                                <span class="fw-bold">{{formatGNF($fraisAgrement->montant)}}</span>
                            </p>

                            @if($fraisAgrement->valide)
                            <p class="card-text col my-0">
                                <strong>Reçu : </strong>
                                <a target="_blank" rel="noopener noreferrer" href="{{ asset($fraisAgrement->recu)}}">
                                    Télécharger
                                </a>
                            </p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="showValideCahierChargeModal" tabindex="-1" role="dialog"
        aria-labelledby="showValideCahierChargeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Validation du paiement du cahier des charges</h4>
                </div>
                <div class="modal-body">
                    <p id="messageValidation">Confirmez-vous le paiement du cahier des charges du média dd
                        <strong>{{$cahierChargePayer ? $cahierChargePayer->media->nom :''}}</strong> ?</p>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-danger" wire:click='showValideCahierChargeClose'>NON</button>
                    <button type="button" class="btn btn-success"
                        wire:click='validationPaiementCahierCharger({{$cahierChargePayer ? $cahierChargePayer->id :''}})'>OUI</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Rejet-->
    <div class="modal fade" id="showRejetPaiementCahierChargeModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="message-titre">Rejet paiement cahier des charges </h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="motif">Motif du rejet :</label><br>
                            @foreach($options as $key=>$option)
                            <input type="radio" name="commentaire" wire:model='commentaire' value="{{$option}}"
                                id="option{{$key}}" class="gender-radio m-1 motif"> <label
                                style="font-weight: normal !important;" for="option{{$key}}"> {{$option}}</label> <br>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-success"
                        wire:click='showRejetPaiementCahierChargeCloseModal'>NON</button>
                    <button type="button" class="btn btn-danger"
                        wire:click='rejetPaiementCahierCharger({{$cahierChargePayer ? $cahierChargePayer->id :''}})'>OUI</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showModalValidationFraisAgrement" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Validation des frais d'agrément</h4>
            </div>
            <div class="modal-body">
              <p>Confirmez-vous la validation du paiement des frais d'agrément du média <strong>{{$fraisAgrement ? $fraisAgrement->media->nom :'' }} </strong> </p>
            </div>
            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">NON</button>
              <button type="button" class="btn btn-success" wire:click="validationRejetPaiementFraisAgrement('{{$fraisAgrement ? $fraisAgrement->id :''}}',{{true}})" data-bs-dismiss="modal">OUI</button>
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="showModalRejetFraisAgrement" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Le réjet des frais d'agrément</h4>
            </div>
            <div class="modal-body">
                <p>
                    Confirmez-vous le rejet du paiement des frais d'agrément du média
                    <strong>{{$fraisAgrement ? $fraisAgrement->media->nom :'' }} </strong>
                </p>
            </div>
            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-success" data-bs-dismiss="modal">NON</button>
              <button type="button" class="btn btn-danger" wire:click="validationRejetPaiementFraisAgrement('{{$fraisAgrement ? $fraisAgrement->id :null}}',{{0}})" data-bs-dismiss="modal">OUI</button>
            </div>
          </div>
        </div>
    </div>
    @endif
