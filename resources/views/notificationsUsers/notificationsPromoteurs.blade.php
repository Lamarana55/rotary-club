@extends('/../layouts.default')
@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">Notifications</h3>
        @if(auth()->user()->role->nom === "Promoteur")
            <a href='/mes-medias' class="btn btn-primary  float-right m-)">Retour</a>
        @else
            <a href='/' class="btn btn-primary  float-right m-)">Retour</a>
        @endif
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th class="col-3">Objet</th>
                    <th>Descriptions</th>
                    <th>Action.s</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($notification as $notif)
                        <tr>
                            <td>{{ $notif->objet}}</td>
                            <td>{!! $notif->contenu !!}</td>
                            <td>
                                @if(auth()->user()->role->nom === "Promoteur")
                                    <a href="{{route('promoteur', $notif->media->uuid)}}"  class="btn btn-primary rounded-circle"> <i class="fa fa-eye"></i> </a>
                                @endif

                                @if(auth()->user()->role->nom === "DAF")
                                    <a href="/dafPreview/{{$notif->id}}"  class="btn btn-primary rounded-circle"> <i class="fa fa-eye"></i></a>
                                @endif

                                @if(auth()->user()->role->nom === "Commission")
                                    <a href="/previewCommission/{{$notif->id}}"  class="btn btn-primary rounded-circle"> <i class="fa fa-eye"></i></a>
                                @endif

                                @if(auth()->user()->role->nom === "HAC")
                                    <a href="/previewHAC/{{$notif->id}}"  class="btn btn-primary rounded-circle"> <i class="fa fa-eye"></i></a>
                                @endif

                                @if(auth()->user()->role->nom === "Direction")
                                    <a href="/previewDirection/{{$notif->id}}" class="btn btn-primary rounded-circle"> <i class="fa fa-eye"></i>
                                    </a>
                                @endif

                                @if(auth()->user()->role->nom === "SGG")
                                    <a href="/previewSGG/{{$notif->id}}"  class="btn btn-primary rounded-circle"> <i class="fa fa-eye"></i>
                                    </a>
                                @endif
                                @if(auth()->user()->role->nom === "Admin")
                                    <a href="/previewADMIN/{{$notif->id}}"  class="btn btn-primary rounded-circle"> <i class="fa fa-eye"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
              </table>

        </div>
    </div>
    <div class="card-footer float-right">
        {{ $notification->links() }}
    </div>
  </div>
@endsection
