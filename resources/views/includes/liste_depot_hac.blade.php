<div class="row justify-content-center">

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $titreListe }}</h3>
                <div class="card-tools">
                    <form>
                        <div class="input-group mb-3">
                            <input name="nom" type="text" class="form-control" placeholder="Nom du média">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-dark">
                        <tr class="text-center">
                            <th style="width: 10px">#</th>
                            <th>Média</th>
                            <th style="width: 300px">Email</th>
                            <th style="width: 150px">Téléphone</th>
                            @if ($page != 'etude')
                                <th style="width: 100px">Rapport</th>
                            @endif
                            @if ($page == 'etude')
                                <th style="width: 200px">Action.s</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($dossiers as $dossier)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dossier->media->nom_media }}</td>
                            <td>{{ $dossier->media->email }}</td>
                            <td>{{ $dossier->media->telephone }}</td>
                            @if ($page != 'etude')
                                <td style="text-align: center">
                                    <a target="_blank" class="" href="{{ asset($dossier->rapport) }}">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                    </a>
                                </td>
                            @endif
                            @if ($page == 'etude')
                            <td style="width: 200px">
                                <div class="row justify-content-center">
                                    @if ($page == 'etude')

                                        <div class="col">
                                            <button @if (!$dossier->etude_termine)@else hidden @endif id="etudier-{{$dossier->id}}" class="btn btn-primary mr-1 etude-hac">Etudier</button>
                                        </div>

                                        <div class="col">
                                            <button @if ($dossier->etude_termine) @else hidden @endif class="btn btn-primary mr-1 rapport-hac" id="rapport-{{$dossier->id}}">Rapport</button>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $dossiers->links()}}
            </div>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEtudeDossier">
    <div class="modal-dialog modal-dialog-center modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Documents<i class="mdi mdi-book-edit"></i></h4>
          <button type="button" data-bs-dismiss="modal" class="btn btn-close btn-danger">x</button>
        </div>
        <div class="modal-body">
            <p id="erreurChargement"></p>
            <table id="tableDocuments" class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 15px">#</th>
                        <th>Document</th>
                        <th style="width: 80px">Téléchargement</th>
                        <th style="width: 250px">Action.s</th>
                    </tr>
                </thead>

                <tbody id="listeDocuments">

                </tbody>
            </table>

            <div class="row justify-content-center">
                <button hidden id="terminerEtudeDocument" type="button" class="btn btn-primary mr-1">Etude Terminée</button>
                <button id="fermerDocuments" type="button" class="btn btn-danger">Annuler</button>
            </div>
        </div>
      </div>
    </div>
</div>


<div class="modal fade" id="modalRapport">
    <div class="modal-dialog modal-dialog-center modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Rapport<i class="mdi mdi-book-edit"></i></h4>
          <button type="button" data-bs-dismiss="modal" class="btn btn-close btn-danger">x</button>
        </div>
        <div class="modal-body">
            <form enctype="multipart/form-data" method="post" id="formRapport">
                @csrf
                <div class="form-group">
                    <label>Rapport</label>
                    <textarea id="documentRapport" name="rapport" class="form-control" rows="5" placeholder="Tapez le rapport "></textarea>
                </div>
            </form>

            <div class="row justify-content-center">
                <button type="button" class="btn btn-primary mr-1" id="validerRapport">Valider</button>
                <button type="button" id="fermerRapport" class="btn btn-danger btn-close">Fermer</button>
            </div>
        </div>
      </div>
    </div>
</div>


<script src="{{asset('js/dossiers_hac.js')}} "></script>
