
{{ Form::model($freelancer, array('route' => array('freelancers.update', $freelancer->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group mb-3">
            {{ Form::label('Freelancer ID', __('Freelancer ID'),['class'=>'form-label']) }}
            {{ Form::text('Freelancer ID', $freelancerId, array('class' => 'form-control','placeholder'=>__('Enter client Name'),'required'=>'required','readonly'=>'readonly')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}
            {{ Form::text('name', null, array('class' => 'form-control','placeholder'=>__('Enter freelancer Name'),'required'=>'required')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('email', __('Email'),['class'=>'form-label']) }}
            {{ Form::text('email', null, array('class' => 'form-control','placeholder'=>__('Enter freelancer email'),'required'=>'required')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('mobile', __('Mobile'),['class'=>'form-label']) }}
            {{ Form::text('mobile', null, array('class' => 'form-control','placeholder'=>__('Enter freelancer Mobile'),'required'=>'required')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('main_category', __('Main Category'),['class'=>'form-label']) }}
            {{ Form::text('main_category', null, array('class' => 'form-control','placeholder'=>__('Enter freelancer Main Category'),'required'=>'required')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('sub_category', __('Sub Category'),['class'=>'form-label']) }}
            {{ Form::text('sub_category', null, array('class' => 'form-control','placeholder'=>__('Enter freelancer Sub Category'),'required'=>'required')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('hourly_rate', __('Hourly Rate'),['class'=>'form-label']) }}
            {{ Form::text('hourly_rate', null, array('class' => 'form-control','placeholder'=>__('Enter freelancer Hourly Rate'),'required'=>'required')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('profile_link', __('Profile Link'),['class'=>'form-label']) }}
            {{ Form::text('profile_link', null, array('class' => 'form-control','placeholder'=>__('Enter freelancer Profile Link'),'required'=>'required')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('city', __('City'),['class'=>'form-label']) }}
            {{ Form::text('city', null, array('class' => 'form-control','placeholder'=>__('Enter freelancer City'),'required'=>'required')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('country', __('Country'),['class'=>'form-label']) }}
            {{ Form::text('country', null, array('class' => 'form-control','placeholder'=>__('Enter freelancer Country'),'required'=>'required')) }}
        </div>
        <div class="form-group mb-3 col-12">
            {{ Form::label('comment', __('Country'),['class'=>'form-label']) }}
            {{ Form::textarea('comment', null, array('class' => 'form-control','placeholder'=>__('Enter Comments'))) }}
        </div>

    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>

{{Form::close()}}


