@extends('layouts.default')
@section('page')
Médias Agréés
@endsection

@section('content')
<div class="row justify-content-center">
 
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Média agréés</h3>
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
                            <th style="width: 15px">#</th>
                            <th>Média</th>
                            <th style="width: 300px">Email</th>
                            <th style="width: 150px">Téléphone</th>
                            <th style="width: 250px">Type</th>
                            <th style="width: 100px">Agrément</th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($meetings as $meeting)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $meeting->media->nom_media }}</td>
                            <td>{{ $meeting->media->email }}</td>
                            <td>{{ $meeting->media->telephone }}</td>
                            <td>{{ $meeting->media->type_media->libelle}}</td>
                            <td style="text-align: center">
                                <a target="_blank" class="" href="{{ $meeting->agrement }}">
                                    <i class="fa fa-download" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $meetings->links()}}
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

