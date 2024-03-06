<div wire:ignore.self>
    @if($currentPage == PAGEEDITFORM)
        @include("parametrage.message.edit")
    @endif

    @if($currentPage == PAGECREATEFORM)
        @include("parametrage.message.add")
    @endif

    @if($currentPage == PAGELISTE)
        @include("parametrage.message.liste")
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
          timer: 6000
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
            timer: 6000
            }
        )
    })
  </script>
  <script>
    window.addEventListener("showConfirmMessageDeleteMessage", event=>{
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
               @this.deleteMessage(event.detail.message.id)
            }
        })
    })
  </script>
