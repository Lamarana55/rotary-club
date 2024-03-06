@extends('layouts.default')
@section('page')
Détails Médias
@endsection

@section('titre-page')
{{ $media->nom_media }}
@endsection

@section('content')
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 g-3 justify-content-center">
    <div class="col">
        <div class="card shadow">
            <div class="img-responsive text-center">
                <img src="" class="w-75 rounded" height="100%" alt="LOGO">
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
                    Le montant du cahier des charges est de <strong>deux millions de francs guinéens (2.000.000 GNF)</strong>
                </p>        
            </div>
            <div class="text-end my-3 px-4">
                <div id="mode-paiement" class="row justify-content-center">
                    <h5>Selectionner le mode de paiement <span v-text="message"></span></h5>
                    
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#paiement-orange"> 
                                    <img src="{{asset('assets/dist/img/om.png')}}" height="100"> 
                                </a>
                            </div>
                        </div> 
                    </div>

                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <a data-bs-toggle="modal" data-bs-target="#paiement-momo"  href="#"> <img alt="MOMO" src="{{asset('assets/dist/img/momo.png')}}" height="100"> </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <a href=""> <img src="{{asset('assets/dist/img/mastercard.png')}}" height="100"> </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
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

<div class="modal fade" id="paiement-orange">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Paiement par Orange Money<i class="mdi mdi-book-edit"></i></h4>
          <button type="button" data-bs-dismiss="modal" class="btn btn-close">x</button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{ route('paiement_cahier_charge', ['id' => $media->id_media]) }}">
                @csrf
                <input type="text" name="mode" class="form-control" value="orange">
                <div class="form-floating mb-3">
                    <label for="floatingInput">Numéros Orange Money</label>
                    <input type="tel" class="form-control" minlength="9" maxlength="12" id="floatingInput" placeholder="Numéro orange money" value="" name="numero" required> 
                </div>
                <div>
                  <label for="affiche">Montant (GNF)</label>
                  <input type="text" class="form-control rounded-end" value="2.000.000 GNF" id="affiche" readonly>
                </div>
                
                <div class=" my-3">
                  <input type="submit" class="form-control bg-success text-white fw-bold" id="floatingInput" placeholder=name@example.com" required>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="paiement-momo">
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">
            <div class="modal-header">
            <h4 id="notfound_title">Paiement Mobile Money<i class="mdi mdi-book-edit"></i></h4>
          
            <button type="button" data-bs-dismiss="modal" class="btn btn-close">x</button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{ route('paiement_cahier_charge', ['id' => $media->id_media]) }}">
                @csrf
                <input type="text" name="mode" class="form-control" value="momo">
                
                <div class="form-floating mb-3">
                    <label for="floatingInput">Numéro Mobile Money</label>
                    <input type="tel" class="form-control" minlength="9" maxlength="12" id="floatingInput" placeholder="Numéro orange money" value="" name="numero" required> 
                </div>
                <div>
                  <label for="affiche">Montant (GNF)</label>
                  <input type="text" class="form-control rounded-end" value="2.000.000 GNF" id="affiche" readonly>
                </div>
                
                <div class=" my-3">
                  <input type="submit" class="form-control bg-success text-white fw-bold" id="floatingInput" placeholder=name@example.com" required>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="paiement-recu">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Paiement par Reçu<i class="mdi mdi-book-edit"></i></h4>
          <button type="button" data-bs-dismiss="modal" class="btn btn-close"></button>
        </div>
        <div class="modal-body">
          
        </div>
      </div>
    </div>
</div>
@endsection

