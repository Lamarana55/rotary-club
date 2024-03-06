@section('css')
<link href="{{asset('assets/libs/mohithg-switchery/switchery.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/multiselect/css/multi-select.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/selectize/css/selectize.bootstrap3.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
<div wire:ignore.self>
    @if($currentPage == PAGEPERMISSION)
        @include("gestionRolePermissions.permission")
    @endif
    @if($currentPage == PAGELISTE)
        @include("gestionRolePermissions.liste")
    @endif

</div>
<script>
    window.addEventListener("showSuccessMessage", event=>{
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
</script>
@section('script')
<script src="{{asset('assets/libs/selectize/js/standalone/selectize.min.js')}}"></script>
<script src="{{asset('assets/libs/mohithg-switchery/switchery.min.js')}}"></script>
<script src="{{asset('assets/libs/multiselect/js/jquery.multi-select.js')}}"></script>
<script src="{{asset('assets/libs/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/libs/jquery-mockjax/jquery.mockjax.min.js')}}"></script>
<script src="{{asset('assets/libs/devbridge-autocomplete/jquery.autocomplete.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>

@endsection

