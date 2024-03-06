<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>GAMA</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">

		<!-- App css -->
		<link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
		<link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

		<link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
		<link href="{{ asset('backend/assets/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="app-dark-stylesheet"  />

		<!-- icons -->
		<link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

        <style type="text/css">
            body{
                background:url({{ asset('backend/assets/images/armoiry.png') }}) center center no-repeat fixed;
                /* -webkit-background-size:cover;
                -moz-background-size:cover;
                -o-background-size:cover;
                background-size:cover;
                width:100%; */
            }

            .head-style {
                text-align: center;
                margin: 10px auto;
                width: 500px;
            }

            .bg-dark {
                background-color: rgba(50, 58, 70, 0.8) !important;
            }

            .bg-main {
                background-color: #007481 !important;
            }

            .bg-gradient-primary, .btn-primary{
                background: #007481 !important;
                border: 1px solid #007481;
            }

            .btn-primary:hover {
                border: 1px solid #007481;
            }

            .bg-gris-fonce{
                background: #696969 !important;
                border: 1px solid #696969;
                color: white !important;
                font-size: 18px;
            }

            /* img {
                max-width: 80%;
                height: auto;
            } */

            .container:before,
            .container:after {
                content: ""; display: block; clear: both;
            }

            .container {
                margin-bottom: 24px;
                *zoom: 1;
            }

        </style>
        @livewireStyles
    </head>
    <body>

        <div class="account-pages mt-3 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-3 text-center mt-0">
                        <img src="{{ asset('logos/logo-1.png')}}" alt="" height="250">
                    </div>
                    <div class="col-sm-6 text-center mt-1">
                        <h2>République de Guinée</h2>
                        <h3><span style="color:red;">Travail</span> - <span style="color:yellow;">Justice</span> - <span style="color:green;">Solidarité</span></h3> <br>
                        <h3>{{ __("Bienvenue sur la plateforme GAMA")}} </h3>
                        <h3 class="mt-2">Gestion des Agréments des Médias Audiovisuels</h3>
                    </div>
                    <div class="col-sm-3 text-center mt-3">
                        <img src="{{ asset('backend/assets/images/gn.png')}}"  alt="" height="100">
                    </div>
                </div>
                <div class="row justify-content-center mt-1">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer footer-alt text-bg-dark ">
            <div class="text-center">
                <h3>Ministère de l'information et de la communication </h3>
                <h4 class="mt-0 text-black bold">{{ __("Direction Nationale de la Communication et des Relations avec les Médias Privés") }}</h4>
            </div>
            <div class="text-right h-20">
                &copy; {{ date("Y") }} réalisée par <a href="https://ande.gov.gn/" class="text-blue" target="_blank" rel="noopener noreferrer">ANDE</a>
            </div>
        </footer>

        <!-- Vendor js -->
        <script src="{{ asset('backend/assets/js/vendor.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('backend/assets/js/app.min.js') }}"></script>
        @yield('script')
        @livewireScripts
        @include('sweetalert::alert')
    </body>

</html>
