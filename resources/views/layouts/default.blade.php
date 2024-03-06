<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GAMA</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    @livewireStyles
  <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @yield('css')
    <style>
        .bg-gradient-primary,
        .btn-primary {
            background: #007481 !important;
            border: 1px solid #007481;
        }

        .layout-navbar-fixed .wrapper .sidebar-dark-primary .brand-link:not([class*="navbar"]) {
            background: #007481 !important;
            color: #fff !important;
        }

        .sidebar-user-name {
            font-size: 22px !important;
            /* color: white !important; */
        }

        .card-title {
            font-size: 22px;
            /* font-weight: bold; */
        }

        .nav-item p {
            font-size: 19px;
        }

        .btn-primary:hover {
            border: 1px solid #007481;
        }

        .nav-treeview .nav-item {
            padding: 8px 32px;
            display: block;
            position: relative;
            transition: all .4s;
        }

        /* .nav-link:hover {
            color: #fff !important;
        } */

        .sidebar-title a {
            font-size: 18px !important;
            font-weight: bold !important;
            color: black !important;
        }

        .user-panel a {
            text-align: center !important;
            color: black;
        }

        .user-panel {
            color: #fff !important;
        }

        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active {
            background-color: transparent;
            color: #fff;
        }

        [class*="sidebar-dark-"] .nav-treeview>.nav-item>.nav-link.active,
        [class*="sidebar-dark-"] .nav-treeview>.nav-item>.nav-link.active:hover,
        [class*="sidebar-dark-"] .nav-treeview>.nav-item>.nav-link.active:focus {
            background-color: transparent;
            color: #fff;
            font-weight: bold;
        }

        [class*="sidebar-dark-"] .nav-sidebar>.nav-item>.nav-link.active {
            color: #fff;
            box-shadow: none;

        }

        .btn-info {
            color: #fff;
            background-color: #17a2b8;
            border-color: #17a2b8;
            box-shadow: none;
        }

        .active .bs-stepper-circle {
            background-color: #17a2b8;
        }

        .page-title:hover {
            color: black !important;
        }

        .page-title {
            color: black !important;
            font-size: 20px !important;
            font-weight: bold !important;
        }

        [class*="sidebar-dark-"] .sidebar a {
            color: #fff !important;
        }

        [class*="sidebar-dark"] .user-panel {
            border-bottom: 1px solid white;
        }

        .layout-navbar-fixed .wrapper .sidebar-dark-primary .brand-link:not([class*="navbar"]) {
            border-bottom: 1px solid white;
        }

        .statistique {
            color: #fff !important;
            background-color: #17a2b8 !important;
            border-color: #17a2b8 !important;
            box-shadow: none;
        }

        .swal-actions {
            margin: 0 2em;
        }

        .btn-confirm {
            order: 1;
        }

        .btn-cancel {
            order: 2;
        }

        .btn-deny {
            order: 3;
        }

        .right-gap {
            margin-right: auto;
        }

        .swal-footer {
            text-align: center !important;
        }

        .swal-modal .swal-footer {
            direction: rtl !important;
        }
    </style>
    @livewireStyles
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div id="app">
        <div class="wrapper">
            @include('layouts.sidbar')
            <aside class="main-sidebar sidebar-dark-primary" style="background: #007481 !important;">
                <a href="@if(auth()->check() && auth()->user()->role->nom != 'Promoteur') / @else /mes-medias @endif"
                    class="brand-link mt-0">
                        <img src="{{ asset('logos/logo-2.png')}}" alt="" style="width:170px; height:70px;">
                </a>
                {{-- <div>
                    <img src="{{ asset('logos/logo-2.png')}}" alt="" class="img-logo">
                </div> --}}
                <div class="sidebar">
                    <div class="user-panel text-left mt-5">
                        <div class="info text-center">
                            <a style="color: white !important;" class="text-center sidebar-user-name"
                                href="@if(auth()->check() && auth()->user()->role->nom != 'Promoteur') / @else /mes-medias @endif"
                                class="d-block">
                                {{ auth()->check()? auth()->user()->nom.' '.auth()->user()->prenom : ''}} </a>
                        </div>
                    </div>
                    @include('layouts.menu')
                </div>
            </aside>

            <div class="content-wrapper">
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">@yield('titre-page')</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item active"></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
            </div>
            @include('layouts.sidebarRight')
            @include('layouts.footer')
        </div>
        @include('sweetalert::alert')
    </div>
    @livewireScripts
    <script src="{{asset('js/script.js')}} "></script>
    <script src="{{asset('js/app.js')}} "></script>
    <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    <script src="{{asset('plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.js')}}"></script>
    <script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

    <script src="{{asset('js/bootstrap.js')}}"></script>

    <script src="{{asset('backend/assets/js/apexcharts.js')}}"></script>

    @stack('js')
    @yield('script')
    @livewireScripts
    @include('sweetalert::alert')

</body>

</html>
