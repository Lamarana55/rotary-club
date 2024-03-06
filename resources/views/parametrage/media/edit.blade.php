<div class="modal fade" id="showModelEditTypeMedia" tabindex="-1" aria-labelledby="showModelEditTypeMedia" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Modifier le type de media</h5>
            </div>
            <form wire:submit.prevent="updateTypeMedia">
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Nom:*</label>
                            <input type="text" wire:model="editType.nom" class="form-control @error('editType.nom') is-invalid @enderror">

                            @error("editType.nom")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Description:</label>
                            <textarea rows="4" cols="50" wire:model="editType.description" class="form-control @error('editType.description') is-invalid @enderror">
                                @error("editType.description")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-danger float-left" data-bs-dismiss="modal">Fermer</button>
                    @if (hasPermission('modifier_type_media') )
                        <button type="submit" class="btn btn-primary float-right" >Modifier</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
