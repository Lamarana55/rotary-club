<div class="">
    @include('parametrage.stepper.add')
    @include('parametrage.stepper.edit')
    <div class="row mb-2">
        <div class="col-sm-6">
          {{-- <h1 class="m-0">Types media</h1> --}}
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}} ">Accueil</a></li>
            <li class="breadcrumb-item active">Stepper</li>
          </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <h2 class="">Liste des Steppers </h2>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a class="btn btn-primary text-white mb-3" data-bs-toggle="modal" data-bs-target="#showModelAddStepper">
                                Ajouter un Steppers
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
                            <th>Libelle</th>
                            <th>Niveau</th>
                            <th>Description</th>
                            <th class="text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse ($stepper as $key=>$value )
                            <tr>
                                <td>{{$key+1}} </td>
                                <td>{{ $value->nom }}</td>
                                <td>{{ $value->level }}</td>
                                <td>{{ $value->description }}</td>
                                <td class="text-right">
                                    <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#showModelEditStepper" wire:click="getStepper({{$value->id}})">
                                    Modifier</a>&nbsp;
                                    <a class="btn btn-sm bg-gradient-danger" wire:click.prevent="confirmDeleteStepper({{$value->id}})"> Supprimer</a>&nbsp;
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
                    {{ $stepper->links() }}
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

    window.addEventListener("closeSaveStepper", event=>{
    $("#showModelAddStepper").modal("hide")
    })

    window.addEventListener("closeEditStepper", event=>{
    $("#showModelEditStepper").modal("hide")
    })

    window.addEventListener("closeModal", event=>{
        $("#showModelEditTypeMedia").modal("hide")
    })


  </script>
