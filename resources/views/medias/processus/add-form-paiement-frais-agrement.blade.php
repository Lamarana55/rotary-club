<div class="modal fade" id="showModalPaiementFraisAgrement" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="showModalPaiementFraisAgrementLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header bg-gradient-default">
                <h5 class="modal-title"><i class="fa fa-save"></i> Importer le reçu de paiement</h5>
            </div>
            <form wire:submit.prevent="paiementFraisAgrement">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group flex-grow-1 mr-2">
                                <label for="">Date de paiement <i class="text-danger">*</i></label>
                                <input type="date" wire:model="dateDePaiement" id="dateDePaiement" name="dateDePaiement" value="{{date('YY')}}" class="form-control @error('dateDePaiement') is-invalid @enderror">
                                @error("dateDePaiement")
                                    <span class="text-danger dateDePaiement">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group flex-grow-1 mr-2">
                                <label for="recuPaiement">Le reçu de paiement <i class="text-danger">*</i></label><br>
                                <input type="file" wire:model='recuPaiement' class="form-control @error('recuPaiement') is-invalid @enderror">
                                @error("recuPaiement")
                                    <span class="text-danger recuPaiement">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer" >
                    <button data-bs-dismiss="modal" type="button" class="btn btn-danger float-left" wire:click='closeModalOrangeMoney'>Fermer</button>
                    <button type="submit" class="btn btn-primary float-right btn-submit" >Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

