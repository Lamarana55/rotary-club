@section("page")
Assignation des permissions
@endsection
<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light d-flex align-items-center">
                    <h3 class="card-title flex-grow-1"></h3>
                    <a href="{{route('roles')}}" class="btn btn-info text-white" ><i class="fas fa-times"></i> Retour </a>&nbsp;&nbsp;
                </div>
                <div class="card-body table-responsive p-0 table-striped" style="height: 800px;">
                    <div class="row m-2 p-2" wire:ignore>
                        @foreach($rolePermissions['permissions'] as $key => $permission)
                        <div class="col-md-3">
                            <div class="card card-default">
                                <div class="card-header">
                                <h3 class="card-title"> {{ucfirst(str_replace('-',' ',$permission['nom']))}} ({{count($permission['description'])}})</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                </div>
                                <div class="card-body">
                                    @foreach($permission['description'] as $keys => $value)
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input" wire:click="updateRoleAndPermissions('{{$value}}')"
                                            @if($this->checkPermissions($value) && $this->checkPermissions($value)->permission===$value) checked @endif
                                            id="customSwitchPermission.{{$value}}">
                                        <label class="custom-control-label" for="customSwitchPermission.{{$value}}">{{ucfirst(str_replace('_',' ',$value))}} </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
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





