<div class="row">
    @include('medias.medias.etudes.show-modal-preview-agrement_licence')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header row">
                <div class="col">
                    <h2 class="">Liste des medias</h2>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        @if (count($medias)>0)
                            <button wire:click='exportExcelDaf' class="btn btn-primary"><i class="fas fa-file-excel"></i> Exporter</button>
                        @endif
                    </div>
                    <div class="input-group input-group col-md-4">
                        <input type="text" class="form-control" wire:model.debounce.250ms="search"
                            placeholder="Recherche ...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="input-group input-group col-md-4">
                        @include('medias.medias.selectFormFiltre')
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-filter"></i></button>
                        </div>
                    </div>
                </div>
                <div class="table table-responsive">
                    @if(auth()->user()->role->nom == 'Admin' || auth()->user()->role->nom =='DAF')
                    @include('medias.medias.tables.table_daf')
                    @elseif(auth()->user()->role->nom == 'Admin' || auth()->user()->role->nom =='Ministre')
                    @include('medias.medias.tables.table_ministre')
                    @elseif(auth()->user()->role->nom == 'Admin' || auth()->user()->role->nom =='Commission' || auth()->user()->role->nom =='HAC')
                    @include('medias.medias.tables.table_commission')
                    @elseif(auth()->user()->role->nom == 'Admin' || auth()->user()->role->nom =='Direction')
                    @include('medias.medias.tables.table_direction')
                    @elseif(auth()->user()->role->nom == 'Admin' || auth()->user()->role->nom =='Conseiller')
                    @include('medias.medias.tables.table_conseiller')
                    @elseif(auth()->user()->role->nom == 'Admin' || auth()->user()->role->nom =='ARPT')
                    @include('medias.medias.tables.table_arpt')
                    @elseif(auth()->user()->role->nom == 'Admin' || auth()->user()->role->nom =='SGG')
                    @include('medias.medias.tables.table_sgg')
                    @endif
                </div>

            </div>
            <div class="clearfix float-right">
                {{ $medias->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="showValideCahierChargeModal" tabindex="-1" role="dialog"
        aria-labelledby="showValideCahierChargeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Validation du paiement du cahier des charges</h4>
                </div>
                <div class="modal-body">
                    <p id="messageValidation">Confirmez-vous le paiement du cahier des charges du média
                        <strong>{{$paiement ? $paiement->media->nom :''}}</strong> ?</p>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-danger" wire:click='showValideCahierChargeClose'>NON</button>
                    <button type="button" class="btn btn-success"
                        wire:click='validationPaiementCahierCharger({{$paiement ? $paiement->id :''}})'>OUI</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Rejet-->
    <div class="modal fade" id="showRejetPaiementCahierChargeModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="message-titre">Rejet paiement cahier des charges </h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="motif">Motif du rejet :</label><br>
                            @foreach($options as $key=>$option)
                            <input type="radio" name="commentaire" wire:model='commentaire' value="{{$option}}"
                                id="option{{$key}}" class="gender-radio m-1 motif"> <label
                                style="font-weight: normal !important;" for="option{{$key}}"> {{$option}}</label> <br>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-success"
                        wire:click='showRejetPaiementCahierChargeCloseModal'>NON</button>
                    <button type="button" class="btn btn-danger"
                        wire:click='rejetPaiementCahierCharger({{$paiement ? $paiement->id :''}})'>OUI</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showPreviewRecu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reçu de paiement  </h4>
                </div>
                <div class="modal-body">
                    <embed id="previewRecu" src="{{$recu_paiement}}" width="100%" height="600">
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="showModelEnregistrementLicence" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="showModelEnregistrementLicenceLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Importation de la licence du média <strong>{{$meetingId ? $meetingId->media->type.' '.$meetingId->media->type_media.' '.$meetingId->media->nom :''}} </strong> </h4>
                </div>
                <form wire:submit.prevent="enregistrerLicence({{$meetingId ? $meetingId->id:''}})">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="file_licence">Importer la licence <i class="text-danger">*</i></label><br>
                            <input type="file" wire:model='file_licence' class="form-control @error('file_licence') is-invalid @enderror">
                            @error("file_licence")
                                <span class="text-danger file_licence">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary mr-1 float-right">Enregistrer</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.addEventListener("showSuccessMessage", event=>{
        Swal.fire({
            position: 'top-end',
            icon: event.detail.is_valided == true ? 'success' : 'error',
            toast:true,
            title: event.detail.message || "Opération effectuée avec succès!",
            showConfirmButton: false,
            timer: 5000
            }
        )
    })

    window.addEventListener("showSuccessPersoMessage", event=>{
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            toast:true,
            title: event.detail.message || "Opération effectuée avec succès!",
            showConfirmButton: false,
            timer: 5000
            }
        )
    })

    window.addEventListener("showErrorMessage", event=>{
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            toast:true,
            title: event.detail.message || "Opération effectuée avec succès!",
            showConfirmButton: false,
            timer: 5000
            }
        )
    })

    window.addEventListener("showRejetMessage", event=>{
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            toast:true,
            title: event.detail.message || "Opération effectuée avec succès!",
            showConfirmButton: false,
            timer: 5000
            }
        )
    })




    window.addEventListener("showPreviewRecu", event=>{
        $("#showPreviewRecu").modal('show')
    })

    window.addEventListener("showValideCahierChargeModal", event=>{
        $("#showValideCahierChargeModal").modal('show')
    })

    window.addEventListener("showValideCahierChargeClose", event=>{
        $("#showValideCahierChargeModal").modal("hide")
    })

    window.addEventListener("showRejetPaiementCahierChargeModal", event=>{
    $("#showRejetPaiementCahierChargeModal").modal("show")
    })

    window.addEventListener("showRejetPaiementCahierChargeCloseModal", event=>{
    $("#showRejetPaiementCahierChargeModal").modal("hide")
    })

    window.addEventListener("showEditModal", event=>{
        $("#modalEditProduit").modal({
            "show": true,
            "backdrop": "static"
        })
    })

    window.addEventListener("showModalValideFraisAgrement", event=>{
        $("#showModalValidationFraisAgrement").modal("show")
    })

    window.addEventListener("showModalRejetFraisAgrement", event=>{
        $("#showModalRejetFraisAgrement").modal("show")
    })

    window.addEventListener("showModalPreviewRecuFraisAgrement", event=>{
        $("#showModalPreviewRecuFraisAgrement").modal("show")
    })
</script>
