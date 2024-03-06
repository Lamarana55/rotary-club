@extends('/../layouts.default')
@section('content')
<div class="card">
    <div class="card-header bg-gradient-light d-flex align-items-center">
        <h5 class="card-title"><i class="fa fa-user fa-1x"></i> Modification Profile</h5>
    </div>
    <form action="/sauvegarder/{{ auth()->check() ? auth()->user()->id :'' }}" method="post" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-9">
                    <div class="d-flex">
                        <div class=" my-2 p-2 flex-grow-1">
                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-2">
                                    <label >Nom</label>
                                    <input type="text" name="nom" value="{{auth()->check() ? auth()->user()->nom :''}}" class="form-control @error('nom') is-invalid @enderror">

                                    @if ($errors)
                                    @error("nom")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @endif
                                </div>
                                <div class="form-group flex-grow-1">
                                    <label >Prenom</label>
                                    <input type="text" name="prenom" value="{{auth()->check() ? auth()->user()->prenom :''}}" class="form-control @error('prenom') is-invalid @enderror">

                                    @if ($errors)
                                    @error("prenom")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-2">
                                    <label for="">Email</label>
                                    <input type="email" name="email" value="{{auth()->check() ? auth()->user()->email :''}}" class="form-control @error('email') is-invalid @enderror">

                                    @if ($errors)
                                    @error("email")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @endif
                                </div>

                                <div class="form-group flex-grow-1 mr-1">
                                    <label for="">Telephone</label>
                                    <input type="text" min="1" value="{{auth()->check() ? auth()->user()->telephone :''}}" name="telephone" class="form-control @error('telephone') is-invalid @enderror">

                                    @if ($errors)
                                    @error("telephone")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @endif
                                </div>
                            </div>
                            <!--  -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Profession</label>
                                        <input class="form-control" value="{{auth()->check() ? auth()->user()->profession :''}}" name="profession" type="text" placeholder="Votre profession">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Commune</label>
                                        <input class="form-control" value="{{auth()->check() ? auth()->user()->commune :''}}" name="commune" type="text" placeholder="Votre commune">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex">
                                <div class="form-group flex-grow-1 mr-2">
                                    <label for="">Adresse</label>
                                    <input type="text" name="adresse" value="{{auth()->check() ? auth()->user()->adresse :''}}" class="form-control @error('adresse') is-invalid @enderror">
                                    @if ($errors)
                                    @error("adresse")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Genre</label>
                                        <select name="genre" class="form-control">
                                            <option value="Masculin">Masculin</option>
                                            <option value="Féminin">Féminin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    @if (!empty(auth()->user()->photo))
                    <div class="d-flex">
                        <div class=" mt-4 p-2 flex-grow-1">
                            <div class="px-5 div_logo" >
                                <label for="photo">
                                <div class="photo_user" style="border: 1px solid #d0d1d3; border-radius: 20px; height: 200px; width:200px; overflow:hidden;">
                                    <img src="{{ asset('/photo_users/'.auth()->check() ? auth()->user()->photo :'')}}" id="image" style="height:200px; width:200px;">
                                </div>
                                </label>
                                <div id="div" class="px-5 icon_photo">
                                    <span id="photolien"></span>
                                    <label for="photo" class="photo"> <i class="fa fa-1x fa-camera"></i>
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
                    @else
                    <div class="d-flex">
                        <div class=" mt-4 p-2 flex-grow-1">
                            <div class="px-5 div_logo" >
                                <label for="photo">
                                <div class="photo_user" style="border: 1px solid #d0d1d3; border-radius: 20px; height: 200px; width:200px; overflow:hidden;">
                                    <img src="{{ asset('profile.jpg')}}" id="image" style="height:200px; width:200px;">
                                </div>
                                </label>
                                <div id="div" class="px-5 icon_photo">
                                    <span id="photolien"></span>
                                    <label for="photo" class="photo"> <i class="fa fa-1x fa-camera"></i>
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
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="/profile" class="btn btn-danger">Annuler</a>
            <input type="submit" value="Sauvegarder" class="btn btn-primary float-right">
        </div>
    </form>
</div>
<script src="{{asset('js/script.js')}} "></script>
@endsection
