<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item page-title d-none d-sm-inline-block">
        <a href="#" class="nav-link page-title">
             @yield('page')
             {{-- {{$title ? $title : ''}} --}}
        </a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown " data-bs-toggle="dropdown" href="#">
              <i class="fa fa-bell"></i>
              @if($notificationNombre = compteurNotifications() >= 1)
                  <span class="badge badge-danger navbar-badge fw-bold">{{$notificationNombre = compteurNotifications()}}</span>
              @endif
            </a>
            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right mt-2 py-0">

                <?php $notifications = notificationPreview();?>

                @foreach($notifications as $notification)
                  @if(auth()->user()->role->nom === "DAF")
                    <a href="/dafPreview/{{$notification->id}}" class="dropdown-item pt-3">
                      <b class="dropdown-item-title">
                        {{ \Illuminate\Support\Str::limit($notification->objet, 30) }}
                      </b>
                      <p class="text-md mb-0">
                        <span>{!! trunWordNotif($notification->contenu) !!}</span>
                      </p>
                    </a>
                  @endif

                  @if(auth()->user()->role->nom === "Promoteur")
                    <a href="{{route('promoteur', $notification->media->uuid??null)}}" class="dropdown-item pt-3">
                      <b class="dropdown-item-title">
                        {{ \Illuminate\Support\Str::limit($notification->objet, 30) }}
                      </b>
                      <p class="text-md mb-0">
                        <span>{!! trunWordNotif($notification->contenu) !!}</span>
                      </p>
                    </a>
                  @endif

                  @if(auth()->user()->role->nom === "Commission")
                    <a href="/previewCommission/{{$notification->id}}" class="dropdown-item pt-3">
                      <b class="dropdown-item-title">
                        {{ \Illuminate\Support\Str::limit($notification->objet, 30) }}
                      </b>
                      <p class="text-md mb-0">
                        <span>{!! trunWordNotif($notification->contenu) !!}</span>
                      </p>
                    </a>
                  @endif

                  @if(auth()->user()->role->nom === "HAC")
                  <a href="/previewHAC/{{$notification->id}}" class="dropdown-item pt-3">
                    <b class="dropdown-item-title">
                      {{ \Illuminate\Support\Str::limit($notification->objet, 30) }}
                    </b>
                    <p class="text-md mb-0">
                      <span>{!! trunWordNotif($notification->contenu) !!}</span>
                    </p>
                  </a>
                  @endif

                  @if(auth()->user()->role->nom === "Direction")
                  <a href="/previewDirection/{{$notification->id}}" class="dropdown-item pt-3">
                    <b class="dropdown-item-title">
                      {{ \Illuminate\Support\Str::limit($notification->objet, 30) }}
                    </b>
                    <p class="text-md mb-0">
                      <span>{!! trunWordNotif($notification->contenu) !!}</span>
                    </p>
                  </a>
                  @endif

                  @if(auth()->user()->role->nom === "SGG" || auth()->user()->role->nom === "Ministre" || auth()->user()->role->nom === "ARPT" || auth()->user()->role->nom === "Conseiller")
                    <a href="/previewSGG/{{$notification->id}}" class="dropdown-item pt-3">
                      <b class="dropdown-item-title">
                        {{ \Illuminate\Support\Str::limit($notification->objet, 30) }}
                      </b>
                      <p class="text-md mb-0">
                        <span>{!! trunWordNotif($notification->contenu) !!}</span>
                      </p>
                    </a>
                  @endif
                  @if(auth()->user()->role->nom === "Admin")
                    <a href="/previewADMIN/{{$notification->id}}" class="dropdown-item pt-3">
                      <b class="dropdown-item-title">
                        {{ \Illuminate\Support\Str::limit($notification->objet, 30) }}
                      </b>
                      <p class="text-md mb-0">
                        <span>{!! trunWordNotif($notification->contenu) !!}</span>
                      </p>
                    </a>
                  @endif
                  <div class="dropdown-divider my-0"></div>
                @endforeach
                <a href="{{route("notificationPromoteur")}}" class="dropdown-item dropdown-header bg-info" style="font-weight: bold; font-size: 20px">
                    <i class="fas fa-eye "></i> Voir les notifications
                  </a>
              </div>
          </li>
        <li class="nav-item dropdown">
            <a href="#" class="dropdown nav-link" data-bs-toggle="dropdown">
                <i class="fas fa-user"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right mt-2">
                <div class="card-body box-profile">
                    <h3 class="profile-username sidebar-user-name text-center ellipsis">
                        {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
                    </h3>
                    <p class="text-muted text-center mb-3">{{ auth()->user()->email }}</p>
                    <hr>
                    <a href="{{route('profile')}}" class="text-center btn btn-outline-dark">
                    <i class="fa fa-user"></i> Profile
                    </a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" class="float-right btn btn-outline-danger">
                    Déconnexion
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                </div>
            </ul>
        </li>
      </ul>
</nav>
