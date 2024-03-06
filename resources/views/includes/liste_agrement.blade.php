<div class="row justify-content-center">
    <div class="col-10">
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
                            @if ($page == 'demande')
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
                            @if ($page == 'demande')
                            <td style="width: 200px">
                                <div class="row justify-content-center">
                                    <button id="agreer-{{$dossier->media->id_media}}" class="btn btn-primary mr-1 agreer">Agréer</button>
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


<div class="modal fade" id="modalAgrement">
    <div class="modal-dialog modal-dialog-center">
      <div class="modal-content">
        <div class="modal-header">
          <h4 id="notfound_title">Importation de l'agrément<i class="mdi mdi-book-edit"></i></h4>
          <button type="button" data-bs-dismiss="modal" class="btn btn-close btn-danger">x</button>
        </div>
        <div class="modal-body">
            <form id="formAgrement" enctype="multipart/form-data" method="post" action="{{ route('paiement_frais_agrement', ['id' => $dossier->id_media]) }}">
                @csrf

                <div class="form-group">
                    <div class="custom-file">
                        <input accept=".pdf,.doc,.docx" name="recu" type="file" class="custom-file-input" id="documentAgrement">
                        <label class="custom-file-label" for="documentAgrement">importer</label>
                    </div>
                </div>
            </form>

            <div class="row justify-content-center">
                <button class="btn btn-primary mr-1" id="confirmImportAgrement">Importer</button>
                <button data-bs-dismiss="modal" class="btn btn-close btn-danger">Fermer</button>
            </div>
        </div>
      </div>
    </div>
</div>

<script src="{{asset('js/agrement.js')}} "></script>
