{{ Form::open(array('url' => 'suppliers')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group mb-3">
            {{ Form::label('Supplier ID', __('Supplier ID'),['class'=>'form-label']) }}
            {{ Form::text('Supplier ID', $supplierId, array('class' => 'form-control','placeholder'=>__('Enter client Name'),'required'=>'required','readonly'=>'readonly')) }}
        </div>
        <div class="form-group mb-3">
            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}
            {{ Form::text('name', null, array('class' => 'form-control','placeholder'=>__('Enter client Name'),'required'=>'required')) }}
        </div>
        <div class="form-group mb-3">
            {{ Form::label('industry', __('Industry'),['class'=>'form-label']) }}
            {{ Form::text('industry', null, array('class' => 'form-control','placeholder'=>__('Enter Client Industry'),'required'=>'required')) }}
        </div>
        <div class="form-group mb-3">
            {{ Form::label('address', __('Address'),['class'=>'form-label']) }}
            {{ Form::text('address', null, array('class' => 'form-control','placeholder'=>__('Enter Client Address'),'required'=>'required')) }}
        </div>
        <hr>
        <div class="form-group mb-3">
            <div class="d-flex justify-content-between">
                <h4>{{ __('Supplier Contacts') }}</h4>
                <button id="rowAdder" type="button" class="btn btn-sm btn-dark">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="row" style="background: #ededed; padding: 10px; border-top: 2px solid #c9c9c9; margin-top: 5px; border-bottom: 2px solid #c9c9c9;">
                <div class="col-6 mb-3">
                    <label for="contact_name">{{ __('Contact Name') }}</label>
                    <input type="text" name="contact_name[]" id="contact_name" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="position">{{ __('Contact Position') }}</label>
                    <input type="text" name="position[]" id="position" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="mobile">{{ __('Contact Mobile') }}</label>
                    <input type="text" name="mobile[]" id="mobile" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="email">{{ __('Contact Email') }}</label>
                    <input type="email" name="email[]" id="email" class="form-control" required>
                </div>
            </div>
            <div id="newinput"></div>
        </div>
       
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>

{{Form::close()}}


