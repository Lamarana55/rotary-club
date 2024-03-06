<div wire:ignore.self>
    @if($currentPage == PAGELISTE)
        @include("parametrage.types.liste")
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

    window.addEventListener("showErrorMessage", event=>{
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            toast:true,
            title: event.detail.message || "Opération effectuée avec succès!",
            showConfirmButton: false,
            timer: 5000
            }
        )
    })
  </script>
  <script>
    window.addEventListener("showConfirmMessageDeleteTypePaiement", event=>{
       Swal.fire({
        title: event.detail.message.title,
        text: event.detail.message.text,
        icon: event.detail.message.type,
        showCancelButton: true,
        confirmButtonColor: '{{ SUCCESS }}',
        cancelButtonColor: '{{ DANGER }}',
        confirmButtonText: 'Continuer',
        cancelButtonText: 'Annuler',
        reverseButtons: true,
        }).then((result) => {
            if(result.isConfirmed) {
               @this.deleteTypePaiement(event.detail.message.id)
            }
        })
    })
  </script>
