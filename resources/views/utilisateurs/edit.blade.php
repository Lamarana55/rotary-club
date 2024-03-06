<div class="card">
    <div class="card-header bg-light d-flex align-items-center">
        <h5 class="card-title"> Modifier un utilisateur </h5>
    </div>
    <form wire:submit.prevent="updateUser()">
        <div class="card-body">
            <div class="d-flex">
                <div class="my-4 p-3 flex-grow-1">
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label >Nom:*</label>
                            <input type="text" wire:model="editUser.nom" class="form-control @error('editUser.nom') is-invalid @enderror">

                            @error("editUser.nom")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group flex-grow-1">
                            <label >Prénom:*</label>
                            <input type="text" wire:model="editUser.prenom" class="form-control @error('editUser.prenom') is-invalid @enderror">

                            @error("editUser.prenom")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Email:*</label>
                            <input type="email" wire:model="editUser.email" class="form-control @error('editUser.email') is-invalid @enderror">

                            @error("editUser.email")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group flex-grow-1 mr-1">
                            <label for="">Téléphone:*</label>
                            <input type="text" wire:model="editUser.telephone" class="form-control @error('editUser.telephone') is-invalid @enderror">

                            @error("editUser.telephone")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Adresse:</label>
                            <input type="text" wire:model="editUser.adresse" class="form-control @error('editUser.adresse') is-invalid @enderror">

                            @error("editUser.adresse")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group flex-grow-1">
                        <label for="">Genre*:</label>
                        <select wire:model="editUser.genre" class="form-control @error('editUser.genre') is-invalid @enderror">
                            <option value="Masculin">Masculin</option>
                            <option value="Féminin">Féminin</option>
                        </select>
                        @error("editUser.genre")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Role:</label>
                            <select  class="form-control" wire:model="editUser.role_id">
                                @foreach ($roles as $item)
                                    @if($editUser["role_id"] == $item->id)
                                        <option value="{{ $item->id }}" selected>{{$item->nom}} </option>
                                    @else
                                        <option value="{{$item->id}}">{{$item->nom}} </option>
                                    @endif
                                @endforeach
                            </select>
                            @error("editUser.role")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        @if($editUser["role_id"] ==2)
                        <div class="form-group flex-grow-1">
                            <label for="">Catégorie Promoteur:</label>
                            <select wire:model="editUser.type_promoteur_id" class="form-control @error('editUser.type_promoteur_id') is-invalid @enderror">
                                @foreach ($categoriesPromoteur as $categorie)

                                        @if ($categorie->id==$editUser["type_promoteur_id"])
                                        <option value="{{$categorie->id}}" selected="selected">{{$categorie->nom}}</option>
                                        @else
                                        <option value="{{$categorie->id}}">{{$categorie->nom}} </option>
                                        @endif

                                @endforeach

                            </select>
                            @error("editUser.type_promoteur_id")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-danger" wire:click="goToListUtilisateur">Fermer </button>
                        </div>
                        <div class="col-md-6">
                            @if (hasPermission('modifier_utilisateur') )
                            <button type="submit" class="btn btn-primary float-right" >Modifier</button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </form>
</div>

