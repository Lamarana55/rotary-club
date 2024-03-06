
<div class="modal fade" id="showModelAddTypeMedia" tabindex="-1" aria-labelledby="showModelAddTypeMedia" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title"> {{($isAdd)?"Ajouter un membre":"Mise à jour d'un membre"}} </h5>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="save" >
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="nom">Nom complet <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" id="full_name" wire:model='full_name' name="full_name" placeholder="Entre nom">

                            @error('full_name')
                            <p class="text-danger"> {{$message}} </p>
                            @enderror

                        </div>
                        <div class="col-md-6">
                        <label>Role <i class="text-danger">*</i></label>
                        <select class="form-control" wire:model='fonction' name="fonction" required>
                            <option value="">--Sélectionner--</option>
                            <option value="Président"  >Président</option>
                            <option value="Rapporteur"  >Rapporteur</option>
                            <option value="Membre" >Membre</option>
                        </select>

                            @error('fonction')
                            <p class="text-danger"> {{$message}} </p>
                            @enderror

                        </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="fonction_occupe">Fonction occupée <i class="text-danger">*</i></label>
                      <input type="text" class="form-control" id="fonction_occupe" wire:model='fonction_occupe' name="fonction_occupe"  placeholder="Fonction">

                        @error('fonction_occupe')
                          <p class="text-danger"> {{$message}} </p>
                        @enderror

                    </div>
                    <div class="form-group col-md-6">
                      <label for="category">Catégorie <i class="text-danger">*</i></label>
                      <select class="form-control form-fonction" wire:model='category' name="category">
                        <option value="" selected >--Selectionner--</option>
                          <option value="Commission" >Commission</option>
                          <option value="HAC"  >HAC</option>
                      </select>

                        @error('category')
                          <p class="text-danger"> {{$message}} </p>
                        @enderror

                    </div>
                  </div>
                  <a href="{{ route('membre-commission-index') }}" class="btn btn-danger">Fermer</a>
                  @if ($isAdd && hasPermission('créer_membre') )
                  <button type="submit" class="btn btn-sm btn-primary float-right">Enregistrer</button>
                  @endif
                  @if (!$isAdd && hasPermission('modifier_membre'))
                    <button type="submit" class="btn btn-sm btn-primary float-right">Mise à jour</button>
                  @endif
              </form>
            </div>

        </div>
    </div>
</div>
