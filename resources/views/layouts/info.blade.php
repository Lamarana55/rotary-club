@if (\Illuminate\Support\Facades\Session::has('msg'))
    <h5 id="alert" class="alert alert-danger mt-0">{{ Illuminate\Support\Facades\Session::get('msg') }}</h5>
@endif
@if (\Illuminate\Support\Facades\Session::has('info'))
    <h5 id="alert" class="alert alert-info">{{ Illuminate\Support\Facades\Session::get('info') }}</h5>
@endif
@if (\Illuminate\Support\Facades\Session::has('teste_update_password'))
    <h5 id="alert" class="alert alert-success">{{ Illuminate\Support\Facades\Session::get('teste_update_password') }}</h5>
@endif
@if (\Illuminate\Support\Facades\Session::has('messageemail'))
    <h5 id="alert" class="alert alert-success">{{ Illuminate\Support\Facades\Session::get('messageemail') }}</h5>
@endif
@if (\Illuminate\Support\Facades\Session::has('message_success'))
    <h5 id="alert" class="alert alert-success">{{ Illuminate\Support\Facades\Session::get('message_success') }}</h5>
@endif
@if (\Illuminate\Support\Facades\Session::has('expiration_token'))
    <h5 id="alert" class="alert alert-warning">{{ Illuminate\Support\Facades\Session::get('expiration_token') }}</h5>
@endif
@if (\Illuminate\Support\Facades\Session::has('testemail'))
    <h5 id="alert" class="alert alert-warning">{{ Illuminate\Support\Facades\Session::get('testemail') }}</h5>
@endif
@if ($errors->any())
    <h5 id="alert" class="alert alert-danger">{{ $errors->first() }}</h5>
@endif


<script type="text/javascript">
    setTimeout(function () {
        $('#alert').alert('close');
    }, 10000);
</script>
