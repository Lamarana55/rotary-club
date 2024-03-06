
<div class="modal fade" id="showImportationLicence" data-backdrop="static" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header bg-gradient-default">
                <h5 class="modal-title"><i class="fa fa-save"></i>Remplacer un document </h5>
            </div>
            <form class="authenticate-form">
                <div class="card-body">
                  <div class="col-md-12">
                    <div class="form-group flex-grow-1 mr-2">
                        <label for="filePath">Importer la licence <i class="text-danger">*</i> </label><br>
                        <input type="file" accept=".pdf,.jpg,.png," wire:model='filePath' class="form-control @error('filePath') is-invalid @enderror">
                        @error("filePath")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                </div>
                <div class="card-footer" >
                    <button type="button" data-bs-dismiss="modal" class="btn btn-danger float-left">Fermer</button>
                    <button type="submit" class="btn btn-primary float-right btn-submit" >Importer</button>
                </div>
            </form>
        </div>
    </div>
</div>
