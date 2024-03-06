@extends('layouts.default')
@section('page')
Liste des rendez-vous
@endsection
@section('css')
    <link rel="stylesheet" href="{{asset('plugins/bs-stepper/css/bs-stepper.min.css')}}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <style>
        .custom-file-input ~ .custom-file-label::after {
            content: "Elegir";
        }
    </style>
@endsection
@section('content')

<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Média</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Etat</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="listeMedias">
                        @forelse ($meetings as $meeting)
                        <tr>
                            <td></td>
                            <td>{{ $meeting->media->nom }}</td>
                            <td>{{ $meeting->media->type_media }}</td>
                            <td>{{ dateFormat($meeting->date) }}</td>
                            <td>{{ $meeting->heure }}</td>
                            <td>
                                @if($meeting->confirmer=='Confirmer')
                                Temps restant : <b>{{suivu('confirmation de rendez-vous',traking($meeting->media->id)->date_confirme_rdv??null)}} </b>
                                @else
                                <span class="text-warning">
                                    En attente de confirmation
                                </span>
                                Temps restant : <b>{{suivu('prise de rendez-vous par le promoteur',traking($meeting->media->id)->date_prise_rdv??null)}} </b>
                                @endif
                                {{-- {{ $meeting->confirmer ? "Confirmer":"En attente de confirmation" }} --}}

                                {{-- temps restant : <b>{{suivu('élaboration du projet d\'agrément',traking($media->id)->date_transmission_projet_agrement??null)}} </b> --}}

                            </td>
                            <td class="text-right">
                                @if(!$meeting->confirmer)
                                    <a href="javascript::void()" class="btn btn-primary btn-confirm btn-md mb-1" data-meeting="{{ $meeting->id }}">
                                        Confirmer
                                    </a>
                                    <a href="javascript::void()" class="btn btn-danger btn-annuler btn-md mb-1" data-meeting="{{ $meeting->id }}">
                                        Annuler
                                    </a>
                                @endif

                                @if($meeting->confirmer)
                                    @if($meeting->media->getRecuAgrement())
                                        <a href="javascript::void()" class="btn btn-info btn-preview btn-md mb-1" data-meeting="{{ $meeting->id }}">
                                            Aperçu du reçu
                                        </a>
                                    @endif

                                    <a href="javascript::void()" class="btn btn-dark btn-md mb-1 btn-signer" data-meeting="{{ $meeting->id }}">
                                        Importer les documents
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="alert alert-info">
                                <h5><i class="icon fas fa-ban"></i> Information!</h5>
                                    Aucun rendez-vous prévue.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix" id="pagination">
                {{ $meetings->links() }}
            </div>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" id="signatureDialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-header">
                <h5 class="card-title">Signature de la convention d’établissement </h5>
                <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-danger btn-close" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-success save-agrement-signer float-right">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="{{ asset("backend/assets/js/custom.js") }}"></script>
<script>

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".btn-preview").on("click", function(e) {
            e.preventDefault();
            var meeting = $(this).attr("data-meeting");

            createOrUpdate(`/meeting/${meeting}/preview`, "PREVIEW", function (data) {

            }, "Aperçu du reçu d'agrement", "col-md-8");
        });

        $(".btn-signer").on("click", function(e) {
            e.preventDefault();
            var meeting = $(this).attr("data-meeting");

            $("#signatureDialog .modal-body").load(`/meeting/${meeting}/signature`);

            $('#signatureDialog').modal('show');
        });

        $(".btn-close").on("click", function (e) {
            $('#signatureDialog').modal('hide');
        });


        $('.save-agrement-signer').on('click', function (e) {
            e.preventDefault();
            var form = $(e.target).parents(".modal-content").find("form");
            ajax(
                form.attr("action"),
                "POST",
                form[0],
                function (data) {
                    if(data.status == true) {
                        window.location.href = "/meetings";
                        swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            toast: true,
                            title: data.message,
                            showConfirmButton: false,
                            timer: 5000,
                        });
                    }
                }
            );
        });


        $(".btn-annuler").on("click", function(e) {
            e.preventDefault();
            var meeting = $(this).attr("data-meeting");

            createOrUpdate(`/meeting/${meeting}/cancel`, "POST", function (data) {

            }, "Annuler un rendez-vous", "col-md-4");
        });

        // $(".btn-confirm").on("click", function(e) {
        //     e.preventDefault();
        //     var meeting = $(this).attr("data-meeting");
        //     $.confirm({
        //         title: 'Confirmation',
        //         content: "Êtes-vous sûr de vouloir confirmer ce rendez-vous",
        //         animateFromElement: false,
        //         buttons: {
        //             NON: function () {
        //                 return true;
        //             },
        //             Confirmer: {
        //                 text: 'OUI',
        //                 btnClass: 'btn-success',
        //                 action: function(){
        //                     $.get(`/meetings/${meeting}/edit`, { meeting: meeting, confirm: true }, function (data){
        //                         $.confirm({
        //                             title: 'Succes',
        //                             content: data.message,
        //                             animateFromElement: false,
        //                             buttons: {
        //                                 OK: function () {
        //                                     document.location.reload();
        //                                 }
        //                             }
        //                         });
        //                     });
        //                 }
        //             }
        //         }
        //     });
        // });

        $(document).on('click','.btn-confirm', function(e){
            e.preventDefault();
            var meeting = $(this).attr("data-meeting");
            var id = $(this).val();
            Swal.fire({
                title: 'Confirmation',
                text: "Êtes-vous sûr de vouloir confirmer ce rendez-vous ?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '{{ SUCCESS }}',
                cancelButtonColor: '{{ DANGER }}',
                cancelButtonText: 'NON',
                confirmButtonText: 'OUI',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/meetings/${meeting}/edit`,
                        type:'GET',
                        data: { meeting: meeting, confirm: true },
                        success: function(data) {
                            window.location.href = "/meetings";
                            swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                toast: true,
                                title: data.message,
                                showConfirmButton: false,
                                timer: 4000,
                            });
                        },
                    });
                }
            });
        });
    });

</script>
@endsection
