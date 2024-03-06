<?php use Illuminate\Support\Facades\Auth; ?>

<div class="row">
    @include('parametrage.documents.add')
    @include('parametrage.documents.edit')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h2 class="">Liste des utilisateurs</h2>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row mb-3">
                    @if(hasPermission('créer_utilisateur'))
                    <div class="col-md-4">
                        <a class="btn btn-primary text-white" href="{{ route('add-utilisateur') }}">
                            Ajouter un utilisateur
                        </a>
                    </div>
                    @endif
                    <div class="input-group input-group col-md-4">
                        <input type="text" class="form-control" wire:model.debounce.250ms="search" placeholder="Recherche ...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="input-group input-group col-md-4">
                        <select wire:model="filter" class="form-control">
                            <option value="">Tous les types</option>
                            @foreach ($roles as $item)
                            <option value="{{$item->id}} ">{{$item->nom}} </option>
                            @endforeach

                        </select>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-filter"></i></button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Genre</th>
                        <th>Role</th>
                        <th class="text-right">Statut</th>
                        <th class="text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $key => $user)
                        <tr>
                            <td>{{ $users->firstItem()+$key }}</td>
                            <td>{{ $user->prenom }}</td>
                            <td>{{ $user->nom }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->telephone }}</td>
                            <td>{{ $user->genre }}</td>
                            <td>{{$user->role->nom}} </td>
                            <td>
                                @if ($user->is_deleted==1)
                                <span class="badge bg-warning">
                                    <a href="#">Supprimé</a>
                                </span>

                                @elseif ($user->valide_compte==false)
                                <span class="badge bg-warning">
                                    <a href="#">En cours</a>
                                </span>

                                @elseif ($user->isvalide)
                                <span class="badge bg-success">
                                    <a href="#">Activé</a>
                                </span>

                                @elseif (!$user->isvalide)
                                <span class="badge bg-danger">
                                    <a href="#">Desactivé</a>
                                </span>
                                @endif

                             </td>

                            <td class="text-right">
                                @if(hasPermission('activate_utilisateur'))
                                <?php if ($user->is_deleted==1) { ?>
                                    <a title="activer ou desactiver le compte" class="btn btn-sm bg-gradient-danger" wire:click="showConfirmMessageActiveUser({{$user->id}})" href="#"   >
                                        <i class="fa {{((($user->is_deleted==1)||($user->valide_compte==false)||(!$user->isvalide))?"fa-lock":"fa-unlock")}} "></i>
                                    </a>
                                <?php   } else { ?>
                                <?php if ($user->valide_compte==false) { ?>
                                    <a title="activer ou desactiver le compte" class="btn btn-sm bg-gradient-danger" wire:click="modalvalideCompte({{$user->id}})" href="#"   >
                                        <i class="fa {{((($user->is_deleted==1)||($user->valide_compte==false)||(!$user->isvalide))?"fa-lock":"fa-unlock")}} "></i>
                                    </a>
                                    <?php   } else { ?>
                                    <a title="activer ou desactiver le compte" class="btn btn-sm bg-gradient-danger" href="#" wire:click="showConfirmMessageActiveValider({{$user->id}},{{$user->isvalide ==0 ? 0:1}})">
                                        <i class="fa {{((($user->is_deleted==1)||($user->valide_compte==false)||(!$user->isvalide))?"fa-lock":"fa-unlock")}} "></i>
                                    </a>
                               <?php } ?>
                               <?php } ?>
                               @endif
                                <a title="Voir les details" class="btn btn-sm bg-gradient-info" wire:click="goToDetailUser({{$user->id}})"> <i class="far fa-eye"></i></a>&nbsp;
                                @if(hasPermission('modifier_utilisateur'))<a title="Modifier les informations" class="btn btn-sm btn-primary" wire:click="goToEditUser({{$user->id}})"> <i class="far fa-edit"></i></a>&nbsp;@endif
                                @if (Auth::user()->id!=$user->id)
                                @if(hasPermission('supprimer_utilisateur'))<a title="Supprimer l'utilisateur" class="btn btn-sm bg-gradient-danger"  wire:click.prevent="confirmDeleteUser({{$user->id}})"> <i class="fa fa-trash"></i></a>&nbsp;@endif
                                @endif
                                @if(hasPermission('modifier_utilisateur'))<a title="Renitialiser le mot de passe" class="btn btn-sm bg-gradient-dark" wire:click="confirmPwdReset({{$user->id}})"> <i class="fa fa-key"></i></a>&nbsp;@endif
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
            <div class="card-footer clearfix">
                {{ $users->links() }}
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
        $("#modalAddProduit").modal("hide")
    })

    window.addEventListener("showEditModal", event=>{
        $("#modalEditProduit").modal({
            "show": true,
            "backdrop": "static"
        })
    })
</script>
