<select wire:model="filter" class="form-control" >
        <option value="">Tous</option>
    @if (auth()->user()->role->nom =='Direction')
        <option value="nouveaux">Nouveaux </option>
        <option value="acceptes">Acceptés</option>
        <option value="rejetes">Rejetés</option>
    @elseif(auth()->user()->role->nom =='DAF')
        <option value="nouveaux">Nouveaux</option>
        <option value="acceptes">Acceptés</option>
        <option value="rejetes">Rejetés</option>
    @elseif(auth()->user()->role->nom =='SGG')
        <option value="nouveaux">Nouveaux</option>
        <option value="agree">Agréé</option>
    @elseif(auth()->user()->role->nom =='Commission')
        <option value="en_cours">En cours</option>
        <option value="terminer">Acceptés</option>
        <option value="rejetes">Rejetés</option>
        <option value="revoir">Revoir</option>
    @elseif(auth()->user()->role->nom =='HAC')
        <option value="en_cours">En cours</option>
        <option value="terminer">Acceptés</option>
        <option value="rejeter">Rejetés</option>
        <option value="revoir">Revoir</option>
    @elseif(auth()->user()->role->nom =='ARPT')
        <option value="nouveaux">Nouveaux</option>
    @endif
</select>
