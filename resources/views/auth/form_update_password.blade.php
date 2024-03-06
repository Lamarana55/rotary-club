@extends('layouts.login-master')
@section('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js">
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js">
</script>
@endsection
@section('content')
<div class="card bg-pattern text-light bg-main text-xs-center">
    <div class="card-body p-4">
        <div class="text-center w-75 m-auto">
            <h4 class="mt-2 text-white">{{ __("Mise à jour du mot de passe") }}</h4>
        </div>

        @include('layouts.info')
        <form method="GET" action="{{ route('save_new_password',['email'=>$email]) }}" novalidate>
            @csrf

            <div class="input-group mb-3">
                <input type="password" class="form-control @error('newpassword') is-invalid @enderror" name="newpassword" value="{{ old('newpassword') }}" required autocomplete="newpassword" placeholder="Nouveau mot de passe">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('newpassword')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control @error('confirmpassword') is-invalid @enderror" name="confirmpassword" value="{{ old('confirmpassword') }}" required autocomplete="confirmpassword" placeholder="conforme mot de passe">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('confirmpassword')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-0 text-center">
                <button class="btn bg-gris-fonce btn-block" type="submit"> {{ __("Mise à jour") }}</button>
            </div>
            <div class="col-6 mt-3">
                <p> <a href="{{route('login')}}" class="ms-1 text-center text-white">Connexion</a></p>
            </div>
        </form>
    </div>
</div>
@endsection
