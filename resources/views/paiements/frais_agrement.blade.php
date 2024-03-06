@extends('layouts.default')
@section('page')
{{ $titrePage}}
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $titrePage}}</h3>
                <div class="card-tools">
                    <form>
                        <div class="input-group mb-3">
                            <input name="nom" type="text" class="form-control" placeholder="Nom du média">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-dark">
                        <tr class="text-center">
                            <th style="width: 10px">#</th>
                            <th>Média</th>
                            <th style="width: 300px">Email</th>
                            <th style="width: 150px">Téléphone</th>
                            <th style="width: 300px">Type</th>
                            <th style="width: 180px">Montant</th>
                            <th style="width: 80px">Reçu</th>
                            @if ($page == 'en_attente')
                                <th style="width: 100px">Action.s/th>
                            @endif
                        </tr>
                    </thead>

                    <tbody id="listePaiements">
                    @foreach ($paiements as $paiement)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $paiement->media->nom_media }}</td>
                            <td>{{ $paiement->media->email }}</td>
                            <td>{{ $paiement->media->telephone }}</td>
                            <td>{{ $paiement->media->type_media->libelle }}</td>
                            <td style="text-align: right">{{ formatGNF($paiement->montant) }}</td>
                            <td style="text-align: center"><a class="" href="{{ $paiement->recu }}"><i class="fa fa-download" aria-hidden="true"></i>
                            </a></td>
                            @if ($page == 'en_attente')
                            <td style="width: 200px">
                                <div class="row justify-content-center">
                                    <button class="btn btn-primary mr-1 accepter" id="valider-{{$paiement->id_paiement}}">Valider</button>
                                    <button class="btn btn-danger rejeter" id="rejeter-{{$paiement->id_paiement}}">Rejeter</button>
                                </div>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $paiements->links()}}
            </div>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalValidationFrais">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Validation des frais d'agrément</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="messageValidation"></p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-bs-dismiss="modal">Fermer</button>
          <button type="button" class="btn btn-primary" id="confirmValidation"></button>
        </div>
      </div>
    </div>
</div>


<script src="{{asset('js/paiement_frais_agrement.js')}} "></script>
@endsection

