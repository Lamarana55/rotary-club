<form action="/meeting/{{ $meeting->id }}/cancel" method="post">
    <h4>Veuillez préciser la raison de l'annulation du rendez-vous avec le média <b>{{ $meeting->media->nom }}</b></h4>
    <h4 class="message"></h4>
    <div class="form-group">
        <label for="motif">Motif de l'annulation:</label>
        <textarea name="motif" id="motif" cols="30" rows="10" class="form-control"></textarea>
    </div>
</form>
