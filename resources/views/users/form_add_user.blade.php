@extends('/../layouts.default')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-dark">
          <div class="card-header">

                <h3 class="card-title"> <a href="{{url('utilisateur')}} " class="btn btn-primary" style="border-radius: 100%"><i class="fa fa-reply-all"></i></a> Enrégistrement d'un utilisateur</h3>
          </div>
          <form action="{{route('insertion')}}" method="post" enctype="multipart/form-data">
            @method('post')
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="nom">Nom <i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="nom" name="nom" value="{{old('nom')}}" placeholder="Entre nom">
                            @if($errors)
                            @error('nom')
                                <p class="text-danger"> {{$message}} </p>
                            @enderror
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom <i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="{{old('prenom')}}" placeholder="Entre prénom">
                            @if($errors)
                            @error('prenom')
                                <p class="text-danger"> {{$message}} </p>
                            @enderror
                          @endif
                        </div>
                        <div class="form-group">
                            <label for="mail">Email <i class="text-danger">*</i></label>
                            <input type="email" class="form-control" id="mail" name="email" value="{{old('email')}}" placeholder="Enter email">
                            @if($errors)
                            @error('email')
                                <p class="text-danger"> {{$message}} </p>
                            @enderror
                          @endif
                        </div>
                        <div class="form-group">
                            <label for="telephone">Téléphone <i class="text-danger">*</i></label>
                            <input type="tel" class="form-control" id="telephone" name="telephone" value="{{old('telephone')}}" placeholder="Enter téléphone">
                            @if($errors)
                            @error('telephone')
                                <p class="text-danger"> {{$message}} </p>
                            @enderror
                          @endif
                        </div>
                        <div class="form-group">
                            <label for="role">Rôles <i class="text-danger">*</i></label>
                            @isset($promoteur)
                              <select name="role" class="form-control" id="role">
                                <option value="2" selected>Promoteur</option>
                              </select>
                            @else
                              <select name="role" class="form-control" id="role" value="{{old('role')}}">
                                <option value="">Selectionnez...</option>
                                @foreach($role as $item)
                                <?php $item_var = $item->nom;
                                if($item_var !==  "Promoteur"):?>
                                    <option value="{{$item -> id_role}}">{{$item->nom}}</option>
                                <?php endif; ?>
                                @endforeach
                              </select>
                            @endisset
                            @if($errors)
                            @error('role')
                              <p class="text-danger"> {{$message}} </p>
                            @enderror
                          @endif
                        </div>
                        <div class="form-group">
                            <label for="adresse">Adresse <i class="text-danger">*</i></label>
                            <input type="text" class="form-control" id="adresse" name="adresse" value="{{old('adresse')}}" placeholder="Entre adresse">
                            @if($errors)
                            @error('adresse')
                                <p class="text-danger"> {{$message}} </p>
                            @enderror
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Enregistrer </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
    @if(session()->has('success'))
        Swal.fire(
      "{{ session()->get('success') }}",
      '',
      'success'
    )
    @endif
    </script>
@endsection
