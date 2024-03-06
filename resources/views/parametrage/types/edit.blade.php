<div class="modal fade" id="showModelEditTypePaiement" tabindex="-1" aria-labelledby="showModelEditTypePaiement" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Modifier le type de paiement</h5>
            </div>
            <form wire:submit.prevent="updateTypePaiement">
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Nom:*</label>
                            <input type="text" wire:model="editTypePaiement.nom" class="form-control @error('editTypePaiement.nom') is-invalid @enderror">

                            @error("editTypePaiement.nom")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-danger float-left" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary float-right" >Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>
