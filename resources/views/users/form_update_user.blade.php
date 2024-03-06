@extends('/../layouts.default')
@section('content')

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-dark">
          <div class="card-header">
                <h3 class="card-title"> <a href="{{url('utilisateur')}} " class="btn btn-primary" style="border-radius:100%;" ><i class="fa fa-reply-all"></i></a> Modifier un utilisateur</h3>
          </div>
          <form action="/modification/{{ $user -> id_user }}" method="post" enctype="multipart/form-data">
            @method('put')
            @csrf
            <div class="card-body">
              <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <p class="text-center" style=" font-size:20px; margin-bottom:10px ">Photo de profil</p>
                            <img class="profile-user-img img-fluid img-circle" id="image" style="width: 120px; height:120px" src="{{ asset('photo_users/'.$user->photo) }}" alt="User profile">
                            <div id="div">
                                <span id="photolien"></span>
                                <label for="photo" class="photo"> <i class="fa fa-1x fa-camera"></i> Changer...
                                    <input type="file" class="float-right" name="photo" id="photo"  onchange="previewPicture(this)" hidden>
                                </label>
                                @if($errors)
                                @error('photo')
                                <p class="text-danger"> {{$message}} </p>
                                @enderror
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body border-none" style="font-size: 15px">
                            <div class="form-group mt-2">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="{{$user->nom}}" placeholder="Entre nom">
                                @if($errors)
                                @error('nom')
                                    <p class="text-danger"> {{$message}} </p>
                                @enderror
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="prenom">Prénom </label>
                                <input type="text" class="form-control" id="prenom" name="prenom" value="{{$user->prenom}}" placeholder="Entre prénom">
                                @if($errors)
                                @error('prenom')
                                    <p class="text-danger"> {{$message}} </p>
                                @enderror
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="mail">Email </label>
                                <input type="email" class="form-control" id="mail" name="email" value="{{$user->email}}" placeholder="Enter email">
                                @if($errors)
                                @error('email')
                                    <p class="text-danger"> {{$message}} </p>
                                @enderror
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="telephone">Téléphone </label>
                                <input type="number" class="form-control" id="telephone" name="telephone" value="{{$user->telephone}}" placeholder="Enter téléphone">
                                @if($errors)
                                @error('telephone')
                                    <p class="text-danger"> {{$message}} </p>
                                @enderror
                                @endif
                            </div>
                            <div class="form-group mt-3">
                                <label for="role">Rôles </label>
                                <select name="role" class="form-control" id="role">
                                    <option value="">Selectionnez...</option>
                                    @foreach($role as $item)
                                    <?php $item_var = $item -> id_role;
                                        $user_var = $user -> id_role;
                                    if($item_var ===  $user_var):?>
                                        <option value="{{$item -> id_role}}" selected>{{$item->nom}}</option>
                                    <?php else: ?>
                                        <option value="{{$item -> id_role}}">{{$item->nom}}</option>
                                    <?php endif; ?>
                                    @endforeach
                                </select>
                                @if($errors)
                                @error('role')
                                    <p class="text-danger"> {{$message}} </p>
                                @enderror
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="adresse">Adresse </label>
                                <input type="text" class="form-control" id="adresse" name="adresse" value="{{$user->adresse}}" placeholder="Entre adresse">
                                @if($errors)
                                @error('adresse')
                                    <p class="text-danger"> {{$message}} </p>
                                @enderror
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>

            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary"> Enrégistrer </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
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
