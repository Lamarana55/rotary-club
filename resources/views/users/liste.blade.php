@extends('/../layouts.default')
@section('content')
   <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">

                @isset($promoteur)

                    <h3 class="card-title">Liste des promoteurs</h3>
                    <h3 class="float-right d-flex">
                        <form action="{{route('affichage_promoteur')}}" method="get" class="float-right d-flex">
                            @method('get')
                            <div class="input-group mx-5">
                                <input type="search" class="form-control" name="search" placeholder="Recherche" value="{{request()->get('search')}}">
                                <div class="input-group-prepend">
                                    <button type="submit" class="input-group-text"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <a href="{{route('ajout_promoteur')}}" class="btn btn-dark"><i class="fa fa-plus"></i></a>
                    </h3>

                @else

                    <h3 class="card-title">Liste des utilisateurs</h3>
                    <h3 class="float-right d-flex">
                        <form action="{{route('affichage')}}" method="get" class="float-right d-flex">
                            @method('get')
                            <div class="input-group mx-5">
                                <input type="search" class="form-control" name="search" placeholder="Recherche" value="{{request()->get('search')}}">
                                <div class="input-group-prepend">
                                    <button type="submit" class="input-group-text"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <a href="{{route('ajout')}}" class="btn btn-dark"> <i class="fa fa-plus"></i> </a>
                    </h3>
                @endisset

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-hover text-center table-responsive">
                  <thead class="bg-dark">
                    <tr class="text-center">
                      <th style="width: 10px">#</th>
                      <th>Noms</th>
                      <th>Prénoms</th>
                      <th>E-mails</th>
                      <th>Téléphone</th>
                      <th>Rôles </th>
                      <th class="col-2">Actions</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php $i = 0 ?>
                    @foreach($utilisateurs as $user)
                    @isset($promoteur)
                        @if($user->isDelete == 0 && $user->roleNom == 'Promoteur')

                        <tr>
                        <td>{{ $i += 1 }}</td>
                        <td>{{ $user->nom}}</td>
                        <td>{{ $user->prenom}}</td>
                        <td>{{ $user->email}}</td>
                        <td>{{ $user->telephone}}</td>
                        <td>{{ $user->roleNom}}</td>
                        <td class="d-flex justify-content-center p-0 py-1">
                            @isset($promoteur)
                                <a href="/details-Promoteur/{{ $user -> id_user }}" class="btn btn-dark btnAction"> <i class="fa fa-eye"></i> </a>
                            @else
                                <a href="/details-Utilisateur/{{ $user -> id_user }}" class="btn btn-dark btnAction "> <i class="fa fa-eye"></i> </a>
                            @endisset
                                <a href="/modification/{{ $user -> id_user }}" class="btn btn-primary btnAction "> <i class="fa fa-pencil-alt"></i> </a>
                                <a href="/reinitialisation_mot_de_passe/{{ $user -> id_user }}" class="btn btn-dark btnAction "> <i class="fa fa-undo"></i> </a>
                                <button type="button" class="btn btn-danger btnAction " data-bs-toggle="modal" data-bs-target="#suppression{{ $user -> id_user}}"> <i class="fa fa-trash"></i> </button>
                        </td>
                        </tr>
                        @endif
                    @else
                        @if($user->isDelete == 0 && $user->roleNom != 'Promoteur')
                        <tr>
                        <td>{{ $i += 1 }}</td>
                        <td>{{ $user->nom}}</td>
                        <td>{{ $user->prenom}}</td>
                        <td>{{ $user->email}}</td>
                        <td>{{ $user->telephone}}</td>
                        <td>{{ $user->roleNom}}</td>
                        <td class="d-flex justify-content-center p-0 py-1">
                            @isset($promoteur)
                                <a href="/details-Promoteur/{{ $user -> id_user }}" class="btn btn-dark btnAction "> <i class="fa fa-eye"></i> </a>
                            @else
                                <a href="/details-Utilisateur/{{ $user -> id_user }}" class="btn btn-dark btnAction "> <i class="fa fa-eye"></i> </a>
                            @endisset
                                <a href="/modification/{{ $user -> id_user }}" class="btn btn-primary btnAction"> <i class="fa fa-pencil-alt"></i> </a>
                                <a href="/reinitialisation_mot_de_passe/{{ $user -> id_user }}" class="btn btn-dark btnAction"> <i class="fa fa-undo"></i> </a>
                                <button type="button" class="btn btn-danger btnAction " data-bs-toggle="modal" data-bs-target="#suppression{{ $user -> id_user}}"> <i class="fa fa-trash"></i> </button>
                        </td>
                        </tr>
                        @endif
                    @endisset
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="card-footer clearfix">
                {{ $utilisateurs->links() }} <!-- lien de pagination sur le tableau  -->
              </div>
            </div>
        </div>
      </div>
      </div>
    </section>

    @foreach($utilisateurs as $user)

    <div class="modal fade" id="suppression{{ $user -> id_user}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel"> <i class="fas fa-trash"></i> Suppression</h5>
            </div>
            <div class="modal-body text-center">
                <h4 class="fw-5">Voulez-vous supprimer ?</h4>
            </div>
            <div class="modal-footer justify-content-between">
            <form action="utilisateur/{{ $user -> id_user}}/suppression" method="post">
                @method('delete')
                @csrf
                <input type="submit" class="form-control bg-primary" value="Supprimer">
            </form>
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Quitter</button>

            </div>
        </div>
        </div>
    </div>

    @endforeach

</div>

<script>
@if(session()->has('success'))
    Swal.fire(
  "{{ session()->get('success') }}",
  '',
  'success'
)
@endif
</script>
@endsection
