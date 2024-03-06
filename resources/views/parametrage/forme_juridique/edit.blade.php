<div class="modal fade" id="showModelEditFormeJuridique" tabindex="-1" aria-labelledby="showModelEditFormeJuridique" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Modifier la forme juridique</h5>
            </div>
            <form wire:submit.prevent="updateFormeJuridique">
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Nom:*</label>
                            <input type="text" wire:model="editForme.nom" class="form-control @error('editForme.nom') is-invalid @enderror">

                            @error("editForme.nom")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Description:</label>
                            <textarea rows="4" cols="50" wire:model="editForme.description" class="form-control @error('editForme.description') is-invalid @enderror">
                                @error("editForme.description")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-danger float-left" data-bs-dismiss="modal">Fermer</button>
                    @if (hasPermission('modifier_forme_juridique'))
                        <button type="submit" class="btn btn-primary float-right" >Modifier</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
