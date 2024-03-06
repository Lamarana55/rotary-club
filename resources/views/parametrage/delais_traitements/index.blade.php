<div wire:ignore.self>
    @include('parametrage.delais_traitements.add')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="">Liste des délais du traitement</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            @if (hasPermission('créer_delai_traitement'))
                             <a class="btn btn-primary text-white mb-3" data-bs-toggle="modal"
                                data-bs-target="#ajoutDelaisTraitement">
                                Ajouter un délais du traitement
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

                    <table class="table table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Etapes</th>
                            <th>Délais</th>
                            <th>Unité</th>
                            <th class="text-right">Actions</th>
                        </thead>
                        <tbody>
                            @foreach ($delais_traitements as $key=> $item)
                                <tr>
                                    <td> {{ $key+1 }} </td>
                                    <td>{{mb_strtoupper($item->etape,'UTF-8')}} </td>
                                    <td> {{ $item->delais }} </td>
                                    <td> {{ $item->unite }} </td>
                                    <td class="text-right">
                                        @if (hasPermission('modifier_delai_traitement'))
                                        <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#ajoutDelaisTraitement" wire:click="getDelaisTraitement({{ $item->id }})">
                                            Modifier
                                        </a>
                                        @endif
                                        @if (hasPermission('supprimer_delai_traitement'))
                                        <button type="button" class="btn btn-sm bg-gradient-danger" wire:click.prevent="deleteConfirmation({{ $item->id }})">
                                            Supprimer
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
        $("#ajoutDelaisTraitement").modal("hide")
    })
</script>
