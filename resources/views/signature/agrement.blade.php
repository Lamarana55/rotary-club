<form enctype="multipart/form-data" method="post" action="/meeting/{{ $meeting->id }}/signature">
    <h4>Meric d'importer la convention d’établissement signé de la <b>{{ $meeting->media->type.' '.$meeting->media->type_media.' '.$meeting->media->nom }}</b></h4>
    <h5 class="message"></h5>
    <div class="form-group mt-5">
        <label for="">Importer la convention d’établissement signé <i class="text-danger">*</i> </label>
        <input accept=".pdf" name="agrement" class="form-control" type="file" id="agrement" style="border: 1px solid black;">
    </div>
</form>
