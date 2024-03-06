@extends('/../layouts.default')
@section('content')
<section class="content">
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">@isset($ajout)
                <a href="{{route('affichage_promoteur')}}" class="btn btn-primary"style="border-radius:100%;"> <i class="fas fa-reply-all"></i></a>
            @else
                <a href="{{route('affichage')}}" class="btn btn-primary"style="border-radius:100%;"> <i class="fas fa-reply-all"></i></a>
            @endisset Détails utilisateur</h3>
            <div class="">
                <button type="button" class="btn btn-danger float-right" style="border-radius:100%;" data-bs-toggle="modal" data-bs-target="#suppression{{ $user -> id_user}}"> <i class="fa fa-trash"></i></button>
                <a href="/modification/{{ $user -> id_user }}" class="btn btn-primary float-right"style="border-radius:100%;"> <i class="fas fa-pencil-alt"></i></a>
            </div>
        </div>
        <div class="card-body bg-light">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body" style="font-size: 20px">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">
                                        Nom
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        {{$user->nom}}
                                    </p>
                                </div>
                            </div>
                            <hr class="my-2">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">
                                        Prénom
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        {{$user->prenom}}
                                    </p>
                                </div>
                            </div>
                            <hr class="my-2">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">
                                        Email
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        {{$user->email}}
                                    </p>
                                </div>
                            </div>
                            <hr class="my-2">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">
                                        Téléphone
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        {{$user->telephone}}
                                    </p>
                                </div>
                            </div>
                            <hr class="my-2">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">
                                        Adresse
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        {{$user->adresse}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <div>
                                <img class="profile-user-img img-fluid img-circle" style="width: 130px; height:130px " src="{{ asset('photo_users/'.$user->photo) }}" alt="User profile">
                            </div>
                            <h5 class="my-3"> {{$user->prenom}} {{$user->nom}} </h5>
                            <p class="text-muted mb-1"> {{$user->role->nom}} </p>
                            <p class="text-muted"> {{$user->adresse}} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>


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
</div>

  <script>
      @if(session()->has('success'))
      Swal.fire({
          position: 'center',
          icon: 'success',
          title: 'Mot de passe reinitialisé',
          showConfirmButton: false,
          timer: 2000
      })
      @endif
      </script>
@endsection
