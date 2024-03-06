<div class="">
    @include('parametrage.forme_juridique.add')
    @include('parametrage.forme_juridique.edit')
    <div class="row mb-2">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('home')}} ">Accueil</a></li>
                <li class="breadcrumb-item active">Formes Juridiques</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="">Liste des Formes Juridiques</h2>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if (hasPermission('créer_forme_juridique'))
                                <a class="btn btn-primary text-white mb-3" data-bs-toggle="modal"
                                    data-bs-target="#showModelAddFormeJuridique">
                                    Ajouter une Forme Juridique
                                </a>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group col-md-4 float-right">
                                <input type="text" class="form-control" wire:model.debounce.250ms="search"
                                    placeholder="Recherche ...">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th >Description</th>
                                    <th  style="width: 200px">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($forme_juridique as $key=>$value )
                                <tr>
                                    <td>{{$key+1}} </td>
                                    <td>{{ $value->nom }}</td>
                                    <td>{{ $value->description }}</td>
                                    <td class="text-center">
                                        @if (hasPermission('modifier_forme_juridique'))
                                            <a class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#showModelEditFormeJuridique"
                                                wire:click="getFormeJuridique({{$value->id}})">
                                                Modifier</a>&nbsp;
                                        @endif
                                        @if (hasPermission('supprimer_forme_juridique'))
                                        <a class="btn btn-sm bg-gradient-danger"
                                            wire:click.prevent="confirmDeleteFormeJuridique({{$value->id}})">
                                            Supprimer</a>&nbsp;
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


                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $forme_juridique->links() }}
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

    window.addEventListener("closeEditFormeJuridique", event=>{
        $("#showModelEditFormeJuridique").modal("hide")
    })

    window.addEventListener("closeSaveFormeJuridique", event=>{
    $("#showModelAddFormeJuridique").modal("hide")
    })

    window.addEventListener("showEditModal", event=>{
        $("#modalEditProduit").modal({
            "show": true,
            "backdrop": "static"
        })
    })
</script>
