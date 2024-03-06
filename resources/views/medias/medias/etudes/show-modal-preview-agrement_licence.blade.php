<div class="modal fade" id="showModalProjetAgrement" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog" style="max-width:900px;">
        <div class="modal-content">
            <div class="modal-body m-3">
                <embed src="{{asset($agrement ? $agrement->agrement : '') }}"  width="100%" height="600">
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary float-end" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="showModalLicence" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog" style="max-width:900px;">
        <div class="modal-content">
            <div class="modal-body m-3">
                <embed src="{{asset($agrement ? $agrement->licence : '') }}"  width="100%" height="600">
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-primary float-end" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
