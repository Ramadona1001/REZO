@extends('layouts.admin')
@section('page-title')
    {{__('Manage Pipelines')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Pipelines')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="#" data-size="md" data-url="{{ route('pipelines.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Pipeline')}}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus"></i>
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            @include('layouts.crm_setup')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Pipeline')}}</th>
                                <th width="250px">{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pipelines as $pipeline)
                                <tr>
                                    <td>{{ $pipeline->name }}</td>
                                    <td class="Action">
                                        <span>
                                                @if(count($pipelines) > 1)
                                                @can('delete pipeline')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['pipelines.destroy', $pipeline->id]]) !!}
                                                <a href="#" class="mx-3 btn btn-sm btn-danger align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="fa fa-trash text-white"></i></a>
                                                {!! Form::close() !!}
                                                @endcan
                                            @endif
                                            @can('edit pipeline')
                                            <a href="#" class="mx-3 btn btn-primary btn-sm d-inline-flex align-items-center" data-url="{{ URL::to('pipelines/'.$pipeline->id.'/edit') }}" data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Pipeline')}}">
                                                <i class="fa fa-pencil text-white"></i>
                                            </a>
                                            @endcan

                                        </span>
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
