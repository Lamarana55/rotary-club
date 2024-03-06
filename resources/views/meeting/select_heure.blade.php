<form action="{{ route("meetings.store") }}" method="post">
    <input type="hidden" name="date" value="{{ $date }}">
    <input type="hidden" name="day_name" value="{{ $dayName }}">
    <input type="hidden" name="media" value="{{ $media }}">
    <h3>{{ $formatDate }}</h3>
    <h4 class="message"></h4>
    <div class="col-sm-6">
        <!-- radio -->
        <div class="form-group">
            @foreach($programmes as $key => $programme)
                <div class="custom-control custom-radio">
                    <input style="" class="custom-control-input" type="radio" id="{{ $programme->uuid }}" name="heure" value="{{ $programme->uuid }}">
                    <label for="{{ $programme->uuid }}" class="custom-control-label" style="font-size: 18px;">
                        {{ $programme->heure_debut }}H - {{ $programme->heure_fin }}H
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</form>
