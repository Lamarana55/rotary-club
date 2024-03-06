<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{asset('css/app.css')}} ">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        @if(session('message_success'))
            <div class="alert  alert-success text-white">
                Merci, votre compte utilisateur sera activé par l'administrateur!!!
            </div>
        @endif
    <div class="card card-" >
        <div class="card-header text-center" style="background-color: #007481">
        <a href="#" class="h4 text-white" ><b>Mise à jour du mot de passe</b></a>
        </div>
        <p style="color: red;">{{ session('erreur') }}</p>
        <div class="card-body">

        @if(session('alerte_delete'))
            <div class="alert  alert-warning text-white">

            </div>
        @endif

        <form method="GET" action="{{ route('save_new_password',['email'=>$email]) }}" novalidate>
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
            <div class="nput-group mb-3 row" >

                <div class="col-12 mb-3">
                    <button type="submit" style="background-color: #007481" class=" form-control btn btn- text-white">Mise à jour</button>
                </div>
                <div class="col-6">
                    <a href="{{ route('login') }}"  class="" style="color: #007481">Connexion</a>
                </div>


            </div>

        </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    </div>
<script src="{{asset('js/app.js')}} "></script>
</body>
</html>
