<div class="modal fade" x-on:close-modal.window="on = false" id="showModelAddMontant" tabindex="-1" aria-labelledby="showModelAddMontant" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Montant de paiement</h5>
            </div>
            <form wire:submit.prevent="save">
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Nom:*</label>
                            <select wire:model="nom" class="form-control @error('nom') is-invalid @enderror">
                                <option value="" selected>Selectionner</option>
                                <option value="cahier_de_charge">Cahier de charge</option>
                                <option value="frais_agrement">Frais d'agrément</option>
                            </select>
                            @error("nom")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @if($nom=='frais_agrement')
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Type de media:*</label>
                            <select wire:model="type_media" class="form-control @error('type_media') is-invalid @enderror">
                                <option value="" selected>Selectionner</option>
                                <option value="Radio">Radio</option>
                                <option value="Télévision">Télévision</option>
                            </select>
                            @error("type_media")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @endif
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Montant:*</label>
                            <input type="text"  id="number"  wire:model="montant" class="form-control @error('montant') is-invalid @enderror">

                            @error("montant")
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
                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-danger float-left" data-bs-dismiss="modal">Fermer</button>
                    @if (hasPermission('créer_montant_paiement'))
                    <button type="submit" class="btn btn-primary float-right"   >Enregistrer</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('#number').on("keyup", function() {
    this.value = this.value.replace(/ /g,"");
    this.value = this.value.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    });
    })
    window.addEventListener('showSuccessMessage', event => {
    $('#showModelAddMontant').modal('toggle');

})
</script>
