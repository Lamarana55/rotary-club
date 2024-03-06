<div class="modal fade" id="showModalValidationFraisAgrement" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Validation des frais d'agrément</h4>
        </div>
        <div class="modal-body">
          <p>Confirmez-vous la validation du paiement des frais d'agrément du média<strong></strong> </p>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" class="btn " data-bs-dismiss="modal">NON</button>
          <button type="button" class="btn " id="confirmValidation"></button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalPreview">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Reçu frais d'agrément</h4>
        </div>
        <div class="modal-body">
          <p>Reçu frais d'agrément du média <strong id="nomMediaPreview"></strong></p>
          <embed id="previewRecu"  width="100%" height="600">
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" class="btn btn-default" data-bs-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalPreviewAgreement">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Projet d'agreement</h4>
        </div>
        <div class="modal-body">
          <embed id="previewRecuAgreement"  width="100%" height="600">
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" class="btn btn-default" data-bs-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalSignature">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Signature de l'agrément</h4>
        </div>
        <div class="modal-body">
            <p id="messageImportSignature"></p>
            <form  enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <div class="custom-file">
                        <input accept=".pdf" name="agrementSigne" type="file" class="custom-file-input" id="agrementSigne">
                        <label class="custom-file-label" for="agrementSigne">importer l'agrément signé</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer justify-content-end">
            <button class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
            <button class="btn btn-primary mr-1 float-right" id="confirmImportSignature">Importer</button>
        </div>
        </div>
      </div>
    </div>
</div>
