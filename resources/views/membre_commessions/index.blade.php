<div wire:ignore.self>
@section('page')
Membres de la commission
@endsection

@include("membre_commessions.createUpdate")
  <div class="row">
    <div class="col-12">
      <div class="card card-default">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-8">
                    @if (hasPermission('créer_membre'))
                    <button class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#showModelAddTypeMedia">
                        Ajouter un membre
                    </button>
                    @endif
                </div>
                <div class="input-group input-group col-md-4 ">
                    <input type="text" class="form-control" wire:model.debounce.250ms="search" placeholder="Recherche ...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                </div>

            </div>
          <table class="table table-hover table-bordered membre_commission_list">
            <thead>
              <tr>
                <th>#</th>
                <th>Nom complet</th>
                <th>Role</th>
                <th>Fonction</th>
                <th>Catégorie</th>
                <th class="text-right">Action.s</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1;?>
              @foreach($membre_commissions as $member)
                <tr>
                  <td>{{$i++}}</td>
                  <td>{{ $member->full_name }}</td>
                  <td>{{ $member->fonction}}</td>
                  <td>{{ $member->fonction_occupe}}</td>
                  <td>{{ $member->category}}</td>
                  <td class="text-right">
                      <button wire:click='getMembre({{$member->id}})' data-bs-toggle="modal" data-bs-target="#showModelAddTypeMedia"  class="btn btn-sm btn-primary">Afficher</button>
                      @if (hasPermission('supprimer_membre'))
                        <a href="#" id="{{$member->id}}" class="btn btn-sm btn-danger membre_commission">Supprimer</a>
                      @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

        </div>
        <div class="card-footer">
            {{ $membre_commissions->links() }}
        </div>
      </div>

    </div>
  </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>

  <script>
     $(document).ready(function(){
      console.log("object");
      $('.membre_commission_list').on('click', '.membre_commission', function(e) {
        e.preventDefault();
        var id = $(this).attr('id');

        Swal.fire({
          title: 'Confirmation',
          text: "Etes-vous sûr de supprimer ce membre à la liste commission ? ",
          icon: 'info',
          showCancelButton: true,
          confirmButtonColor: '{{ DANGER }}',
          cancelButtonColor: '{{ SUCCESS }}',
          cancelButtonText: 'NON',
          confirmButtonText: 'OUI',
          reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                  url: "{{route('membre-commission-destroy')}}",
                  type:'GET',
                  data: {id:id},
                  success: function(data) {
                      if(data.success){
                          window.location.reload();
                          swal.fire({
                              position: 'top-end',
                              icon: 'success',
                              toast: true,
                              title: data.message,
                              showConfirmButton: false,
                              timer: 4000,
                          });
                      }else{
                          window.location.reload();
                          swal.fire({
                              position: 'top-end',
                              icon: 'error',
                              toast: true,
                              title: data.message,
                              showConfirmButton: false,
                              timer: 4000,
                          });;
                      }
                  },
                });
            }
          });

      })

     })
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
</div>
