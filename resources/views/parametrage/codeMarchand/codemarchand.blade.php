<div wire:ignore.self>
    @include('parametrage.codeMarchand.add')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="">Liste des codes marchands</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if (hasPermission('créer_code_marchand'))
                            <a class="btn btn-primary text-white mb-3" data-bs-toggle="modal"
                                data-bs-target="#ajoutCodePaiement">
                                Ajouter un code marchand
                            </a>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group col-md-4 float-right">
                                <input type="text" class="form-control" wire:model.debounce.250ms="search"
                                    placeholder="Recherche ...">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i
                                            class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <th>#</th>
                            <th class="col-6">Mode de paiement</th>
                            <th class="col-2">Code</th>
                            <th class="col-1">Status</th>
                            <th class="text-right">Actions</th>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($codeMarchand as $item)
                                <tr>
                                    @if ($item->status == 1)
                                        <td> {{ $i }} </td>
                                        <td> {{ $item->modepaiement }} </td>
                                        <td> {{ $item->code }} </td>
                                        <td> <a class="btn btn-success btn-xs"
                                                style="font-weight: bold; cursor: not-allowed">Activer</a> </td>
                                        <td class="text-right">
                                            @if (hasPermission('modifier_code_marchand'))
                                            <a class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#updateCodeMarchand"
                                                wire:click="get_edit_value({{ $item->id }})">
                                                Modifier</a>
                                            @endif
                                        </td>
                                    @elseif($item->status == 0)
                                        <td> {{ $i }} </td>
                                        <td> {{ $item->modepaiement }} </td>
                                        <td> {{ $item->code }} </td>
                                        <td> <a class="btn btn-danger btn-xs"
                                                style="font-weight: bold; cursor: not-allowed">Desactiver</a> </td>
                                        <td class="text-right">
                                            @if (hasPermission('créer_code_marchand'))
                                            <button class="btn btn-sm bg-gradient-danger"
                                                wire:click.prevent="deleteConfirmation({{ $item->id }})">
                                                Supprimer</button>
                                            @endif
                                        </td>
                                    @endif
                                    <?php $i++; ?>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('parametrage.codeMarchand.edit')
</div>


<script>
    window.addEventListener("showSuccessMessage", event => {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            toast: true,
            title: event.detail.message || "Opération effectuée avec succès!",
            showConfirmButton: false,
            timer: 5000
        })
    })

    window.addEventListener("showErrorMessage", event => {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            toast: true,
            title: event.detail.message || "Opération effectuée avec succès!",
            showConfirmButton: false,
            timer: 5000
        })
    })

    window.addEventListener("showConfirmMessage", event => {
        Swal.fire({
            title: event.detail.message.title,
            html: event.detail.message.text,
            icon: event.detail.message.type,
            showCancelButton: true,
            confirmButtonColor: '{{ SUCCESS }}',
            cancelButtonColor: '{{ DANGER }}',
            confirmButtonText: 'Continuer',
            cancelButtonText: 'Annuler',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                @this.delete(event.detail.message.id)
            }
        })
    })


    window.addEventListener("closeModal", event => {
        $("#ajoutCodePaiement").modal("hide")
    })

    window.addEventListener("closeModalEdite", event => {
        $("#updateCodeMarchand").modal("hide")
    })
</script>
