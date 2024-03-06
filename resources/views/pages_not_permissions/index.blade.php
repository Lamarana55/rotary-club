@section('css')
<!-- App css -->
<link href="{{asset("backend/assets/css/config/material/app.min.css")}}" rel="stylesheet" type="text/css" id="app-style"/>
<!-- icons -->
<link href="{{asset("backend/assets/css/icons.min.css")}}" rel="stylesheet" type="text/css" />
@endsection
<div class="row justify-content-center">
    <div class="col-lg-6 col-xl-4 mb-4">
        <div class="error-text-box">
            <svg viewBox="0 0 600 200">
                <!-- Symbol-->
                <symbol id="s-text">
                    <text text-anchor="middle" x="50%" y="50%" dy=".35em">404!</text>
                </symbol>
                <!-- Duplicate symbols-->
                <use class="text" xlink:href="#s-text"></use>
                <use class="text" xlink:href="#s-text"></use>
                <use class="text" xlink:href="#s-text"></use>
                <use class="text" xlink:href="#s-text"></use>
                <use class="text" xlink:href="#s-text"></use>
            </svg>
        </div>
        <div class="text-center">
            <h2 class="mt-0 mb-2">Page non trouvée</h2>
            <p class="mb-3">Vous n'avez pas la permission d'accéder à cette page</p>
        </div>
        <!-- end row -->

    </div> <!-- end col -->
</div>
@section('js')
<script src="{{asset('backend/assets/js/vendor.min.js')}}"></script>

<!-- App js -->
<script src="{{asset("backend/assets/js/app.min.js")}}"></script>
@endsection
