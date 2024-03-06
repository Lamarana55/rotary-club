<aside class="control-sidebar control-sidebar-dark">
    <div class="card bg-dark">
        <div class="card-body bg-dark box-profile">
            <h3 class="profile-username sidebar-user-name text-center ellipsis">
                {{ auth()->user()->prenom }} {{ auth()->user()->nom }}
            </h3>
          <p class="text-muted text-center">{{ auth()->user()->email }}</p>
          <ul class="list-group bg-dark mb-3">
            <li class="list-group-item">
                <a href="{{route('profile')}}" class="d-flex align-items-center">
                  <i class="fa fa-user pr-2"></i><b>Profile</b>
                </a>
            </li>
          </ul>
          <a href="{{ route('logout') }}" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();" class="btn btn-primary btn-block">
            Déconnexion
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        </div>
      </div>
  </aside>
