<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Promoteur</th>
            <th>Media</th>
            <th>Type</th>
            <th>Téléphone</th>
            <th>Etat</th>
            <th class="text-center">Action.s</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($medias as $key => $media)
        <tr>
            <td>{{ $key+1 }} </td>
            <td>{{ $media->media->user->prenom.' '.$media->media->user->nom }}</td>
            <td>{{ $media->media->nom }}</td>
            <td>{{ $media->media->type_media }}</td>
            <td>{{ number_format(str_replace(' ', '', $media->media->telephone), 0, '', '-') }}</td>
            <td class="text-center">
                @if(auth()->user()->role->nom == 'Commission')
                    @if($media->status_commission =='en_cours')
                        <p class="text-warning">En cours</p>
                    @elseif($media->status_commission =='terminer')
                        <p class="text-success">Terminé</p>
                    @elseif($media->status_commission =='rejeter')
                        <p class="text-danger">Rejeté</p>
                    @elseif($media->status_commission =='revoir')
                        <p class="text-info">Revoir</p>
                    @elseif($media->status_commission==null)
                        <p class="text-info">Nouveau</p>
                    @endif
                @elseif(auth()->user()->role->nom == 'HAC')
                    @if($media->status_hac =='en_cours')
                        <p class="text-warning">En cours</p>
                    @elseif($media->status_hac =='terminer')
                        <p class="text-success">Terminé</p>
                    @elseif($media->status_hac =='rejeter')
                        <p class="text-danger">Rejeté</p>
                    @elseif($media->status_hac =='revoir')
                        <p class="text-info">Revoir</p>
                    @elseif($media->status_hac==null)
                        <p class="text-info">Nouveau</p>
                    @endif
                @endif
            </td>
            <td class="text-center">
                <div class="btn-group">
                    <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> Séléctionner une action <i class="mdi mdi-chevron-down"></i> </button>
                    <div class="dropdown-menu justify-content-between">
                        <a class="dropdown-item btn btn-default btn-sm mr-1" href="{{route('detail-media',['id'=>$media->media->uuid])}}">Détails</a>
                        @if(auth()->user()->role->nom == 'Commission')
                            @if($media->status_commission =='en_cours')
                                @if (hasPermission('afficher_document'))
                                    <a href="{{ route('etude-document', ['id'=> $media->media->uuid ]) }}" class="dropdown-item mt-1 btn bg-success btn-sm mr-1 text-white">
                                        Voir documents
                                    </a>
                                @endif
                                @if (hasPermission('editer_rapport'))
                                    <a @if($this->etudeDocumentsTermineHac($media->media_id)) hidden @else  @endif href="{{ url('rapport-commission/'.$media->media->uuid.'/commission') }}"
                                        class="dropdown-item mt-1 btn bg-info btn-sm mr-1">
                                        Rapport
                                    </a>
                                @endif
                            @elseif($media->status_commission =='revoir')
                                @if (hasPermission('valider_document'))
                                    <a href="{{ route('etude-document', ['id'=> $media->media->uuid ]) }}" @if(($media->status_commission =='revoir')) @else hidden @endif
                                        class="dropdown-item mt-1 btn bg-{{$media->status_commission =='revoir' ?'warning' : 'success'}} btn-sm mr-1">
                                        @if($media->status_commission =='revoir') Re-examiner @else Voir documents @endif
                                    </a>
                                @endif
                            @elseif($media->status_commission =='terminer')
                                @if (hasPermission('afficher_document'))
                                    <a href="{{ route('etude-document', ['id'=> $media->media->uuid ]) }}" class="dropdown-item mt-1 btn bg-success btn-sm mr-1 text-white">
                                        Voir documents
                                    </a>
                                @endif
                            @else
                                @if (hasPermission('valider_document'))
                                    <a href="{{ route('etude-document', ['id'=> $media->media->uuid ]) }}" class="dropdown-item mt-1 btn bg-warning btn-sm mr-1">
                                        Examiner
                                    </a>
                                @endif
                            @endif
                        @elseif(auth()->user()->role->nom == 'HAC')
                            @if($media->status_hac =='en_cours')
                            @if (hasPermission('afficher_document'))
                                <a href="{{ route('etude-document', ['id'=> $media->media->uuid ]) }}" class="dropdown-item mt-1 btn bg-success btn-sm mr-1 text-white">
                                    Voir documents
                                </a>
                            @endif
                            @if (hasPermission('editer_rapport'))
                                <a @if($this->etudeDocumentsTermineHac($media->media_id)) hidden @else  @endif href="{{ url('rapport-commission/'.$media->media->uuid.'/hac') }}"
                                    class="dropdown-item mt-1 btn bg-info btn-sm mr-1">
                                    Rapport
                                </a>
                            @endif
                            @elseif($media->status_hac =='revoir')
                                @if (hasPermission('valider_document'))
                                    <a href="{{ route('etude-document', ['id'=> $media->media->uuid ]) }}" @if(($media->status_hac =='revoir')) @else hidden @endif
                                        class="dropdown-item mt-1 btn bg-{{$media->status_hac =='revoir' ?'warning' : 'success'}} btn-sm mr-1">
                                        @if($media->status_hac =='revoir') Re-examiner @else Voir documents @endif
                                    </a>
                                @endif
                            @elseif($media->status_hac =='terminer')
                                @if (hasPermission('afficher_document'))
                                    <a href="{{ route('etude-document', ['id'=> $media->media->uuid ]) }}" class="dropdown-item mt-1 btn bg-success btn-sm mr-1">
                                        Voir documents
                                    </a>
                                @endif
                            @else
                                @if (hasPermission('valider_document'))
                                    <a href="{{ route('etude-document', ['id'=> $media->media->uuid ]) }}" class="dropdown-item mt-1 btn bg-warning btn-sm mr-1">
                                        Examiner
                                    </a>
                                @endif
                            @endif
                        @endif

                        @if(hasMeeting($media->media_id) && hasMeeting($media->media_id)->agrement !=null)
                        <button type="button" class="dropdown-item btn btn-sm btn-primary text-white mt-1" wire:click='showAgrementSigne({{$media->media_id}})' data-bs-toggle="modal" data-bs-target="#showModalProjetAgrement">Convention d’établissement</button>
                        @endif
                        @if(hasMeeting($media->media_id) && hasMeeting($media->media_id)->licence !=null)
                        <button type="button" class="dropdown-item btn btn-sm bg-dark mt-1" wire:click='showLicence({{$media->media_id}})' data-bs-toggle="modal" data-bs-target="#showModalLicence">Visualiser licence</button>
                        @endif
                    </div>
                </div>

            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">
                <div class="alert alert-info">
                <h5><i class="icon fas fa-ban"></i> Information!</h5>
                Aucune donnée trouvée par rapport aux éléments de recherche entrés.
                </div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
