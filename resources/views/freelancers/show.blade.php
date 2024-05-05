
{{ Form::model($freelancer, array('route' => array('freelancers.update', $freelancer->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group mb-3 col-6">
            {{ Form::label('name', __('Name'),['class'=>'form-label']) }}
            {{ Form::text('name', null, array('class' => 'form-control','placeholder'=>__('Name'),'required'=>'required','readonly'=>'readonly')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('email', __('Email'),['class'=>'form-label']) }}
            {{ Form::text('email', null, array('class' => 'form-control','placeholder'=>__('email'),'required'=>'required','readonly'=>'readonly')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('mobile', __('Mobile'),['class'=>'form-label']) }}
            {{ Form::text('mobile', null, array('class' => 'form-control','placeholder'=>__('Mobile'),'required'=>'required')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('main_category', __('Main Category'),['class'=>'form-label']) }}
            {{ Form::text('main_category', null, array('class' => 'form-control','placeholder'=>__('Main Category'),'required'=>'required','readonly'=>'readonly')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('sub_category', __('Sub Category'),['class'=>'form-label']) }}
            {{ Form::text('sub_category', null, array('class' => 'form-control','placeholder'=>__('Sub Category'),'required'=>'required','readonly'=>'readonly')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('hourly_rate', __('Hourly Rate'),['class'=>'form-label']) }}
            {{ Form::text('hourly_rate', null, array('class' => 'form-control','placeholder'=>__('Hourly Rate'),'required'=>'required','readonly'=>'readonly')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('profile_link', __('Profile Link'),['class'=>'form-label']) }}
            {{ Form::text('profile_link', null, array('class' => 'form-control','placeholder'=>__('Profile Link'),'required'=>'required','readonly'=>'readonly')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('city', __('City'),['class'=>'form-label']) }}
            {{ Form::text('city', null, array('class' => 'form-control','placeholder'=>__('City'),'required'=>'required','readonly'=>'readonly')) }}
        </div>
        <div class="form-group mb-3 col-6">
            {{ Form::label('country', __('Country'),['class'=>'form-label']) }}
            {{ Form::text('country', null, array('class' => 'form-control','placeholder'=>__('Country'),'required'=>'required','readonly'=>'readonly')) }}
        </div>
        <div class="form-group mb-3 col-12">
            {{ Form::label('comment', __('Country'),['class'=>'form-label']) }}
            {{ Form::textarea('comment', null, array('class' => 'form-control','placeholder'=>__('Comments'),'readonly'=>'readonly')) }}
        </div>

    </div>
</div>


{{Form::close()}}


