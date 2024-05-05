{{Form::model($department,array('route' => array('department.update', $department->id), 'method' => 'PUT')) }}
<div class="modal-body">

    <div class="row ">
        <div class="form-group mb-3">
            {{ Form::label('Department ID', __('Department ID'),['class'=>'form-label']) }}
            {{ Form::text('Department ID', $departmentId, array('class' => 'form-control','placeholder'=>__('Enter client Name'),'required'=>'required','readonly'=>'readonly')) }}
        </div>
        <div class="col-12">
            <div class="form-group">
                {{Form::label('manager_id',__('Manager'),['class'=>'form-label'])}}
                {{Form::select('manager_id',$employees,null,array('class'=>'form-control select','placeholder'=>__('Select Manager')))}}
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                {{Form::label('name',__('Name'))}}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Department Name')))}}
                @error('name')
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
    <input type="submit" value="{{__('Update')}}" class="btn  btn-primary">
</div>
{{Form::close()}}
