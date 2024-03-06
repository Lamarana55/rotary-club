<div class="row">
    @include('parametrage.documents.add')
    @include('parametrage.documents.edit')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h2 class="">Liste des roles</h2>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-7">
                        {{-- <div class="input-group input-group col-md-4 float-right">
                            <input type="text" class="form-control" wire:model.debounce.250ms="search" placeholder="Recherche ...">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div> --}}
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $key=> $role)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $role->nom }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('asigne-role-permission', ['id'=>$role->uuid]) }}" class="btn btn-sm bg-gradient-info" > <i class="fa fa-eye"></i></a>&nbsp;
                                        {{-- <a class="btn btn-sm bg-gradient-success" > <i class="far fa-edit"></i></a> --}}
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
                    {{-- <div class="col-md-4">
                        <form wire:submit.prevent="ajoutRole">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" wire:model="nom" placeholder="Nom de role" class="form-control @error('nom') is-invalid @enderror">

                                        @error("nom")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex col-md-4">
                                    <div class="form-group flex-grow-1 mr-2">
                                        <button type="submit" class="btn btn-primary" >Enregistrer</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> --}}
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $roles->links() }}
            </div>
          </div>
    </div>
</div>

