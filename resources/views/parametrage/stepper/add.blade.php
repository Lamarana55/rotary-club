<div class="modal fade" id="showModelAddStepper" tabindex="-1" aria-labelledby="showModelAddStepper" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title"> Ajouter un Stepper</h5>
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
                            <label for="">Level:*</label>
                            <input type="text" wire:model="level" class="form-control @error('level') is-invalid @enderror">

                            @error("level")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="description">Description:</label>
                            <textarea id="description" name="description" rows="4" cols="50" wire:model="description" class="form-control @error('description') is-invalid @enderror">
                                @error("description")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-danger float-left" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary float-right" >Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
