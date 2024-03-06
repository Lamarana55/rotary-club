<div class="row justify-content-center mb-2">
    <div class="col-10">
        <div class="row">
            <div class="col-3">
                <form>
                    <div class="form-group">
                        <select wire:model="statut" class="form-control">
                            <option value="tous">Statuts</option>
                            <option value="agrees">Agréés</option>
                            <option value="nouveaux">Nouveaux</option>
                            <option value="acceptes">Acceptés</option>
                            <option value="rejetes">Rejetés</option>
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

            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Média</th>
                            <th>Type</th>
                            <th style="width: 300px">Email</th>
                            <th style="width: 150px">Téléphone</th>
                            <th style="width: 100px">FA</th>
                            <th style="width: 15px">Agréé</th>
                            <th style="width: 230px">Action.s</th>
                        </tr>
                    </thead>

                    <tbody id="listeMedias">
                        @if($medias)
                            @include('includes.liste_all_medias')
                        @endif

                        @if($meetings)
                            @include('includes.liste_medias_agrees')
                        @endif

                        @if($paiements)
                            @include('includes.liste_medias_paiement_agrement')
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix" id="pagination">
                @if($medias)
                {{ $medias->links()}}
                @endif

                @if($paiements)
                {{ $paiements->links()}}
                @endif

                @if($meetings)
                {{ $meetings->links()}}
                @endif

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
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p id="messageValidation"></p>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
          <button type="button" class="btn btn-primary" id="confirmValidation"></button>
        </div>
      </div>
    </div>
</div>



