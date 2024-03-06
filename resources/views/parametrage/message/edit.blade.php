<div class="modal fade" id="showModelEditMessage" tabindex="-1" aria-labelledby="showModelEditMessage" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-center">Modifier Le Message</h5>
            </div>
            <form wire:submit.prevent="updateMessage">
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="">Stepper:*</label>
                            <select class="form-control @error('stepper') is-invalid @enderror" wire:model="stepper">
                                <option value="">Selectionner</option>
                                @foreach(\App\Models\Stepper::all() as $key=> $item)
                                <option selected value="{{$item->id}}" >{{$item->nom}} </option>
                                @endforeach
                            </select>

                            @error("stepper")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="type_message">Type de Message:*</label>

                            <select id="type_message" class="form-control @error('type_message') is-invalid @enderror" wire:model="editMessage.type_message">
                                @foreach ($type_options as $type_option)
                                    <option value="{{ $type_option }}">{{ $type_option }}</option>
                                @endforeach
                            </select>
                            @error("type_message")
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="form-group flex-grow-1 mr-2">
                            <label for="message">Message:</label>
                            <textarea id="message" name="message" rows="4" cols="50" wire:model="editMessage.message" class="form-control @error('message') is-invalid @enderror">
                                @error("message")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" >
                    <button type="button" class="btn btn-danger float-left" data-bs-dismiss="modal">Fermer</button>
                    @if (hasPermission('modifier_message'))
                    <button type="submit" class="btn btn-primary float-right" >Modifier</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
