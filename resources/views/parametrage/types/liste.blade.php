<div class="row">
    @include('parametrage.types.add')
    @include('parametrage.types.edit')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h2 class="">Liste des types de document</h2>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <a class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#showModelAddTypePaiement">
                            Ajouter un type de document
                        </a>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group col-md-4 float-right">
                            <input type="text" class="form-control" wire:model.debounce.250ms="search" placeholder="Recherche ...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($types as $key=>$user )
                        <tr>
                            <td>{{$key+1}} </td>
                            <td>{{ $user->nom }}</td>
                            <td class="text-right">
                                <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#showModelEditTypePaiement" wire:click="getTypePaiement({{$user->id}})">Modifier</a>&nbsp;
                                <a class="btn btn-sm bg-gradient-danger" wire:click.prevent="confirmDeleteTypePaiement({{$user->id}})"> Supprimer</a>&nbsp;
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
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $types->links() }}
            </div>
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
        $("#showModelEditTypePaiement").modal("hide")
    })

  </script>
