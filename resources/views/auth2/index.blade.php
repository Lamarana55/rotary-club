
<div wire:ignore.self >

    @if($currentPage == PAGELOGINS)
        @include("auth.login")
    @endif

    @if($currentPage == PAGEINSCRIPTION)
        @include("auth.register")
    @endif

    @if($currentPage == PAGEMOTDEPASSEOUBLIER)
        @include("auth.verify")
    @endif

    @if($currentPage == PAGECHANGERMOTDEPASSE)
        @include("auth.form_update_password")
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
    window.addEventListener("showConfirmMessageDeleteTypeMedia", event=>{
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
               @this.deleteTypeMedia(event.detail.message.id)
            }
        })
    })
  </script>

<script type="text/javascript">
    setTimeout(function () {
        $('#alert').alert('close');
    }, 10000);
</script>
