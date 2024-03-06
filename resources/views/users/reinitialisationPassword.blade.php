@extends('/../layouts.default')
@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-dark">
            <div class="card-header">
              <h3 class="card-title">Envoie du lien de reinitialisation de mot de passe</h3>
            </div>
            @if(session()->has('status'))
            <div class="alert alert-success mt-2">
                <p> {{ session()->get('status') }} </p>
            </div>
            @endif
            @if(session()->has('email'))
            <div class="alert alert-danger mt-2">
                <p> {{ session()->get('email') }} </p>
            </div>
            @endif
            <form id="quickForm" action="/reinitialisation_mot_de_passe" method="POST">
                @method('post')
                @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" name="email" class="form-control" id="email" placeholder="Entrer l'e-mail" value="{{$user->email}}">
                </div>
              </div>
              <div class="card-footer">
                <a href="{{url('utilisateur')}} " class="btn btn-danger"><i class="fa fa-times"></i> Fermer </a>
                <button type="submit" class="btn btn-primary float-right"><i class="fas fa-location-arrow"></i> Envoyer </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
