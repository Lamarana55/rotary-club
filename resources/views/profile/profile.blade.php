@extends('/../layouts.default')
@section('content')
<div class="card">
    <div class="card-header bg-gradient-light d-flex align-items-center">
        <h5 class="card-title"><i class="fa fa-user fa-1x"></i> Profile</h5>
    </div>
    <form>
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <div class="d-flex">
                        <div class=" my-2 p-2 flex-grow-1">
                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-2">
                                    <label >Nom</label>
                                    <input type="text" disabled name="nom" value="{{auth()->check() ? auth()->user()->nom :''}}" class="form-control @error('nom') is-invalid @enderror">

                                    @error("nom")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group flex-grow-1">
                                    <label >Prenom</label>
                                    <input type="text" disabled name="prenom" value="{{auth()->check() ? auth()->user()->prenom :''}}" class="form-control @error('prenom') is-invalid @enderror">

                                    @error("prenom")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-2">
                                    <label for="">Email</label>
                                    <input type="email" disabled name="email" value="{{auth()->check() ? auth()->user()->email :''}}" class="form-control @error('email') is-invalid @enderror">

                                    @error("email")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group flex-grow-1 mr-1">
                                    <label for="">Telephone</label>
                                    <input type="text" disabled min="1" value="{{auth()->check() ? auth()->user()->telephone :''}}" name="telephone" class="form-control @error('telephone') is-invalid @enderror">

                                    @error("telephone")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-2">
                                    <label for="">Adresse</label>
                                    <input type="text" disabled name="adresse" value="{{auth()->check() ? auth()->user()->adresse :''}}" class="form-control @error('adresse') is-invalid @enderror">

                                    @error("adresse")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-2">
                                    <label for="">Role</label>
                                    @foreach ($role as $item)
                                        @if (auth()->user()->role_id == $item->id)
                                        <input type="text" disabled name="role" value="{{auth()->check() ? auth()->user()->role->nom :''}}" class="form-control @error('role') is-invalid @enderror">
                                        @endif
                                    @endforeach
                                    @error("role")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    @empty($user->photo)
                    <div class="p-5" >
                        <div style="border: 1px solid #d0d1d3; border-radius: 20px; height: 200px; width:200px; overflow:hidden;">
                            <img src="{{ asset('profile.jpg')}}" style="height:200px; width:200px;">
                        </div>
                    </div>
                    @else
                    <div class="p-5" >
                        <div style="border: 1px solid #d0d1d3; border-radius: 20px; height: 200px; width:200px; overflow:hidden;">
                            <img src="{{ asset('/photo_users/'.$user->photo)}}" style="height:200px; width:200px;">
                        </div>
                    </div>
                    @endempty

                    <p class="text-center">
                        <a href="{{route("updatePassword")}}" style="text-decoration: underline;">Changer de mot de passe ?</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{route('calBack')}}" class="btn btn-danger">Fermer</a>
            <a href="/modificationProfile" class="btn btn-primary float-right">Editer</a>
        </div>
    </form>
</div>

@endsection
