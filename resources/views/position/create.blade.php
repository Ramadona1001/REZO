{{Form::open(array('url'=>'position','method'=>'post'))}}
    <div class="modal-body">

    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="form-group">
                <label for="id">{{ __('Position ID') }}</label>
                <input type="text" value="{{ $positionId }}" readonly class="form-control" style="background: #ececec">
            </div>
        </div>

        <div class="col-12">
            <div class="form-group mb-2">
                {{Form::label('name',__('Name'),['class'=>'form-label'])}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Position Name')))}}
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group mb-2">
                {{Form::label('descriptions',__('Descriptions'),['class'=>'form-label'])}}
                {{Form::textarea('descriptions',null,array('class'=>'form-control','placeholder'=>__('Enter Position Descriptions')))}}
                @error('descriptions')
                <span class="invaliD-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                {{Form::label('slaray_range',__('Salary Range'),['class'=>'form-label'])}}
                {{Form::text('slaray_range',null,array('class'=>'form-control','placeholder'=>__('Enter Salary Range')))}}
                @error('slaray_range')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

    </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Create')}}" class="btn  btn-primary">
    </div>
    {{Form::close()}}

