@extends('layouts.login-master', ['verify' => true])

@section('content')
	<div class="card bg-pattern text-light bg-main text-xs-center">

        <div class="card-body p-4">

            <div class="text-center w-75 m-auto">
                <div class="auth-logo">
                    {{-- <a href="/" class="logo logo-dark text-center">
                        <span class="logo-lg">
                            <img src="{{ asset('backend/assets/images/gn.png') }}" alt="" height="80">
                        </span>
                    </a>

                    <a href="/" class="logo logo-light text-center">
                        <span class="logo-lg">
                            <img src="{{ asset('backend/assets/images/gn.png') }}" alt="" height="80">
                        </span>
                    </a> --}}
                </div>
                <h4 class="mt-2 text-white">
                    Réinitialisez votre mot de passe
                </h4>

            </div>

            @include('layouts.info')

            <form method="POST" action="{{ route('save_email') }}">
                @csrf
                <div class="form-group mb-3">
                    <label for="emailaddress">{{ __('Adresse e-mail') }}:</label>
                    <input class="form-control" name="email" type="email" value="{{ old("email") }}" id="emailaddress" required="" placeholder="Entrer votre adresse email">
                </div>

                <div class="form-group mb-0 text-center">
                    <button class="btn bg-gris-fonce btn-block" type="submit"> {{ __("Valider") }}</button>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12 text-center">
                        <p class="text-black text-center">Avez-vous déjà un compte ? <a href="{{ route("login") }}" class="text-info ms-1" style="color: inherit;"><b>Connectez-vous</b></a></p>
                    </div> <!-- end col -->
                </div>

            </form>


        </div> <!-- end card-body -->
    </div>
@endsection
