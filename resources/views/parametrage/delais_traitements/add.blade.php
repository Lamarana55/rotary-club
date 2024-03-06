<div  wire:ignore.self class="modal fade" data-bs-backdrop="static" id="ajoutDelaisTraitement">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> {{$delaisId ? 'Modifier': 'Ajouter'}} un délais du traitement</h5>
            </div>
            <form wire:submit.prevent="store">
                <div class="card-body">
                    <div class="form-group">
                        <label for="etape">Etape <i class="text-danger">*</i></label>
                        <select wire:model='etape' class="form-control @error('etape') is-invalid @enderror">
                            <option value="">Séléctionner une étape</option>
                            <option value="validation du compte promoteur">{{mb_strtoupper('validation du compte promoteur','UTF-8')}}</option>
                            <option value="création du media">{{mb_strtoupper('création du media','UTF-8')}}</option>
                            <option value="paiement de cahier des charges">{{mb_strtoupper('paiement de cahier des charges','UTF-8')}}</option>
                            <option value="validation du paiement de cahier des charges">{{mb_strtoupper('validation du paiement de cahier des charges','UTF-8')}}</option>
                            <option value="soumission des documents techniques">{{mb_strtoupper('soumission des documents techniques','UTF-8')}}</option>
                            <option value="étude des documents techniques a la commission">{{mb_strtoupper('étude des documents techniques a la commission','UTF-8')}}</option>
                            <option value="etude des documents techniques a la hac">{{mb_strtoupper('etude des documents techniques à la hac','UTF-8')}}</option>
                            <option value="paiement de frais d'agrément">{{mb_strtoupper("paiement de frais d'agrément",'UTF-8')}}</option>
                            <option value="validation de frais d'agrément">{{mb_strtoupper("validation de frais d'agrément",'UTF-8')}}</option>
                            <option value="élaboration du projet d'agrément">{{mb_strtoupper("élaboration du projet d'agrément",'UTF-8')}}</option>
                            <option value="enregistrement du numéro de l'agrément">{{mb_strtoupper("enregistrement du numéro de l'agrément",'UTF-8')}}</option>
                            <option value="prise de rendez-vous par le promoteur">{{mb_strtoupper("prise de rendez-vous par le promoteur",'UTF-8')}}</option>
                            <option value="confirmation de rendez-vous">{{mb_strtoupper("confirmation de rendez-vous",'UTF-8')}}</option>
                            <option value="signature de l'agrément a la direction">{{mb_strtoupper("signature de l'agrément a la direction",'UTF-8')}}</option>
                            <option value="importation de licence">{{mb_strtoupper("importation de licence",'UTF-8')}}</option>
                        </select>
                        @error('etape')
                            <p class="text-danger"> {{$message}} </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="delais">Délais <i class="text-danger">*</i></label>
                        <input type="number" wire:model='delais' class="form-control @error('delais') is-invalid @enderror">
                        @error('delais')
                            <p class="text-danger"> {{$message}} </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="unite">Unité <i class="text-danger">*</i></label>
                        <select wire:model='unite' class="form-control @error('unite') is-invalid @enderror">
                            <option value="">Séléctionner une unite</option>
                            <option value="Heure(s)">Heure(s)</option>
                            <option value="Jour(s)">Jour(s)</option>
                            <option value="Mois">Mois</option>
                        </select>
                        @error('unite')
                            <p class="text-danger"> {{$message}} </p>
                        @enderror
                    </div>

                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" wire:click='fermer'> Fermer</button>
                    @if (hasPermission('créer_delai_traitement'))
                    <button class="btn btn-success float-right" type="submit">{{$delaisId?'Modification':'Enregistrer'}}</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
