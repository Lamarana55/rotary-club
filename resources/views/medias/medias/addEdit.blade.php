<div>
<style>
    .iti--allow-dropdown input, .iti--allow-dropdown input[type=text] {
        padding-right: 0px;
        width: 100%;
    }

    .intl-tel-input{
        width: 100%;
    }

    .iti {
        width: 100%;
    }

    .iti__country-name {
        color: black !important;
    }
</style>
<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="d-flex">
            <div class=" my-2 p-3 flex-grow-1 row">
                <div class="col-md-9">
                    <div class="row">
                        <input type="hidden" wire:model='type' value="{{$type}}">
                        <div class="form-group col-md-6">
                            <label for="">Type de média <i class="text-danger">*</i> </label>
                            <select wire:model.lazy='type_media'
                                class="form-control @error('type_media') is-invalid @enderror">
                                <option value="" selected>--Sélectionner-- </option>
                                @foreach($type_medias as $item)
                                <option value="{{$item->nom}}" wire:key="{{$item->id}}">{{$item->nom}}</option>
                                @endforeach
                            </select>
                            @error("type_media")
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Nom du média <i class="text-danger">*</i> </label>
                            <input wire:model.lazy='nom' type="text" value="" placeholder="Votre nom du média"
                                class="form-control @error('nom') is-invalid @enderror">

                            @error("nom")
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Email <i class="text-danger">*</i> </label>
                            <input wire:model.lazy='email' type="text" placeholder="Votre email" value=""
                                class="form-control @error('email') is-invalid @enderror">

                            @error("email")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <div wire:ignore>
                                <label for="">Téléphones <i class="text-danger">*</i> </label>
                                <input wire:model.lazy='telephone' type="number" step="0.01" id="phone" placeholder="Votre numéro de téléphone" class="form-control @error('telephone') is-invalid @enderror">
                            </div>
                            @error("telephone")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="">Forme Juridique<i class="text-danger">*</i> </label>
                            <select wire:model.lazy='forme_juridique'
                                class="form-control @error('forme_juridique') is-invalid @enderror">
                                <option value="">Selectionner</option>
                                @foreach($forme_juridiques as $key=> $item)
                                @if($media !=null && $media->id == $item->id)
                                <option selected value="{{$item->nom}}">{{$item->nom}} </option>
                                @else
                                <option value="{{$item->nom}} ">{{$item->nom}} </option>
                                @endif
                                @endforeach
                            </select>
                            @error("forme_juridique")
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Sigle </label>
                            <input wire:model.lazy='sigle' type="text" placeholder="Votre sigle" value=""
                                class="form-control @error('sigle') is-invalid @enderror">
                            @error("sigle")
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-2">
                        <div class="px-3 div_logo">
                            <label for="logo">
                                <div class="file-input" id="imageName"
                                    style="border: 1px solid #d0d1d3; border-radius: 20px; height: 200px; width:200px; overflow:hidden;">
                                    <input wire:model.lazy='logo' id="logo"
                                        accept="image/png, image/jpeg, image/jpg, image/gif"
                                        style="display: none" type="file" />
                                    @if($logo)
                                    <img style="height: 200px; width:200px;"
                                        src="{{(is_string($logo))?asset($logo):asset($logo->temporaryUrl())}}">
                                    @else
                                    <img style="height: 200px; width:200px;" src="{{asset('logo-google.png')}}">
                                    @endif
                                    <span id="imageName"></span>
                                </div>
                            </label>
                            <div id="div" class="px-3 icon_photo">
                                <span id="photolien"></span>
                                <label for="logo" class="photo"> <i class="fa fa-1x fa-camera"></i>
                                </label>
                            </div>
                        </div>
                        @error("logo")
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="">Région <i class="text-danger">*</i></label>
                            <select class="form-control" wire:model="region">
                                <option value="">Sélectionnez une région</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->nom }}</option>
                                @endforeach
                            </select>
                            @error('region')
                                <span class="text-danger"> {{$message}} </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="">Préfecture <i class="text-danger">*</i></label>
                            <select class="form-control" wire:model="prefecture">
                                <option value="">Sélectionnez une préfecture</option>
                                @foreach ($prefectures as $item)
                                <option value="{{$item->id}}">{{$item->nom}} </option>
                                @endforeach
                            </select>
                            @error('prefecture')
                                <span class="text-danger"> {{$message}} </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="">Communne <i class="text-danger">*</i></label>
                            <select class="form-control" wire:model="commune">
                                <option value="">Sélectionnez une commune</option>
                                @foreach ($communes as $item)
                                <option value="{{$item->id}}">{{$item->nom}} </option>
                                @endforeach
                            </select>
                            @error('commune')
                                <span class="text-danger"> {{$message}} </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label for="">Description<i class="text-danger">*</i> </label>
                    <textarea wire:model.lazy='description' data-autoresize  cols="20" row ="2"  placeholder="Description ..."  value="" class="form-control text-resize @error('description') is-invalid @enderror"> </textarea>
                    @error("description")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <button type="button" class="btn btn-danger" data-dismiss="modal" wire:click='resetForm' >Fermer </a>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary float-right" >{{!$isAdd ? 'Modifier' : 'Enregistrer'}} </button>
            </div>
        </div>
    </div>
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0;
        }
    </style>
</form>
<script type="text/javascript">
    $(document).ready(function (e) {
       $('#logo').change(function(){
        let reader = new FileReader();
        reader.onload = (e) => {
          $('#preview-image-before-upload').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
       });
    });

    $("textarea").keyup(function () {

        addAutoResize()
    });

    function addAutoResize() {
        document.querySelectorAll('[data-autoresize]').forEach(function (element) {
            element.style.boxSizing = 'border-box';
            var offset = element.offsetHeight - element.clientHeight;
            element.style.height = 'auto';
            element.style.height = element.scrollHeight + offset + 'px';

            element.addEventListener('input', function (event) {
            event.target.style.height = 'auto';
            event.target.style.height = event.target.scrollHeight + offset + 'px';
            });

            element.removeAttribute('data-autoresize');
        });
    }

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
