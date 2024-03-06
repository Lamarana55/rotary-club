@php
    $jours = collect([
        "Lundi",
        "Mardi",
        "Mercredi",
        "Jeudi",
        "Vendredi",
        "Samedi"
    ])
@endphp
<form action="{{ route("disponibilites.store") }}" method="post">
    <h3 class="message"></h3>
    <div class="form-group">
        <label for="jour">Jour <i class="text-danger">*</i></label>
        <select name="jour" id="jour" class="form-control">
            <option value="">Selectionner un jour</option>
            @foreach($jours as $key => $jour)
                <option value="{{ $jour }}">{{ $jour }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="heure_debut">Heure de debut <i class="text-danger">*</i></label>
        <select name="heure_debut" id="heure_debut" class="form-control">
            <option value="">Selectionner une heure</option>
            @for($i = 8; $i <= 18; $i++)
                <option value="{{ $i }}">{{ $i }} H</option>
            @endfor
        </select>
    </div>

    <div class="form-group">
        <label for="heure_fin">Heure de fin <i class="text-danger">*</i></label>
        <select name="heure_fin" id="heure_fin" class="form-control">
            <option value="">Selectionner une heure</option>
            @for($i = 8; $i <= 18; $i++)
                <option value="{{ $i }}">{{ $i }} H</option>
            @endfor
        </select>
    </div>
</form>
