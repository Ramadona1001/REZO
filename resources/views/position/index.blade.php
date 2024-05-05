@extends('layouts.admin')
@section('page-title')
    {{__('Manage Position')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Position')}}</li>
@endsection


@section('action-btn')
    <div class="float-end">
        @can('create position')
            <a href="#" data-url="{{ route('position.create') }}" data-ajax-popup="true" data-title="{{__('Create New Position')}}" data-bs-toggle="tooltip" title="{{__('Create')}}"  class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> {{ __('Add New Position') }}
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
                                <th>{{__('Position')}}</th>
                                <th>{{__('Descriptions')}}</th>
                                <th>{{__('Salary Range')}}</th>
                                <th width="200px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($positions as $position)
                                <tr>
                                    <td>{{ idFormat('position',$position->id) }}</td>
                                    <td>{{ $position->name }}</td>
                                    <td>{{ $position->descriptions }}</td>
                                    <td>{{ $position->slaray_range }}</td>

                                    <td class="Action d-flex justify-content-between">
                                        @can('edit position')
                                            <a href="#" class="btn btn-primary" data-url="{{route('position.edit',$position->id) }}" data-ajax-popup="true" data-title="{{__('Edit Position')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                                <i class="fa fa-pencil text-white"></i>
                                            </a>
                                            @endcan

                                            @can('delete position')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['position.destroy', $position->id],'id'=>'delete-form-'.$position->id]) !!}
                                                <a href="#" class="btn btn-danger bs-pass-para" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$position->id}}').submit();">
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
