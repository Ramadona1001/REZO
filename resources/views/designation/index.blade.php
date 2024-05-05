@extends('layouts.admin')
@section('page-title')
    {{__('Manage Units')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Unit')}}</li>
@endsection


@section('action-btn')
    <div class="float-end">
        @can('create designation')
            <a href="#" data-url="{{ route('designation.create') }}" data-ajax-popup="true" data-title="{{__('Create New Unit')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> {{ __('Add New Unit') }}
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
                                <th>{{__('Unit')}}</th>
                                <th>{{__('Descriptions')}}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($designations as $designation)
                                @php
                                    $department = \App\Models\Department::where('id', $designation->department_id)->first();
                                @endphp
                                <tr>
                                    <td>{{ idFormat('section',$designation->id) }}</td>
                                    <td>{{ !empty($department->name)?$department->name:'' }}</td>
                                    <td>{{ $designation->name }}</td>
                                    <td>{{ $designation->descriptions }}</td>

                                    <td class="Action d-flex justify-content-between">
                                        @can('edit designation')
                                            <a href="#" class="btn btn-primary" data-url="{{route('designation.edit',$designation->id) }}" data-ajax-popup="true" data-title="{{__('Edit Unit')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                <i class="fa fa-pencil text-white"></i>
                                            </a>
                                            @endcan

                                            @can('delete designation')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['designation.destroy', $designation->id],'id'=>'delete-form-'.$designation->id]) !!}
                                                <a href="#" class="btn btn-danger bs-pass-para" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$designation->id}}').submit();">
                                                    <i class="fa fa-trash text-white"></i>
                                                </a>
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
