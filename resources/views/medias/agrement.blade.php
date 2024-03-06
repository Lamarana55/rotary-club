@extends('layouts.default')
@section('page')
Médias
@endsection
@section('css')
<link rel="stylesheet" href="{{asset('plugins/bs-stepper/css/bs-stepper.min.css')}}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
@endsection

@section('content')
<div class="row justify-content-center mb-2">
    <div class="col-10">
        <div class="row">
            <div class="col-3">
                <form>
                    <div class="form-group">
                        <select id="statut" class="form-control">
                            <option value="tous">Tous</option>
                            <option value="demandes">Nouveaux</option>
                            <option value="agrees">Agréés</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-2">
        <form>
            <div class="input-group mb-3">
                <input id="nomMedia" name="nom" type="text" class="form-control" placeholder="Nom du média">
                <div class="input-group-append">
                    <button id="rechercheMedia" type="submit" class="btn btn-primary">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 50px">#</th>
                            <th>Média</th>
                            <th>Type</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Projet agrément</th>
                            <th>Dossier Technique</th>
                            <th>Rapport Commission</th>
                            <th>Rapport HAC</th>
                            <th class="text-right">Action.s</th>
                        </tr>
                    </thead>

                    <tbody id="listeMedias">
                    @foreach ($dossiers as $dossier)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dossier->media->nom_media }}</td>
                            <td>{{ $dossier->media->type_media->libelle }}</td>
                            <td>{{ $dossier->media->email }}</td>
                            <td>{{ phone($dossier->media->telephone, ["GN"], "National") }}</td>
                            <td style="text-align: center">
                                <a target="_blank" rel="noopener noreferrer" href="{{asset($dossier->projetAgrement)}}">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                </a>
                            <td style="text-align: center"><span id="viewDocument-{{$dossier->media->id_media}}" class="text text-primary viewDocument"><span class="text text-primary"><i class="fa fa-download" aria-hidden="true"></i></span>
                            </span></td>

                            <td style="text-align: center"><a target="_blank" rel="noopener noreferrer" href="{{asset($dossier->media->dossier_commission->rapport)}}"><i class="fa fa-download" aria-hidden="true"></i>
                            </a></td>
                            <td style="text-align: center"><a target="_blank" rel="noopener noreferrer" href="{{asset($dossier->media->dossier_hac->rapport)}}"><i class="fa fa-download" aria-hidden="true"></i>
                            </a></td>

                            <td>
                                <div class="row justify-content-end">
                                    <a class="btn btn-primary btn-sm mr-1" href="{{ route('details', ['id' => $dossier->media->id_media]) }}">Détails</a>
                                    <button @if($dossier->agrement === null) @else hidden @endif value="{{$dossier->id}}"
                                        class="btn btn-primary btn-sm btnEnregistrerAgrement" data-bs-toggle="modal" data-bs-target="#showModelEnregistrementNumeroAgrement">Enregistrer </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix" id="pagination">
                {{ $dossiers->links()}}
            </div>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDocuments">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Documents Techniques<i class="mdi mdi-book-edit"></i></h4>
          {{-- <button type="button" data-bs-dismiss="modal" class="btn btn-close btn-danger">x</button> --}}
        </div>
        <div class="modal-body">
            <p id="erreurChargement"></p>
            <table id="tableDocuments" class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 15px">#</th>
                        <th>Document</th>
                        <th style="width: 80px">Action.s</th>
                    </tr>
                </thead>

                <tbody id="listeDocuments">

                </tbody>
            </table>

            <div class="row justify-content-center">
                <button data-bs-dismiss="modal" type="button" class="btn btn-primary">Fermer</button>
            </div>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalAgrement">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Enregistrement média</h4>
        </div>
        <div class="modal-body">
            <p>Enregistrement du média <strong id="mediaAEnregistre"></strong></p>
            <form id="formAgrement" enctype="multipart/form-data" method="post">
                @csrf
                <div class="form-group">
                    <label>Numéro d'agrément</label>
                    <input id="numero" name="numero" class="form-control" />
                </div>

                <div class="form-group">
                    <div class="custom-file">
                        <input accept=".pdf" name="recu" type="file" class="custom-file-input" id="documentAgrement">
                        <label class="custom-file-label" for="documentAgrement">importer</label>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal-footer justify-content-between">
            <button data-bs-dismiss="modal" class="btn btn-close btn-danger">Annuler</button>
            <button class="btn btn-success mr-1" id="confirmImportAgrement">Confirmer</button>
        </div>
      </div>
    </div>
</div>


<div class="modal fade" id="showModelEnregistrementNumeroAgrement" tabindex="-1" aria-labelledby="showModelEnregistrementNumeroAgrement" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h4>Enregistrement de l'agrément </h4>
        </div>
        <div class="alert alert-danger print-error-msg" style="display:none">
            <ul></ul>
        </div>
        <div class="modal-body">
            <form id="file-upload-numero-agrement" enctype="multipart/form-data" method="post">
                @csrf
                <div class="d-flex">
                    <input type="hidden" id="id">
                    <div class="form-group flex-grow-1 mr-2">
                        <label for="">Numero d'enregistrement du média</label>
                        <input type="text" name="numero_media" id="numero_media" accept=".pdf" class="form-control @error('numero_media') is-invalid @enderror">
                        <span class="text-danger" id="file-input-error"></span>
                    </div>
                </div>

                <div class="d-flex">
                    <div class="form-group flex-grow-1 mr-2">
                        <label for="">importer agrement</label>
                        <input type="file" name="agrement" id="agrement" accept=".pdf" class="form-control @error('agrement') is-invalid @enderror">
                        <span class="text-danger" id="file-input-error"></span>
                    </div>
                </div>
            </form>
            <div class="card-footer">
                <button data-bs-dismiss="modal" class="btn btn-close btn-danger">Fermer</button>
                <button class="btn btn-primary float-right mr-1 importer-agrement-submit">Importer</button>
            </div>
        </div>
      </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click','.btnEnregistrerAgrement', function(){
            var id = $(this).val();
            $('#id').text(id);
        });

        $(document).on('click','.importer-agrement-submit', function(){
            var formData = new FormData($('#file-upload-numero-agrement')[0]);
            var files = $('#agrement')[0].files;
            var id = $('#id').text();
            var _token = $("input[name='_token']").val();
            var numero_media = $('#numero_media').val();
            var fdAgrement = new FormData();
            fdAgrement.append('_token',_token);
            fdAgrement.append('agrement',files[0]);
            fdAgrement.append('numero_media',numero_media);
            fdAgrement.append('id',id);

            $.ajax({
                url: "/demandes-agrement/"+id+"/agree/",
                type:'POST',
                data: fdAgrement,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if($.isEmptyObject(data.error)){
                        swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            toast: true,
                            title: "Enregistrement effecuté avec succes",
                            showConfirmButton: false,
                            timer: 4000,
                        });
                        $("#projetAgrement").val('');
                        window.location.href = "/demandes-agrement/agree";
                    }else{
                        printErrorMsg(data.error);
                    }
                },
            });
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
<script src="{{asset('js/agrement.js')}} "></script>

@endsection

