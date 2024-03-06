@extends('layouts.register-master')
@section('content')
	<div class="card bg-pattern text-light bg-main text-xs-center">

        <div class="card-body p-4">

            <div class="text-center w-75 m-auto">
                {{-- <div class="auth-logo">
                    <a href="/" class="logo logo-dark text-center">
                        <span class="logo-lg">
                            <img src="{{ asset('backend/assets/images/gn.png') }}" alt="" height="80">
                        </span>
                    </a>

                    <a href="/" class="logo logo-light text-center">
                        <span class="logo-lg">
                            <img src="{{ asset('backend/assets/images/gn.png') }}" alt="" height="80">
                        </span>
                    </a>
                </div> --}}
                <h2 class="text-white" style="margin-top: -14px;">Création de compte</h2>
                {{-- <p class="text-white mb-2">
                    {{ __("Entrez votre identifiant et votre mot de passe pour accéder au compte.") }}
                </p> --}}
            </div>
            @if (\Illuminate\Support\Facades\Session::has('msg'))
            <h5 id="alert" class="alert alert-warning">{{ Illuminate\Support\Facades\Session::get('msg') }}</h5>
            @endif
            <form method="POST" action="{{ route('enregistrement_promoteur') }}">
                @csrf
                <div class="row mt-2">
                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label >{{ __("Prénom(s)") }} <i class="text-danger size-text">*</i> </label>
                            <input type="text"  placeholder="Entrez votre prénom" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" autocomplete="prenom" >

                            @error('prenom')
                                <span class="invalid-feedback text-white" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label >{{ __('Nom') }} <i class="text-danger size-text">*</i></label>
                            <input class="form-control @error('nom') is-invalid @enderror" value="{{ old("nom") }}" name="nom" type="text"  placeholder="Votre nom">
                            @error('nom')
                                <span class="invalid-feedback text-white" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label >{{ __("Adresse e-mail") }} <i class="text-danger size-text">*</i></label>
                            <input class="form-control @error('email') is-invalid @enderror" value="{{ old("email") }}" name="email" type="text"  placeholder="Votre email">
                            @error('email')
                                <span class="invalid-feedback text-white" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label >{{ __('Numéro de téléphone') }} <i class="text-danger size-text">*</i></label>
                            <input class="form-control @error('telephone') is-invalid @enderror" id="phone" value="{{ old("telephone") }}" name="telephone" type="number" step="0.01" placeholder="Votre numéro de téléphone">
                            @error('telephone')
                                <span class="invalid-feedback text-white" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Genre <i class="text-danger size-text">*</i></label>
                            <select name="genre" class="form-control">
                                <option value="">Selectionner un genre</option>

                                @if (old('genre')=='Masculin')
                                <option value="Masculin">Masculin</option>
                                @endif
                                @if (old('genre')=='Féminin')
                                <option value="Féminin">Féminin</option>
                                @endif
                                <option value="Masculin">Masculin</option>
                                <option value="Féminin">Féminin</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Profession <i class="text-danger size-text">*</i></label>
                            <input class="form-control" name="profession" type="text" placeholder="Votre profession" value="{{ old('profession') }}">
                            @error('profession')
                                <span class="invalid-feedback text-white" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label >{{ __('Adresse') }} <i class="text-danger size-text">*</i></label>
                            <input class="form-control @error('adresse') is-invalid @enderror" value="{{ old("adresse") }}" name="adresse" type="text"  placeholder="Votre adresse(quartier...)">
                            @error('adresse')
                                <span class="invalid-feedback text-white" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Statut du promoteur <i class="text-danger size-text">*</i></label>
                            <select name="categorie" class="form-control @error('categorie') is-invalid @enderror">
                                <option value="">Selectionner un status</option>
                                @foreach ($categories as $categorie)
                                @if (old('categorie')==$categorie->id)
                                <option value="{{$categorie->id}}" selected>{{$categorie->nom}} </option>
                                @else
                                <option value="{{$categorie->id}}">{{$categorie->nom}} </option>
                                @endif

                                @endforeach
                            </select>
                            @error('categorie')
                                <span class="invalid-feedback text-white" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Region <i class="text-danger size-text">*</i> </label>
                            <select name="region" id="region" class="form-control">
                                <option value="">Sélectionnez une region</option>
                                @foreach ($regions as $item)
                                <option value="{{$item->id}} ">{{$item->nom}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Préfecture <i class="text-danger size-text">*</i></label>
                            <select name="prefecture" id="prefecture" class="form-control">

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Commune <i class="text-danger size-text">*</i></label>
                            <select name="commune" id="commune" class="form-control">

                            </select>
                        </div>
                    </div> --}}
                </div>

                <div class="form-group mb-0 text-center">
                    <button class="btn bg-gris-fonce float-right" type="submit"> {{ __("Enregistrer") }}</button>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 text-center">
                        <p class="text-black text-center">Avez-vous déjà un compte ? <a href="{{ route("login") }}" class="text-black ms-1" style="color: inherit;"><b>Connectez-vous</b></a></p>
                    </div> <!-- end col -->
                </div>

            </form>
            <style>
                input[type=number]::-webkit-inner-spin-button,
                input[type=number]::-webkit-outer-spin-button {
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    appearance: none;
                    margin: 0;
                }
            </style>
        </div> <!-- end card-body -->
    </div>
@endsection
@section('script')
{{-- <script>
    $(document).ready(function() {
        $('#region').change(function() {
            var regionId = $(this).val();
            if (regionId) {
                $.ajax({
                    url: "{{ route('prefectures') }}",
                    type: "GET",
                    data: {
                        region_id: regionId
                    },
                    success: function(data) {
                        $('#prefecture').empty();
                        $('#commune').empty();
                        $('#prefecture').append('<option value="">Sélectionnez une préfecture</option>');
                        $.each(data, function(key, value) {
                            $('#prefecture').append('<option value="' + value.id + '">' + value.nom + '</option>');
                        });
                    }
                });
            } else {
                $('#prefecture').empty();
                $('#commune').empty();
                $('#prefecture').append('<option value="">Sélectionnez une préfecture</option>');
            }
        });

        $('#prefecture').change(function() {
            var prefectureId = $(this).val();
            if (prefectureId) {
                $.ajax({
                    url: "{{ route('communes') }}",
                    type: "GET",
                    data: {
                        prefecture_id: prefectureId
                    },
                    success: function(data) {
                        $('#commune').empty();
                        $('#commune').append('<option value="">Sélectionnez une commune</option>');
                        $.each(data, function(key, value) {
                            $('#commune').append('<option value="' + value.nom + '">' + value.nom + '</option>');
                        });
                    }
                });
            } else {
                $('#commune').empty();
                $('#commune').append('<option value="">Sélectionnez une commune</option>');
            }
        });

    });
</script> --}}
@endsection
