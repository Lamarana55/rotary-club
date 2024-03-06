<div class="modal fade" id="showModelAddProjetAgrement" tabindex="-1" aria-labelledby="showModelAddProjetAgrement" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-default">
                <h5 class="modal-title"> Importation du projet d'agrément du média</h5>
            </div>
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <form id="file-upload-projet-agrement" method="POST"  action="javascript:void(0)" accept-charset="utf-8" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_media" id="id_media">
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Projet d'agrement</label>
                            <input type="file" name="projetAgrement" id="projetAgrement" accept=".pdf,.jpeg,.png,.jpg" class="form-control @error('projetAgrement') is-invalid @enderror">
                            <span class="text-danger" id="file-input-error"></span>
                        </div>
                    </div>
                </div>
                <div class="card-footer justify-content-end">
                    <button class="btn btn-primary float-right projetAgrement-submit ml-2">Importer</button>
                    <button type="button" class="btn btn-danger float-right" data-bs-dismiss="modal">Fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".projetAgrement-submit").click(function(e){
            e.preventDefault();
            if($("#projetAgrement").val()== '' || $("#projetAgrement").val()==null)
            {
                swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    toast: true,
                    title: "veuillez selectionner le projet d'agrement",
                    showConfirmButton: false,
                    timer: 4000,
                });
            }else{
                var formData = new FormData($('#file-upload-projet-agrement')[0]);
                var files = $('#projetAgrement')[0].files;
                var _token = $("input[name='_token']").val();
                var id = $("#id_media").text();

                var fd = new FormData();
                fd.append('_token',_token);
                fd.append('projetAgrement',files[0]);
                fd.append('id',id);
                $.ajax({
                    url: "{{ route('save-projet-agrement') }}",
                    type:'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(data) {
                        if($.isEmptyObject(data.error)){
                            swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                toast: true,
                                title: "Importation de projet d'agrement effecuté avec succes",
                                showConfirmButton: false,
                                timer: 4000,
                            });
                            $("#projetAgrement").val('');
                            window.location.href = "/medias/direction/";
                        }else{
                            printErrorMsg(data.error);
                        }
                    },
                });
            }
        });

        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');

            });

        }
    });
</script>

