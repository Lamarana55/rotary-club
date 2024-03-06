<div class="card">
    <div class="card-header bg-light d-flex align-items-center">
        <h5 class="card-title">Creation d'un utilisateur </h5>
    </div>
    <form wire:submit.prevent="ajoutUser">
        <div class="card-body">
            <div class="d-flex">
                <div class=" my-4 p-3 flex-grow-1">
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label >Nom:*</label>
                            <input type="text" wire:model="nom" class="form-control @error('nom') is-invalid @enderror">

                            @error("nom")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group flex-grow-1">
                            <label >Prénom:*</label>
                            <input type="text" wire:model="prenom" class="form-control @error('prenom') is-invalid @enderror">

                            @error("prenom")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Email:*</label>
                            <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror">

                            @error("email")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group   ">
                            <label for="" >Téléphone:*</label> <br>
                            <input id="phone" type="number" style="width: 560px" step="0.01" wire:model="telephone" class="form-control @error('telephone') is-invalid @enderror">

                            @error("telephone")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Adresse:</label>
                            <input type="text" wire:model="adresse" class="form-control @error('adresse') is-invalid @enderror">

                            @error("adresse")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Role:</label>
                            <select wire:model="role" class="form-control @error('role') is-invalid @enderror">
                                <option value="">Selectione un role</option>
                                @foreach ($roles as $item)
                                <option value="{{$item->id}} ">{{$item->nom}} </option>
                                @endforeach

                            </select>
                            @error("role")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @if($role ==2)
                        <div class="form-group flex-grow-1">
                            <label for="">Catégorie Promoteur:</label>
                            <select wire:model="categoriePromoteur" class="form-control @error('categoriePromoteur') is-invalid @enderror">
                                <option value="">Selectionnez une catégorie</option>
                                @foreach ($categoriesPromoteur as $categorie)
                                <option value="{{$categorie->id}} ">{{$categorie->nom}} </option>
                                @endforeach

                            </select>
                            @error("categoriePromoteur")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endif
                    </div>

                    <div class="row mt-5">
                        <div class="col-md-6">
                            @if(request()->path() == 'add-utilisateurs' || request()->path()=='livewire/message/add-utilisateur')
                            <a href="{{route('utilisateur')}}" class="btn btn-danger">Fermer </a>
                            @else
                            <button type="button" class="btn btn-danger" wire:click="goToListUtilisateur">Fermer </button>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if (hasPermission('créer_utilisateur') )
                                <button type="submit" class="btn btn-primary float-right" >Enregistrer</button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

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
</div>
<script>
    window.addEventListener("showSuccessMessage", event=>{
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            toast:true,
            title: event.detail.message || "Opération effectuée avec succès!",
            showConfirmButton: false,
            timer: 5000
            }
        )
    })

    window.addEventListener("showErrorMessage", event=>{
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            toast:true,
            title: event.detail.message || "Opération effectuée avec succès!",
            showConfirmButton: false,
            timer: 5000
            }
        )
    })
</script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>
<script>
  var input = document.querySelector("#phone");
  window.intlTelInput(input, {
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/utils.js",
    initialCountry: 'gn',
    placeholderNumberType: 'MOBILE',
    separateDialCode: true,
    onlyCountries: ['gn'],
  });
</script>
