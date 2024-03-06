<div class="modal fade" id="showModalProjetAgrement" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog" style="max-width:900px;">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h5 class="modal-title"> {{$hasPaiementReçi de paiement}} </h5>
            </div> --}}
            <div class="modal-body m-3">
                <embed src="{{asset($projetAgrementNoSigne ? $projetAgrementNoSigne->document : '') }}" width="100%" height="600">
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary float-end" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
