{{ Form::model($productService, array('route' => array('service.update', $productService->id), 'method' => 'PUT','enctype' => "multipart/form-data")) }}
<div class="modal-body">
    {{-- start for ai module--}}
    @php
        $plan= \App\Models\Utility::getChatGPTSettings();
    @endphp
    @if($plan->chatgpt == 1)
    {{-- <div class="text-end">
        <a href="#" data-size="md" class="btn  btn-primary btn-icon btn-sm" data-ajax-popup-over="true" data-url="{{ route('generate',['productservice']) }}"
           data-bs-placement="top" data-title="{{ __('Generate content with AI') }}">
            <i class="fas fa-robot"></i> <span>{{__('Generate with AI')}}</span>
        </a>
    </div> --}}
    @endif
    {{-- end for ai module--}}
    <div class="row">
        <div class="form-group mb-3">
            {{ Form::label('Service ID', __('Service ID'),['class'=>'form-label']) }}
            {{ Form::text('Service ID', $serviceId, array('class' => 'form-control','placeholder'=>__('Enter client Name'),'required'=>'required','readonly'=>'readonly')) }}
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                {{ Form::label('name', __('Name'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {{ Form::text('name',null, array('class' => 'form-control','required'=>'required')) }}
            </div>
        </div>
        
        <div class="col-md-6 mb-3">
            <div class="form-group">
                {{ Form::label('hourly_rate', __('Hourly Rate'),['class'=>'form-label']) }}<span class="text-danger">*</span>
                {{ Form::text('hourly_rate', null, array('class' => 'form-control','required'=>'required')) }}
            </div>
        </div>
        
        <div class="form-group  col-md-12 mb-3">
            {{ Form::label('description', __('Description'),['class'=>'form-label']) }}
            {!! Form::textarea('description', null, ['class'=>'form-control','rows'=>'2']) !!}
        </div>


    </div>
</div>
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{Form::close()}}

