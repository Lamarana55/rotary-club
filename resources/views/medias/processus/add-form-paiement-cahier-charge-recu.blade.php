<div class="modal fade" id="showModalFormPaiementCahierChargeRecu" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="showModalFormPaiementCahierChargeRecuLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header bg-gradient-default">
                <h5 class="modal-title"><i class="fa fa-save"></i> Paiement de cahier des charges par  <strong>{{$CodeBanque->modepaiement}}</strong> </h5>
            </div>
            <form wire:submit.prevent="paiementCahierDesCharges({{$CodeBanque->id}})">
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Numéro de reçu <i class="text-danger">*</i></label>
                            <input type="number" min="1" wire:model="numeroDeRecu" placeholder="Donnez le numéro du reçu" class="form-control @error('numeroDeRecu') is-invalid @enderror">
                            @error("numeroDeRecu")
                                <span class="text-danger numeroDeRecu">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Reçu de paiement <i class="text-danger">*</i></label>
                            <input type="file" wire:model="recuPaiement" accept=".pdf,.jpg,.png" class="form-control @error('recuPaiement') is-invalid @enderror">
                            @error("recuPaiement")
                                <span class="text-danger recuPaiement">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Date de paiement <i class="text-danger">*</i></label>
                            <input type="date" wire:model="dateDePaiement" class="form-control @error('dateDePaiement') is-invalid @enderror">
                            @error("dateDePaiement")
                                <span class="text-danger dateDePaiement">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button data-dismiss="modal" type="button" class="btn btn-danger float-left" wire:click='closeModalRecu'>Fermer</button>
                    <button type="submit" class="btn btn-primary float-right recu-submit">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>


