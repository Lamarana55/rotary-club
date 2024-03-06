<div class="modal fade" data-bs-backdrop="static" id="updateCodeMarchand" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Modification du code marchand</h5>
            </div>
            <form wire:submit.prevent="update">
                <div class="modal-body">
                    <label>Mode de paiement :*</label>
                    <select name="modePaiement" id="modePaiement" wire:model='editCodePaiement.modepaiement'
                        class="form-control" required>
                        <option value="Mobile Money">Mobile Money</option>
                        <option value="Orange Money" selected>Orange Money</option>
                        <option value="Paiement Bancaire">Paiement Bancaire</option>
                    </select>

                    <label for="code">Code :* </label>
                    <input type="text" name="code" class="form-control" wire:model='editCodePaiement.code'
                        id="code" required>

                </div>
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-danger" type="reset" data-bs-dismiss="modal"> Annuler</button>
                    <button class="btn btn-success" type="submit">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>
