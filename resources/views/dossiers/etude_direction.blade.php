@extends('layouts.default')
<?php $userIds = [] ?>
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
    @include('dossiers.projet-agrement.add-form-projet-agrement')
    <div class="col-10">
        <div class="row">
            <div class="col-3">
                <form>
                    <div class="form-group">
                        <select id="statut" class="form-control">
                            <option value="tous">Tous</option>
                            <option value="agrees">Agréés</option>
                            {{-- <option value="rendez-vous">Rendez-vous pour signature</option> --}}
                            <option value="nouveaux">Nouveaux paiements agréments</option>
                            <option value="acceptes">Paiements agréments acceptés</option>
                            <option value="rejetes">Paiements agréments rejetés</option>
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
            <div class="card-header">
                <h3 class="card-title">Médias</h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Promoteur</th>
                            <th>Média</th>
                            <th>Type</th>
                            <th style="width: 300px">Email</th>
                            <th style="width: 150px">Téléphone</th>
                            <th style="width: 100px">FA</th>
                            <th style="width: 15px">Agréé</th>
                            <th style="width: 330px" class="text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="listeMedias">
                        @foreach ($medias as $media)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            @if(!in_array($media->id_user, $userIds))
                            <td class="align-middle" rowspan="{{count($media->user->media)}}">{{ $media->user->prenom }} {{ $media->user->nom }}</td>
                            @endif
                            <td>{{ $media->nom_media }}</td>
                            <td>{{ $media->type_media->libelle }}</td>
                            <td>{{ $media->email }}</td>
                            <td>{{ number_format(str_replace(' ', '', $media->telephone), 0, '', '-') }}</td>
                            <td>
                                <span id="statutNouveau-{{ $media->id_media }}" @if($media->paiement_agrement && $media->paiement_agrement->valide === null) @else hidden @endif>
                                    Nouveau
                                </span>

                                <span id="statutAccepte-{{ $media->id_media }}" @if( $media->paiement_agrement && $media->paiement_agrement->valide === 1) @else hidden @endif>
                                    Accepté
                                </span>

                                <span id="statutRejete-{{ $media->id_media }}" @if( $media->paiement_agrement && $media->paiement_agrement->valide === 0) @else hidden @endif>
                                    Rejeté
                                </span>

                            </td>
                            <td style="text-align: center">
                                <span @if($media->meeting && $media->meeting->agrement) @else hidden @endif id="mediaAgree-{{ $media->meeting ? $media->meeting->id_meeting : 0}}" class="text text-success"><i class="fa fa-check"></i></span>
                            </td>

                            <td class="">
                                <a class="btn btn-info btn-sm mr-1" href="{{ route('details', ['id' => $media->id_media]) }}">Détails</a>

                                <button @if($media->paiement_agrement !== null) @else hidden @endif class="btn btn-primary btn-sm mr-1 preview-recu"
                                    href="{{$media->paiement_agrement !== null ? $media->paiement_agrement->recu : '' }}">Reçu</button>

                                @if($media->paiement_agrement && $media->paiement_agrement->valide === null)
                                    <button @if($media->paiement_agrement && $media->paiement_agrement->valide === null) @else hidden @endif class="btn btn-primary btn-sm mr-1 accepter" id="valider-{{$media->paiement_agrement->id_paiement}}">Valider</button>
                                    <button @if($media->paiement_agrement && $media->paiement_agrement->valide === null) @else hidden @endif class="btn btn-danger btn-sm mr-1 rejeter" id="rejeter-{{$media->paiement_agrement->id_paiement}}">Rejeter</button>
                                @endif

                                @if($media->paiement_agrement && $media->paiement_agrement->valide == 1 && $media->paiement_agrement->isAgrement == null)
                                    <button type="button" value="{{$media->paiement_agrement->id_paiement}}" class="btn btn-dark btn-sm m-1 btnShowProjetAgrement" data-bs-toggle="modal" data-bs-target="#showModelAddProjetAgrement">
                                         Projet d'agrement
                                    </button>
                                @endif

                                @if($media->paiement_agrement && $media->paiement_agrement->valide == 1 && $media->paiement_agrement->isAgrement == null)
                                    <button type="button" class="btn btn-dark btn-sm m-1" data-bs-toggle="modal" data-bs-target="#genererProjetAgreement">
                                         Generer
                                    </button>
                                    <div class="modal fade genererProjetAgreement" id="genererProjetAgreement" >
                                        <div class="modal-dialog modal-dialog-center">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h4 id="notfound_title">Generer projet d'agreement</h4>
                                            </div>
                                            <form>
                                                <div class="modal-body">
                                                    <input type="text" name="id_media" id="id_media_{{$media->id_media}}" value="{{$media->id_media}}" hidden>
                                                    <div class="form-group">
                                                        <div>
                                                            <label  for="nomMinistre_{{$media->id_media}}">Nom Ministre</label>
                                                            <input name="nomMinistre" type="text" class="form-control" id="nomMinistre_{{$media->id_media}}">
                                                        </div>
                                                        <span hidden class="text-danger" id="invalidName_{{$media->id_media}}">Veuillez saisir le nom complet du ministre</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <div>
                                                            <label  for="genreMinistre_{{$media->id_media}}">Genre</label>
                                                            <select name="genreMinistre_{{$media->id_media}}" id="genreMinistre_{{$media->id_media}}" class="form-control">
                                                                <option value="">---Selectionner---</option>
                                                                <option value="Masculin">Masculin</option>
                                                                <option value="Feminin">Feminin</option>
                                                            </select>
                                                        </div>
                                                    <span hidden class="text-danger" id="invalidGenre_{{$media->id_media}}">Veuillez selectionner un genre</span>
                                                    </div>
                                                </div>
                                                <div class="card-footer justify-content-end">
                                                    <button class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                                                    <button type="submit" class="btn btn-primary mr-1 float-right confirmGenererProjetAgreement" id="{{$media->id_media}}">Generer</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>

                        <?php array_push($userIds, $media->id_user); ?>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix" id="pagination">
                {{ $medias->links()}}
            </div>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalValidationFrais">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Validation des frais d'agrément</h4>
        </div>
        <div class="modal-body">
          <p id="messageValidation"></p>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" class="btn " id="btn_fermer" data-bs-dismiss="modal">NON</button>
          <button type="button" class="btn " id="confirmValidation"></button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalPreview">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Reçu frais d'agrément</h4>
        </div>
        <div class="modal-body">
          <p>Reçu frais d'agrément du média <strong id="nomMediaPreview"></strong></p>
          <embed id="previewRecu"  width="100%" height="600">
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" class="btn btn-default" data-bs-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalPreviewAgreement">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Projet d'agreement</h4>
        </div>
        <div class="modal-body">
          <embed id="previewRecuAgreement"  width="100%" height="600">
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" class="btn btn-default" data-bs-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modalSignature">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Signature de l'agrément</h4>
        </div>
        <div class="modal-body">
            <p id="messageImportSignature"></p>
            <form  enctype="multipart/form-data" method="post">
                <div class="form-group">
                    <div class="custom-file">
                        <input accept=".pdf" name="agrementSigne" type="file" class="custom-file-input" id="agrementSigne">
                        <label class="custom-file-label" for="agrementSigne">importer l'agrément signé</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer justify-content-end">
            <button class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
            <button class="btn btn-primary mr-1 float-right" id="confirmImportSignature">Importer</button>
        </div>
        </div>
      </div>
    </div>
</div>
<script>
     $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click','.btnShowProjetAgrement',function(){
            var id = $(this).val();
            console.log(id);
            $('#id_media').text(id);
        });
    });

</script>

<script src="{{asset('js/paiement_frais_agrement.js')}} "></script>
<script src="{{asset('js/pdfProjetAgreement.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" integrity="sha512-a9NgEEK7tsCvABL7KqtUTQjl69z7091EVPpw5KxPlZ93T141ffe1woLtbXTX+r2/8TtTvRX/v4zTL2UlMUPgwg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.min.js" integrity="sha512-P0bOMePRS378NwmPDVPU455C/TuxDS+8QwJozdc7PGgN8kLqR4ems0U/3DeJkmiE31749vYWHvBOtR+37qDCZQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/html-to-pdfmake/browser.js"></script>
<script>

    $(document).ready(function(){

        $(".confirmGenererProjetAgreement").click( function (e) {
            e.preventDefault();
            let id = e.target.id
            $(`#invalidName_${id}`).attr("hidden", true)
            $(`#invalidGenre_${id}`).attr("hidden", true)
            let idNomMinistre = document.getElementById(`nomMinistre_${id}`)
            let nomMinistre= idNomMinistre.value
            let idGenreMinistre = document.getElementById(`genreMinistre_${id}`)
            let genreMinistre =  document.getElementById(`genreMinistre_${id}`).value

            if(nomMinistre == ""){
                $(`#invalidName_${id}`).attr("hidden", false)
                return
            }
            if(genreMinistre == ""){
                $(`#invalidGenre_${id}`).attr("hidden", false)
                return
            }

            var data = {id: id,  nomMinistre: nomMinistre, genreMinistre: genreMinistre};

            // $confirmValidation.html("<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> <span class='visually-hidden'>En cours...</span>");
            // $confirmValidation.css("cursor", "wait")

            $.post(
                `/medias/direction/generer-agrement/${id}`,
                data,
                function (reponse) {
                    if (reponse.succes) {
                        toastr.success(reponse.message);

                        $(".genererProjetAgreement").modal('hide');

                        $('#previewRecuAgreement').attr('src', reponse.data.document)
                        $("#modalPreviewAgreement").modal('show');

                    } else {
                        console.log("Error Reponse", reponse);
                        toastr.error(reponse.message);
                    }
                }
            )
        })

    });
</script>
@endsection

