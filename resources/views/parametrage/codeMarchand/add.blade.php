<div  wire:ignore.self class="modal fade" data-bs-backdrop="static" id="ajoutCodePaiement">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Ajouter un code marchand</h5>
            </div>
            <form wire:submit.prevent="store">
            {{-- <form action="{{route('ajoutCodeMarchand')}}" method="post">
                @method('post')
                @csrf --}}
            <div class="modal-body">
                <label for="modePaiement">Mode de paiement :*</label>
                <select name="modePaiement" id="modePaiement" wire:model='modePaiement' class="form-control">
                    <option value="">Selectionnez...</option>
                    <option value="Orange Money">Orange Money</option>
                    <option value="Mobile Money">Mobile Money</option>
                    <option value="Paiement Bancaire">Paiement Bancaire</option>
                </select>
                @if($errors)
                @error('modePaiement')
                    <p class="text-danger"> {{$message}} </p>
                @enderror
                @endif

                <label for="code">Code :* </label>
                <input type="text" name="code" wire:model='code' class="form-control" id="code">
                @if($errors)
                    @error('code')
                        <p class="text-danger"> {{$message}} </p>
                    @enderror
                @endif
            </div>
            <div class="modal-footer justify-content-between">
                <button class="btn btn-danger" data-bs-dismiss="modal"> Fermer</button>
                @if (hasPermission('créer_code_marchand'))
                 <button class="btn btn-success" type="submit">Enrégistrer</button>
                @endif
            </div>
            </form>
        </div>
    </div>
</div>
{{-- <script>
    window.addEventListener('showSuccessMessage', event => {
    $('#showModelAddMontant').modal('toggle');

})
</script> --}}
