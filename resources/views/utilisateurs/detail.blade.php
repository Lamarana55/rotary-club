<div class="card">
    <div class="card-header bg-gradient-dark d-flex align-items-center">
        <h5 class="card-title"><i class="fa fa-plus fa-1x"></i> Detail utilisateur </h5>
    </div>
    <form>
        <div class="card-body">

            <div class="row">

                <div class="col-md-12">

                    <div class="d-flex">
                        <div class=" my-2 p-2 flex-grow-1">
                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-2">
                                    <label >Nom</label>
                                    <input type="text" disabled wire:model="editUser.nom" class="form-control @error('editUser.nom') is-invalid @enderror">

                                    @error("editUser.nom")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group flex-grow-1">
                                    <label >Prenom</label>
                                    <input type="text" disabled wire:model="editUser.prenom" class="form-control @error('editUser.prenom') is-invalid @enderror">

                                    @error("editUser.prenom")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-2">
                                    <label for="">Email</label>
                                    <input type="email" disabled wire:model="editUser.email" class="form-control @error('editUser.email') is-invalid @enderror">

                                    @error("editUser.email")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group flex-grow-1 mr-1">
                                    <label for="">Téléphone {{$this->nom}}</label>
                                    <input type="text" disabled min="1" wire:model="editUser.telephone" class="form-control @error('editUser.telephone') is-invalid @enderror">

                                    @error("editUser.telephone")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-2">
                                    <label for="">Adresse</label>
                                    <input type="text" disabled wire:model="editUser.adresse" class="form-control @error('editUser.adresse') is-invalid @enderror">

                                    @error("editUser.adresse")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-2">
                                    <label for="">Role</label>
                                    <select  class="form-control" disabled wire:model="editUser.role_id">
                                        <option value="{{ $editUser["role_id"] }}">{{ $editUser["role"]["nom"] }}</option>
                                    </select>
                                    @error("editUser.role")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @if($editUser['media'] != null)
        <div class="card">
            <div class="card-header bg-gradient-dark d-flex align-items-center">
                <h3 class="card-title">Les medias</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Nom</th>
                            <th>Telephone</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($editUser['media'] as $key=>$item)
                        <tr>
                            <td>{{$key+1}} </td>
                            <td>{{$item['nom']}} </td>
                            <td>{{$item['telephone']}}</td>
                            <td>{{$item['email']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>activeactive
        @endif
        <div class="card-footer">
            <button type="button" class="btn btn-danger" wire:click="goToListUtilisateur">Fermer</button>
            @if (hasPermission('activate_utilisateur') )
            <button type="button" class="btn btn-primary active" >Activé </button>
            @endif



        </div>
    </form>
</div>

{{-- wire:click='modalvalideCompte({{$editUser['id_user']}})' --}}
