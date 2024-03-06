<div wire:ignore.self>
    @if($currentPage == PAGEEDITFORM)
        @include("utilisateurs.edit")
    @endif

    @if($currentPage == PAGECREATEFORM)
        @include("utilisateurs.add")
    @endif

    @if($currentPage == PAGEDETAILFORM)
        @include("utilisateurs.detail")
    @endif

    @if($currentPage == PAGELISTE)
        @include("utilisateurs.liste")
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
    window.addEventListener("showConfirmMessageDeleteUser", event=>{
       Swal.fire({
        title: event.detail.message.title,
        text: event.detail.message.text,
        icon: event.detail.message.type,
        showCancelButton: true,
        confirmButtonColor: '{{ DANGER }}',
        cancelButtonColor: '{{ SUCCESS }}',
        confirmButtonText: 'OUI',
        cancelButtonText: 'NON',
        reverseButtons: true,
        }).then((result) => {
            if(result.isConfirmed) {
               @this.deleteUser(event.detail.message.id)
            }
        })
    })

    window.addEventListener("showConfirmMessageActiveUser", event=>{
       Swal.fire({
        title: event.detail.message.title,
        text: event.detail.message.text,
        icon: event.detail.message.type,
        showCancelButton: true,
        confirmButtonColor: '{{ SUCCESS }}',
        cancelButtonColor: '{{ DANGER }}',
        confirmButtonText: 'OUI',
        cancelButtonText: 'NON',
        reverseButtons: true,
        }).then((result) => {
            if(result.isConfirmed) {
               @this.activeUser(event.detail.message.id)
            }
        })
    })

    window.addEventListener("showConfirmMessageActiveValider", event=>{
       Swal.fire({
        title: event.detail.message.title,
        text: event.detail.message.text,
        icon: event.detail.message.type,
        showCancelButton: true,
        confirmButtonColor: '{{ SUCCESS }}',
        cancelButtonColor: '{{ DANGER }}',
        confirmButtonText: 'OUI',
        cancelButtonText: 'NON',
        reverseButtons: true,
        }).then((result) => {
            if(result.isConfirmed) {
               @this.valideUser(event.detail.message.id,event.detail.message.isValid)
            }
        })
    })


    window.addEventListener("showConfirmMessage", event=>{
       Swal.fire({
        title: event.detail.message.title,
        text: event.detail.message.text,
        icon: event.detail.message.type,
        showCancelButton: true,
        confirmButtonColor: '{{ SUCCESS }}',
        cancelButtonColor: '{{ DANGER }}',
        confirmButtonText: 'OUI',
        cancelButtonText: 'NON',
        reverseButtons: true,
        }).then((result) => {
            if(result.isConfirmed) {
              @this.resetPassword(event.detail.message.id)
            }
        })
    })

    window.addEventListener("showConfirmMessageDelete", event=>{
       Swal.fire({
        title: event.detail.message.title,
        text: event.detail.message.text,
        icon: event.detail.message.type,
        showCancelButton: true,
        confirmButtonColor: '{{ SUCCESS }}',
        cancelButtonColor: '{{ DANGER }}',
        confirmButtonText: 'Active',
        cancelButtonText: 'NON',
        reverseButtons: true,
        }).then((result) => {
            if(result.isConfirmed) {
              @this.resetPassword(event.detail.message.id)
            }
        })
    })



     window.addEventListener("showvalideCompte", event=>{

       Swal.fire({
        title: event.detail.message.title,
        text: event.detail.message.text,
        icon: event.detail.message.type,
        showCancelButton: true,
        confirmButtonColor: '{{ SUCCESS }}',
        cancelButtonColor: '{{ DANGER }}',
        confirmButtonText: 'OUI',
        cancelButtonText: 'NON',
        reverseButtons: true,
        }).then((result) => {
            if(result.isConfirmed) {
               @this.valideCompteUser(event.detail.message.id)
            }
        })
    })
  </script>
