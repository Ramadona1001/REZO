@extends('layouts.admin')

@section('page-title')
    {{__('Manage Labels')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Labels')}}</li>
@endsection

@section('action-btn')
    @can('create label')
        <div class="float-end">
            <a href="#" data-size="md" data-url="{{ route('labels.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create Labels')}}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i>
            </a>
        </div>
    @endcan
@endsection

@section('content')

    <div class="row">
        <div class="col-md-3">
            @include('layouts.crm_setup')
        </div>
        <div class="col-md-9">
            <div class="row justify-content-center">

                <div class="p-3 card">
                    <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
                        @php($i=0)
                        @foreach($pipelines as $key => $pipeline)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link @if($i==0) active @endif" id="pills-user-tab-1" data-bs-toggle="pill"
                                        data-bs-target="#tab{{$key}}" type="button">{{$pipeline['name']}}
                                </button>
                            </li>
                            @php($i++)
                        @endforeach
                    </ul>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="pills-tabContent">
                            @php($i=0)
                            @foreach($pipelines as $key => $pipeline)
                                <div class="tab-pane fade show @if($i==0) active @endif" id="tab{{$key}}" role="tabpanel" aria-labelledby="pills-user-tab-1">
                                    <ul class="list-group sortable">
                                        @foreach ($pipeline['labels'] as $label)
                                            <li class="list-group-item" data-id="{{$label->id}}">
                                                <span class="text-sm text-dark">{{$label->name}}</span>
                                                <span class="float-end">

                                                @can('edit label')
                                                <a href="#" class="mx-3 btn-primary btn btn-sm d-inline-flex align-items-center" data-url="{{ URL::to('labels/'.$label->id.'/edit') }}" data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Labels')}}">
                                                    <i class="fa fa-pencil text-white"></i>
                                                </a>
                                                    @endcan
                                                    @if(count($pipeline['labels']))
                                                        @can('delete label')
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['labels.destroy', $label->id]]) !!}
                                                        <a href="#" class="mx-3 btn-danger btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="fa fa-trash text-white"></i></a>
                                                        {!! Form::close() !!}
                                                        @endcan
                                                    @endif
                                            </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @php($i++)
                            @endforeach
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection
