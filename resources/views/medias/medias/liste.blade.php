<div wire:ignore.self>
<link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

<style>
    .center {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 200px;
    }
</style>
@section('page')
Médias
@endsection
<?php
 use App\Http\Controllers\MediaControlle;
 use Illuminate\Support\Facades\DB;
 use App\Models\Media;
 use App\Models\TypeMedia;
 $count = DB::table('media')->where('user_id',auth()->user()->id)->get();
 ?>

     <section class="content">
        @if(count($count) < 2)
        <div class="card bg-default">
            <div class="card-header">
                {{-- <h3 class="card-title">Médias</h3> --}}
                <div class="card-tools">
                    <a type="button" wire:click='addmedia("Radio")'  href="#" data-toggle="modal" data-target="#editCreateMedia" class="btn btn-default btn-md">
                        <span class="mdi mdi-radio" style="font-size: 30px;"> Radio</span>
                    </a>

                    <a type="button" wire:click='addmedia("Télévision")'  href="#" data-toggle="modal" data-target="#editCreateMedia" class="btn btn-default btn-md">
                        <span class="mdi mdi-television-classic" style="font-size: 30px;"> Télévision</span>
                    </a>
                </div>
            </div>
        </div>
        @endif
        @if(count($medias)==0)
        <div class="center row text-center p-2 m-4">
            <div class="col-md-6 col-sm-12 mt-2">
                <a class="btn btn-block btn-default btn-lg float-right" wire:click='addmedia("Radio")'  data-toggle="modal"  data-target="#editCreateMedia" href="#">
                    <span class="mdi mdi-radio" style="font-size: 48px;"> Radio</span>
                </a>
            </div>

            <div class="col-md-6 col-sm-12 mt-2">
                <a class="btn btn-block btn-default btn-lg float-right" wire:click='addmedia("Télévision")'  data-toggle="modal"  data-target="#editCreateMedia" href="#">
                    <span class="mdi mdi-television-classic" style="font-size: 48px;"> Télévision</span>
                </a>
            </div>
        </div>
        @endif
        <div class="row m-2 mt-3" >
            @forelse($medias as $data)
                <div class="col-md-6 mb-2 content" >
                    <div class="card content" style="height: 95%;">
                        <div class="row g-0">
                            <div class="col-md-12">
                                <div class="card-body {{strlen($data->description) >= 1  ? "" : "mb-4" }} ">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="{{asset(($data->logo) ? $data->logo : 'logo-google.png')}}" style="border: 1px solid #a4a4a5; border-radius: 10px; height: 120px; width:120px; overflow:hidden;" class="img-fluid rounded-start" alt="...">
                                        </div>
                                        <div class="col-md-8">
                                            <h5 class="me-0 col-12 col-md-12">Statut : <span class="badge {{$data->agree ? 'bg-success':'bg-warning'}} ">{{$data->agree? 'Agrée' :'En cours de traitement'}}</span> </h5>
                                            <div class="my-auto">
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success fw-bold " role="progressbar" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-center fw-bold text-uppercase h4"><strong>{{$data->nom}}</strong></p>
                                    <div class="row">
                                        <p class="card-text col my-0"><strong>Type de médias</strong> <br> <span class="fw-bold">{{$data->type_media}} ({{$data->type}})</span></p>
                                        <p class="card-text col my-0"><strong>Date de création</strong>  <br> <span class="fw-bold">{{$data->created_at->format('d-m-y')}}</span></p>
                                    </div>
                                    <div class="row">
                                        <p class="card-text col my-0"><strong>Téléphone</strong> <br> <span class="fw-bold">{{$data->telephone}}</span></p>
                                        <p class="card-text col my-0"><strong>Email</strong>  <br> <span class="fw-bold">{{$data->email}}</span></p>

                                    </div>
                                    <div class="row">
                                        <p class="card-text col my-0"><strong>Forme juridique</strong> <br> <span class="fw-bold">{{$data->forme_juridique}}</span></p>
                                        <p class="card-text col my-0"><strong>Sigle</strong> <br> <span class="fw-bold">{{$data->sigle}}</span></p>
                                    </div>
                                    <div class="row">
                                        <p class="card-text col my-0"><strong>Localité : </strong> <br> <span class="fw-bold">{{$data->region->nom??null}}/{{$data->prefecture->nom??null}}/{{$data->commune->nom??null}}</span></p>
                                        <p class="card-text col my-0">
                                        <strong>Description</strong><br>
                                        <span class="fw-bold">
                                            {{strlen($data->description) <= 40 ? $data->description : substr($data->description, 0, 40).' ...'; }} @if(strlen($data->description) >40)
                                            <button type="button" value="{{ $data->id }}" data-toggle="modal" data-target="#exampleModal" description="{{$data->description}}" class="btn btn-sm btn-info editbtn voir_plus">voir plus</button>@endif
                                        </span>
                                    </p>
                                    </div>
                                </div>
                                <div class="card-footer pb-3 ">
                                    @if($data->level !=7)
                                        @if (hasPermission('modifier_media'))
                                            <a class="float-start btn btn-primary btn-md" data-toggle="modal"  data-target="#editCreateMedia" wire:click='editmedia({{$data->id}})' > <i class="fa-solid fa-pencil"></i> Modifier </a>
                                        @endif
                                    @endif
                                    @if (hasPermission('processus'))
                                        <a class="float-right btn btn-info btn-md" href="{{route('detail-media',['id'=>$data->uuid])}}"> <i class="mdi mdi-folder-eye mdi-24px"></i>Accedez aux étapes d’enregistrement</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
              @endforelse
        </div>
    </section>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><strong>La description du media</strong></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <p id="desc" class="m-3"></p>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
    </div>
    {{-- Modal de la edit-create d'un media promoteur --}}
    <div wire:ignore.self class="modal fade" id="editCreateMedia" tabindex="-1" role="dialog" aria-labelledby="editCreateMediaLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" ><strong>{{($isAdd && $type)? "Création d'un média : ".$type??null:"Mise à jour".$type??null}} </strong></h5>
                <button type="button" class="close" data-dismiss="modal" wire:click='resetForm'>
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    @include('medias.medias.addEdit')
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function (e) {
       $('.voir_plus').on('click', function () {
        $('#desc').html($(this).attr('description'))
       })
    });
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
  </script>
  <script>
    window.addEventListener("showConfirmMessageDeleteTypeMedia", event=>{
       Swal.fire({
        title: event.detail.message.title,
        text: event.detail.message.text,
        icon: event.detail.message.type,
        showCancelButton: true,
        confirmButtonColor: '{{ SUCCESS }}',
        cancelButtonColor: '{{ DANGER }}',
        confirmButtonText: 'Continuer',
        cancelButtonText: 'Annuler',
        reverseButtons: true,
        }).then((result) => {
            if(result.isConfirmed) {
               @this.deleteTypeMedia(event.detail.message.id)
            }
        })
    })



  </script>

<script>
    window.addEventListener("closeModal", event=>{
        $("#editCreateMedia").modal('hide')

    })
</script>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
<script>
  var input = document.querySelector("#phone");
  window.intlTelInput(input, {
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
    initialCountry: 'gn',
    placeholderNumberType: 'MOBILE',
    separateDialCode: true,
    onlyCountries: ['gn'],
  });
</script>


