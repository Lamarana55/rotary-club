@extends('layouts.default')
@section('page')
Prise de Rendez-vous
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Rendez-vous disponibles</h3>

            </div>

            <div class="card-body">
                <div class="row" id="listeProgrammes">
                    @foreach ($programmes as $programme)
                        <div class="col-2">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $jours[$programme->date->formatLocalized('%u') - 1] }}</h3>

                                    <div class="card-tools">
                                        <button id="programme-{{ $programme->id_programme}}" type="button" class="btn btn-tool programme"><span class="text text-success"><i class="fa fa-check" aria-hidden="true"></i>
                                        </span>
                                    </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    {{ $programme->format_date }}

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card-footer clearfix">
                {{ $programmes->links()}}
            </div>
        </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalConfirmRendezVous">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Prise de rendez-vous</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p id="messageConfirmationRendezVous"></p>
            <form method="post">
                <input type="hidden" id="idMedia" value="{{$idMedia}}"/>
                <div class="form-group">
                    <label>Représentant</label>
                    <input id="representant" name="representant" class="form-control" />
                </div>
            </form>

        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-primary" id="confirmRendezVous">Confirmer</button>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
</div>


<script src="{{asset('js/rendez_vous.js')}} "></script>

@endsection

