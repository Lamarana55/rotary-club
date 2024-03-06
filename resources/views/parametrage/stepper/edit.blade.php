<div class="modal fade" id="showModelEditStepper" tabindex="-1" aria-labelledby="showModelEditStepper" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Modifier le Stepper</h5>
            </div>
            <form wire:submit.prevent="updateStepper">
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Nom:*</label>
                            <input type="text" wire:model="editStepper.nom" class="form-control @error('editStepper.nom') is-invalid @enderror">

                            @error("editStepper.nom")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Level:*</label>
                            <input type="text" wire:model="editStepper.level" class="form-control @error('level') is-invalid @enderror">

                            @error("level")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Description:</label>
                            <textarea rows="4" cols="50" wire:model="editStepper.description" class="form-control @error('editStepper.description') is-invalid @enderror">
                                @error("editStepper.description")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </textarea>
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
