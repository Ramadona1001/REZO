{{ Form::model($custom_request, ['route' => ['customs.store.positions', $custom_request->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    @if ($custom_request_position < $custom_request->positions)
        <button type="button" class="btn btn-primary btn-sm" style=" display: block; margin-left: auto; margin-bottom: 20px; " id="addPosition">+</button>
    @endif
    <div class="row mb-3">
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('positions[]', __('Position Name'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                {{ Form::select('positions[]', $positions,null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('positions_count[]', __('Position Count'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                {{ Form::number('positions_count[]',$custom_request->positions, ['class' => 'form-control','step'=>0.01,'min' => 0]) }}
            </div>
        </div>
    </div>

    <div id="positionsData"></div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Save')}}" class="btn  btn-primary">
</div>
{{Form::close()}}

