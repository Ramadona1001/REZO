{{ Form::model($custom_request, ['route' => ['customs.update', $custom_request->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">

    <div class="row mb-3">
        <div class="form-group mb-3">
            {{ Form::label('Custom Request ID', __('Custom Request ID'),['class'=>'form-label']) }}
            {{ Form::text('Custom Request ID', $projectId, array('class' => 'form-control','placeholder'=>__('Enter client Name'),'required'=>'required','readonly'=>'readonly')) }}
        </div>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                {{ Form::label('request_name', __('Custom Request Name'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                {{ Form::text('request_name', null, ['class' => 'form-control','required'=>'required']) }}
            </div>
        </div>
    </div>
    
    <div class="row mb-3">
        <div class="col-sm-4 col-md-4 mb-3">
            <div class="form-group">
                {{ Form::label('positions', __('By Unit / Position'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {{ Form::select('unit_position', [
                    1 => __('Unit'),
                    2 => __('Position'),
                ],null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-sm-4 col-md-4 mb-3">
            <div class="form-group">
                {{ Form::label('positions', __('Positions'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {{ Form::number('positions', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-sm-4 col-md-4 mb-3">
            <div class="form-group">
                {{ Form::label('budget', __('Budget'), ['class' => 'form-label']) }}
                {{ Form::number('budget', null, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '4', 'cols' => '50']) }}
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                <select name="status" id="status" class="form-control main-element" >
                    @foreach(\App\Models\CustomRequest::$project_status as $k => $v)
                        <option value="{{$k}}" {{ ($custom_request->status == $k) ? 'selected' : ''}}>{{__($v)}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{Form::close()}}

