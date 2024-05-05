{{ Form::open(['url' => 'projects', 'method' => 'post','enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    {{-- start for ai module--}}
    @php
        $plan= \App\Models\Utility::getChatGPTSettings();
    @endphp
    
    
    <div class="row mb-3">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                {{ Form::label('project_name', __('Project Name'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                {{ Form::text('project_name', null, ['class' => 'form-control','required'=>'required']) }}
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date'), ['class' => 'form-label']) }}
                {{ Form::date('start_date', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-sm-6 col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date'), ['class' => 'form-label']) }}
                {{ Form::date('end_date', null, ['class' => 'form-control']) }}
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-4 col-md-4 mb-3">
            <div class="form-group">
                {{ Form::label('client', __('Client'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {!! Form::select('client', $clients, null,array('class' => 'form-control','required'=>'required')) !!}
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
    {{-- <div class="row mb-3">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                {{ Form::label('tag', __('Tag'), ['class' => 'form-label']) }}
                {{ Form::text('tag', null, ['class' => 'form-control', 'data-toggle' => 'tags']) }}
            </div>
        </div>
    </div> --}}
    <div class="row mb-3">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                {{ Form::label('status', __('Status'), ['class' => 'form-label']) }}
                <select name="status" id="status" class="form-control main-element">
                    @foreach(\App\Models\Project::$project_status as $k => $v)
                        <option value="{{$k}}">{{__($v)}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <hr>
    <div class="row mb-3">
        <div style=" display: flex; justify-content: space-between; ">
            <h4>{{__('Services')}}</h4>
            <button type="button" id="addService" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    {{ Form::label('services', __('Service'), ['class' => 'form-label']) }}
                    <select name="services[]" id="services" class="form-control main-element" required>
                        @foreach($services as $service)
                            <option value="{{$service->id}}">{{__($service->name)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    {{ Form::label('financial_value', __('Financial value'), ['class' => 'form-label']) }}
                    <input type="number" name="financial_value[]" id="financial_value" required step="0.01" min="0" value="0" class="form-control">
                </div>
            </div>
        </div>
        <div id="servicesData" class="mt-3"></div>
    </div>

</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
</div>
{{Form::close()}}
