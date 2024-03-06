<?php
    use Illuminate\Support\Facades\DB;
    $count = DB::table('media')->where('user_id',auth()->user()->id)->get();
?>
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

      @if(auth()->check() && auth()->user()->role->nom != 'Promoteur' && hasPermission('afficher_dashboard'))
      <li class="nav-item">
        <a href="{{ route('home')}}" class="nav-link {{request()->path()=='/' ? 'active':''}}">
            <i class="nav-icon fas fa-home"></i>
          <p>
            Tableau de bord
          </p>
        </a>
      </li>
      @endif

      @if(hasPermission('créer_utilisateur') || hasPermission('afficher_utilisateur') || hasPermission('afficher_role'))
        <li class="nav-item {{request()->path()=='utilisateurs' || request()->path()=='add-utilisateurs' || request()->path()=='roles' ? 'menu-open active':''}} ">
            <a href="#" class="nav-link {{request()->path()=='utilisateurs' || request()->path()=='add-utilisateurs' || request()->path()=='roles' ? 'active':''}}">
                <i class="nav-icon fas fa-users"></i>
                <p> Utilisateurs <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                @if(hasPermission('afficher_utilisateur'))
                <li class="nav-item">
                    <a href="{{route('utilisateur')}}" class="nav-link {{request()->path()=='utilisateurs' ? 'active':''}}">
                        Liste utilisateurs
                    </a>
                </li>
                @endif
                @if(hasPermission('créer_utilisateur'))
                <li class="nav-item">
                    <a href="{{route('add-utilisateur')}}" class="nav-link {{request()->path()=='add-utilisateurs' ? 'active':''}}">
                        Ajout utilisateur
                    </a>
                </li>
                @endif
                @if(hasPermission('afficher_role'))
                <li class="nav-item">
                    <a href="{{route('roles')}}" class="nav-link {{request()->path()=='roles' ? 'active':''}}">
                        Roles
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if(auth()->check() && auth()->user()->role->nom != 'Promoteur' && hasPermission('afficher_statistique'))
        <li class="nav-item">
            <a href="{{ route('statistique')}}" class="nav-link {{request()->path()=='statistique' ? 'active':''}}">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>Statistiques</p>
            </a>
        </li>
        @endif
        @if(auth()->check() && auth()->user()->role->nom == 'Promoteur' && hasPermission('mes_medias'))
        <li class="nav-item {{ (request()->is('mes-medias')|| request()->is('create-media')) ? 'menu-open active' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('mes-medias')|| request()->is('create-media')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-play"></i>
            <p>
                Média <i class="fas fa-angle-left right"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{route('mesmedias')}}" class="nav-link {{ request()->is('mes-medias') ? 'active' : '' }}">
                <p>Liste des médias</p>
                </a>
            </li>
            </ul>
        </li>
        @endif

        @if(auth()->check() && auth()->user()->role->nom != 'Promoteur')
            @if(hasPermission('afficher_media'))
                <li class="nav-item">
                    <a href="{{ route('liste-medias') }}" class="nav-link">
                        <i class="nav-icon fas fa-play"></i>
                    <p>Médias</p>
                    </a>
                </li>
            @endif
            @if(hasPermission('afficher_disponibilite'))
                <li class="nav-item">
                    <a href="{{ route('disponibilites.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p class="">Mes disponibilités</p>
                    </a>
            </li>
            @endif
            @if(hasPermission('afficher_rendez_vous'))
            <li class="nav-item">
                <a href="{{ route('meetings.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-handshake"></i>
                    <p class="">Rendez-vous</p>
                </a>
            </li>
            @endif
        @endif
        @if(hasPermission('afficher_delai_traitement') || hasPermission('afficher_type_media') || hasPermission('afficher_type_document') || hasPermission('afficher_montant_paiement') || hasPermission('afficher_code_marchand') || hasPermission('afficher_forme_juridique') || hasPermission('afficher_membre'))
        <li class="nav-item {{ (request()->is('types-media')|| request()->is('types-document') || request()->is('parametre-paiement')|| request()->is('types-paiement')) ? 'menu-open active' : '' }}">
            <a href="#" class="nav-link {{ (request()->is('types-media')|| request()->is('types-document') || request()->is('parametre-paiement')|| request()->is('types-paiement')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-cogs"></i>
                <p>Paramétres</p>
                <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
                @if(hasPermission('afficher_delai_traitement'))
                <li class="nav-item ">
                    <a href="{{route('delais-traitement')}}" class="pull-right nav-link {{ request()->is('delais-traitement') ? 'active' : '' }}">
                        <p>Delais traitement</p>
                    </a>
                </li>
                @endif
                @if(hasPermission('afficher_type_media'))
                <li class="nav-item ">
                    <a href="{{route('types-media')}}" class="pull-right nav-link {{ request()->is('types-media') ? 'active' : '' }}">
                        <p>Type média</p>
                    </a>
                </li>
                @endif
                @if(hasPermission('afficher_type_document'))
                <li class="nav-item">
                    <a href="{{route('types-document')}}" class="nav-link {{ request()->is('types-document') ? 'active' : '' }}">
                        <p>Type document</p>
                    </a>
                </li>
                @endif
                @if(hasPermission('afficher_montant_paiement'))
                <li class="nav-item">
                    <a href="{{route('parametre-paiement')}}" class="nav-link {{ request()->is('parametre-paiement') ? 'active' : '' }}">
                        <p>Montant du paiement</p>
                    </a>
                </li>
                @endif
                @if(hasPermission('afficher_code_marchand'))
                <li class="nav-item">
                    <a href="{{route('codeMarchant')}}" class="nav-link {{ request()->is('code-paiement') ? 'active' : '' }}">
                        <p>Code marchand</p>
                    </a>
                </li>
                @endif
                @if(hasPermission('afficher_message'))
                <li class="nav-item ">
                    <a href="{{route('messages')}}" class="pull-right nav-link {{ request()->is('messages') ? 'active' : '' }}">
                        <p>Messages</p>
                    </a>
                </li>
                @endif
                @if(hasPermission('afficher_cahier_charge'))
                <li class="nav-item ">
                    <a href="{{route('cahier-de-charge')}}" class="pull-right nav-link {{ request()->is('cahier-de-charge') ? 'active' : '' }}">
                        <p>Cahier de charge</p>
                    </a>
                </li>
                @endif
                @if(hasPermission('afficher_forme_juridique'))
                <li class="nav-item ">
                    <a href="{{route('forme-juridiques')}}" class="pull-right nav-link {{ request()->is('forme-juridiques') ? 'active' : '' }}">
                        <p>Formes Juridiques</p>
                    </a>
                </li>
                @endif
                @if(hasPermission('afficher_membre'))
                <li class="nav-item ">
                    <a href="{{route('membre-commission-index')}}" class="pull-right nav-link {{ request()->is('steppers') ? 'active' : '' }}">
                        <p>Membres de la commission</p>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
    </ul>
</nav>
