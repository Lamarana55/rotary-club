<div class="time-label">
    <span class="bg-{{delaisUilise2($traking->date_valide_cahier??null,$traking->date_achat_cahier??null,'paiement de cahier des charges') >= 0 ?'success':'danger'}}"> Achat Cahier de charge (DAF) :
        {{delaisUilise($traking->date_valide_cahier??null,$traking->date_achat_cahier??null,'paiement de cahier des charges')}}
    </span>
</div>
<div>
    <div class="timeline-item">
        <div class="card card-default">
            <div class="card-header">
            <h3 class="card-title">Paiement de cahier des charges</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
                {{-- <span class="time"><i class="fas fa-clock"></i> </span> --}}
            </div>
            </div>
            <div class="card-body">
                @if(!$cahierChargePayer)
                <div class="callout callout-info">
                    <h5>
                        <p>
                        Cher/Chère promoteur.trice votre média a été ajouté avec succès.
                        <p>Vous avez 48h pour effectuer le paiement du cahier des charges qui est de
                            <span style="font-weight: bold;" class="montant">
                                {{formatGNF($montant->montant)}}
                            </span></p>
                        </p>

                    </h5>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-12">
                        <button type="button" class="info-box" data-toggle="modal" data-target="#staticBackdrop">
                            <span class="info-box-icon">
                                <img src="{{asset('assets/dist/img/om.png')}}">
                            </span>
                            <div class="info-box-content mt-3">
                                <span class="info-box-text">Orange Money </span>
                            </div>
                        </button>
                    </div>

                    <div class="col-md-4 col-sm-4 col-12">
                        <button type="button" class="info-box" data-toggle="modal" data-target="#staticBackdropMomo">
                            <span class="info-box-icon">
                                <img alt="MOMO" src="{{asset('assets/dist/img/momo.png')}}">
                            </span>
                            <div class="info-box-content mt-3">
                                <span class="info-box-text">Mobile Money</span>
                            </div>
                        </button>
                    </div>

                    <div class="col-md-4 col-sm-4 col-12">
                        <button type="button" class="info-box" data-toggle="modal"
                            data-target="#showModalFormPaiementCahierChargeRecu">
                            <span class="info-box-icon">
                                <img src="{{asset('assets/dist/img/mastercard.png')}}">
                            </span>
                            <div class="info-box-content mt-3">
                                <span class="info-box-text">Paiement Bancaire</span>
                            </div>
                        </button>
                    </div>
                </div>
                @else
                    @if($cahierChargePayer->is_valided === null)
                        <p class="text-center font-weight-bold text-info">Votre paiement est en cours de vérification à la division des affaires financières du Ministère de l’Information et de la Communication</p>
                    @else
                    @if($cahierChargePayer->is_valided == true)
                    <p class="text-center font-weight-bold text-info">Votre paiement a été validé</p>
                    <p class="text-center">
                        <a target="_blank" href="{{asset($cahierChargePayer->recu_genere)}}" class="btn btn-primary btn-md mb-4 text-center">
                            Télécharger le reçu
                        </a>
                        @if($typeDoc)
                        <a target="_blank" class="btn btn-primary btn-md mb-4 text-center" href="{{ asset($typeDoc->nom)}}">
                            Télécharger votre cahier des charges
                        </a>
                        @else
                            <h5 class="text-info mb-4 text-center">Votre cahier de charge n'est pas parametrer pour l'instant!</h5>
                        @endif
                    </p>
                    @else
                        @if ($cahierChargePayer->is_valided==false)
                            <p class="text-info text-center font-weight-bold text-danger">
                                Votre paiement a été rejeté pour motif suivant : {{$cahierChargePayer->commentaire_reject}}
                                <br>Veuillez consulter votre boite mail pour plus de détails.
                            </p>
                        @endif
                        <div class="callout callout-info">
                            <h5>
                                <p>Vous avez 48h pour effectuer le paiement du cahier des charges qui est de  <span style="font-weight: bold;" class="montant">{{formatGNF($montant->montant)}}</span></p>
                            </h5>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-12">
                                <button type="button" class="info-box" value="{{ $media->id }}, Orange Money, {{$CodeOM->code}}" data-toggle="modal" data-target="#staticBackdrop">
                                    <span class="info-box-icon">
                                        <img src="{{asset('assets/dist/img/om.png')}}">
                                    </span>
                                    <div class="info-box-content mt-3">
                                        <span class="info-box-text">Orange Money</span>
                                    </div>
                                </button>
                            </div>

                            <div class="col-md-4 col-sm-4 col-12">
                                <button type="button" class="info-box" value="{{ $media->id }}, Mobile Money, {{$CodeMOMO->code}}" data-toggle="modal" data-target="#staticBackdrop">
                                    <span class="info-box-icon">
                                        <img alt="MOMO" src="{{asset('assets/dist/img/momo.png')}}">
                                    </span>
                                    <div class="info-box-content mt-3">
                                        <span class="info-box-text">Mobile Money</span>
                                    </div>
                                </button>
                            </div>

                            <div class="col-md-4 col-sm-4 col-12">
                                <button type="button" class="info-box" data-toggle="modal"
                                    data-target="#showModalFormPaiementCahierChargeRecu">
                                    <span class="info-box-icon">
                                        <img src="{{asset('assets/dist/img/mastercard.png')}}">
                                    </span>
                                    <div class="info-box-content mt-3">
                                        <span class="info-box-text">Paiement Bancaire</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                @endif
            @endif
        </div>
    </div>
</div>
