
<div class="modal fade" id="showModelAddProgramme" tabindex="-1" aria-labelledby="showModelAddProgramme" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-default">
                <h5 class="modal-title"><i class="fa fa-save"></i> Paiement de cahier des charges par  </h5>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <form>
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="id_media">
                    <div class="row">
                        <input type="hidden" name="id_media" id="id_media">
                        <div class="form-group col-md-12">
                            <label for="">date de rendez-vous</label>
                            <input type="time" name="heure" id="heure" class="form-control" min="09:00" max="17:00">
                            @error("date")
                                <span class="text-danger date">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-12">
                            <label for="">Representant</label>
                            <input type="text" name="representant" id="representant" class="form-control @error('representant') is-invalid @enderror">
                            @error("representant")
                                <span class="text-danger representant">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer" >
                    <button type="button" class="btn btn-danger float-left closeModel">Fermer</button>
                    <button class="btn btn-primary float-right btnSaveProgramme" >Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.closeModel').click(function(e){
            e.preventDefault();
            $("#showModelAddProgramme").modal("hide")
            $("#representant").val('')
            $("#heure").val('')
        });
        $('.btnSaveProgramme').click(function(e){
            e.preventDefault();
            var _token = $("input[name='_token']").val();
            var id = $('#id_media').text();
            var heure = $('#heure').val();
            var representant = $('#representant').val();
            let id_media = id.split(",");
            $.ajax({
                url: "{{ route('confirme-rendez-vous') }}",
                type:'POST',
                data: {_token:_token, id_media:id_media[0], id_programme:id_media[1],representant:representant,heure:heure},
                success: function(data) {
                    if(data.succes){
                        if(data.media.meeting != null || data.media.meeting.annuler != 1){
                        $('#rendezvoussignature').text(`Votre rendez-vous pour la signature est le ${data.media.meeting.date.toString('MM-dd-yyyy')+' à '+data.media.meeting.heure }`);
                        }
                        swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            toast: true,
                            title: data.message,
                            showConfirmButton: false,
                            timer: 4000,
                        });
                        $("#showModelAddProgramme").modal("hide")
                        $("#representant").val('')
                        $("#heure").val('')
                    }else{
                        swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            toast: true,
                            title: data.message,
                            showConfirmButton: false,
                            timer: 4000,
                        });
                    }
                }
            });
        });
    });
</script>

