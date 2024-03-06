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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css"/>

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
            .size-text{
                font-size: 20px;
            }

            .bg-main {
                background-color: #007481 !important;
            }

            .bg-gris-fonce{
                background: #696969 !important;
                border: 1px solid #696969;
                color: white !important;
                font-size: 18px;
            }

            .iti--allow-dropdown input, .iti--allow-dropdown input[type=text] {
                padding-right: 0px;
                width: 100%;
            }

            .intl-tel-input{
                width: 100%;
            }

            .iti {
                width: 100%;
            }

            .iti__country-name {
                color: black !important;
            }
        </style>
        @livewireStyles
    </head>

    <body class="">

        <div class="account-pages mt-2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-3 text-center">
                        <img src="{{ asset('logos/logo-1.png') }}"  alt="" height="250" >
                    </div>
                    <div class="col-md-6 text-center">
                        <h2>République de Guinée</h2>
                        <h3><span style="color:red;">Travail</span> - <span style="color:yellow;">Justice</span> - <span style="color:green;">Solidarité</span></h3>
                        <h3>{{ __("Bienvenue sur la plateforme de demande d’agrément des radios et télévisions privées")}}</h3>
                    </div> <!-- end col -->

                    <div class="col-md-3 text-center">
                        <img src="{{ asset('backend/assets/images/gn.png')}}"  alt="" height="100" >
                    </div>
                </div>
                <div class="row justify-content-center mt-1">
                    <div class="col-xl-9">
                        @yield('content')

                    </div>
                </div>

            </div>
        </div>
        <footer class="footer footer-alt text-bg-dark">
            <div class="text-center">
                <h3>Ministère de l'information et de la communication </h3>
                <h4 class="mt-0 text-black bold">{{ __("Direction Nationale de la Communication et des Relations avec les Médias Privés") }}</h4>
            </div>
            <div class="text-right h-20">
                &copy; {{ date("Y") }} réalisée par <a href="https://ande.gov.gn/" class="text-blue" target="_blank" rel="noopener noreferrer">ANDE</a>
            </div>
        </footer>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="{{ asset('backend/assets/js/vendor.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('backend/assets/js/app.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

        <script>
            const phoneInputField = document.querySelector("#phone");
            const phoneInput = window.intlTelInput(phoneInputField, {
                initialCountry: "gn",
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                nationalMode: false,
                formatOnDisplay: true,
                onlyCountries: ["gn"]
            });
        </script>
        @yield('script')
        @livewireScripts
        @include('sweetalert::alert')
    </body>

</html>
