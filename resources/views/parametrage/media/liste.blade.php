<div class="">
    @include('parametrage.media.add')
    @include('parametrage.media.edit')
    <div class="row mb-2">
        <div class="col-sm-6">
          {{-- <h1 class="m-0">Types media</h1> --}}
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}} ">Accueil</a></li>
            <li class="breadcrumb-item active">Types media</li>
          </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <h2 class="">Liste des types de média</h2>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if (hasPermission('créer_type_media') )
                                <a class="btn btn-primary text-white mb-3" data-bs-toggle="modal" data-bs-target="#showModelAddTypeMedia">
                                    Ajouter un type de média
                                </a>
                            @endif
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
                            <th>Description</th>
                            <th class="text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse ($typeMedia as $key=>$user )
                            <tr>
                                <td>{{$key+1}} </td>
                                <td>{{ $user->nom }}</td>
                                <td>{{ $user->description }}</td>
                                <td class="text-right">
                                    @if (hasPermission('modifier_type_media') )
                                        <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#showModelEditTypeMedia" wire:click="getTypeMedia({{$user->id}})">
                                        Modifier</a>&nbsp;
                                    @endif
                                    @if (hasPermission('supprimer_type_media') )
                                        <a class="btn btn-sm bg-gradient-danger" wire:click.prevent="confirmDeleteTypeMedia({{$user->id}})"> Supprimer</a>&nbsp;
                                    @endif
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
                    {{ $typeMedia->links() }}
                </div>
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

    window.addEventListener("showModal", event=>{
        $("#modalAddProduit").modal({
            "show": true,
            "backdrop": "static"
        })
    })

    window.addEventListener("closeModal", event=>{
        $("#showModelEditTypeMedia").modal("hide")
    })

    window.addEventListener("showEditModal", event=>{
        $("#modalEditProduit").modal({
            "show": true,
            "backdrop": "static"
        })
    })
  </script>
