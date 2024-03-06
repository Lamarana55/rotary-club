<div>

    @if(!empty($successMessage))
    <div class="alert alert-success">
       {{ $successMessage }}
    </div>
    @endif

    <div class="text-center">
        <!-- progressbar -->
        <ul class="">
            <li class="{{ $currentStep != 1 ? '' : 'active' }}"><a href="#step-1" type="button">Step 1</a></li>
            <li class="{{ $currentStep != 2 ? '' : 'active' }}"><a href="#step-2" type="button">Step 2</a></li>
            <li class="{{ $currentStep != 3 ? '' : 'active' }}"><a href="#step-3" type="button" disabled="disabled">Step 3</a></li>
        </ul>
    </div>
        <div class="row setup-content {{ $currentStep != 1 ? 'displayNone' : '' }}" id="step-1">
            <div class="col-xs-12">
                <div class="col-md-12">
                    <h3> Step 1</h3>
                    <div class="form-group">
                        <label for="title">Product Name:</label>
                        <input type="text" wire:model="name" class="form-control" id="taskTitle">
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Product Amount:</label>
                        <input type="text" wire:model="amount" class="form-control" id="productAmount"/>
                        @error('amount') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Product Description:</label>
                        <textarea type="text" wire:model="description" class="form-control" id="taskDescription">{{{ $description ?? '' }}}</textarea>
                        @error('description') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <button class="btn btn-primary nextBtn btn-lg pull-right" wire:click="firstStepSubmit" type="button" >Next</button>
                </div>
            </div>
        </div>
        <div class="row setup-content {{ $currentStep != 2 ? 'displayNone' : '' }}" id="step-2">
            <div class="col-xs-12">
                <div class="col-md-12">
                    <h3> Step 2</h3>
                    <div class="form-group">
                        <label for="description">Product Status</label><br/>
                        <label class="radio-inline"><input type="radio" wire:model="status" value="1" {{{ $status == '1' ? "checked" : "" }}}> Active</label>
                        <label class="radio-inline"><input type="radio" wire:model="status" value="0" {{{ $status == '0' ? "checked" : "" }}}> DeActive</label>
                        @error('status') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Product Stock</label>
                        <input type="text" wire:model="stock" class="form-control" id="productAmount"/>
                        @error('stock') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" wire:click="secondStepSubmit">Next</button>
                    <button class="btn btn-danger nextBtn btn-lg pull-right" type="button" wire:click="back(1)">Back</button>
                </div>
            </div>
        </div>
        <div class="row setup-content {{ $currentStep != 3 ? 'displayNone' : '' }}" id="step-3">
            <div class="col-xs-12">
                <div class="col-md-12">
                    <h3> Step 3</h3>
                    <table class="table">
                        <tr>
                            <td>Product Name:</td>
                            <td><strong>{{$name}}</strong></td>
                        </tr>
                        <tr>
                            <td>Product Amount:</td>
                            <td><strong>{{$amount}}</strong></td>
                        </tr>
                        <tr>
                            <td>Product status:</td>
                            <td><strong>{{$status ? 'Active' : 'DeActive'}}</strong></td>
                        </tr>
                        <tr>
                            <td>Product Description:</td>
                            <td><strong>{{$description}}</strong></td>
                        </tr>
                        <tr>
                            <td>Product Stock:</td>
                            <td><strong>{{$stock}}</strong></td>
                        </tr>
                    </table>
                    <button class="btn btn-success btn-lg pull-right" wire:click="submitForm" type="button">Finish!</button>
                    <button class="btn btn-danger nextBtn btn-lg pull-right" type="button" wire:click="back(2)">Back</button>
                </div>
            </div>
        </div>
    </div>
