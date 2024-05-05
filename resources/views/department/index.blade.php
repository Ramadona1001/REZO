@extends('layouts.admin')

@section('page-title')
    {{__('Manage Department')}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Department')}}</li>
@endsection


@section('action-btn')
    <div class="float-end">
    @can('create department')
            <a href="#" data-url="{{ route('department.create') }}" data-ajax-popup="true" data-title="{{__('Create New Department')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> {{ __('Add New Department') }}
            </a>

        @endcan
    </div>
@endsection

@section('content')
    <div class="row">
        {{-- <div class="col-3">
            @include('layouts.hrm_setup')
        </div> --}}
        <div class="col-12">
            <div class="card">
            <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                            <thead>
                            <tr>
                                <th>{{__('ID')}}</th>
                                <th>{{__('Department')}}</th>
                                <th>{{__('Manager')}}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($departments as $department)
                                <tr>
                                    <td>{{ idFormat('department',$department->id) }}</td>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ !empty($department->employee)?$department->employee->name:'' }}</td>
                                    <td class="Action d-flex justify-content-between">
                                        @can('edit department')
                                            <a href="#" data-url="{{ URL::to('department/'.$department->id.'/edit') }}"  data-ajax-popup="true" data-title="{{__('Edit Department')}}" class="btn btn-primary" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                <i class="fa fa-pencil text-white"></i></a>
                                                @endcan
                                            @can('delete department')
                                            
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['department.destroy', $department->id],'id'=>'delete-form-'.$department->id]) !!}


                                    <a href="#" class="btn btn-danger bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$department->id}}').submit();"><i class="fa fa-trash text-white"></i></a>
                                    {!! Form::close() !!}
                                            @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
