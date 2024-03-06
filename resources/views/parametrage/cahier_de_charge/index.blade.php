@extends('layouts.default')
<?php $userIds = [] ?>
@section('page')
Cahier de charge
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
              <h2 class="">Liste des cahiers de charge</h2>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="col-md-12 mb-3">
                    <div class="col-md-6">
                        
                        <a class="btn bg-gradient-primary text-white" data-toggle="modal" data-target="#modal-default">
                            Ajouter un cahier de charge
                        </a>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-5">
                        @include('layouts.info')
                        <table class="table table-bordered ">
                            <thead>
                            <tr>

                                <th>Cahier de charge</th>

                                <th class="text-right">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse ($cahier_de_charges as $data )
                                <tr>
                                    <td>{{ $data->type_media->nom }}</td>

                                    <td class="text-right">
                                        <a href="{{route('cahier-de-charge',[
                                            'id'=>$data->id,
                                            ])}}" class="btn btn-sm btn-primary" >Afficher</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="alert alert-info">
                                        <h5><i class="icon fas fa-ban"></i> Information!</h5>
                                        Aucune donnée trouvée par rapport aux éléments de recherche entrés.
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-7">
                        @if ($document)
                        <a href="{{route('cahier-de-charge')}}" type="submit" class="btn btn-primary float-right mb-1" >Fermer </a>
                            <object data="{{ asset($document->nom) }}" width="100%" height="400">{{ asset($document->nom) }}</object>
                        @else
                        <div class="alert alert-info" align="center">
                            <h5>Information!</h5>
                             Aucun document affiché.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
          </div>
    </div>

</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Selectionner le cahier de charge</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('save-cahier-de-charge')}}" enctype="multipart/form-data">
                @csrf
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Type média</label>
                            <select class="form-control select2" name="type_media" style="width: 100%;">
                                @foreach ($type_media as $data)
                                    <option value="{{$data->id}}">{{$data->nom}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Cahier de charge:*</label>
                            <input type="file" name="nom" class="form-control" id="cahierDeCharge" required>

                        </div>
                    </div>

                <div class="modal-footer" >
                    <button type="button" class="btn btn-danger float-left" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary float-right" >Ajouter</button>
                </div>
            </form>
        </div>

      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<!-- /.modal -->
<script>
    $(function(){

        $('#afficher').on('click', function (e) {
            alert("uuu")
        })
        var cahierDeCharge = $('#cahierDeCharge')
        cahierDeCharge.on("change", function(e) {
            console.log("event", e)
        })
    })
</script>
@endsection


