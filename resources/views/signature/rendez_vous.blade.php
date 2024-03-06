@extends('layouts.default')
@section('page')
Rendez-vous
@endsection

@section("css")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection

@section('content')
<div class="row justify-content-center mb-2">
    <div class="col-2">
        <a class="btn btn-block @if($page == "") btn-outline-primary @else btn-primary @endif" href="?">Tous</a>
    </div>

    <div class="col-2">
        <a class="btn btn-block @if($page == "disponibles") btn-outline-primary @else btn-primary @endif" href="?q=disponibles">Disponibles</a>
    </div>

    <div class="col-2">
        <a class="btn btn-block @if($page == "pris") btn-outline-primary @else btn-primary @endif" href="?q=pris">Pris</a>
    </div>

    <div class="col-2">
        <a class="btn btn-block @if($page == "annuler") btn-outline-primary @else btn-primary @endif" href="?q=annuler">Annulés</a>
    </div>

    <div class="col-2">
        <a class="btn btn-block @if($page == "signes") btn-outline-primary @else btn-primary @endif" href="?q=signes">Signés</a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Rendez-vous</h3>
                <div class="card-tools">
                    <button class="btn btn-primary add-disponibilite" id="ajouterProgrammes">
                        Ajouter une plage de disponibilité
                    </button>
                </div>
            </div>


            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Date</th>
                            <th>Média</th>
                            <th style="width: 300px">Email</th>
                            <th style="width: 150px">Téléphone</th>
                            <th>Représentant</th>
                            <th style="width: 15px">statut</th>
                            <th style="width: 230px">Action.s</th>
                        </tr>
                    </thead>

                    <tbody id="listeProgrammes">
                        @if(in_array($page, ['pris', 'signes', 'annuler']))
                        @include('signature.rendez_vous_pris_signes')
                        @else
                            @include('signature.rendez_vous_all_disponible')
                        @endif
                    </tbody>
                </table>
            </div>


            <div class="card-footer clearfix">
                @if(in_array($page, ['pris', 'signes', 'annuler']))
                {{ $meetings->links()}}
                @else
                {{ $programmes->links()}}
                @endif
            </div>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAjoutProgramme">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Ajouter un programme<i class="mdi mdi-book-edit"></i></h4>
          <button type="button" data-bs-dismiss="modal" class="btn btn-close btn-danger">x</button>
        </div>
        <div class="modal-body">
            <form id="formAjoutProgramme" method="post" action="{{ route('ajouter_programme')}}">

                <div class="form-group">
                    <label>Jour et Heure:</label>
                        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                            <input id="date" type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime"/>
                            <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                </div>

            </form>
        </div>

        <div class="modal-footer justify-content-between">
            <button class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
            <button class="btn btn-primary mr-1" id="confirmAjoutProgramme">Ajouter</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalSuppressionProgramme">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Suppression programme</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="messageSuppression"></p>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" id="confirmSupProgramme">Supprimer</button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalSignature">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Signature de l'agrément<i class="mdi mdi-book-edit"></i></h4>
          <button type="button" data-bs-dismiss="modal" class="btn btn-close btn-danger">x</button>
        </div>
        <div class="modal-body">
            <form  enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <div class="custom-file">
                        <input accept=".pdf,.doc,.docx" name="agrementSigne" type="file" class="custom-file-input" id="agrementSigne">
                        <label class="custom-file-label" for="agrementSigne">importer l'agrément signé <i class="text-danger">*</i></label>
                    </div>
                </div>
            </form>

            <div class="row justify-content-center">
                <button class="btn btn-primary mr-1" id="confirmImportSignature">Importer</button>
                <button class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalAnnulationMeeting">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Annulation Meeting</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="messageAnnulation"></p>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" id="confirmAnnuler">OUI</button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Non</button>
        </div>
      </div>
    </div>
</div>


{{-- <script src="{{asset('js/programmes.js')}} "></script>
<script src="{{asset('js/signature.js')}} "></script> --}}

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function ajax(url, data, onSuccess, jc) {

                //var data = new FormData(form);

                $.ajax({
                    url: url,
                    type: "POST",
                    data: data,
                    dataType: "JSON",
                    success: function (data) {

                        if(typeof onSuccess === 'function') {
                            onSuccess(data);
                        }

                        var alerte = 'alert alert-success';
                        if(typeof data.status !== 'undefined') {
                            alerte = data.status ? 'alert alert-success':'alert alert-danger';
                        }

                        $(".message").empty().fadeIn("slow");
                        $('<h4/>', {
                            'class': alerte
                        }).text(data.message).appendTo(".message");

                        setTimeout(function () {
                            $(".message").fadeOut("slow", function () {
                                if(typeof data.close !== 'undefined' && data.close) {
                                    jc.close();
                                }

                                if(typeof data.refresh !== 'undefined' && data.refresh) {
                                    document.location.reload();
                                }
                            });
                        }, 5000);
                    },
                    error: function (xhr, status, error) {

                        if (xhr.status == 422) {
                            var data = JSON.parse(xhr.responseText);
                            $(".message").empty().fadeIn("slow");
                            $.each(data.errors, function (key, value) {
                                $('<h4/>', {
                                    'class': 'alert alert-danger'
                                }).text(value).appendTo(".message");
                                return false;
                            });
                            setTimeout(function () {
                                $(".message").fadeOut("slow");
                            }, 5000);
                        }else if (xhr.status == 403) {
                            Swal.fire({
                                type: 'error',
                                title: 'Cette action n\'est pas autorisée',
                                confirmButtonClass: 'btn btn-confirm mt-2',
                            });

                            $(".message").empty().fadeIn("slow");
                            $('<h4/>', {
                                'class': 'alert alert-danger'
                            }).text('Cette action n\'est pas autorisée').appendTo(".message");

                            setTimeout(function () {
                                $(".message").fadeOut("slow");
                            }, 5000);
                        }

                    }
                })
            }

            $(".add-disponibilite").on("click", function (e) {
                e.preventDefault();
                var message = $(e.target).attr("data-key");
                $.confirm({
                    title: "Création d'une plage de disponibilité",
                    content: "url:/create-programme",
                    buttons: {
                        FERMER: function () {
                            return true;
                        },
                        formSubmit: {
                            text: 'Enregistrer',
                            btnClass: 'btn-primary',
                            action: function () {

                                var form = this.$content.find('form');

                                ajax(
                                    this.$content.find('form').attr("action"),
                                    form.serialize(),
                                    function (data) {
                                        alert(data);
                                    },
                                    this
                                );
                                return false;
                            }
                        },
                    },
                    onContentReady: function () {
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    },
                    columnClass: 'medium',
                });
            });
        });
    </script>
@endsection

