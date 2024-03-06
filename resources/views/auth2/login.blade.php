
        <div class="card bg-pattern text-light bg-main text-xs-center ">
            <div class="card-body p-4">
                <div class="text-center w-75 m-auto">
                    <h3 class="mt-2 text-white">{{ __("Authentification") }}</h3>
                </div>

                @include('layouts.info')
                <form wire:submit.prevent="connexion">

                    <div class="form-group mb-3">
                        <label for="emailaddress">{{ __('Adresse e-mail') }}</label>
                        <input class="form-control" wire:model='email'  type="email" id="emailaddress" required="" placeholder="Entrer votre Email">
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">{{ __('Mot de passe') }}:</label>
                        <div class="input-group input-group-merge">
                            <input type="password" wire:model='password' id="password"  class="form-control" placeholder="Entrer votre mot de passe">
                            <div class="input-group-append" data-password="false">
                                <div class="input-group-text">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-center">
                        <button class="btn bg-gris-fonce btn-block" type="submit"> {{ __("Connexion") }}</button>
                    </div>
                </form>
                <div class="row mt-3">
                    <div class="col-md-12 text-center">
                        <p> <a  class="ms-1 text-center text-info" href="{{ route("mot_de_pass_oublier") }}" >Mot de passe oubliéee</a></p>
                        <p class="text-black text-center">Vous n'avez pas de compte ? <a   href="{{ route("inscription") }}" class="text-info ms-1 btn"><b>S'inscrire</b></a></p>

                    </div> <!-- end col -->
                </div>
            </div>
        </div>



