<div class="modal fade" id="staticBackdropMomo" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropMomoLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header bg-gradient-default">
                <h5 class="modal-title"><i class="fa fa-save"></i> Paiement de cahier des charges par  <strong>{{$CodeMOMO->modepaiement}}</strong> </h5>
            </div>
            <form wire:submit.prevent="paiementCahierDesCharges({{$CodeMOMO->id}})">
                <div class="modal-body">
                    <h4>Code marchand : <strong>{{$CodeMOMO->code}}</strong></h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group flex-grow-1 mr-2" wire:ignore>
                                <label for="numeroDePaiement">Numéro de paiement <i class="text-danger">*</i></label><br>
                                <input id="numeroMomo" type="number" step="0.01" style="width: 460px" wire:model='numeroDePaiement' class="form-control @error('numeroDePaiement') is-invalid @enderror">
                            </div>
                            @error("numeroDePaiement")
                                <span class="text-danger numeroDePaiement">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <div class="form-group flex-grow-1 mr-2">
                                <label for="">Date de paiement <i class="text-danger">*</i></label>
                                <input type="date" wire:model="dateDePaiement" id="dateDePaiement" name="dateDePaiement" value="{{date('YY')}}" class="form-control @error('dateDePaiement') is-invalid @enderror">
                                @error("dateDePaiement")
                                    <span class="text-danger dateDePaiement">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer" >
                    <button data-dismiss="modal" type="button" class="btn btn-danger float-left" wire:click='closeModalMomo'>Fermer</button>
                    <button class="btn btn-primary float-right btn-submit" >Enregistrer</button>
                </div>
            </form>
            <style>
                input[type=number]::-webkit-inner-spin-button,
                input[type=number]::-webkit-outer-spin-button {
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    appearance: none;
                    margin: 0;
                }
            </style>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
<script>
  var input = document.querySelector("#numeroMomo");
  window.intlTelInput(input, {
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
    initialCountry: 'gn',
    placeholderNumberType: 'MOBILE',
    separateDialCode: true,
    onlyCountries: ['gn'],
  });
</script>
