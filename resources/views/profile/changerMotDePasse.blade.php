@extends('/../layouts.default')
@section('content')
<div class="d-flex justify-content-center">
    <div class="card ">
        <div class="card-header bg-gradient-light d-flex align-items-center">
            <h5 class="card-title"><i class="fa fa-user fa-1x"></i> Changer de mot de passe</h5>
        </div>
        <form action="ChangerMotDePasse" method="post">
            @method('put')
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Email :</label>

                    <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                    </div>
                        <input type="email" disabled name="email" value="{{auth()->user()->email ?? null}}" class="form-control @error('email') is-invalid @enderror">
                    </div>
                    @error("email")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Mot de passe actuel : <i class="text-danger">*</i> </label>

                            <div class="input-group">
                            <input type="password" id="password" name="mdpActuel" value="{{old('mdpActuel')}}" class="form-control @error('mdpActuel') is-invalid @enderror">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="cursor: pointer;" onclick="changer()"><i class="fa fa-eye"></i></span>
                            </div>
                            </div>
                            @error("mdpActuel")
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group ">
                            <label>Nouveau mot de passe : <i class="text-danger">*</i></label>

                            <div class="input-group">
                            <input type="password" id="newPassword" name="password" value="{{old('password')}}" class="form-control @error('password') is-invalid @enderror"><br>
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="cursor: pointer;" onclick="changerNew()"><i class="fa fa-eye"></i></span>
                            </div>
                            </div>
                            @error("password")
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group ">
                            <label>Confirmer : <i class="text-danger">*</i></label>

                            <div class="input-group">
                            <input type="password" id="confirmedPassword" name="password_confirmation" value="{{old('password_confirmation')}}" class="form-control @error('password_confirmation') is-invalid @enderror">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="cursor:pointer;" onclick="changerConfirmer()"><i class="fa fa-eye"></i></span>
                            </div>
                        </div>
                        @error("password_confirmation")
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="/profile" class="btn btn-danger">Annuler</a>
                <input type="submit" value="Sauvegarder" class="btn btn-primary float-right">
            </div>
        </form>
    </div>
</div>

<script>
    e=true;
    function changer(){
        if(e){
            document.getElementById('password').setAttribute('type','text');
            e=false;
        }else{
            document.getElementById('password').setAttribute('type','password');
            e=true;
        }
    }
    n=true
    function changerNew(){
        if(n){
            document.getElementById('newPassword').setAttribute('type','text');
            n=false;
        }else{
            document.getElementById('newPassword').setAttribute('type','password');
            n=true;
        }
    }
    c=true
    function changerConfirmer(){
        if(c){
            document.getElementById('confirmedPassword').setAttribute('type','text');
            c=false;
        }else{
            document.getElementById('confirmedPassword').setAttribute('type','password');
            c=true;
        }
    }
</script>
@endsection
