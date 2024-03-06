@extends('layouts.default')
@section('page')
Paiement cahier de charge
@endsection

@section('titre-page')
{{ $media->nom_media }}
@endsection

@section('content')
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 g-3 justify-content-center">
    <div class="col">
        <div class="card shadow">
            <div class="img-responsive text-center">

                <img src="{{asset('/logos/'.$media->logo)}}" height="100" alt="LOGO">
            </div>
            <div class="card-body">
                <h3 class="my-3 text-uppercase">{{ $media->nom_media }}
                    <sup class="text-muted fs-5 text-end">
                        <small class="text-muted">
                            {{ $interval->format('%R%a jour(s)') }}
                        </small>
                    </sup>
                </h3>
                <p class="card-text">
                    Cher/Chère promoteur-trice votre média a été ajouté avec succès <br>
                    Vous avez 48h pour effectuer le paiement du cahier des charges. <br>
                    Le montant du cahier des charges est de <strong>{{ formatGNF($paiement->montant) }} GNF</strong>
                </p>
            </div>

            <div>
                <div id="mode-paiement" class="row justify-content-center">
                    <div class="col-md-12">
                        <h5 style="text-align: center">Selectionner le mode de paiement <span v-text="message"></span></h5>
                    </div>
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <a href="#" id="paiementOrange">
                                    <img src="{{asset('assets/dist/img/om.png')}}" height="100">
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <a id="paiementMoMo"  href="#"> <img alt="MOMO" src="{{asset('assets/dist/img/momo.png')}}" height="100"> </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <a href="#" id="paiementRecu"> <img src="{{asset('assets/dist/img/mastercard.png')}}" height="100"> </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body">
                                <a href=""> <img src="{{asset('assets/dist/img/mastercard.png')}}" height="100"> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPaiement">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Paiement cahier de charges<i class="mdi mdi-book-edit"></i></h4>
          <button type="button" data-bs-dismiss="modal" class="btn btn-close btn-danger">x</button>
        </div>
        <div class="modal-body">
            <form id="formPaiement" enctype="multipart/form-data" method="post" action="{{ route('paiement_cahier_charge', ['id' => $media->id_media]) }}">
                @csrf
                <input id="mode" type="hidden" name="mode" class="form-control">

                <div class="form-group" id="divNumero">
                    <label id="labelNumero" for="numero">Numéro Mobile Money</label>
                    <input type="tel" class="form-control" minlength="9" maxlength="12" id="numero" placeholder="Numéro" name="numero">
                </div>

                <div class="form-group" id="divMontant">
                  <label for="montant">Montant (GNF)</label>
                  <input type="text" class="form-control rounded-end" value="{{ $paiement->montant }} GNF" id="montant">
                </div>

                <div class="form-group" id="divRecu">
                    <div class="custom-file">
                        <label class="custom-file-label" for="recu">Importer le reçu de paiement</label>
                        <input class="custom-file-input" type="file" accept=".pdf,.png,.jpg" placeholder="Reçu de paiement" name="recu" id="recu">
                    </div>
                </div>
            </form>

            <div class="row justify-content-center">
                <button class="btn btn-primary mr-1" id="confirmPaiement">Payer</button>
                <button class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
      </div>
    </div>
</div>

<script src="{{asset('js/paiement_cahier_charge.js')}} "></script>
@endsection

