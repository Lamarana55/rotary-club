<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Paiements</h3>
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
                            <th>Mode</th>
                            <th>Montant</th>
                            <th>Numéro</th>
                            <th>Reçu</th>
                            @if ($page == 'accepte')
                                <th style="width: 100px">Reçu généré</th>
                            @endif
                            @if ($page == 'nouveaux' && auth()->check() && auth()->user()->role->nom == 'DAF')
                                <th style="width: 100px">Action.s</th>
                            @endif

                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($paiements as $paiement)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $paiement->media->nom_media }}</td>
                            <td>{{ $paiement->mode }}</td>
                            <td>{{ $paiement->montant }}</td>
                            <td>{{ $paiement->numero }}</td>
                            <td>
                                @if ($paiement->mode == 'recu')
                                <a class="btn btn-primary btnAction" href="{{ $paiement->recu }}"><i class="fa fa-download" aria-hidden="true"></i>
                                </a>
                                @endif
                            </td>
                            @if ($page == 'accepte')
                                <td>
                                    <a class="" target="_blank" href="{{ $paiement->recu_genere }}" target="_blank"><i class="fa fa-download" aria-hidden="true"></i>
                                    </a>
                                </td>
                            @endif
                            @if ($page == 'nouveaux' && auth()->check() && auth()->user()->role->nom == 'DAF')
                            <td style="width: 200px">
                                <div class="row justify-content-center">
                                    @if($paiement_cahier_charge->valide === null)
                                    <button class="btn btn-primary mr-1 valider" id="valide-{{$paiement->id_paiement}}">Valider</button>
                                    <button class="btn btn-danger rejeter" id="rejeter-{{$paiement->id_paiement}}">Rejeter</button>
                                    @endif
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

<div class="modal fade" id="modalConfirmation">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Validation paiement cahier de charges</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="messageValidation"></p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-bs-dismiss="modal">Fermer</button>
          <button type="button" class="btn btn-success" id="confirmValidation"></button>
        </div>
      </div>
    </div>
</div>


<script src="{{asset('js/liste_paiements_cahier_charge.js')}} "></script>
