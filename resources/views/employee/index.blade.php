@extends('layouts.admin')
@section('page-title')
    {{__('Manage Employee')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Employee')}}</li>
@endsection


@section('action-btn')
    <div class="float-end">
        <a href="#" data-size="md"  data-bs-toggle="tooltip" title="{{__('Import')}}" data-url="{{ route('employee.file.import') }}" data-ajax-popup="true" data-title="{{__('Import employee CSV file')}}" class="btn btn-sm btn-primary">
            <i class="fa fa-file-import"></i>
        </a>
        <a href="{{route('employee.export')}}" data-bs-toggle="tooltip" title="{{__('Export')}}" class="btn btn-sm btn-primary">
            <i class="fa fa-file-export"></i>
        </a>
        <a href="{{ route('employee.create') }}"
            data-title="{{ __('Create New Employee') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="{{ __('Create') }}">
            <i class="fa fa-plus"></i> {{ __('Add New Employee') }}
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
        <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                            <tr>
                                <th>{{__('Employee ID')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Email')}}</th>
                                <th>{{__('Department') }}</th>
                                <th>{{__('Section') }}</th>
                                <th>{{__('Position') }}</th>
                                <th>{{__('Hire Date') }}</th>
                                <th>{{__('Contract End Date') }}</th>
                                <th>{{__('Salary') }}</th>
                                <th>{{__('Status') }}</th>
                                <th>{{__('Contract Type') }}</th>
                                <th width="200px">{{__('Action')}}</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td class="Id">
                                        @can('show employee profile')
                                            <a href="{{route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}" class="btn btn-outline-primary">{{ \Auth::user()->employeeIdFormat($employee->id) }}</a>
                                        @else
                                            <a href="#"  class="btn btn-outline-primary">{{ \Auth::user()->employeeIdFormat($employee->id) }}</a>
                                        @endcan
                                    </td>
                                    <td class="font-style">{{ $employee->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    {{-- @if($employee->branch_id)
                                        <td class="font-style">{{$employee->branch  ? $employee->branch->name:''}}</td>
                                    @else
                                        <td>-</td>
                                    @endif --}}
                                    @if($employee->department_id)
                                        <td class="font-style">{{$employee->department ? $employee->department->name:''}}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    @if($employee->designation_id)
                                        <td class="font-style">{{$employee->designation ? $employee->designation->name:''}}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    @if($employee->position_id)
                                        <td class="font-style">{{$employee->position ? $employee->position->name:''}}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    @if($employee->company_doj)
                                        <td class="font-style">{{ \Auth::user()->dateFormat($employee->company_doj )}}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    @if($employee->contract_end_date)
                                        <td class="font-style">{{ \Auth::user()->dateFormat($employee->contract_end_date )}}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    @if($employee->salary)
                                        <td class="font-style">{{ $employee->salary}}</td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    @if($employee->employee_status)
                                        <td class="font-style">
                                            @if($employee->employee_status == 1)
                                                <span class="btn btn-success btn-sm">{{ __('Active') }}</span>
                                            @else
                                                <span class="btn btn-danger btn-sm">{{ __('Terminated') }}</span>
                                            @endif
                                        </td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    @if($employee->contract_type)
                                        <td class="font-style">
                                            @if($employee->contract_type == 1)
                                                <span class="btn btn-info btn-sm">{{ __('Full Time') }}</span>
                                            @else
                                                <span class="btn btn-info btn-sm">{{ __('Part Time') }}</span>
                                            @endif
                                        </td>
                                    @else
                                        <td>-</td>
                                    @endif
                                    {{-- <td>
                                        {{ (!empty($employee->user->last_login_at)) ? $employee->user->last_login_at : '-' }}
                                    </td> --}}
                                    @if(Gate::check('edit employee') || Gate::check('delete employee'))
                                    <td class="Action d-flex justify-content-between">
                                            @can('show employee profile')
                                                <a href="{{route('employee.show',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="{{__('Details')}}" data-original-title="{{__('Details')}}"><i class="fa fa-eye text-white"></i></a>
                                            @endcan
                                            @can('edit employee')
                                                    <a href="{{route('employee.edit',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="{{__('Edit')}}"
                                                    data-original-title="{{__('Edit')}}"><i class="fa fa-pencil text-white"></i></a>
                                                @endcan
                                                @can('delete employee')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['employee.destroy', $employee->id],'id'=>'delete-form-'.$employee->id]) !!}

                                                    <a href="#" class="btn btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$employee->id}}').submit();"><i class="fa fa-trash text-white"></i></a>
                                                    {!! Form::close() !!}
                                                @endcan
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

