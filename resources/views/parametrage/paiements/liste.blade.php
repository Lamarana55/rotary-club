<div class="row">
    @include('parametrage.paiements.add')
    @include('parametrage.paiements.edit')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h2 class="">Liste des frais</h2>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        @if (hasPermission('créer_montant_paiement'))
                            <a class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#showModelAddMontant">
                                Ajouter un type frais
                            </a>
                        @endif
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card">
                          <div class="card-body">
                            <h5 class="card-title"><strong>Cahier de charge</strong> </h5>
                            <p class="card-text">{{($data_cahier_charge['montant'])? formatGNF($data_cahier_charge['montant']):0}}</p>
                            <a  wire:click='historique("cahier_de_charge")' class="btn btn-primary">Historique</a>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><strong>Frais d'agrément de radio</strong> </h5>
                                <p class="card-text">{{($data_frais_agrement)?formatGNF($data_frais_agrement['montant']):0}}</p>
                                <a wire:click='historiqueAgrement("Radio")' class="btn btn-primary">Historique</a>
                            </div>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><strong>Frais d'agrément de télévision</strong> </h5>
                                <p class="card-text">{{($data_frais_agrement2)?formatGNF($data_frais_agrement2['montant']):0}}</p>
                                <a wire:click='historiqueAgrement("Télévision")' class="btn btn-primary">Historique</a>
                            </div>
                        </div>
                      </div>
                </div>
                @if ($is_affiche_historique)
                    <div class="row">
                        <div class="col-12">
                            <label for="">Historique de: {{ ($type_historique=="cahier_de_charge")?"Cahier de charge":"Frais d'agrément" }}</label>
                            <a wire:click='fermer()' class="btn btn-primary btn-sm float-right mb-1">Fermer</a>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left">Montant</th>
                                <th class="text-left">Type du media</th>
                                <th class="text-left">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse ($historiques as $key=>$user)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td class="text-left">{{ formatGNF($user->montant) }}</td>
                                    <td class="text-left">{{ $user->type_media_id??null }}</td>
                                    <td class="text-left">
                                        {{ $user->updated_at }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="alert alert-info">
                                        <h5><i class="icon fas fa-ban"></i> Information!</h5>
                                        Aucune donnée trouvée par rapport aux éléments de recherche entrés.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <!-- /.card-body -->
            @if ($is_affiche_historique )
             <div class="card-footer clearfix">
                 {{ $historiques->links() }}
            </div>
            @endif

          </div>
    </div>
</div>
  <script>
    window.addEventListener("showSuccessMessage", event=>{
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            toast:true,
            title: event.detail.message || "Opération effectuée avec succès!",
            showConfirmButton: false,
            timer: 5000
            }
        )
    })

    window.addEventListener("showErrorMessage", event=>{
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            toast:true,
            title: event.detail.message || "Opération effectuée avec succès!",
            showConfirmButton: false,
            timer: 5000
            }
        )
    })


    window.addEventListener("closeModal", event=>{
        $("#showModelEditMontant").modal("hide")
    })

  </script>
