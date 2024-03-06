<div class="modal fade" id="showModelEditMontant" tabindex="-1" aria-labelledby="showModelEditMontant" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Modifier le montant de paiement</h5>
            </div>
            <form wire:submit.prevent="updateMontant">
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Nom:*</label>
                            <select wire:model="editMontant.nom" class="form-control @error('editMontant.nom') is-invalid @enderror">
                                <option value="cahier_de_charge">Cahier de charge</option>
                                <option value="frais_agrement">Frais d'agrément</option>
                            </select>
                            @error("editMontant.nom")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Montant:*</label>
                            <input type="text" wire:model="editMontant.montant" class="form-control @error('editMontant.montant') is-invalid @enderror">

                            @error("editMontant.montant")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Description:</label>
                            <textarea rows="4" cols="50" wire:model="editMontant.description" class="form-control @error('editMontant.description') is-invalid @enderror">
                                @error("editMontant.description")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-danger float-left" data-bs-dismiss="modal">Fermer</button>
                    @if (hasPermission('modifier_montant_paiement'))
                    <button type="submit" class="btn btn-primary float-right" >Modifier</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
