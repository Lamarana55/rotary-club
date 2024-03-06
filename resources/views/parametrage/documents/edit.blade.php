<div class="modal fade" id="showModelEditTypeDocument" tabindex="-1" aria-labelledby="showModelEditTypeDocument" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Modifier le type de document</h5>
            </div>
            <form wire:submit.prevent="updateTypeDocument">
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Nom:*</label>
                            <input type="text" wire:model="editDocument.nom" class="form-control @error('editDocument.nom') is-invalid @enderror">

                            @error("editDocument.nom")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Description:</label>
                            <textarea rows="4" cols="50" wire:model="editDocument.description" class="form-control @error('editDocument.description') is-invalid @enderror">
                                @error("editDocument.description")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-danger float-left" data-bs-dismiss="modal">Fermer</button>
                    @if (hasPermission('modifier_type_document'))
                    <button type="submit" class="btn btn-primary float-right" >Modifier</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
