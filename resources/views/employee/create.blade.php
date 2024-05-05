@extends('layouts.admin')

@section('page-title')
    {{ __('Create Employee') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ url('employee') }}">{{ __('Employee') }}</a></li>
    <li class="breadcrumb-item">{{ __('Create Employee') }}</li>
@endsection


@section('content')
    <div class="row">
        <div class="">
            <div class="">
                <div class="row">
                </div>
                {{ Form::open(['route' => ['employee.store'], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
                <div class="row mb-3">

                    <div class="col-md-12 mb-3">
                        <div class="card em-card">
                            <div class="card-header">
                                <h5>{{ __('Employee Data') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group mb-2 ">
                                        {!! Form::label('employee_id', __('Employee ID'), ['class' => 'form-label']) !!}
                                        {!! Form::text('employee_id', $employeesId, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2">
                                        {!! Form::label('name', __('Name'), ['class' => 'form-label']) !!}<span class="text-danger pl-1">*</span>
                                        {!! Form::text('name', old('name'), [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'placeholder' => 'Enter employee name',
                                        ]) !!}
                                    </div>
                                    <div class="form-group col-md-6 mb-2">
                                        {!! Form::label('phone', __('Phone'), ['class' => 'form-label']) !!}<span class="text-danger pl-1">*</span>
                                        {!! Form::text('phone', old('phone'), [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'placeholder' => 'Enter employee phone',
                                        ]) !!}
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            {!! Form::label('dob', __('Date of Birth'), ['class' => 'form-label']) !!}<span class="text-danger pl-1">*</span>
                                            {{ Form::date('dob', null, ['class' => 'form-control ', 'required' => 'required', 'autocomplete' => 'off', 'placeholder' => 'Select Date of Birth']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-group">
                                            {!! Form::label('gender', __('Gender'), ['class' => 'form-label', 'required' => 'required']) !!}<span class="text-danger pl-1">*</span>
                                            <div class="d-flex radio-check">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="g_male" value="Male" name="gender"
                                                        class="form-check-input" checked>
                                                    <label class="form-check-label "
                                                        for="g_male">{{ __('Male') }}</label>
                                                </div>
                                                <div class="custom-control custom-radio ms-1 custom-control-inline">
                                                    <input type="radio" id="g_female" value="Female" name="gender"
                                                        class="form-check-input">
                                                    <label class="form-check-label "
                                                        for="g_female">{{ __('Female') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 mb-2">
                                        {!! Form::label('email', __('Email'), ['class' => 'form-label']) !!}<span class="text-danger pl-1">*</span>
                                        {!! Form::email('email', old('email'), [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'placeholder' => 'Enter employee email',
                                        ]) !!}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group mb-2">
                                            {!! Form::label('address', __('Address'), ['class' => 'form-label']) !!}<span class="text-danger pl-1">*</span>
                                            {!! Form::textarea('address', old('address'), [
                                                'class' => 'form-control',
                                                'rows' => 2,
                                                'placeholder' => 'Enter employee address',
                                                'required' => 'required',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group mb-2">
                                            {!! Form::label('city', __('City'), ['class' => 'form-label']) !!}<span class="text-danger pl-1">*</span>
                                            {!! Form::text('city', old('city'), [
                                                'class' => 'form-control',
                                                'rows' => 2,
                                                'placeholder' => 'Enter employee city',
                                                'required' => 'required',
                                            ]) !!}
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group mb-2">
                                            {!! Form::label('country', __('Country'), ['class' => 'form-label']) !!}<span class="text-danger pl-1">*</span>
                                            {!! Form::text('country', old('country'), [
                                                'class' => 'form-control',
                                                'rows' => 2,
                                                'placeholder' => 'Enter employee country',
                                                'required' => 'required',
                                            ]) !!}
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card em-card">
                            <div class="card-header">
                                <h5>{{ __('Company Data') }}</h5>
                            </div>
                            <div class="card-body employee-detail-create-body">
                                <div class="row">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-4 mb-2 ">
                                            <div class="d-flex justify-content-between">
                                                {{ Form::label('position_id', __('Select Position*'), ['class' => 'form-label']) }}
                                                <button type="button" id="addNewPosition" class="btn btn-primary btn-sm mb-3">
                                                    {{ __('Add New Position') }}
                                                </button>
                                            </div>

                                            <div class="form-icon-user">
                                                {{ Form::select('position_id', $positions, null, ['class' => 'form-control', 'id' => 'position_id', 'placeholder' => 'Select Position']) }}
                                            </div>


                                            <div id="myModal" class="modal fade" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{ __('Add New Position') }}</h5>
                                                            <button type="button" class="close btn btn-primary btn-sm "
                                                                data-dismiss="modal">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" id="addNewPositionForm">
                                                                @csrf
                                                                <div class="row">

                                                                    <div class="col-12">
                                                                        <div class="form-group mb-2">
                                                                            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                                                                            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Position Name'), 'id' => 'position_name']) }}
                                                                            @error('name')
                                                                                <span class="invalid-name" role="alert">
                                                                                    <strong
                                                                                        class="text-danger">{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group mb-2">
                                                                            {{ Form::label('descriptions', __('Descriptions'), ['class' => 'form-label']) }}
                                                                            {{ Form::textarea('descriptions', null, ['class' => 'form-control', 'placeholder' => __('Enter Position Descriptions'), 'id' => 'position_descriptions']) }}
                                                                            @error('descriptions')
                                                                                <span class="invaliD-name" role="alert">
                                                                                    <strong
                                                                                        class="text-danger">{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="form-group">
                                                                            {{ Form::label('slaray_range', __('Salary Range'), ['class' => 'form-label']) }}
                                                                            {{ Form::text('slaray_range', null, ['class' => 'form-control', 'placeholder' => __('Enter Salary Range'), 'id' => 'position_slaray_range']) }}
                                                                            @error('slaray_range')
                                                                                <span class="invalid-name" role="alert">
                                                                                    <strong
                                                                                        class="text-danger">{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <button type="button" onclick="submitPositionForm()"
                                                                    class="btn btn-primary mt-3">{{ __('Create') }}</button>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group col-4 mb-2">
                                            {{ Form::label('department_id', __('Select Department*'), ['class' => 'form-label']) }}
                                            <div class="form-icon-user">
                                                {{ Form::select('department_id', $departments, null, ['class' => 'form-control', 'id' => 'department_id', 'placeholder' => 'Select Department']) }}
                                            </div>
                                        </div>

                                        <div class="form-group col-4 mb-2 ">
                                            {{ Form::label('designation_id', __('Select Section*'), ['class' => 'form-label']) }}

                                            <div class="form-icon-user">
                                                {{ Form::select('designation_id', $designations, null, ['class' => 'form-control', 'id' => 'designation_id', 'placeholder' => 'Select Section']) }}
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="form-group mb-2 col-6">
                                            {!! Form::label('company_doj', __('Hire Date'), ['class' => '  form-label']) !!}
                                            {{ Form::date('company_doj', null, ['class' => 'form-control ', 'required' => 'required', 'autocomplete' => 'off', 'placeholder' => 'Select Hire Date']) }}
                                        </div>

                                        <div class="form-group mb-2 col-6">
                                            {!! Form::label('contract_end_date', __('Contract End Date'), ['class' => '  form-label']) !!}
                                            {{ Form::date('contract_end_date', null, ['class' => 'form-control ', 'required' => 'required', 'autocomplete' => 'off', 'placeholder' => 'Select Contract End Date']) }}
                                        </div>
                                    </div>

                                    <div class="form-group mb-2  ">
                                        {!! Form::label('salary', __('Salary'), ['class' => '  form-label']) !!}
                                        {{ Form::number('salary', null, ['class' => 'form-control ', 'required' => 'required', 'autocomplete' => 'off', 'placeholder' => 'Employee Salary']) }}
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-6 mb-2">
                                            {{ Form::label('employee_status', __('Select Status*'), ['class' => 'form-label']) }}
                                            <div class="form-icon-user">
                                                {{ Form::select(
                                                    'employee_status',
                                                    [
                                                        '1' => __('Active'),
                                                        '2' => __('Terminated'),
                                                    ],
                                                    null,
                                                    ['class' => 'form-control', 'id' => 'employee_status', 'placeholder' => 'Select Status'],
                                                ) }}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6 mb-2">
                                            {{ Form::label('contract_type', __('Select Contract Type*'), ['class' => 'form-label']) }}
                                            <div class="form-icon-user">
                                                {{ Form::select(
                                                    'contract_type',
                                                    [
                                                        '1' => __('Full Time'),
                                                        '2' => __('Part Time'),
                                                    ],
                                                    null,
                                                    ['class' => 'form-control', 'id' => 'contract_type', 'placeholder' => 'Select Contract Type'],
                                                ) }}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="float-end">
                <button type="submit" class="btn  btn-primary">{{ 'Create' }}</button>
            </div>
            </form>
        </div>
    </div>
@endsection


@push('script-page')
    <script>
        $(document).ready(function(){
            $('#addNewPosition').on('click',function(){
                $("#myModal").modal('show');
            })
    
            // Close modal on button click
            
        });
        
        function submitPositionForm() {
            $.ajax({
                url: '{{ route('new.positions.ajax') }}',
                type: 'POST',
                data: {
                    position_name: $('#position_name').val(),
                    position_descriptions: $('#position_descriptions').val(),
                    position_slaray_range: $('#position_slaray_range').val(),
                    "_token": "{{ csrf_token() }}",
                },
                success: function(response) {
                    var select = document.getElementById("position_id");
                    var option = document.createElement("option");
                    option.value = response.data.id;
                    option.text = response.data.name;
                    select.appendChild(option);
                    $("#myModal").modal('hide');
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
        }
    </script>

    <script>
        $('input[type="file"]').change(function(e) {
            var file = e.target.files[0].name;
            var file_name = $(this).attr('data-filename');
            $('.' + file_name).append(file);
        });
    </script>
    <script>
        $(document).ready(function() {
            var d_id = $('.department_id').val();
            getDesignation(d_id);
        });

        $(document).on('change', 'select[name=department_id]', function() {
            var department_id = $(this).val();
            getDesignation(department_id);
        });

        function getDesignation(did) {

            $.ajax({
                url: '{{ route('employee.json') }}',
                type: 'POST',
                data: {
                    "department_id": did,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {

                    $('.designation_id').empty();
                    var emp_selct = ` <select class="form-control  designation_id" name="designation_id" id="choices-multiple"
                                            placeholder="Select Designation" >
                                            </select>`;
                    $('.designation_div').html(emp_selct);

                    $('.designation_id').append('<option value="0"> {{ __('All') }} </option>');
                    $.each(data, function(key, value) {
                        $('.designation_id').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                    new Choices('#choices-multiple', {
                        removeItemButton: true,
                    });


                }
            });
        }
    </script>
@endpush
