
    {{Form::model($designation,array('route' => array('designation.update', $designation->id), 'method' => 'PUT')) }}
    <div class="modal-body">

    <div class="row">
        <div class="col-12">
            <div class="form-group mb-3">
                {{ Form::label('Section ID', __('Section ID'),['class'=>'form-label']) }}
                {{ Form::text('Section ID', $sectionId, array('class' => 'form-control','placeholder'=>__('Enter client Name'),'required'=>'required','readonly'=>'readonly')) }}
            </div>
            <div class="form-group">
                {{Form::label('name',__('Name'),['class'=>'form-label'])}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Department Name')))}}
                @error('name')
                <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                {{Form::label('descriptions',__('Descriptions'),['class'=>'form-label'])}}
                {{Form::textarea('descriptions',null,array('class'=>'form-control','placeholder'=>__('Enter Designation Descriptions')))}}
                @error('descriptions')
                <span class="invaliD-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

    </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
    </div>
    {{Form::close()}}

