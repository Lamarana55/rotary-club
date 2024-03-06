@section('page')
@if(auth()->check() && auth()->user()->role->nom == 'HAC')
Analyse du dossier technique du média ({{$this->media->nom.' | '.$this->media->type.' '.$this->media->type_media}})
@else
Examen du dossier technique du média ({{$this->media->nom.' | '.$this->media->type.' '.$this->media->type_media}})
@endif
@endsection

<div class="row">
    <div class="{{$preview ? 'col-lg-6' : 'col-lg-12'}} ">
        <div class="row mb-2">
            <div class="col-12">
                <div style="display: flex;align-items: center;Justify-content: space-between">
                    <div>
                        @if($this->etudeDocumentsTermineHac($media->id) && !$this->etudeTerminerCommission($media->id))
                            @if(auth()->user()->role->nom =='Commission' && $dossier && $dossier->status_commission !='terminer')
                            <button @if($dossier->is_termine_commission) hidden @endif type="button" wire:click='showConfirmeTerminerEtude' class="btn btn-success mr-4">Terminer </button>
                            @elseif(auth()->user()->role->nom =='HAC' && $dossier && $dossier->status_hac !='terminer')
                            <button @if($dossier->is_termine_hac) hidden @endif type="button" wire:click='showConfirmeTerminerEtude' class="btn btn-success mr-4">Terminer </button>
                            @endif
                        @endif
                        @if($dossier && $dossier->status_commission =='en_cours')
                            @if (hasPermission('editer_rapport'))
                                <a @if($this->etudeDocumentsTermine($dossier->media_id)) hidden @else  @endif href="{{ url('rapport-commission/'.$dossier->media->uuid.'/commission') }}"
                                    class="btn btn-primary btn-sm mr-1">
                                    Rapport
                                </a>
                            @endif
                        @endif
                        @if($dossier && $dossier->status_hac =='en_cours')
                            @if (hasPermission('editer_rapport'))
                                <a @if($this->etudeDocumentsTermine($dossier->media->uuid)) hidden @else  @endif href="{{ url('rapport-commission/'.$dossier->media->uuid.'/hac') }}"
                                    class="btn btn-primary btn-sm mr-1">
                                    Rapport
                                </a>
                            @endif
                        @endif
                        {{-- <button type="button" wire:click='showConfirmeTerminerEtude' class="btn btn-success mr-4">Terminers {{$this->etudeDocumentsTermineHac($media->id)}} </button> --}}
                        {{-- @if($dossier->status_commission=='terminer') --}}
                        <button @if(count($selected) ==0) hidden @endif wire:click="showConfirmeAccepteFavorable" class="btn btn-success mr-1">{{(auth()->user()->role->nom == 'Commission')?"Accepter":"Accepter"}}</button>
                        @if (hasPermission('rejeter_document'))
                            <button @if(count($selected) ==0) hidden @endif id="rejeter" class="btn btn-danger mr-1">{{(auth()->user()->role->nom == 'Commission')?"Rejeter":"Rejeter"}}</button>
                        @endif
                    </div>
                    <a href="{{url('/liste-medias')}}" class="btn btn-primary float-right retourn-page">Retour</a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Documents </h3>
                <div class="form-group">
                    @if(auth()->user()->role->nom =='Commission' && $dossier && !$dossier->is_termine_commission)
                    <div class="float-right">
                        <input type="checkbox" id="selectedAll" class="form-check-input" wire:model="selectedAll" value="{{$selectedAll}}" wire:click='selectedAllClick'>
                        <label for="selectedAll" class="control-label">{{$selectedAll ? 'Décocher tous' : 'Tous cocher'}}</label>
                    </div>
                    @elseif(auth()->user()->role->nom =='HAC' && $dossier && !$dossier->is_termine_hac)
                    <div class="float-right">
                        <input type="checkbox" id="selectedAll" class="form-check-input" wire:model="selectedAll" value="{{$selectedAll}}" wire:click='selectedAllClick'>
                        <label for="selectedAll" class="control-label">{{$selectedAll ? 'Décocher tous' : 'Tous cocher'}}</label>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card-body table-responsive">
                <table id="tableDocuments" class="table table-bordered" style="width: 100%">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th>Nom</th>
                            <th style="width: 13%">{{(auth()->user()->role->nom == 'Commission')?"MIC":"MIC"}}</th>
                            @if(auth()->user()->role->nom == 'Commission')
                            <th style="width: 13%">HAC </th>
                            @elseif(auth()->user()->role->nom == 'HAC')
                            <th style="width: 13%">HAC </th>
                            @endif
                            <th style="width: 20%">Action.s</th>
                        </tr>
                    </thead>

                    <tbody id="listeDocuments">
                        @foreach($documents as $key=> $document)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $document->document_type_promoteur->document_technique->nom }}</td>
                            @if(auth()->user()->role->nom == 'Commission')
                            <td>
                                    @if($document->is_validated_commission)
                                    <strong class="text-success">accepté</strong>
                                    @elseif($document->is_validated_commission===null)
                                    @elseif(!$document->is_validated_commission)
                                    <strong class="text-danger">rejeté</strong>
                                    @endif
                            </td>
                            <td>
                                @if($document->is_validated_hac)
                                <strong class="text-success">accepté</strong>
                                @elseif($document->is_validated_hac===null)
                                @elseif(!$document->is_validated_hac)
                                <strong class="text-danger">rejeté</strong>
                                @endif
                            </td>
                            @elseif(auth()->user()->role->nom == 'HAC')
                            <td> @if($document->is_validated_commission) <strong class="text-success">accepté</strong>@endif</td>
                            <td>
                                @if($document->is_validated_hac)
                                <strong class="text-success">accepté</strong>
                                @elseif($document->is_validated_hac===null)
                                @elseif(!$document->is_validated_hac)
                                <strong class="text-danger">rejeté</strong>
                                @endif
                            </td>
                            @endif
                            <td style="text-align: center">
                                <div style="display: flex;justify-content: center">
                                    @if(auth()->user()->role->nom =='Commission' && !$dossier->is_termine_commission)
                                    <div>
                                        <input type="checkbox" id="document-{{ $document->id }}" class="form-check-input document" wire:model="selected" value="{{$document->id}}" wire:click='updateMySeleted'>
                                    </div>
                                    @elseif(auth()->user()->role->nom =='HAC' && !$dossier->is_termine_hac)
                                    <div>
                                        <input type="checkbox" id="document-{{ $document->id }}" class="form-check-input document" wire:model="selected" value="{{$document->id}}" wire:click='updateMySeleted'>
                                    </div>
                                    @endif
                                    <a target="_blank" rel="noopener noreferrer"
                                        href="{{ asset($document->file_path) }}" class="mr-1">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                    </a>

                                    <span class="text text-primary view" wire:click="showDocument({{$document->id}})">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </span>
                                    {{-- @if(auth()->user()->role->nom =='Commission' && $document->is_validated_commission==false)
                                    <a class="ml-1" wire:click="showDocumentDescription({{$document->id}})" data-bs-toggle="modal" data-bs-target="#showModelDescriptionTypeDocument">
                                        <i class="fa fa-info" aria-hidden="true"></i>
                                    </a>
                                    @endif --}}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if($preview)
    <div class="col-6">
        <div class="d-flex justify-content-between">
            <button class="btn btn-primary mb-1 float-right" wire:click="closeDocument">Fermer</button>
            <p>{{$firstDocument->categorie == 'document_technique' ? $firstDocument->document_type_promoteur->document_technique->nom : $firstDocument->categorie}} </p>
        </div>
        <embed src="{{$firstDocument->file_path}} " width="100%" height="800">
    </div>
    @endif

    @if(auth()->user()->role->nom == 'Commission' && $dossier && $dossier->status_commission=='terminer')
    <div class="mt-2">
        <div class="col-12">
            <h5>Rapport Commision</h5>
            <div class="row">
                <div class="col-12">
                    <button type="button" wire:click="showDocument({{$this->rapportCommissionHac('rapport_commission')->id}})" class="btn btn-primary">Visualiser </button>

                    <a target="_blank" rel="noopener noreferrer" id="telecharger_rapport_hac" class="btn btn-primary"
                        href="{{ asset($this->rapportCommissionHac('rapport_commission')->file_path) }}" class="mr-1">
                        <i class="fa fa-download" aria-hidden="true"></i>Télécharger
                    </a>
                </div>
            </div>
        </div>
    </div>
    @elseif(auth()->user()->role->nom == 'HAC' && $dossier && $dossier->status_hac=='terminer')
    <div class="mt-2">
        <div class="col-12">
            <h5>Rapport HAC</h5>
            <div class="row">
                <div class="col-12">
                    <button type="button" wire:click="showDocument({{$this->rapportCommissionHac('rapport_hac')->id}})" class="btn btn-primary">Visualiser </button>

                    <a target="_blank" rel="noopener noreferrer" id="telecharger_rapport_hac" class="btn btn-primary"
                        href="{{ asset($this->rapportCommissionHac('rapport_hac')->file_path) }}" class="mr-1">
                        <i class="fa fa-download" aria-hidden="true"></i>Télécharger
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<div class="modal fade" id="showModalDocumentDescription" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="showModalDocumentDescriptionLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>{{$description}} </h2>
                {{-- <h4>{{$description->document_type_promoteur->document_technique->nom ?? null}} </h4> --}}
            </div>
            <div class="modal body">
                @dump($description ?? null)
                {{-- <p> {!! $firstDocument->document_type_promoteur->document_technique->description ?? null !!} </p> --}}
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
        </div>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="showModelDescriptionTypeDocument" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="showModelDescriptionTypeDocument" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4>{{$description->document_type_promoteur->document_technique->nom ?? null}} </h4>
        </div>
        <div class="modal-body">
            <p>
                {!! $description->document_type_promoteur->document_technique->nom ?? null !!}
            </p>
            <div class="card-footer">
                <button data-bs-dismiss="modal" type="button" class="btn btn-danger float-right">Fermer</button>
            </div>
        </div>
      </div>
    </div>
</div>


<div class="modal fade" id="modalEtudeDocuments">
    <div class="modal-dialog modal-dialog-center">
        <div class="modal-content">
            <div class="modal-header">
                @if (auth()->check() && auth()->user()->role->nom == 'HAC')
                <h4 id="notfound_title">Analyse du dossier</h4>
                @else
                <h4 id="notfound_title">Examen du dossier</h4>
                @endif
            </div>
            <div class="modal-body">
                <input type="hidden" id="idMedia" value="{{ $media->id }}" />
                <div hidden id="motifsRejet">
                    @foreach ($media->documents as $document)
                    <div hidden id="divCommentaire-{{ $document->id}}" class="form-group divCommentaire">
                        <label>Motif d'avis rejeté de {{ $document->document_type_promoteur ? $document->document_type_promoteur->document_technique->nom : ''}}</label>
                        <textarea id="commentaire-{{ $document->id}}" class="form-control" rows="2" placeholder="Entrer le motif de rejet"></textarea>
                        <span id="commentaireError-{{ $document->id}}" hidden>Votre commentaire doit avoir quatre(4) caractères au minimum</span>
                    </div>
                    @endforeach
                </div>

                <p hidden id="messageValidations">Confirmez-vous {{(auth()->user()->role->nom == 'HAC')?"votre avis sur les":"la validation des"}} documents du média <strong>{{
                        $media->nom }}</strong>?</p>
            </div>

            <div class="modal-footer justify-content-end">
                <button id="annuler" data-bs-dismiss="modal" type="button" class="btn bg-gris-fonce">Annuler</button>
                <button id="valider" type="button" class="btn btn-success mr-1">Valider</button>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/etude_documents.js')}} "></script>

<script>
    window.addEventListener("showEditModalRejetDocumentCommentaire", event=>{
       $("#editModalRejetDocumentCommentaire").modal('show')
    })

    window.addEventListener("showConfirmTerminerExamenDocuments", event=>{
       Swal.fire({
        title: "Terminer l'examen du dossier technique",
        text: "Confirmez-vous la fin de l'examen du dossier technique du média "+event.detail.message ,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '{{ SUCCESS }}',
        cancelButtonColor: '{{ DANGER }}',
        confirmButtonText: 'OUI',
        cancelButtonText: 'NON',
        reverseButtons: true,
        }).then((result) => {
            if(result.isConfirmed) {
               @this.terminerEtudeDocumentsTechniques()
            }
        })
    })

    window.addEventListener("showConfirmAccepteExamenDocuments", event=>{
       Swal.fire({
        title: 'Examen du dossier',
        text: "Confirmez-vous la validation des documents du média "+event.detail.message ,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '{{ SUCCESS }}',
        cancelButtonColor: '{{ DANGER }}',
        confirmButtonText: 'OUI',
        cancelButtonText: 'NON',
        reverseButtons: true,
        }).then((result) => {
            if(result.isConfirmed) {
               @this.accepteFavorable()
            }
        })
    })

    window.addEventListener("showSuccessPersoMessage", event=>{
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


    window.addEventListener("showErrorsPersoMessage", event=>{
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

