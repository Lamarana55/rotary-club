@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

<div>
    <div wire:ignore>
        <label for="taskSelect" class="form-label">Select Tasks</label>
        <select class="form-control" id="taskSelect" multiple="multiple" wire:model="selectedTasks">
            {{-- @foreach ($tasks as $task)
                <option id="{{ $task->id }}">
                    {{ $task->title }}
                </option>
            @endforeach --}}
            <option value="CA">California</option>
            <option value="NV">Nevada</option>
            <option value="OR">Oregon</option>
            <option value="WA">Washington</option>
        </select>
    </div>
    <div class="my-3">
        Selected Tasks :
        {{ collect($selectedTasks)->join(', ') }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

<script>
    $(document).ready(function() {
        $('#taskSelect').select2();

        $('#taskSelect').on('change', function(e) {
            @this.set('selectedTasks', $(this).val());
        });
    });
</script>
