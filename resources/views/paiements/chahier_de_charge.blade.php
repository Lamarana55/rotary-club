@extends('layouts.default')
@section('page')
Media
@endsection
@section('content')

<div class="row justify-content-center mb-2">
    <div class="col-10">
        <div class="row">
            <div class="col-3">
                <form>
                    <div class="form-group">
                        <select id="statut" class="form-control">
                            <option value="tous">Tous</option>
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

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Média</th>
                                <th style="width: 170px">Mode de paiement</th>
                                <th style="width: 150px">Montant</th>
                                <th style="width: 150px">Code marchand</th>
                                <th style="width: 100px">Etat</th>
                                <th style="width: 250px">Action(s) </th>
                            </tr>
                        </thead>
                        <tbody id="listePaiements" class="listePaiements">
                            @foreach ($paiements as $paiement)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $paiement->media->nom_media }}</td>
                                <td>
                                    @if(array_key_exists($paiement->mode, $modes))
                                    {{ $modes[$paiement->mode] }}
                                    @else
                                    {{ $paiement->mode }}
                                    @endif
                                </td>
                                <td style="text-align: right">{{formatGNF($paiement->montant) }}</td>
                                <td style="text-align: center">{{$paiement->codeMarchand }}</td>
                                <td style="text-align: center">

                                    <span id="statutNouveau-{{$paiement->id_paiement}}" @if ($paiement->valide === null)
                                        @else hidden @endif >
                                        Nouveau
                                    </span>

                                    <span id="statutAccepte-{{$paiement->id_paiement}}" @if($paiement->valide === 1) @else hidden @endif>
                                        Paiement reçu
                                    </span>

                                    <span id="statutRejete-{{$paiement->id_paiement}}" @if($paiement->valide === 0)
                                        @else hidden @endif>
                                        Rejeté
                                    </span>
                                </td>
                                <td>
                                    <div class="row justify-content-center">
                                        <a class="btn btn-primary btn-sm mr-1"
                                            href="{{ route('details', ['id' => $paiement->media->id_media]) }}">Vérifier</a>

                                        <button href="{{ $paiement->recu }}" @if($paiement->mode !== 'Recu') hidden
                                            @endif class="btn btn-primary mr-1 btn-sm preview"
                                            id="preview-{{$paiement->id_paiement}}">Reçu</button>
                                        <button @if($paiement->valide === null) @else hidden @endif class="btn
                                            btn-success mr-1 btn-sm valider"
                                            id="valide-{{$paiement->id_paiement}}">Valider</button>
                                        <button @if($paiement->valide === null) @else hidden @endif class="btn
                                            btn-danger btn-sm rejeter"
                                            id="rejeter-{{$paiement->id_paiement}}">Rejeter</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="clearfix" id="pagination">
                    {{ $paiements->links()}}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>


<div class="modal fade" id="modalConfirmation">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="message-titre"></h4>
            </div>
            <div class="modal-body">
                <p id="messageValidation"></p>
                <form style="display: none;" id="confirmForm">
                    <div id="motifRejet" class="form-group" >
                        <label for="motif">Motif du rejet :</label><br>
                        <input type="radio" name="commentaire" value="Paiement non reçu" id="option1" class="gender-radio m-1 motif"> <label style="font-weight: normal !important;" for="option1">  Paiement non reçu</label> <br>
                        <input type="radio" name="commentaire" value="Preuve non valide" id="option2" class="gender-radio m-1  motif"> <label style="font-weight: normal !important;" for="option2"> Preuve non valide</label> <br>
                        <input type="radio" name="commentaire" value="Montant incorrect" id="option3" class="gender-radio m-1  motif"> <label style="font-weight: normal !important;" for="option3"> Montant incorrect</label> <br>
                        <input type="radio" name="commentaire" value="veuillez contacter la DAF du MIC" id="option4" class="gender-radio m-1  motif"> <label style="font-weight: normal !important;"  for="option4"> Autres, veuillez contacter la DAF du MIC</label><br>
                    </div>
                    {{-- <div class="form-group">
                        <label>Commentaire</label>
                        <textarea id="commentaire" name="commentaire" class="form-control" rows="3"
                            placeholder="Entrer un commentaire"></textarea>
                    </div> --}}
                </form>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-danger" id="annuler_Validation" data-bs-dismiss="modal">NON</button>
                <button type="button" class="btn btn-success" id="confirmValidation"></button>
                {{-- <button type="button" class="btn btn-danger" id="confirmValidation">
                    <p id="spinner"></p>
                </button> --}}
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalPreview">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reçu de paiement</h4>
            </div>
            <div class="modal-body">
                <p>Reçu de paiement du média <strong id="nomMediaPreview"></strong></p>
                <embed id="previewRecu"   width="100%" height="600">
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>


<script src="{{asset('js/liste_paiements_cahier_charge.js')}} "></script>
@endsection
