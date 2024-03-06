<div class="modal fade" id="showModelAddTypeMedia" tabindex="-1" aria-labelledby="showModelAddTypeMedia" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title"> Ajouter un type de media</h5>
            </div>
            <form wire:submit.prevent="save">
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Nom:*</label>
                            <input type="text" wire:model="nom" class="form-control @error('nom') is-invalid @enderror">

                            @error("nom")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Description:</label>
                            <textarea id="w3review" name="w3review" rows="4" cols="50" wire:model="description" class="form-control @error('description') is-invalid @enderror">
                                @error("description")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </textarea>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Cahier de charge:*</label>
                            <input type="file" wire:model="cahierDeCharge"  class="form-control @error('cahierDeCharge') is-invalid @enderror">

                            @error("cahierDeCharge")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-danger float-left" data-bs-dismiss="modal">Fermer</button>
                    @if (hasPermission('créer_type_media') )
                        <button type="submit" class="btn btn-primary float-right" >Enregistrer</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
