@section('css')
<style>
    .popover {
        min-width: 400px !important;
    }
</style>
<link rel="stylesheet" href="{{asset('plugins/bs-stepper/css/bs-stepper.min.css')}}">
<!-- SweetAlert2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/themes/dark.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
</script>
<style>
    .fc-content,
    .fc-event {
        cursor: pointer;
    }

    button :actives {
        color: red;
    }

    .active-step {
        background-color: orange;
    }


    .active-stepper {
        background-color: orange !important;
        color-interpolation-filters: #ffffff !important;
    }

    .actives {
        color: #007481 !important;
        color-interpolation-filters: #ffffff !important;
    }

    .active-encours {
        background-color: #898c8f !important;
    }

    .fc-event-container:hover,
    .fc-day:hover {
        cursor: pointer;
    }

    p,
    .fw-bold {
        font-size: 16px !important;
    }
</style>
@endsection
@section("page")
Processus de validation du média : {{$media->nom}} ({{$media->type.' '.$media->type_media}})
@endsection
<div wire:ignore.self>
    @include('medias.processus.add-form-paiement-cahier-charge')
    @include('medias.processus.add-form-paiement-cahier-charge-momo')
    @include('medias.processus.add-form-paiement-cahier-charge-recu')
    @include('medias.processus.add-form-rendez-vous')
    @include('medias.processus.add-form-document-technique')
    @include('medias.processus.add-form-paiement-frais-agrement')
    @include('medias.processus.add-form-prise-rendez-vous')
    <script src="{{asset('plugins/jquery/jquery.min.js')}} "></script>
    <div>
        <section class="content">
            @if(auth()->check() && auth()->user()->role->nom == 'Promoteur')
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <div class="card-header">
                            <div class="card-tools d-flex align-items-center">
                                <a href="{{url('/detail-media/'.$media->uuid)}}"
                                    class="btn btn-md btn-primary">Actualiser</a>&emsp;
                                <a href="{{url('/mes-medias')}}" class="btn btn-md btn-info float-left">Retour</a>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="bs-stepper">
                                @include('medias.stepper.header')
                                <div class="bs-stepper-content">
                                    @include('medias.stepper.etape_cahier_charge_paiement')

                                    @include('medias.stepper.etape_depot_dossier_technique')

                                    @include('medias.stepper.etape_etude_dossier_hac')

                                    @include('medias.stepper.etape_paiement_frais_agrement')

                                    @include('medias.stepper.etape_transmission_agrement')

                                    @include('medias.stepper.etape_sgg')

                                    @include('medias.stepper.etape_prise_rdv')

                                    @include('medias.stepper.etape_telecharge_document')

                                    @include('medias.stepper.etape_arpt_licence')

                                    @include('medias.stepper.etape_sommaire')

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            @include('medias.stepper.detail_d_un_media')
            @endif
        </section>
    </div>
</div>
<script>

</script>
<script>
    window.addEventListener("showSuccessMessage", event=>{
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

    window.addEventListener("showConfirmMessageSoumissionDocumentTechnique", event=>{
       Swal.fire({
        title: 'Confirmation',
        text: 'Etes-vous sûr de vouloir terminer ?',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '{{ SUCCESS }}',
        cancelButtonColor: '{{ DANGER }}',
        confirmButtonText: 'OUI',
        cancelButtonText: 'NON',
        reverseButtons: true,
        }).then((result) => {
            if(result.isConfirmed) {
               @this.soumissionDocumentTechnique()
            }
        })
    })

  </script>
  <script>
    window.addEventListener("closeModalOrangeMoney", event=>{
       $("#staticBackdrop").modal("hide")
    })

    window.addEventListener("closeModalMomo", event=>{
       $("#staticBackdropMomo").modal("hide")
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

    window.addEventListener("showModalValideFraisAgrement", event=>{
        $("#showModalValidationFraisAgrement").modal("show")
    })

    window.addEventListener("showModalRejetFraisAgrement", event=>{
        $("#showModalRejetFraisAgrement").modal("show")
    })

  </script>
  @section('script')
  <script src="{{asset('plugins/bs-stepper/js/bs-stepper.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.js"></script>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/locale/fr.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
  <script src='{{ asset("backend/assets/js/custom.js") }}'></script>


<script>
    $(document).ready(function() {

        $('#staticBackdrop').on("shown.bs.modal", function (e) {
            var input = document.querySelector("#numero");
            window.intlTelInput(input, ({
                preferredCountries: ["gn"],
            }));

        });

        $('#addEventModal').on('shown.bs.modal', function (e) {
            if ($('.calendar').length) {
                var calendarEl = $('.calendar')[0];
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    hiddenDays: [0, 6],
                    eventOrder: "id",
                    eventOrderStrict: true,
                    initialView: 'dayGridMonth',
                    locale: 'fr',
                    validRange: {
                        start: new Date().toISOString().slice(0, 10)
                    },
                    showNonCurrentDates: true,
                    eventClick: function(info) {

                        var humanFormt = moment(info.event.start).format("LL", "fr");
                        var date = moment(info.event.start).format("YYYY-MM-DD");
                        var id = info.event.id;
                        console.log(id);
                        $.confirm({
                            title: 'CONFIRMATION',
                            content: `Confirmez-vous ce rendez-vous du <b>${humanFormt}</b> à partir de <b>${info.event.title.split(" ")[0]}</b> ?.`,
                            buttons: {
                                NON: {
                                    text: 'NON',
                                    btnClass: 'btn-danger',
                                    keys: ['enter', 'shift'],
                                    action: function(){
                                        return true;
                                    }
                                },
                                OUI: {
                                    text: 'OUI',
                                    btnClass: 'btn-success',
                                    keys: ['enter', 'shift'],
                                    action: function(){
                                        $.post("{{ route("meetings.store") }}",{
                                            date: date,
                                            heure: id,
                                            media: "{{ $media->id }}"
                                        }).done(function (data) {

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
                                                    if(data.status) document.location.reload();
                                                });
                                            }, 3000);

                                        }).fail(function(xhr, status, error) {
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
                                                }, 3000);
                                            }
                                        });
                                    }
                                }
                            }
                        });
                    },
                    events: [
                        @foreach ($disponibilites as $disponibilite)
                            {
                                id: '{{ $disponibilite->uuid }}',
                                daysOfWeek: ['{{ getDayIndex($disponibilite->jour) }}'],
                                className: 'gcal-event',
                                color:"green",
                                title: "{{ $disponibilite->heure_debut }}H - {{ $disponibilite->heure_fin }}H" ,
                            },
                        @endforeach
                    ],
                });

                calendar.render();

                var current_rdv = null;
                var current_title = null;

                @if($media->meeting AND (!$media->meeting->confirmer AND !$media->meeting->annuler))
                    current_rdv = '{{ $media->meeting->date }}';
                    current_title = '{{ $media->meeting->heure }}';
                @endif

                var events = calendar.getEvents();

                events.filter((event, index, arr) => {
                    if((current_rdv == event.startStr) && (current_title == event.title)) {
                        //event.remove();
                    }
                });

                $('#addEventModal').modal('handleUpdate');

            }
        });

    });
</script>
  @endsection
