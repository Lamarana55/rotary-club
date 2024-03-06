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
                        </tr>
                    </thead>

                    <tbody>
                    @foreach ($medias as $media)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $media->nom_media }}</td>
                            <td>{{ $media->email }}</td>
                            <td>{{ $media->telephone }}</td>
                            <td>{{ $media->type_media->libelle}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer clearfix">
                {{ $medias->links()}}
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

