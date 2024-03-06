@extends('layouts.default')
<?php $userIds = [] ?>
@section('page')
Rédaction du rapport de la commission pour le media : {{ $media->nom_media }}
@endsection
@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
  <style>
    fieldset.scheduler-border {
      border: 1px groove #e5e0e05e !important;
      padding: 0 1.4em 1.4em 1.4em !important;
      border-radius: 5px;
      margin: 0 0 1.5em 0 !important;
      -webkit-box-shadow: 0px 0px 0px 0px #e5e0e05e;
      box-shadow: 0px 0px 0px 0px #e5e0e05e;
      margin-top: 30px !important;
    }

    legend.scheduler-border {
      font-size: 1.2em !important;
      font-weight: bold !important;
      text-align: left !important;
      width: auto;
      padding: 0 10px;
      border-bottom: none;
      margin-top: -15px;
      background-color: white;
      color: #007481;
    }
    label {
      color: #00000085;
      font-weight:none;
      font-size: 10pt;
    }
  </style>
@endsection
@section('content')
<form action="{{ route('post-redaction-rapport-commission')}}" method="post">
  @csrf
  <div class="row">
    <div class="col-md-4">
      <div class="card card-default">
        <div class="card-body">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td> <strong>Nom du média: </strong></td>
                <td> {{ $media->nom_media }} </td>
              </tr> 
              <tr>
                <td> <strong>Nom du promoteur: </strong></td>
                <td> {{ $media->user->nom }} {{ $media->user->prenom }} </td>
              </tr>
              <tr>
                <td> <strong>Rapporteur: </strong></td>
                <td> {{ $rapporteur->nom }} {{ $rapporteur->prenom }} </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  
    @if($type_commission == 'hac')
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header"><h1 class="card-title">Membres de la commission</h1></div>
            <input type="hidden" name="media_id" value="{{ $media->id_media }}"/>
            <input type="hidden" name="type_commission" value="HAC"/>
            <div class="card-body">
              @if($membre_hac_commissions->count() > 0)
                <div class="form-group form-check">
                  <input type="checkbox" name="member" class="form-check-input" id="exampleCheck_all" onClick="toggle(this)" />
                  <label class="form-check-label" for="exampleCheck_all" >Tout cocher</label>
                </div>
              @endif
              <table class="table table-bordered">
                <tbody>
                  @if($membre_hac_commissions->count() > 0)
                    @foreach( $membre_hac_commissions as $member)
                      <tr>
                        <td>
                          <div class="form-group form-check">
                            <input type="checkbox" name="member[]" value="{{$member->id}}" class="form-check-input" id="exampleCheck_{{$member->id}}" {{ checkedMemberForRapport($member->id,$media->id_media) ? 'checked' : '' }} />
                            <label class="form-check-label" for="exampleCheck_{{$member->id}}" >{{ $member->full_name }}</label>
                          </div>
                        </td>
                        <td>
                          {{ $member->fonction_occupe }}
                        </td>
                      </tr>
                    @endforeach
                  @else
                    <div class="alert alert-warning">
                      Les membres de la commission technique doivent être ajouté dépuis le compte administrateur
                    </div>
                  @endif
                </tbody>
              </table>
            </div>
        </div>
      </div>
    @endif

  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body table-responsive">
            <input type="hidden" name="id_media" value="{{$media->id_media}}" />
            
            @if($type_commission == 'hac')
              <input type="hidden" name="dossier_hac_id" value="{{request()->get('dossier_hac_id')}}" />
            @endif

            <input type="hidden" name="type_commission" value="{{$type_commission}}" />
            @if($type_commission != 'hac')
              <fieldset class="scheduler-border">
                <legend class="scheduler-border">Commission</legend>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="input-form-group-forme-date_debut">Date début <i class="text-danger">*</i></label>
                    @if(old('date_debut'))
                      <input type="date" name="date_debut" value="{{$rapport_commission ? explode(' ', $rapport_commission->date_debut)[0] : old('date_debut') }}" class="form-control"/>
                    @else
                      <input type="date" name="date_debut" value="{{$rapport_commission ? explode(' ', $rapport_commission->date_debut)[0] : explode(' ',\Carbon\Carbon::now())[0] }}" class="form-control"/>
                    @endif
                    @if($errors)
                      @error('date_debut')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div> 
                  <div class="form-group col-md-3">
                    <label for="input-form-group-forme-heure_fin">Heure début <i class="text-danger">*</i></label>
                    <input type="time" name="heure_debut" value="{{$rapport_commission ?  $rapport_commission->heure_debut : old('heure_debut') }}" class="form-control"/>
                    @if($errors)
                      @error('heure_debut')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                  <div class="form-group col-md-3">
                    <label for="input-form-group-forme-date-fin">Date fin <i class="text-danger">*</i></label>
                    @if(old('date_debut'))
                    <input type="date" name="date_fin" value="{{$rapport_commission ? explode(' ', $rapport_commission->date_fin)[0] : old('date_fin') }}" class="form-control"/>
                    @else
                    <input type="date" name="date_fin" value="{{$rapport_commission ? explode(' ', $rapport_commission->date_fin)[0] : explode(' ',\Carbon\Carbon::now())[0] }}" class="form-control"/>
                    @endif
                    @if($errors)
                      @error('date_fin')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                  <div class="form-group col-md-3">
                    <label for="input-form-group-forme-heure-fin">Heure fin <i class="text-danger">*</i></label>
                    <input type="time" name="heure_fin" value="{{$rapport_commission ? $rapport_commission->heure_fin : old('heure_fin') }}" class="form-control"/>
                    @if($errors)
                      @error('heure_fin')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="input-form-group-present">Nombre de présent <i class="text-danger">*</i></label>
                    <input class="form-control" name="nombre_present" disabled value="{{ count($member_rapport_commissions) }}" id="input-form-group-present" type="number" placeholder=""/>
                    @if($errors)
                      @error('nombre_present')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                </div>
              </fieldset>
            @endif

            
            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Forme juridique </legend>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="input-form-group-forme-jurique">Forme juridique <i class="text-danger">*</i></label>
                  <input type="text" name="forme_juridique" class="form-control" value="{{ $media->forme_juridique->libelle }}" readonly/>
                  @if($errors)
                    @error('forme_juridique')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                  @endif
                </div>
              </div>
            </fieldset>
    
            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Capital social</legend>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="input-form-group-capital-social">Norme du cahier des charges <i class="text-danger">*</i></label>
                  <select name="capital_social" id="input-form-group-forme-jurique" class="form-control">
                    <option value="">--Selectionner--</option>
                    @if($rapport_commission && $rapport_commission->capital_social == 'Illimité')
                      <option value="Illimité" selected >Illimité</option>
                    @else
                      <option value="Illimité" {{ old('capital_social') == 'Illimité' ? 'selected' : '' }} >Illimité</option>
                    @endif
                    @if($rapport_commission && $rapport_commission->capital_social == 'Limité')
                      <option value="Limité"  selected >Limité</option>
                    @else
                      <option value="Limité" {{ old('capital_social') == 'Limité' ? 'selected' : ''}} >Limité</option>
                    @endif
                  </select>
                  @if($errors)
                    @error('capital_social')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                  @endif
                </div>
                <div class="form-group col-md-4">
                  <label for="input-form-group-capital">Montant <i class="text-danger">*</i></label>
                  <input class="form-control" name="capital_montant" value="{{$rapport_commission ? $rapport_commission->capital_montant : old('capital_montant') }}" id="input-form-group-capital" type="number" min="1" placeholder="Capital"/>
                  @if($errors)
                    @error('capital_montant')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                  @endif
                </div>
                <div class="form-group col-md-2">
                  <label for="input-form-group-unite">Unité <i class="text-danger">*</i></label>
                  <select name="capital_unite" id="input-form-group-unite" class="form-control">
                    <option value="">--Selectionner--</option>
                    @if($rapport_commission && $rapport_commission->capital_unite == 'Million(s)')
                      <option value="Million(s)" selected >Million(s)</option>
                    @else
                      <option value="Million(s)" {{ old('capital_unite') == 'Million(s)' ? 'selected': '' }}>Million(s)</option>
                    @endif
                    @if($rapport_commission && $rapport_commission->capital_unite == 'Milliard(s)')
                      <option value="Milliard(s)" selected >Milliard(s)</option>
                    @else
                      <option value="Milliard(s)" {{ old('capital_unite') == 'Milliard(s)' ? 'selected' : '' }} >Milliard(s)</option>
                    @endif
                  </select>
                  @if($errors)
                    @error('capital_unite')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                  @endif
                </div>
              </div> 
            </fieldset>
            
            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Nombre de part </legend>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="input-form-group-capital-social">Norme du cahier des charges <i class="text-danger">*</i></label>
                  <select name="nombre_depart" id="input-form-group-nombre_depart" class="form-control">
                    <option value="">--Selectionner--</option>
                    @if($rapport_commission && $rapport_commission->nombre_depart == 'Illimité') 
                      <option value="Illimité" selected>Illimité</option>
                    @else
                      <option value="Illimité" {{ old('nombre_depart') == 'Illimité' ? 'selected' : '' }}>Illimité</option>
                    @endif
                    @if($rapport_commission && $rapport_commission->nombre_depart == 'Limité')
                      <option value="Limité"  selected>Limité</option>
                    @else
                      <option value="Limité" {{ old('nombre_depart') == 'Limité' ? 'selected' : '' }} >Limité</option>
                    @endif
                  </select>
                  @if($errors)
                    @error('nombre_depart')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                  @endif
                </div>
                <div class="form-group col-md-6">
                  <label for="input-form-group-nombre_part_value">Valeur <i class="text-danger">*</i></label>
                  <input class="form-control" name="nombre_part_value" id="input-form-group-nombre_part_value" value="{{$rapport_commission ? $rapport_commission->nombre_part_value : old('nombre_part_value') }}" type="number" min="1" placeholder="Nombre"/>
                  @if($errors)
                    @error('nombre_part_value')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                  @endif
                </div>
              </div>
            </fieldset>
            
            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Pourcentage réservé aux investisseurs locaux</legend>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="input-form-group-capital-social">Opérateur de comparaison :  <i class="text-danger">*</i></label>
                  <select name="pourcentage_investisseur_signe" id="input-form-group-nombre_depart" class="form-control">
                    <option value="">--Selectionner--</option>
                    @if($rapport_commission && $rapport_commission->pourcentage_investisseur_signe == '<=') 
                      <option value="<=" selected> <= </option>
                    @else
                      <option value="<=" {{ old('pourcentage_investisseur_signe') == '<=' ? 'selected' : ''}}> <= </option>
                    @endif
                    @if($rapport_commission && $rapport_commission->pourcentage_investisseur_signe == '>=') 
                      <option value=">=" selected> >= </option>
                    @else
                      <option value=">=" {{ old('pourcentage_investisseur_signe') == '>=' ? 'selected' : '' }}> >= </option>
                    @endif
                    @if($rapport_commission && $rapport_commission->pourcentage_investisseur_signe == '<') 
                      <option value="<" selected > < </option>
                    @else
                      <option value="<" {{ old('pourcentage_investisseur_signe') == '<' }}> < </option>
                    @endif
                    @if($rapport_commission && $rapport_commission->pourcentage_investisseur_signe == '>') 
                      <option value=">" selected > > </option>
                    @else
                      <option value=">"{{ old('pourcentage_investisseur_signe') == '>' }} > > </option>
                    @endif
                    @if($rapport_commission && $rapport_commission->pourcentage_investisseur_signe == '=')
                      <option value="=" selected> = </option>
                    @else
                      <option value="="  {{ old('pourcentage_investisseur_signe') == '=' }} > = </option>
                    @endif
                  </select>
                  @if($errors)
                    @error('pourcentage_investisseur_signe')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                  @endif
                </div>
                <div class="form-group col-md-3">
                  <label for="input-form-group-pourcentage_investisseur_label_value">Indice de comparaison  <i class="text-danger">*</i></label>
                  <input class="form-control" name="pourcentage_investisseur_label_value" value="{{ $rapport_commission  ? $rapport_commission->pourcentage_investisseur_label_value : 0  }}" id="input-form-group-pourcentage_investisseur_label_value" type="number" min="0" placeholder="Nombre"/>
                  @if($errors)
                    @error('pourcentage_investisseur_label_value')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                  @endif
                </div> 
                <div class="form-group col-md-6">
                  <label for="input-form-group-pourcentage">Valeur en pourcentage  <i class="text-danger">*</i></label>
                  <input class="form-control" name="pourcentage_investisseur_value" value="{{ $rapport_commission  ? $rapport_commission->pourcentage_investisseur_value : old('pourcentage_investisseur_value')  }}" id="input-form-group-pourcentage_value" type="number" min="0" placeholder="Nombre"/>
                  @if($errors)
                    @error('pourcentage_investisseur_value')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                  @endif
                </div>
              </div>
            </fieldset>
            
            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Nombre de Certificat de nationalités des principaux dirigeants</legend>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="input-form-group-nombre_certificat_resident"> Norme du cahier des charges </label>
                  <input type="text" class="form-control" disabled value="{{'(1 à 3 )'}}"/>
                </div>
                <div class="form-group col-md-6">
                  <label for="input-form-group-nombre_certificat">Nombre  <i class="text-danger">*</i></label>
                  <select name="nombre_certificat" id="input-form-group-nombre_certificat" class="form-control">
                    <option value="">--Selectionner--</option>
                    @if($rapport_commission && $rapport_commission->nombre_certificat == "1")
                      <option value="1" selected >1</option>
                    @else
                      <option value="1" {{ old('nombre_certificat') == '1' ? 'selected' : '' }} >1</option>
                    @endif
                    @if($rapport_commission && $rapport_commission->nombre_certificat == "2") 
                      <option value="2" selected>2</option>
                    @else
                      <option value="2" {{ old('nombre_certificat') == '2' ? 'selected' : '' }}  >2</option>
                    @endif
                    @if($rapport_commission && $rapport_commission->nombre_certificat == "3")
                      <option value="3" selected >3</option>
                    @else
                      <option value="3" {{ old('nombre_certificat') == '3' ? 'selected' : '' }}>3</option>
                    @endif
                  </select>
                  @if($errors)
                    @error('nombre_certificat')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                  @endif
                </div>
                
              </div>
            </fieldset>

            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Nombre de Certificat de résidence des principaux dirigeants </legend>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="input-form-group-nombre_certificat_resident"> Norme du cahier des charges </label>
                  <input type="text" class="form-control" disabled value="{{'(1 à 3 )'}}"/>
                </div>
                <div class="form-group col-md-6">
                  <label for="input-form-group-nombre_certificat_resident"> Nombre  <i class="text-danger">*</i></label>
                  <select name="nombre_certificat_resident" id="input-form-group-nombre_certificat_resident" class="form-control">
                    <option value="">--Selectionner--</option>
                    @if($rapport_commission && $rapport_commission->nombre_certificat_resident == "1") 
                      <option value="1" selected >1</option>
                    @else
                      <option value="1" {{ old('nombre_certificat_resident') == '1' ? 'selected' : '' }}  >1</option>
                    @endif
                    @if($rapport_commission && $rapport_commission->nombre_certificat_resident == "2") 
                      <option value="2" selected >2</option>
                    @else
                      <option value="2" {{ old('nombre_certificat_resident') == '2' ? 'selected': '' }} >2</option>
                    @endif
                    @if($rapport_commission && $rapport_commission->nombre_certificat_resident == "3")
                      <option value="3" selected >3</option>
                    @else
                      <option value="3" {{ old('nombre_certificat_resident') == '3' ? 'selected' : '' }} >3</option>
                    @endif
                  </select>
                  @if($errors)
                    @error('nombre_certificat_resident')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                  @endif
                </div>
              </div>
            </fieldset> 
            
            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Nombre de casiers judiciaires des principaux dirigeants</legend>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="input-form-group-nombre_certificat_casier_dirigeant"> Norme du cahier des charges </label>
                  <input type="text" class="form-control" disabled value="{{'(1 à 3 )'}}"/>
                </div>
                <div class="form-group col-md-6">
                  <label for="input-form-group-nombre_certificat_casier_dirigeant">Nombre  <i class="text-danger">*</i></label>
                  <select name="nombre_certificat_casier_dirigeant" id="input-form-group-nombre_certificat_casier_dirigeant" class="form-control">
                    <option value="">--Selectionner--</option>
                    @if($rapport_commission && $rapport_commission->nombre_certificat_casier_dirigeant == "1")
                      <option value="1" selected >1</option>
                    @else
                      <option value="1" {{ old('nombre_certificat_casier_dirigeant') == "1" ? 'selected' : '' }} >1</option>
                    @endif
                    @if($rapport_commission && $rapport_commission->nombre_certificat_casier_dirigeant == "2")
                      <option value="2" selected >2</option>
                    @else
                      <option value="2" {{ old('nombre_certificat_casier_dirigeant') == "2" ? 'selected' : '' }} >2</option>
                    @endif
                    @if($rapport_commission && $rapport_commission->nombre_certificat_casier_dirigeant == "3")
                      <option value="3" selected >3</option>
                    @else
                      <option value="3" {{ old('nombre_certificat_casier_dirigeant') == '3' ? 'selected' : '' }} >3</option>
                    @endif
                  </select>
                  @if($errors)
                    @error('nombre_certificat_casier_dirigeant')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                  @endif
                </div>
              </div>
            </fieldset>
            
            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Nombre de diplôme des journalistes qualifiés</legend>
              <div class="form-row">
              <div class="form-group col-md-6">
                  <label for="input-form-group-nombre_journaliste"> Norme du cahier des charges  <i class="text-danger">*</i></label>
                  <input class="form-control" name="nombre_journaliste" value="{{3}}" max="3" disabled id="input-form-group-nombre_journaliste" type="number" min="0" placeholder="Nombre"/>
                </div>
                <div class="form-group col-md-6">
                  <label for="input-form-group-nombre_journaliste"> Nombre  <i class="text-danger">*</i></label>
                  <input class="form-control" name="nombre_journaliste" value="{{$rapport_commission ? $rapport_commission->nombre_journaliste : old('nombre_journaliste') }}" id="input-form-group-nombre_journaliste" type="number" min="0" placeholder="Nombre"/>
                  @if($errors)
                    @error('nombre_journaliste')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                  @endif
                </div>
              </div>
            </fieldset>
        
            @if($type_commission != 'hac')
              <fieldset class="scheduler-border">
                <legend class="scheduler-border">Nombre de diplôme de techniciens professionnels</legend>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="input-form-group-nombre_diplome_technicien"> Norme du cahier des charges  <i class="text-danger">*</i></label>
                    <input class="form-control" value="2" disabled id="input-form-group-pourcentage_value" type="number" min="0" placeholder="Nombre"/>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="input-form-group-nombre_diplome_technicien"> Nombre  <i class="text-danger">*</i></label>
                    <input class="form-control" name="nombre_diplome_technicien" value="{{$rapport_commission ? $rapport_commission->nombre_diplome_technicien : old('nombre_diplome_technicien') }}" id="input-form-group-pourcentage_value" type="number" min="0" placeholder="Nombre"/>
                    @if($errors)
                      @error('nombre_diplome_technicien')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                </div>
              </fieldset>
              
              <fieldset class="scheduler-border">
                <legend class="scheduler-border">Chaine et public cible</legend>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="input-form-group-categorie_chaine">Catégorie de la chaine  <i class="text-danger">*</i></label>
                    <select name="categorie_chaine" id="input-form-group-categorie_chaine" class="form-control">
                      <option value="">--Selectionner--</option>
                      @if($rapport_commission && $rapport_commission->categorie_chaine == 'Commerciale')
                        <option value="Commerciale"  selected>Commerciale</option>
                      @else
                        <option value="Commerciale" {{ old('categorie_chaine')  == 'Commerciale' ? 'selected' : '' }} >Commerciale</option>
                      @endif
                      @if($rapport_commission && $rapport_commission->categorie_chaine == 'Communautaire')
                        <option value="Communautaire"  selected >Communautaire</option>
                      @else
                        <option value="Communautaire" {{ old('categorie_chaine') == 'Communautaire' ? 'selected' : '' }} >Communautaire</option>
                      @endif
                    </select>
                    @if($errors)
                      @error('categorie_chaine')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                  <div class="form-group col-md-3">
                    <label for="input-form-group-orientation-chaine">Orientation de la chaine  <i class="text-danger">*</i></label>
                    <select name="orientation_chaine" id="input-form-group-orientation-chaine" class="form-control">
                      <option value="">--Selectionner--</option>
                      @if($rapport_commission && $rapport_commission->orientation_chaine == 'Généraliste')
                      <option value="Généraliste" selected >Généraliste</option>
                      @else
                      <option value="Généraliste" {{ old('orientation_chaine') == 'Généraliste' ? 'selected' : '' }} >Généraliste</option>
                      @endif
                      @if($rapport_commission && $rapport_commission->orientation_chaine == 'Thématique')
                      <option value="Thématique"  selected >Thématique</option>
                      @else
                      <option value="Thématique"  {{ old('orientation_chaine') == 'Thématique' ? 'selected' : '' }} >Thématique</option>
                      @endif
                    </select>
                    @if($errors)
                      @error('orientation_chaine')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                  <div class="form-group col-md-3">
                    <label for="input-form-group-public_cible">Public cible  <i class="text-danger">*</i></label>
                    <select name="public_cible" id="input-form-group-orientation-chaine" class="form-control">
                      <option value="">--Selectionner--</option>
                      @if($rapport_commission && $rapport_commission->public_cible == 'Tous publics') 
                        <option value="Tout public" selected >Tout public</option>
                      @else
                        <option value="Tout public" {{old('public_cible') == 'Tout public' ? 'selected' : '' }} >Tout public</option>
                      @endif
                      @if($rapport_commission && $rapport_commission->public_cible == 'Jeunes et Femmes')
                        <option value="Jeunes et Femmes" selected >Jeunes et Femmes</option>
                      @else
                        <option value="Jeunes et Femmes"  {{ old('public_cible') == 'Jeunes et Femmes' ? 'selected' : '' }} >Jeunes et Femmes</option>
                      @endif
                    </select>
                    @if($errors)
                      @error('public_cible')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                </div>
              </fieldset>

              <fieldset class="scheduler-border">
                <legend class="scheduler-border">Équipements</legend>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="input-form-group-equipement-reception">Équipements de réception  <i class="text-danger">*</i></label>
                    <select name="equipement_reception" id="input-form-group-equipement-reception" class="form-control">
                      <option value="">--Selectionner--</option>
                      @if($rapport_commission && $rapport_commission->equipement_reception == 'Analogique')
                        <option value="Analogique" selected >Analogique</option>
                      @else
                        <option value="Analogique" {{ old('equipement_reception') == 'Analogique' ? 'selected' : '' }} >Analogique</option>
                      @endif
                      @if($rapport_commission && $rapport_commission->equipement_reception == 'Hybride')
                        <option value="Hybride" selected >Hybride</option>
                      @else
                        <option value="Hybride" {{ old('equipement_reception') == 'Hybride' ? 'selected' : ''}} >Hybride</option>
                      @endif
                      @if($rapport_commission && $rapport_commission->equipement_reception == 'Numérique') 
                        <option value="Numérique" selected >Numérique</option>
                      @else
                        <option value="Numérique"  {{ old('equipement_reception') == 'Numérique' ? 'selected' : '' }}>Numérique</option>
                      @endif
                    </select>
                    @if($errors)
                      @error('equipement_reception')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                  <div class="form-group col-md-3">
                    <label for="input-form-group-equipement_studio">Équipement de studio  <i class="text-danger">*</i></label>
                    <select name="equipement_studio" id="input-form-group-equipement_studio" class="form-control">
                      <option value="">--Selectionner--</option>
                      @if($rapport_commission && $rapport_commission->equipement_studio == 'Analogique')
                        <option value="Analogique" selected >Analogique</option>
                      @else
                        <option value="Analogique"  {{ old('equipement_studio') == 'Analogique' ? 'selected' : '' }} >Analogique</option>
                      @endif
                      @if($rapport_commission && $rapport_commission->equipement_studio == 'Hybride') 
                        <option value="Hybride" selected >Hybride</option>
                      @else
                        <option value="Hybride" {{ old('equipement_studio') == 'Hybride' ? 'selected' : '' }} >Hybride</option>
                      @endif
                      @if($rapport_commission && $rapport_commission->equipement_studio == 'Numérique')
                        <option value="Numérique" selected >Numérique</option>
                      @else
                        <option value="Numérique"  {{ old('equipement_studio') == 'Numérique' ? 'selected' : '' }} >Numérique</option>
                      @endif
                    </select>
                    @if($errors)
                      @error('equipement_studio')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                  <div class="form-group col-md-5">
                    <label for="input-form-group-equipement_emission">Équipement d'émission (emetteur : 500-1000 Watts)  <i class="text-danger">*</i></label>
                    <input type="number" class="form-control" name="equipement_emission" value="{{$rapport_commission ? $rapport_commission->equipement_emission : old('equipement_emission') }}" placeholder="Équipement d'émission" min="500" max="1000" placeholder="Équipement démission 500-1000 Watts"/>
                    @if($errors)
                      @error('equipement_emission')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                </div>
              </fieldset>
              
              <fieldset class="scheduler-border">
                <legend class="scheduler-border"> Part reservée aux programmes provenant de l'extérieur (%) </legend>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="input-form-group-programme_provenant_exterieur">Opérateur de comparaison  <i class="text-danger">*</i></label>
                    <select name="programme_provenant_exterieur" id="input-form-group-programme_provenant_exterieur" class="form-control">
                      <option value="">--Selectionner--</option>
                      @if($rapport_commission && $rapport_commission->programme_provenant_exterieur == '<=') 
                        <option value="<=" selected> <= </option>
                      @else
                        <option value="<=" {{ old('programme_provenant_exterieur') == '<=' ? 'selected' : ''}}> <= </option>
                      @endif
                      @if($rapport_commission && $rapport_commission->programme_provenant_exterieur == '>=') 
                        <option value=">=" selected> >= </option>
                      @else
                        <option value=">=" {{ old('programme_provenant_exterieur') == '>=' ? 'selected' : '' }}> >= </option>
                      @endif
                      @if($rapport_commission && $rapport_commission->programme_provenant_exterieur == '<') 
                        <option value="<" selected > < </option>
                      @else
                        <option value="<" {{ old('programme_provenant_exterieur') == '<' }}> < </option>
                      @endif
                      @if($rapport_commission && $rapport_commission->programme_provenant_exterieur == '>') 
                        <option value=">" selected > > </option>
                      @else
                        <option value=">"{{ old('programme_provenant_exterieur') == '>' }} > > </option>
                      @endif
                      @if($rapport_commission && $rapport_commission->programme_provenant_exterieur == '=')
                        <option value="=" selected> = </option>
                      @else
                        <option value="="  {{ old('programme_provenant_exterieur') == '=' }} > = </option>
                      @endif
                    </select>
                    @if($errors)
                      @error('programme_provenant_exterieur')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                  <div class="form-group col-md-3">
                    <label for="input-form-group-programme_provenant_exterieur_value">Indice de comparaison  <i class="text-danger">*</i></label>
                    <input class="form-control" name="programme_provenant_exterieur_label_value" value="{{ $rapport_commission ?  $rapport_commission->programme_provenant_exterieur_label_value : old('programme_provenant_exterieur_label_value') }}" id="input-form-group-programme_provenant_exterieur_label_value" type="number" min="0" max="100" placeholder="Nombre"/>
                    @if($errors)
                      @error('programme_provenant_exterieur_label_value')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                  <div class="form-group col-md-6">
                    <label for="input-form-group-programme_provenant_exterieur_value">Valeur  <i class="text-danger">*</i></label>
                    <input class="form-control" name="programme_provenant_exterieur_value" value="{{ $rapport_commission ?  $rapport_commission->programme_provenant_exterieur_value : old('programme_provenant_exterieur_value') }}" id="input-form-group-pourcentage_value" type="number" min="0" max="100" placeholder="Nombre"/>
                    @if($errors)
                      @error('programme_provenant_exterieur_value')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                </div>
              </fieldset>
              
              <fieldset class="scheduler-border">
                <legend class="scheduler-border">Productions internes (%)</legend>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="input-form-group-production_interne_signe">Opérateur de comparaison  <i class="text-danger">*</i></label>
                    <select name="production_interne_signe" id="input-form-group-production_interne_signe" class="form-control">
                      <option value="">--Selectionner--</option>
                      @if($rapport_commission && $rapport_commission->production_interne_signe == '<=') 
                        <option value="<=" selected> <= </option>
                      @else
                        <option value="<=" {{ old('production_interne_signe') == '<=' ? 'selected' : ''}}> <= </option>
                      @endif
                      @if($rapport_commission && $rapport_commission->production_interne_signe == '>=') 
                        <option value=">=" selected> >= </option>
                      @else
                        <option value=">=" {{ old('production_interne_signe') == '>=' ? 'selected' : '' }}> >= </option>
                      @endif
                      @if($rapport_commission && $rapport_commission->production_interne_signe == '<') 
                        <option value="<" selected > < </option>
                      @else
                        <option value="<" {{ old('production_interne_signe') == '<' }}> < </option>
                      @endif
                      @if($rapport_commission && $rapport_commission->production_interne_signe == '>') 
                        <option value=">" selected > > </option>
                      @else
                        <option value=">"{{ old('production_interne_signe') == '>' }} > > </option>
                      @endif
                      @if($rapport_commission && $rapport_commission->production_interne_signe == '=')
                        <option value="=" selected> = </option>
                      @else
                        <option value="="  {{ old('production_interne_signe') == '=' }} > = </option>
                      @endif
                    </select>
                    @if($errors)
                      @error('production_interne_signe')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                  <div class="form-group col-md-3">
                    <label for="input-form-group-production_interne_value">Indice de comparaison  <i class="text-danger">*</i> </label>
                    <input class="form-control" name="production_interne_label_value" value="{{$rapport_commission ? $rapport_commission->production_interne_label_value : old('production_interne_label_value')  }}" id="input-form-group-production_interne_label_value" type="number" min="0" max="100" placeholder="Valeur de reference"/>
                    @if($errors)
                      @error('production_interne_label_value')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                  <div class="form-group col-md-6">
                    <label for="input-form-group-production_interne_value">Valeur  <i class="text-danger">*</i></label>
                    <input class="form-control" name="production_interne_value" value="{{$rapport_commission ? $rapport_commission->production_interne_value : old('production_interne_value')  }}" id="input-form-group-production_interne_value" type="number" min="0" max="100" placeholder="Nombre"/>
                    @if($errors)
                      @error('production_interne_value')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                </div>
              </fieldset>
              
              <fieldset class="scheduler-border">
                <legend class="scheduler-border">Coproductions (%)</legend>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="input-form-group-coproduction_signe">Opérateur de comparaison  <i class="text-danger">*</i></label>
                    <select name="coproduction_signe" id="input-form-group-coproduction_signe" class="form-control">
                      <option value="">--Selectionner--</option>
                      @if($rapport_commission && $rapport_commission->coproduction_signe == '<=') 
                        <option value="<=" selected> <= </option>
                      @else
                        <option value="<=" {{ old('coproduction_signe') == '<=' ? 'selected' : ''}}> <= </option>
                      @endif
                      @if($rapport_commission && $rapport_commission->coproduction_signe == '>=') 
                        <option value=">=" selected> >= </option>
                      @else
                        <option value=">=" {{ old('coproduction_signe') == '>=' ? 'selected' : '' }}> >= </option>
                      @endif
                      @if($rapport_commission && $rapport_commission->coproduction_signe == '<') 
                        <option value="<" selected > < </option>
                      @else
                        <option value="<" {{ old('coproduction_signe') == '<' }}> < </option>
                      @endif
                      @if($rapport_commission && $rapport_commission->coproduction_signe == '>') 
                        <option value=">" selected > > </option>
                      @else
                        <option value=">"{{ old('coproduction_signe') == '>' }} > > </option>
                      @endif
                      @if($rapport_commission && $rapport_commission->coproduction_signe == '=')
                        <option value="=" selected> = </option>
                      @else
                        <option value="="  {{ old('coproduction_signe') == '=' }} > = </option>
                      @endif
                    </select>
                    @if($errors)
                      @error('coproduction_signe')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                  <div class="form-group col-md-3">
                    <label for="input-form-group-coproduction_value">Indice de comparaison  <i class="text-danger">*</i></label>
                    <input class="form-control" name="coproduction_label_value" value="{{ $rapport_commission ?  $rapport_commission->coproduction_label_value : old('coproduction_label_value') }}" id="input-form-group-coproduction_label_value" type="number" min="0" max="100" placeholder="Nombre"/>
                    @if($errors)
                      @error('coproduction_label_value')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                  <div class="form-group col-md-6">
                    <label for="input-form-group-coproduction_value">Valeur  <i class="text-danger">*</i></label>
                    <input class="form-control" name="coproduction_value" value="{{ $rapport_commission ?  $rapport_commission->coproduction_value : old('coproduction_value') }}" id="input-form-group-coproduction_value" type="number" min="0" max="100" placeholder="Nombre"/>
                    @if($errors)
                      @error('coproduction_value')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                </div>
              </fieldset>
      
              <fieldset class="scheduler-border">
                <legend class="scheduler-border">Échanges de programmes (%)</legend>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="input-form-group-echange_programme_signe">Opérateur de comparaison:  <i class="text-danger">*</i></label>
                    <select name="echange_programme_signe" id="input-form-group-echange_programme_signe" class="form-control">
                      <option value="">--Selectionner--</option>
                      @if($rapport_commission && $rapport_commission->echange_programme_signe == '<=') 
                        <option value="<=" selected> <= </option>
                      @else
                        <option value="<=" {{ old('echange_programme_signe') == '<=' ? 'selected' : ''}}> <= </option>
                      @endif
                      @if($rapport_commission && $rapport_commission->echange_programme_signe == '>=') 
                        <option value=">=" selected> >= </option>
                      @else
                        <option value=">=" {{ old('echange_programme_signe') == '>=' ? 'selected' : '' }}> >= </option>
                      @endif
                      @if($rapport_commission && $rapport_commission->echange_programme_signe == '<') 
                        <option value="<" selected > < </option>
                      @else
                        <option value="<" {{ old('echange_programme_signe') == '<' }}> < </option>
                      @endif
                      @if($rapport_commission && $rapport_commission->echange_programme_signe == '>') 
                        <option value=">" selected > > </option>
                      @else
                        <option value=">"{{ old('echange_programme_signe') == '>' }} > > </option>
                      @endif
                      @if($rapport_commission && $rapport_commission->echange_programme_signe == '=')
                        <option value="=" selected> = </option>
                      @else
                        <option value="="  {{ old('echange_programme_signe') == '=' }} > = </option>
                      @endif
                    </select>
                    @if($errors)
                      @error('echange_programme_signe')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                  <div class="form-group col-md-3">
                    <label for="input-form-group-echange_programme_label_value">indice de comparaison  <i class="text-danger">*</i></label>
                    <input class="form-control" name="echange_programme_label_value" value="{{ $rapport_commission ? $rapport_commission->echange_programme_label_value  : old('echange_programme_label_value')}}" id="input-form-group-echange_programme_label_value" type="number" min="0" max="100" placeholder="Nombre"/>
                    @if($errors)
                      @error('echange_programme_label_value')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                  <div class="form-group col-md-6">
                    <label for="input-form-group-echange_programme_value">Valeur en pourcentage de l'échanges de programmes  <i class="text-danger">*</i></label>
                    <input class="form-control" name="echange_programme_value" value="{{ $rapport_commission ? $rapport_commission->echange_programme_value  : old('echange_programme_value')}}" id="input-form-group-echange_programme_value" type="number" min="0" max="100" placeholder="Nombre"/>
                    @if($errors)
                      @error('echange_programme_value')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                </div>
              </fieldset>
              <fieldset class="scheduler-border">
                <legend class="scheduler-border"> Respect des exigences de l'unité nationale et l'ordre public</legend>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="input-form-group-exigence_unite_nationale">Respect des exigences de l'unité nationale et l'ordre public  <i class="text-danger">*</i></label>
                    <select name="exigence_unite_nationale" id="input-form-group-exigence_unite_nationale" class="form-control">
                      <option value="">--Selectionner--</option>
                      @if($rapport_commission && $rapport_commission->exigence_unite_nationale == 'OUI')
                        <option value="OUI"  selected >OUI</option>
                      @else
                        <option value="OUI" {{ old('exigence_unite_nationale') == 'OUI' ? 'selected' : ''}}>OUI</option>
                      @endif
                      @if($rapport_commission && $rapport_commission->exigence_unite_nationale == 'NON')
                        <option value="NON"  selected >NON</option>
                      @else
                        <option value="NON" {{ old('exigence_unite_nationale') == 'NON' ? 'selected' : '' }}>NON</option>
                      @endif
                    </select>
                    @if($errors)
                      @error('exigence_unite_nationale')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                </div>
              </fieldset>

              <fieldset class="scheduler-border">
                  <legend class="scheduler-border"> Capacités financières</legend>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="input-form-group-capacite_financiere">Norme du cahier des charges  <i class="text-danger">*</i></label>
                      <select name="capacite_financiere" id="input-form-group-capacite_financiere" class="form-control">
                        <option value="">--Selectionner--</option>
                        @if($rapport_commission && $rapport_commission->capacite_financiere == 'Radio/illimité (en millions GNF)')
                          <option value="Radio/illimité (en millions GNF)"  selected >Radio/illimité (en millions GNF)</option>
                        @else
                          <option value="Radio/illimité (en millions GNF)" {{ old('capacite_financiere') == 'Radio/illimité (en millions GNF)' ? 'selected' : '' }}>Radio/illimité (en millions GNF)</option>
                        @endif
                        @if($rapport_commission && $rapport_commission->capacite_financiere == 'Télévision /4 milliards GNF')
                          <option value="Télévision /4 milliards GNF"  selected >Télévision /4 milliards GNF</option>
                        @else
                          <option value="Télévision /4 milliards GNF" {{ old('capacite_financiere') == 'Télévision /4 milliards GNF' ? 'selected' : '' }} >Télévision /4 milliards GNF</option>
                        @endif
                        @if($rapport_commission && $rapport_commission->capacite_financiere == 'Relevé de compte')
                          <option value="Relevé de compte"  selected >Relevé de compte</option>
                        @else
                          <option value="Relevé de compte" {{ old('capacite_financiere') == 'Relevé de compte' ? 'selected' : '' }} >Relevé de compte</option>
                        @endif
                        @if($rapport_commission && $rapport_commission->capacite_financiere == 'Attestation bancaire')
                          <option value="Attestation bancaire"  selected >Attestation bancaire</option>
                        @else
                          <option value="Attestation bancaire" {{ old('capacite_financiere') == 'Attestation bancaire' ? 'selected' : '' }} >Attestation bancaire</option>
                        @endif
                      </select>
                      @if($errors)
                        @error('capacite_financiere')
                          <p class="text-danger"> {{$message}} </p>
                        @enderror
                      @endif
                    </div>
                    <div class="form-group col-md-4">
                      <label for="input-form-group-capacite_financiere_interval">Capacités financières <i class="text-danger">*</i></label>
                      <select name="capacite_financiere_interval" id="input-form-group-capacite_financiere_interval" class="form-control">
                        <option value="">--Selectionner--</option>
                        @if($rapport_commission && $rapport_commission->capacite_financiere_interval == '1 - 500 millions')
                          <option value="1 - 500 millions"  selected >1 - 500 millions</option>
                        @else
                          <option value="1 - 500 millions" {{ old('capacite_financiere_interval') == '1 - 500 millions' ? 'selected' : '' }} >1 - 500 millions</option>
                        @endif
                        @if($rapport_commission && $rapport_commission->capacite_financiere_interval == '501 millions - 1 milliard')
                          <option value="501 millions - 1 milliard"  selected >501 millions - 1 milliard</option>
                        @else
                          <option value="501 millions - 1 milliard" {{ old('capacite_financiere_interval') == '501 millions - 1 milliard' ? 'selected' : '' }}  >501 millions - 1 milliard</option>
                        @endif
                        @if($rapport_commission && $rapport_commission->capacite_financiere_interval == 'plus 1 milliard')
                          <option value="plus 1 milliard" selected >plus 1 milliard</option>
                        @else
                          <option value="plus 1 milliard" {{ old('capacite_financiere_interval') == 'plus 1 milliard' ? 'selected' : '' }} >plus 1 milliard</option>
                        @endif
                        @if($rapport_commission && $rapport_commission->capacite_financiere_interval == 'Non spécifiées')
                          <option value="Non spécifiées"  selected >Non spécifiées</option>
                        @else
                          <option value="Non spécifiées" {{ old('capacite_financiere_interval') == 'Non spécifiées' ? 'selected' : '' }} >Non spécifiées</option>
                        @endif
                        @if($rapport_commission && $rapport_commission->capacite_financiere_interval == 'Personnaliser')
                          <option value="Personnaliser"  selected>Personnaliser</option>
                        @else
                          <option value="Personnaliser" {{ old('capacite_financiere_interval') == 'Personnaliser' ? 'selected' : '' }} >Personnaliser</option>
                        @endif
                      </select>
                      @if($errors)
                        @error('capacite_financiere_interval')
                          <p class="text-danger"> {{$message}} </p>
                        @enderror
                      @endif
                    </div>
                    <div class="form-group col-md-4">
                      <label for="input-form-group-capacite_financier_personnalise">Personnaliser </label>
                      <input class="form-control" name="capacite_financier_personnalise" id="input-personnalise" disabled value="{{ $rapport_commission ?  $rapport_commission->capacite_financier_personnalise : 0  }}" id="input-form-group-capacite_financier_personnalise" type="number" min="0" placeholder="Personnaliser capacité financière"/>
                    </div>
                  </div>
              </fieldset>

              <fieldset class="scheduler-border">
                <legend class="scheduler-border">Etats financiers prévisionnels</legend>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="input-form-group-etat_financier">Etats financiers prévisionnels  <i class="text-danger">*</i></label>
                    <select name="etat_financier" id="input-form-group-etat_financier" class="form-control">
                      <option value="">--Selectionner--</option>
                      @if($rapport_commission && $rapport_commission->etat_financier == "Plan d'investissement initial") 
                        <option value="Plan d'investissement initial" selected >Plan d'investissement initial</option>
                      @else
                        <option value="Plan d'investissement initial" {{ old('etat_financier') == 'Plan d\'investissement initial' ? 'selected' : '' }} >Plan d'investissement initial</option>
                      @endif
                      @if($rapport_commission && $rapport_commission->etat_financier == "Compte d'exploitation")
                        <option value="Compte d'exploitation"  selected >Compte d'exploitation</option>
                      @else
                        <option value="Compte d'exploitation" {{ old('etat_financier') == 'Compte d\'exploitation' ? 'selected': '' }} >Compte d'exploitation</option>
                      @endif
                      @if($rapport_commission && $rapport_commission->etat_financier == 'Amortissement sur 3ans')
                        <option value="Amortissement sur 3ans"  selected> Amortissement sur 3ans</option>
                      @else
                        <option value="Amortissement sur 3ans" {{ old('etat_financier') == 'Amortissement sur 3ans' ? 'selected' : '' }} > Amortissement sur 3ans</option>
                      @endif
                      @if($rapport_commission && $rapport_commission->etat_financier == 'Grilles tarifaires proposées')
                        <option value="Grilles tarifaires proposées" selected >Grilles tarifaires proposées</option>
                      @else
                        <option value="Grilles tarifaires proposées" {{ old('etat_financier') == 'Grilles tarifaires proposées' ? 'selected' : '' }}>Grilles tarifaires proposées</option>
                      @endif
                    </select>
                    @if($errors)
                      @error('etat_financier')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>
                </div>
              </fieldset>
            @endif

            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Conclusion</legend>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="input-form-group-conclusion">Conclusion  <i class="text-danger">*</i></label>
                  <textarea name="conclusion" id="conclusion" class="form-control">{{$rapport_commission ? $rapport_commission->conclusion : old('conclusion')}}</textarea>
                  @if($errors)
                    @error('conclusion')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                  @endif
                </div>
              </div>
            </fieldset>

            @if($type_commission != 'hac')
              <a href="{{ route('etude_media_commission') }}" class="btn btn-danger">Fermer</a>
            @else
              <a href="{{ route('etude_medias_hac') }}" class="btn btn-danger">Fermer</a>
            @endif
            <button type="submit" class="btn btn-primary float-right">Valider</button>
        </div>
      </div>
    </div>
  </div>
</form>

@endsection
@section('script')
<!-- SweetAlert2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
  <script>
    $(document).ready(function(){
      $('#input-personnalise').attr('disabled',true)
      var default_value = $('#input-form-group-capacite_financiere_interval').val()

      console.log(default_value)

      if(default_value === 'Personnaliser'){
          $('#input-personnalise').attr('disabled',false)
        }else{
          $('#input-personnalise').attr('disabled',true)
          $('#input-personnalise').val('')
        }
      $('#input-form-group-capacite_financiere_interval').change(function(e){
        var _this = $(this);
        if(_this.val() === 'Personnaliser'){
          $('#input-personnalise').attr('disabled',false)
        }else{
          $('#input-personnalise').attr('disabled',true)
          $('#input-personnalise').val('')

        }
      })


    $('#membre_commission').submit(function(e){
      e.preventDefault();
      $('#error_message').attr('hidden', true);
      var $this =  $(this)
      var url = $this.attr('action');
      var data = $this.serialize()
      $.post(url,data,function(e){
        console.log(e);
        console.log(e);
        console.log(e);
        if(e.success === true){
          swal.fire({
            position: 'top-end',
            icon: 'success',
            toast: true,
            title: e.message,
            showConfirmButton: false,
            timer:  4000,
          });
        }else{
          swal.fire({
            position: 'top-end',
            icon: 'error',
            toast: true,
            title: e.message,
            showConfirmButton: false,
            timer:  4000,
          });
        }
      })
    })

    
    })

    function toggle(source) {
      checkboxes = document.querySelectorAll('input[type="checkbox"]');
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
          checkboxes[i].checked = source.checked;
      }
    }

    var _checkboxes = document.querySelectorAll('input[type="checkbox"]')
    let checker = arr => arr.every(v => v === true);
    var checkboxe_all= document.getElementById('exampleCheck_all')

    var _checked_all = []; 
    for (var i = 0; i < _checkboxes.length; i++) {
      _checked_all.push(_checkboxes[i].checked);
    }

    checkboxe_all.checked = checker(_checked_all)

  </script>
@endsection