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
    <div class="modal-dialog modal-dialog-center">
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
