
{{ Form::model($freelancer, array('route' => array('freelancers.store_projects', $freelancer->id), 'method' => 'POST')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group mb-3 col-12">
            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}
            {{ Form::text('name', null, array('class' => 'form-control','placeholder'=>__('Name'),'required'=>'required')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('total_hours', __('Total Hours'),['class'=>'form-label']) }}
            {{ Form::number('total_hours', null, array('class' => 'form-control','placeholder'=>__('Total Hours'),'required'=>'required')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('amount', __('Amount'),['class'=>'form-label']) }}
            {{ Form::number('amount', null, array('class' => 'form-control','placeholder'=>__('Amount'),'required'=>'required')) }}
        </div>
        <div class="form-group mb-3 col-12">
            {{ Form::label('content', __('Content'),['class'=>'form-label']) }}
            {{ Form::textarea('content', null, array('class' => 'form-control','placeholder'=>__('Content'))) }}
        </div>

    </div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Save')}}" class="btn  btn-primary">
</div>
{{Form::close()}}


