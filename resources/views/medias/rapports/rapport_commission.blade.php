<?php $userIds = []; $date_debut = \Carbon\Carbon::now()->format('dd-mm-yy')  ?>
@section('page')
Rédaction du rapport de la commission pour le media : {{ $media->nom.' | '.$media->type.' '.$media->type_media }}
@endsection
@section('css')
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
<form wire:submit.prevent='postRedactionRapport' method="post">
  <div class="row">
    {{-- @dump($member) --}}
    <div class="col-md-4">
      <div class="card card-default">
        <div class="card-body">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td> <strong>Nom du média: </strong></td>
                <td> {{ $media->nom }} </td>
              </tr>
              <tr>
                <td> <strong>Nom du promoteur: </strong></td>
                <td> {{ $media->user->nom }} {{ $media->user->prenom }} </td>
              </tr>
              <tr>
                <td> <strong>Président: </strong></td>
                <td> {{ $president->full_name??null }} </td>
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
    @if($type_commission != 'hac')
    <div class="col-md-8">
      <div class="card card-default">
        <div class="card-header"><h1 class="card-title">Membres de la commission <i class="text-danger">*</i> </h1></div>
          <input type="hidden" wire:model="type_commission" value="HAC"/>
            <div class="card-body">
            {{-- @if($membre_hac_commissions->count() > 0)
              <div class="form-group form-check">
                <input type="checkbox" wire:model="member" class="form-check-input" id="exampleCheck_all" onClick="toggle(this)" />
                <label class="form-check-label" for="exampleCheck_all" >Tout cocher</label>
              </div>
            @endif --}}
                <div class="table-responsive p-0 table-striped" style="height: 150px;">
                    <table class="table table-bordered table-head-fixed">
                    <tbody>
                        @if($membre_commissions->count() > 0)
                        <tr>
                            <td style="padding: 0px;">
                            <div class="form-group form-check">
                                <input type="checkbox" disabled checked />
                                <label class="form-check-label" >{{ auth()->user()->prenom.' '.auth()->user()->nom }}</label>
                            </div>
                            </td>
                            <td>{{ $rapporteurFirst->fonction_occupe??null }}</td>
                        </tr>
                        @foreach( $membre_commissions as $member)
                        <tr>
                            <td style="padding: 0px;">
                                <div class="form-group form-check">
                                    <input type="checkbox" wire:model="member.{{$member->id}}" wire:click='getMember({{$member->id}})' id="exampleCheck_{{$member->id}}" />
                                    <label class="form-check-label" for="exampleCheck_{{$member->id}}" >{{ $member->full_name }}</label>
                                </div>
                            </td>
                            <td>{{ $member->fonction_occupe }}</td>
                        </tr>
                        @endforeach
                        @error("member")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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
    </div>
    @endif
    @if($type_commission == 'hac')
      <div class="col-md-8">
        <div class="card card-default">
          <div class="card-header"><h1 class="card-title">Membres de la hac <i class="text-danger">*</i></h1></div>
            <input type="hidden" wire:model="type_commission" value="HAC"/>
            <div class="card-body">
                <div class="table-responsive p-0 table-striped" style="height: 150px;">
                    <table class="table table-bordered table-head-fixed">
                    <tbody>
                        @if($membre_hac_commissions->count() > 0)
                        <tr>
                            <td style="padding: 0px;">
                            <div class="form-group form-check">
                                <input type="checkbox" disabled checked />
                                <label class="form-check-label" >{{ auth()->user()->prenom.' '.auth()->user()->nom }}</label>
                            </div>
                            </td>
                            <td>{{ $rapporteurFirst->fonction_occupe??null }}</td>
                        </tr>
                        @foreach( $membre_hac_commissions as $member)
                        <tr>
                            <td style="padding: 0px;">
                                <div class="form-group form-check">
                                    <input type="checkbox" wire:model="member.{{$member->id}}" wire:click='getMember({{$member->id}})' id="exampleCheck_{{$member->id}}" />
                                    <label class="form-check-label" for="exampleCheck_{{$member->id}}" >{{ $member->full_name }}</label>
                                </div>
                            </td>
                            <td>{{ $member->fonction_occupe }}</td>
                        </tr>
                        @endforeach
                        @error("member")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @else
                        <div class="alert alert-warning">
                            Les membres de la commission technique doivent être ajouté dépuis le compte administrateur
                        </div>
                        @endif
                    </tbody>
                    </table>
                </div>
              {{-- <table class="table table-bordered">
                <tbody>
                  @if($membre_hac_commissions->count() > 0)
                    @foreach( $membre_hac_commissions as $member)
                      <tr>
                        <td>
                          <div class="form-group form-check">
                            <input type="checkbox" wire:model="member.{{$member->id}}" id="exampleCheck_{{$member->id}}" class="form-check-input" />
                            <label class="form-check-label" for="exampleCheck_{{$member->id}}" >{{ $member->full_name }}</label>
                          </div>
                        </td>
                        <td>
                          {{ $member->fonction_occupe }}
                        </td>
                      </tr>
                    @endforeach
                    @error("member")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  @else
                    <div class="alert alert-warning">
                      Les membres de la commission technique doivent être ajouté dépuis le compte administrateur
                    </div>
                  @endif
                </tbody>
              </table> --}}
            </div>
        </div>
      </div>
    @endif

  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body table-responsive">
            <input type="hidden" wire:model="type_commission" value="{{$type_commission}}" />

            <fieldset class="scheduler-border">
                {{-- <legend class="scheduler-border">{{$type_commission=='hac'?'Hac':'Commission'}}</legend> --}}
                @if($type_commission != 'hac')
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="input-form-group-forme-date_debut">Date début <i class="text-danger">*</i></label>
                    <input type="date" wire:model="date_debut" class="form-control @error('date_debut') is-invalid @enderror">

                    @error("date_debut")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>

                  <div class="form-group col-md-6">
                    <label for="input-form-group-forme-heure_fin">Heure début <i class="text-danger">*</i></label>
                    <input type="time" wire:model="heure_debut" class="form-control @error('heure_debut') is-invalid @enderror"/>
                      @error('heure_debut')
                        <span class="text-danger">{{ $message }}</span>
                      @enderror
                  </div>
                </div>
                @endif
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="input-form-group-present">Nombre de présent <i class="text-danger">*</i></label>
                    <input type="number" wire:model="nombre_present" disabled id="input-form-group-present" class="form-control @error('nombre_present') is-invalid @enderror" placeholder=""/>
                      @error('nombre_present')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror
                  </div>

                  <div class="form-group col-md-6">
                    <label for="input-form-group-forme-jurique">Forme juridique <i class="text-danger">*</i></label>
                    <input type="text" wire:model="forme_juridique" class="form-control @error('forme_juridique') is-invalid @enderror" readonly/>
                      @error('forme_juridique')
                        <span class="text-danger"> {{$message}} </span>
                      @enderror
                  </div>
                </div>
            </fieldset>

            {{-- <fieldset class="scheduler-border">
              <legend class="scheduler-border">Forme juridique </legend>

            </fieldset> --}}

            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Capital social</legend>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="input-form-group-capital-social">Norme du cahier des charges <i class="text-danger">*</i></label>
                  <select wire:model="capital_social" id="input-form-group-forme-jurique" class="form-control @error('capital_social') is-invalid @enderror">
                        <option value="">--Selectionner--</option>
                        <option value="Illimité">Illimité</option>
                        <option value="Limité">Limité</option>
                  </select>
                    @error('capital_social')
                      <span class="text-danger"> {{$message}} </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                  <label for="input-form-group-capital">Montant <i class="text-danger">*</i></label>
                  <input class="form-control @error('capital_montant') is-invalid @enderror" wire:model="capital_montant" id="input-form-group-capital" type="number" min="1" placeholder="Capital"/>
                    @error('capital_montant')
                      <span class="text-danger"> {{$message}} </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                  <label for="input-form-group-unite">Unité <i class="text-danger">*</i></label>
                  <select wire:model="capital_unite" id="input-form-group-unite" class="form-control @error('capital_unite') is-invalid @enderror">
                        <option value="">--Selectionner--</option>
                        <option value="Million(s)" >Million(s)</option>
                        <option value="Milliard(s)" >Milliard(s)</option>
                  </select>
                    @error('capital_unite')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                </div>
              </div>
            </fieldset>

            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Nombre de part </legend>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="input-form-group-capital-social">Norme du cahier des charges <i class="text-danger">*</i></label>
                  <select wire:model="nombre_depart" id="input-form-group-nombre_depart" class="form-control @error('nombre_depart') is-invalid @enderror">
                        <option value="">--Selectionner--</option>
                        <option value="Illimité" selected>Illimité</option>
                        <option value="Limité"  selected>Limité</option>
                  </select>
                    @error('nombre_depart')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                  <label for="input-form-group-nombre_part_value">Valeur <i class="text-danger">*</i></label>
                  <input class="form-control @error('nombre_part_value') is-invalid @enderror" wire:model="nombre_part_value" id="input-form-group-nombre_part_value" type="number" min="1" placeholder="Nombre"/>
                    @error('nombre_part_value')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                </div>
              </div>
            </fieldset>

            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Pourcentage réservé aux investisseurs locaux</legend>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="input-form-group-capital-social">Opérateur de comparaison :  <i class="text-danger">*</i></label>
                  <select wire:model="pourcentage_investisseur_signe" id="input-form-group-nombre_depart" class="form-control @error('pourcentage_investisseur_signe') is-invalid @enderror">
                        <option value="">--Selectionner--</option>
                        <option value="<="> <= </option>
                        <option value=">="> >= </option>
                        <option value="<"> < </option>
                        <option value=">"> > </option>
                        <option value="="> = </option>
                  </select>
                    @error('pourcentage_investisseur_signe')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                  <label for="input-form-group-pourcentage_investisseur_label_value">Indice de comparaison  <i class="text-danger">*</i></label>
                  <input class="form-control @error('pourcentage_investisseur_label_value') is-invalid @enderror" wire:model="pourcentage_investisseur_label_value" type="number" min="0" placeholder="Nombre"/>
                    @error('pourcentage_investisseur_label_value')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                  <label for="input-form-group-pourcentage">Valeur en pourcentage  <i class="text-danger">*</i></label>
                  <input class="form-control @error('pourcentage_investisseur_value') is-invalid @enderror" wire:model="pourcentage_investisseur_value" type="number" min="0" placeholder="Nombre"/>
                    @error('pourcentage_investisseur_value')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
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
                  <select wire:model="nombre_certificat" class="form-control @error('nombre_certificat') is-invalid @enderror">
                        <option value="">--Selectionner--</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                  </select>
                    @error('nombre_certificat')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
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
                  <select wire:model="nombre_certificat_resident" id="input-form-group-nombre_certificat_resident" class="form-control @error('nombre_certificat_resident') is-invalid @enderror">
                        <option value="">--Selectionner--</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                  </select>
                    @error('nombre_certificat_resident')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
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
                  <select wire:model="nombre_certificat_casier_dirigeant" class="form-control @error('nombre_certificat_casier_dirigeant') is-invalid @enderror">
                    <option value="">--Selectionner--</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                  </select>
                    @error('nombre_certificat_casier_dirigeant')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                </div>
              </div>
            </fieldset>

            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Nombre de diplôme des journalistes qualifiés</legend>
              <div class="form-row">
              <div class="form-group col-md-6">
                  <label for="input-form-group-nombre_journaliste"> Norme du cahier des charges  <i class="text-danger">*</i></label>
                  <input class="form-control" value="3" max="3" disabled type="number" min="0" placeholder="Nombre"/>
                </div>
                <div class="form-group col-md-6">
                  <label for="input-form-group-nombre_journaliste"> Nombre  <i class="text-danger">*</i></label>
                  <input class="form-control @error('nombre_journaliste') is-invalid @enderror" wire:model="nombre_journaliste" type="number" min="0" placeholder="Nombre"/>
                    @error('nombre_journaliste')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                </div>
              </div>
            </fieldset>

            @if($type_commission != 'hac')
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Nombre de diplôme de techniciens professionnels</legend>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="input-form-group-nombre_diplome_technicien"> Norme du cahier des charges  <i class="text-danger">*</i></label>
                    <input class="form-control" value="2" disabled type="number" min="0" placeholder="Nombre"/>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="input-form-group-nombre_diplome_technicien"> Nombre  <i class="text-danger">*</i></label>
                    <input class="form-control @error('nombre_diplome_technicien') is-invalid @enderror" wire:model="nombre_diplome_technicien" type="number" min="0" placeholder="Nombre"/>
                      @error('nombre_diplome_technicien')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>
                </div>
            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Chaine et public cible</legend>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="input-form-group-categorie_chaine">Catégorie de la chaine  <i class="text-danger">*</i></label>
                    <select wire:model="categorie_chaine" disabled class="form-control @error('categorie_chaine') is-invalid @enderror">
                        {{-- <option value="">--Selectionner--</option> --}}
                        @if($media->type_media=='Commerciale')
                        <option value="Commerciale" selected>Commerciale</option>
                        @elseif($media->type_media=='Communautaire')
                        <option value="Communautaire" selected>Communautaire</option>
                        @endif
                    </select>
                      @error('categorie_chaine')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>

                  <div class="form-group col-md-4">
                    <label for="input-form-group-orientation-chaine">Orientation de la chaine  <i class="text-danger">*</i></label>
                    <select wire:model="orientation_chaine" id="input-form-group-orientation-chaine" class="form-control @error('orientation_chaine') is-invalid @enderror">
                      <option value="">--Selectionner--</option>
                      <option value="Généraliste">Généraliste</option>
                      <option value="Thématique">Thématique</option>
                    </select>
                      @error('orientation_chaine')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>

                  <div class="form-group col-md-4">
                    <label for="input-form-group-public_cible">Public cible  <i class="text-danger">*</i></label>
                    <select wire:model="public_cible" id="input-form-group-orientation-chaine" class="form-control @error('public_cible') is-invalid @enderror">
                        <option value="">--Selectionner--</option>
                        <option value="Tout public" selected >Tout public</option>
                        <option value="Jeunes et Femmes" selected >Jeunes et Femmes</option>
                    </select>
                      @error('public_cible')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>
                </div>
            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Équipements</legend>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="input-form-group-equipement-reception">Équipements de réception  <i class="text-danger">*</i></label>
                    <select wire:model="equipement_reception" class="form-control @error('equipement_reception') is-invalid @enderror">
                        <option value="">--Selectionner--</option>
                        <option value="Analogique">Analogique</option>
                        <option value="Hybride">Hybride</option>
                        <option value="Numérique">Numérique</option>
                    </select>
                      @error('equipement_reception')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>

                  <div class="form-group col-md-4">
                    <label for="input-form-group-equipement_studio">Équipement de studio  <i class="text-danger">*</i></label>
                    <select wire:model="equipement_studio" id="input-form-group-equipement_studio" class="form-control @error('equipement_studio') is-invalid @enderror">
                        <option value="">--Selectionner--</option>
                        <option value="Analogique">Analogique</option>
                        <option value="Hybride">Hybride</option>
                        <option value="Numérique">Numérique</option>
                    </select>
                      @error('equipement_studio')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>

                  <div class="form-group col-md-4">
                    <label for="input-form-group-equipement_emission">Équipement d'émission (emetteur : 500-1000 Watts)  <i class="text-danger">*</i></label>
                    <input type="number" class="form-control @error('equipement_emission') is-invalid @enderror" wire:model="equipement_emission" placeholder="Équipement d'émission" min="500" max="1000" placeholder="Équipement démission 500-1000 Watts"/>
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
                    <select wire:model="programme_provenant_exterieur" id="input-form-group-programme_provenant_exterieur" class="form-control @error('programme_provenant_exterieur') is-invalid @enderror">
                        <option value="">--Selectionner--</option>
                        <option value="<="> <= </option>
                        <option value=">="> >= </option>
                        <option value="<"> < </option>
                        <option value=">"> > </option>
                        <option value="="> = </option>
                    </select>
                      @error('programme_provenant_exterieur')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>

                  <div class="form-group col-md-3">
                    <label for="input-form-group-programme_provenant_exterieur_value">Indice de comparaison  <i class="text-danger">*</i></label>
                    <input class="form-control @error('programme_provenant_exterieur_label_value') is-invalid @enderror" wire:model="programme_provenant_exterieur_label_value" type="number" min="0" max="100" placeholder="Nombre"/>
                      @error('programme_provenant_exterieur_label_value')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>

                  <div class="form-group col-md-6">
                    <label for="input-form-group-programme_provenant_exterieur_value">Valeur  <i class="text-danger">*</i></label>
                    <input class="form-control @error('programme_provenant_exterieur_value') is-invalid @enderror" wire:model="programme_provenant_exterieur_value" type="number" min="0" max="100" placeholder="Nombre"/>
                      @error('programme_provenant_exterieur_value')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>
                </div>
            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Productions internes (%)</legend>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="input-form-group-production_interne_signe">Opérateur de comparaison  <i class="text-danger">*</i></label>
                    <select wire:model="production_interne_signe" class="form-control @error('production_interne_signe') is-invalid @enderror">
                        <option value="">--Selectionner--</option>
                        <option value="<="> <= </option>
                        <option value=">="> >= </option>
                        <option value="<"> < </option>
                        <option value=">"> > </option>
                        <option value="="> = </option>
                    </select>
                      @error('production_interne_signe')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>

                  <div class="form-group col-md-3">
                    <label for="input-form-group-production_interne_value">Indice de comparaison  <i class="text-danger">*</i> </label>
                    <input class="form-control @error('production_interne_label_value') is-invalid @enderror" wire:model="production_interne_label_value" type="number" min="0" max="100" placeholder="Valeur de reference"/>
                      @error('production_interne_label_value')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>

                  <div class="form-group col-md-6">
                    <label for="input-form-group-production_interne_value">Valeur  <i class="text-danger">*</i></label>
                    <input class="form-control @error('production_interne_value') is-invalid @enderror" wire:model="production_interne_value" type="number" min="0" max="100" placeholder="Nombre"/>
                      @error('production_interne_value')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>
                </div>
            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Coproductions (%)</legend>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="input-form-group-coproduction_signe">Opérateur de comparaison  <i class="text-danger">*</i></label>
                    <select wire:model="coproduction_signe" class="form-control @error('coproduction_signe') is-invalid @enderror">
                        <option value="">--Selectionner--</option>
                        <option value="<="> <= </option>
                        <option value=">="> >= </option>
                        <option value="<"> < </option>
                        <option value=">"> > </option>
                        <option value="="> = </option>
                    </select>
                      @error('coproduction_signe')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>

                  <div class="form-group col-md-3">
                    <label for="input-form-group-coproduction_value">Indice de comparaison  <i class="text-danger">*</i></label>
                    <input class="form-control @error('coproduction_label_value') is-invalid @enderror" wire:model="coproduction_label_value" type="number" min="0" max="100" placeholder="Nombre"/>
                    @if($errors)
                      @error('coproduction_label_value')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                    @endif
                  </div>

                  <div class="form-group col-md-6">
                    <label for="input-form-group-coproduction_value">Valeur  <i class="text-danger">*</i></label>
                    <input class="form-control @error('coproduction_value') is-invalid @enderror" wire:model="coproduction_value" type="number" min="0" max="100" placeholder="Nombre"/>
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
                    <select wire:model="echange_programme_signe" class="form-control @error('coproduction_signe') is-invalid @enderror">
                        <option value="">--Selectionner--</option>
                        <option value="<="> <= </option>
                        <option value=">="> >= </option>
                        <option value="<"> < </option>
                        <option value=">"> > </option>
                        <option value="="> = </option>
                    </select>
                      @error('echange_programme_signe')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>

                  <div class="form-group col-md-3">
                    <label for="input-form-group-echange_programme_label_value">indice de comparaison  <i class="text-danger">*</i></label>
                    <input class="form-control @error('echange_programme_label_value') is-invalid @enderror" wire:model="echange_programme_label_value" type="number" min="0" max="100" placeholder="Nombre"/>
                      @error('echange_programme_label_value')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>

                  <div class="form-group col-md-6">
                    <label for="input-form-group-echange_programme_value">Valeur en pourcentage de l'échanges de programmes  <i class="text-danger">*</i></label>
                    <input class="form-control @error('echange_programme_value') is-invalid @enderror" wire:model="echange_programme_value" type="number" min="0" max="100" placeholder="Nombre"/>
                      @error('echange_programme_value')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>
                </div>
            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border"> Respect des exigences de l'unité nationale et l'ordre public</legend>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="input-form-group-exigence_unite_nationale">Respect des exigences de l'unité nationale et l'ordre public  <i class="text-danger">*</i></label>
                    <select wire:model="exigence_unite_nationale" class="form-control @error('exigence_unite_nationale') is-invalid @enderror">
                        <option value="">--Selectionner--</option>
                        <option value="OUI">OUI</option>
                        <option value="NON">NON</option>
                    </select>
                      @error('exigence_unite_nationale')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>
                </div>
            </fieldset>

            <fieldset class="scheduler-border">
                  <legend class="scheduler-border"> Capacités financières</legend>
                  <div class="form-row">
                    <div class="form-group col-md-3">
                      <label for="input-form-group-capacite_financiere">Norme du cahier des charges  <i class="text-danger">*</i></label>
                        <select wire:model="capacite_financiere" disabled class="form-control @error('capacite_financiere') is-invalid @enderror">
                            @if($media->type=='Radio')
                            <option selected value="Radio/illimité (en millions GNF)">Radio/illimité (en millions GNF)</option>
                            @elseif($media->type=='Télévision')
                            <option value="Télévision /4 milliards GNF">Télévision /4 milliards GNF</option>
                            @endif
                        </select>
                        @error('capacite_financiere')
                          <p class="text-danger"> {{$message}} </p>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <label for="input-form-group-capacite_financiere_preuve">Preuve  <i class="text-danger">*</i></label>
                        <select wire:model="capacite_financiere_preuve" class="form-control @error('capacite_financiere_preuve') is-invalid @enderror">
                              <option value="">--Selectionner--</option>
                              <option value="Relevé de compte">Relevé de compte</option>
                              <option value="Attestation bancaire">Attestation bancaire</option>
                        </select>
                          @error('capacite_financiere_preuve')
                            <p class="text-danger"> {{$message}} </p>
                          @enderror
                    </div>

                    <div class="form-group col-md-3">
                      <label for="input-form-group-capacite_financiere_interval">Capacités financières <i class="text-danger">*</i></label>
                      <select wire:model="capacite_financiere_interval" id="input-form-group-capacite_financiere_interval" class="form-control @error('capacite_financiere_interval') is-invalid @enderror">
                            <option value="">--Selectionner--</option>
                            <option value="1 - 500 millions">1 - 500 millions</option>
                            <option value="501 millions - 1 milliard">501 millions - 1 milliard</option>
                            <option value="plus 1 milliard">plus 1 milliard</option>
                            <option value="Non spécifiées">Non spécifiées</option>
                            <option value="Personnaliser">Personnaliser</option>
                      </select>
                        @error('capacite_financiere_interval')
                          <p class="text-danger"> {{$message}} </p>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                      <label for="input-form-group-capacite_financier_personnalise">Personnaliser </label>
                        @if ($capacite_financiere_interval =='Personnaliser')
                        <input class="form-control @error('capacite_financier_personnalise') is-invalid @enderror" wire:model="capacite_financier_personnalise" id="input-personnalise" type="number" min="0" placeholder="Personnaliser capacité financière"/>
                        @error('capacite_financier_personnalise')
                          <p class="text-danger"> {{$message}} </p>
                        @enderror
                        @else
                        <input class="form-control @error('capacite_financier_personnalise') is-invalid @enderror" wire:model="capacite_financier_personnalise" id="input-personnalise" disabled type="number" min="0" placeholder="Personnaliser capacité financière"/>
                        @endif
                    </div>
                  </div>
            </fieldset>

            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Etats financiers prévisionnels</legend>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="input-form-group-etat_financier">Etats financiers prévisionnels  <i class="text-danger">*</i></label>
                    <select wire:model="etat_financier" id="input-form-group-etat_financier" class="form-control @error('etat_financier') is-invalid @enderror">
                        <option value="">--Selectionner--</option>
                        <option value="Plan d'investissement initial">Plan d'investissement initial</option>
                        <option value="Compte d'exploitation">Compte d'exploitation</option>
                        <option value="Amortissement sur 3ans"> Amortissement sur 3ans</option>
                        <option value="Grilles tarifaires proposées">Grilles tarifaires proposées</option>
                    </select>
                      @error('etat_financier')
                        <p class="text-danger"> {{$message}} </p>
                      @enderror
                  </div>
                </div>
              </fieldset>
            @endif

            <fieldset class="scheduler-border">
              <legend class="scheduler-border">Conclusion</legend>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="input-form-group-conclusion">Conclusion  <i class="text-danger">*</i></label>
                  <textarea wire:model="conclusion" class="form-control @error('conclusion') is-invalid @enderror"></textarea>
                    @error('conclusion')
                      <p class="text-danger"> {{$message}} </p>
                    @enderror
                </div>
              </div>
            </fieldset>
            <a href="{{ url('/liste-medias') }}" class="btn btn-danger">Fermer</a>
            <button type="submit" class="btn btn-primary float-right">Valider</button>
        </div>
      </div>
    </div>
  </div>
</form>
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
@section('script')
<!-- SweetAlert2 -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>
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

  </script> --}}
@endsection
