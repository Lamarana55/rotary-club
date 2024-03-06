
<div class="modal fade" id="showRemplaceDocumentTechniqueModal" data-backdrop="static" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header bg-gradient-default">
                <h5 class="modal-title"><i class="fa fa-save"></i>Remplacer un document </h5>
            </div>
            <form wire:submit.prevent="remplacerDocumentTechnique" class="authenticate-form">
                <div class="card-body">
                  <div class="col-md-12">
                    <div class="form-group flex-grow-1 mr-2">
                        <label for="filePath">{{$firstDocument->document_type_promoteur->document_technique->nom ?? null}}</label><br>
                        <input type="file" accept=".pdf,.jpg,.png," wire:model='filePath' class="form-control @error('filePath') is-invalid @enderror">
                        @error("filePath")
                            <span class="text-danger filePath">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                </div>
                <div class="card-footer" >
                    <button type="button" data-dismiss="modal" class="btn btn-danger float-left" wire:click='closeModalMomo'>Fermer</button>
                    <button type="submit" class="btn btn-primary float-right btn-submit" >Importer</button>
                </div>
            </form>
        </div>
    </div>
</div>
