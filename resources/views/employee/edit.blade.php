@extends('layouts.admin')
@section('page-title')
    {{__('Edit Employee')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('employee.index')}}">{{__('Employee')}}</a></li>
    <li class="breadcrumb-item">{{$employeesId}}</li>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            {{ Form::model($employee, array('route' => array('employee.update', $employee->id), 'method' => 'PUT' , 'enctype' => 'multipart/form-data')) }}
            @csrf
        </div>
    </div>
    <div class="row ">
        <div class="col-md-12 mb-3">
            <div class="card emp_details">
                <div class="card-header"><h6 class="mb-0">{{__('Employee Data')}}</h6></div>
                <div class="card-body employee-detail-edit-body">

                    <div class="row">
                        <div class="form-group col-md-12 mb-2">
                            {!! Form::label('employee_id', __('Employee ID'),['class'=>'form-label']) !!}
                            {!! Form::text('employee_id',$employeesId, ['class' => 'form-control','disabled'=>'disabled']) !!}
                        </div>

                        <div class="form-group col-md-6  mb-2">
                            {!! Form::label('name', __('Name'),['class'=>'form-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::text('name', null, ['class' => 'form-control','required' => 'required']) !!}
                        </div>
                        <div class="form-group col-md-6  mb-2">
                            {!! Form::label('phone', __('Phone'),['class'=>'form-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::number('phone',null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-md-6  mb-2">

                            {!! Form::label('dob', __('Date of Birth'),['class'=>'form-label']) !!}<span class="text-danger pl-1">*</span>
                            {!! Form::date('dob', null, ['class' => 'form-control']) !!}

                        </div>
                        <div class="form-group col-md-6  mb-2">
                            {!! Form::label('gender', __('Gender'),['class'=>'form-label']) !!}<span class="text-danger pl-1">*</span>
                            <div class="d-flex radio-check mt-2">
                                <div class="form-check form-check-inline form-group">
                                    <input type="radio" id="g_male" value="Male" name="gender" class="form-check-input" {{($employee->gender == 'Male')?'checked':''}}>
                                    <label class="form-check-label" for="g_male">{{__('Male')}}</label>
                                </div>
                                <div class="form-check form-check-inline form-group">
                                    <input type="radio" id="g_female" value="Female" name="gender" class="form-check-input" {{($employee->gender == 'Female')?'checked':''}}>
                                    <label class="form-check-label" for="g_female">{{__('Female')}}</label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group mb-2">
                                {!! Form::label('city', __('City'), ['class' => 'form-label']) !!}<span class="text-danger pl-1">*</span>
                                {!! Form::text('city', null, ['class' => 'form-control', 'rows' => 2 ,'placeholder'=>'Enter employee city' , 'required' => 'required']) !!}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group mb-2">
                                {!! Form::label('country', __('Country'), ['class' => 'form-label']) !!}<span class="text-danger pl-1">*</span>
                                {!! Form::text('country', null, ['class' => 'form-control', 'rows' => 2 ,'placeholder'=>'Enter employee country' , 'required' => 'required']) !!}
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                {!! Form::label('address', __('Address'),['class'=>'form-label']) !!}<span class="text-danger pl-1">*</span>
                                {!! Form::textarea('address',null, ['class' => 'form-control','rows'=>2]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                
                
                @if(\Auth::user()->type=='employee')
                    {!! Form::submit('Update', ['class' => 'btn-create btn-xs badge-blue radius-10px float-right']) !!}
                @endif
            </div>
        </div>
        @if(\Auth::user()->type!='Employee')
            <div class="col-md-12 ">
                <div class="card emp_details">
                    <div class="card-header"><h6 class="mb-0">{{__('Company Detail')}}</h6></div>
                    <div class="card-body employee-detail-edit-body">
                        <div class="row">
                            @csrf
                            
                            <div class="row">
                                <div class="form-group col-4 mb-2 ">
                                    {{ Form::label('position_id', __('Select Position*'), ['class' => 'form-label']) }}

                                    <div class="form-icon-user">
                                        {{ Form::select('position_id', $positions, null, ['class' => 'form-control', 'id' => 'position_id' , 'placeholder' => 'Select Position']) }}
                                    </div>
                                </div>

                                <div class="form-group col-4 mb-2">
                                    {{ Form::label('department_id', __('Select Department*'), ['class' => 'form-label']) }}
                                    <div class="form-icon-user">
                                        {{ Form::select('department_id', $departments, null, ['class' => 'form-control', 'id' => 'department_id' , 'placeholder' => 'Select Department']) }}
                                    </div>
                                </div>

                                <div class="form-group col-4 mb-2 ">
                                    {{ Form::label('designation_id', __('Select Section*'), ['class' => 'form-label']) }}

                                    <div class="form-icon-user">
                                        {{ Form::select('designation_id', $designations, null, ['class' => 'form-control', 'id' => 'designation_id' , 'placeholder' => 'Select Section']) }}
                                    </div>
                                </div>
                                
                                
                            </div>
                        

                            <div class="row">
                                <div class="form-group mb-2 col-6">
                                    {!! Form::label('company_doj', 'Hire date',['class'=>'form-label']) !!}
                                {!! Form::date('company_doj', null, ['class' => 'form-control ','required' => 'required']) !!}
                                </div>

                                <div class="form-group mb-2 col-6">
                                    {!! Form::label('contract_end_date', __('Contract End Date'), ['class' => '  form-label']) !!}
                                    {{ Form::date('contract_end_date', null, ['class' => 'form-control ', 'required' => 'required', 'autocomplete' => 'off' ,'placeholder'=>'Select Contract End Date']) }}
                                </div>
                            </div>
                            
                            <div class="form-group col-md-12">
                                
                            </div>

                            <div class="form-group mb-2  ">
                                {!! Form::label('salary', __('Salary'), ['class' => '  form-label']) !!}
                                {{ Form::number('salary', null, ['class' => 'form-control ', 'required' => 'required', 'autocomplete' => 'off' ,'placeholder'=>'Employee Salary']) }}
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6 mb-2">
                                    {{ Form::label('employee_status', __('Select Status*'), ['class' => 'form-label']) }}
                                    <div class="form-icon-user">
                                        {{ Form::select('employee_status', [
                                            '1' => __('Active'),
                                            '2' => __('Terminated'),
                                        ], null, ['class' => 'form-control', 'id' => 'employee_status' , 'placeholder' => 'Select Status']) }}
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-6 mb-2">
                                    {{ Form::label('contract_type', __('Select Contract Type*'), ['class' => 'form-label']) }}
                                    <div class="form-icon-user">
                                        {{ Form::select('contract_type', [
                                            '1' => __('Full Time'),
                                            '2' => __('Part Time'),
                                        ], null, ['class' => 'form-control', 'id' => 'contract_type' , 'placeholder' => 'Select Contract Type']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-6 ">
                <div class="employee-detail-wrap ">
                    <div class="card emp_details">
                        <div class="card-header"><h6 class="mb-0">{{__('Company Detail')}}</h6></div>
                        <div class="card-body employee-detail-edit-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Branch')}}</strong>
                                        <span>{{!empty($employee->branch)?$employee->branch->name:''}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info font-style">
                                        <strong>{{__('Department')}}</strong>
                                        <span>{{!empty($employee->department)?$employee->department->name:''}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info font-style">
                                        <strong>{{__('Designation')}}</strong>
                                        <span>{{!empty($employee->designation)?$employee->designation->name:''}}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info">
                                        <strong>{{__('Date Of Joining')}}</strong>
                                        <span>{{\Auth::user()->dateFormat($employee->company_doj)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    @if(\Auth::user()->type != 'employee')
        <div class="row mt-3">
            <div class="col-12">
                <input type="submit" value="{{__('Update')}}" class="btn btn-primary float-end">
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('script-page')
    <script type="text/javascript">

        $(document).on('change', '#branch_id', function() {
            var branch_id = $(this).val();
            getDepartment(branch_id);
        });

        function getDepartment(branch_id)
        {
            var data = {
                "branch_id": branch_id,
                "_token": "{{ csrf_token() }}",
            }

            $.ajax({
                url: '{{ route('employee.getdepartment') }}',
                method: 'POST',
                data: data,
                success: function(data) {
                    $('#department_id').empty();
                    $('#department_id').append('<option value="" disabled>{{ __('Select any Department') }}</option>');

                    $.each(data, function(key, value) {
                        $('#department_id').append('<option value="' + key + '">' + value + '</option>');
                    });
                    $('#department_id').val('');
                }
            });
        }
    </script>
    <script type="text/javascript">

        function getDesignation(did) {
            $.ajax({
                url: '{{route('employee.json')}}',
                type: 'POST',
                data: {
                    "department_id": did, "_token": "{{ csrf_token() }}",
                },
                success: function (data) {
                    $('#designation_id').empty();
                    $('#designation_id').append('<option value="">Select any Designation</option>');
                    $.each(data, function (key, value) {
                        var select = '';
                        if (key == '{{ $employee->designation_id }}') {
                            select = 'selected';
                        }

                        $('#designation_id').append('<option value="' + key + '"  ' + select + '>' + value + '</option>');
                    });
                }
            });
        }

        $(document).ready(function () {
            var d_id = $('#department_id').val();
            var designation_id = '{{ $employee->designation_id }}';
            getDesignation(d_id);
        });

        $(document).on('change', 'select[name=department_id]', function () {
            var department_id = $(this).val();
            getDesignation(department_id);
        });

    </script>
@endpush
