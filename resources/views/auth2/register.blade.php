
	<div class="card bg-pattern text-light bg-main text-xs-center">

        <div class="card-body">

            <div class="text-center w-75 m-auto">
                 <div class="auth-logo">
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
                </div>
                <h2 class="mt-2 text-white">Création de compte</h2>

            </div>
            @if (session()->has('message'))
                <div class="alert alert-warning">
                    {{ session('message') }}
                </div>
            @endif
            <form wire:submit.prevent="save_inscription">


                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group mb-3">
                            <label >{{ __("Prénom(s)") }}*</label>
                            <input type="text" wire:model='prenom'  placeholder="Entrez votre prénom" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ old('prenom') }}" autocomplete="prenom" >

                            @error('prenom')
                                <span class="invalid-feedback text-white" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label >{{ __('Nom') }}*</label>
                            <input wire:model='nom' class="form-control @error('nom') is-invalid @enderror" value="{{ old("nom") }}" name="nom" type="text"  placeholder="Votre nom">
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
                            <label >{{ __("Adresse e-mail") }}*</label>
                            <input wire:model="email_promoteur" class="form-control @error('email_promoteur') is-invalid @enderror" value="{{ old("email_promoteur") }}" name="email_promoteur" type="text"  placeholder="Votre email_promoteur">
                            @error('email_promoteur')
                                <span class="invalid-feedback text-white" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label >{{ __('Numéro de téléphone') }}*</label>
                            <input wire:model='telephone' class="form-control @error('telephone') is-invalid @enderror" id="phone" value="{{ old("telephone") }}" name="telephone" type="text"  placeholder="Votre numéro de téléphone">
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
                            <label for="">Genre*</label>
                            <select wire:model='genre' name="genre" class="form-control @error('genre') is-invalid @enderror">
                                <option value="" selected>Selectionner</option>
                                <option value="Masculin">Masculin</option>
                                <option value="Féminin">Féminin</option>
                            </select>
                            @error('genre')
                                <span class="invalid-feedback text-white" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Profession</label>
                            <input wire:model='profession' class="form-control" name="profession" value="{{ old("profession") }}" type="text" placeholder="Votre profession">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Commune</label>
                            <input wire:model='commune' class="form-control" value="{{ old("commune") }}" name="commune" type="text" placeholder="Votre commune">
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label >{{ __('Adresse') }}*</label>
                            <input wire:model='adresse' class="form-control @error('adresse') is-invalid @enderror" value="{{ old("adresse") }}" name="adresse" type="text"  placeholder="Votre adresse(quartier...)">
                            @error('adresse')
                                <span class="invalid-feedback text-white" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Statut du promoteur*</label>
                            <select wire:model='categorie' name="categorie" class="form-control @error('categorie') is-invalid @enderror">
                                <option value="">Selectionner un status</option>
                                @foreach ($categories as $categorie)
                                    @if (old('categorie')==$categorie->id)
                                    <option value="{{$categorie->id}} " selected>{{$categorie->nom}} </option>
                                    @else
                                    <option value="{{$categorie->id}} ">{{$categorie->nom}} </option>
                                    @endif

                                @endforeach
                            </select>
                            @error('categories')
                                <span class="invalid-feedback text-white" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
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
        </div> <!-- end card-body -->
    </div>

