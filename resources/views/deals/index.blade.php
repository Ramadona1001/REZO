@extends('layouts.admin')
@section('page-title')
    {{__('Manage Deals')}} @if($pipeline) - {{$pipeline->name}} @endif
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{asset('css/summernote/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dragula.min.css') }}" id="main-style-link">
@endpush
@push('script-page')
    <script src="{{asset('css/summernote/summernote-bs4.js')}}"></script>
    <script src="{{ asset('assets/js/plugins/dragula.min.js') }}"></script>
    <script>
        !function (a) {
            "use strict";
            var t = function () {
                this.$body = a("body")
            };
            t.prototype.init = function () {
                a('[data-plugin="dragula"]').each(function () {
                    var t = a(this).data("containers"), n = [];
                    if (t) for (var i = 0; i < t.length; i++) n.push(a("#" + t[i])[0]); else n = [a(this)[0]];
                    var r = a(this).data("handleclass");
                    r ? dragula(n, {
                        moves: function (a, t, n) {
                            return n.classList.contains(r)
                        }
                    }) : dragula(n).on('drop', function (el, target, source, sibling) {

                        var order = [];
                        $("#" + target.id + " > div").each(function () {
                            order[$(this).index()] = $(this).attr('data-id');
                        });

                        var id = $(el).attr('data-id');

                        var old_status = $("#" + source.id).data('status');
                        var new_status = $("#" + target.id).data('status');
                        var stage_id = $(target).attr('data-id');
                        var pipeline_id = '{{$pipeline->id}}';

                        $("#" + source.id).parent().find('.count').text($("#" + source.id + " > div").length);
                        $("#" + target.id).parent().find('.count').text($("#" + target.id + " > div").length);
                        $.ajax({
                            url: '{{route('deals.order')}}',
                            type: 'POST',
                            data: {deal_id: id, stage_id: stage_id, order: order, new_status: new_status, old_status: old_status, pipeline_id: pipeline_id, "_token": $('meta[name="csrf-token"]').attr('content')},
                            success: function (data) {
                            },
                            error: function (data) {
                                data = data.responseJSON;
                                show_toastr('error', data.error, 'error')
                            }
                        });
                    });
                })
            }, a.Dragula = new t, a.Dragula.Constructor = t
        }(window.jQuery), function (a) {
            "use strict";

            a.Dragula.init()

        }(window.jQuery);


    </script>
    <script>
        $(document).on("change", "#default_pipeline_id", function () {
            $('#change-pipeline').submit();
        });
    </script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Deal')}}</li>
@endsection


@section('action-btn')
    <div class="float-end">
        {{ Form::open(array('route' => 'deals.change.pipeline','id'=>'change-pipeline','class'=>'btn btn-sm')) }}
        {{ Form::select('default_pipeline_id', $pipelines,$pipeline->id, array('class' => 'form-control select me-4','id'=>'default_pipeline_id')) }}
        {{ Form::close() }}

        <a href="#" data-size="lg" data-url="{{ route('deals.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Deal')}}" data-title="{{__('Create Deal')}}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus"></i>
        </a>
    </div>
@endsection


@section('content')
    <div class="row">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <small class="text-muted">{{__('Total Deals')}}</small>
                            <h4 class="m-0">{{ $cnt_deal['total'] }}</h4>
                        </div>
                        <div class="col-auto">
                            <div class="theme-avtar bg-info">
                                <i class="fa fa-layers-difference"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <small class="text-muted">{{__('This Month Total Deals')}}</small>
                            <h4 class="m-0">{{ $cnt_deal['this_month'] }}</h4>
                        </div>
                        <div class="col-auto">
                            <div class="theme-avtar bg-primary">
                                <i class="fa fa-layers-difference"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <small class="text-muted">{{__('This Week Total Deals')}}</small>
                            <h4 class="m-0">{{ $cnt_deal['this_week'] }}</h4>
                        </div>
                        <div class="col-auto">
                            <div class="theme-avtar bg-warning">
                                <i class="fa fa-layers-difference"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <small class="text-muted">{{__('Last 30 Days Total Deals')}}</small>
                            <h4 class="m-0">{{ $cnt_deal['last_30days'] }}</h4>
                        </div>
                        <div class="col-auto">
                            <div class="theme-avtar bg-danger">
                                <i class="fa fa-layers-difference"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        @php
                $stages = $pipeline->stages;
                $json = [];
                foreach ($stages as $stage){
                    $json[] = 'task-list-'.$stage->id;
                }
            @endphp
        <div class="row kanban-wrapper horizontal-scroll-cards" style="row-gap: 20px" data-containers='{!! json_encode($json) !!}' data-plugin="dragula">
            @foreach($stages as $stage)
            @php($deals = $stage->deals())
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-end">
                                <span class="btn btn-sm btn-primary btn-icon count">
                                    {{count($deals)}}
                                </span>
                            </div>
                            <h4 class="mb-0">{{$stage->name}}</h4>
                        </div>
                        <div class="card-body kanban-box" id="task-list-{{$stage->id}}" data-id="{{$stage->id}}">
                            @foreach($deals as $deal)
                            <div class="card" data-id="{{ $deal->id }}" style="cursor: move;">
                                <div class="card-body">
                                    @php($labels = $deal->labels())
                                    @if ($labels)
                                        <span>{{ __('Labels') }}</span>
                                        @foreach ($labels as $label)
                                            <div class="badge-xs badge bg-{{ $label->color }} p-2 px-3 rounded">
                                                {{ $label->name }}</div>
                                        @endforeach
                                    <hr>
                                    @endif
                                    <h5 class="text-center"><a href="@can('view lead')@if ($deal->is_active){{ route('leads.show', $deal->id) }}@else#@endif @else#@endcan">{{ $deal->name }}</a>
                                    </h5>
                                    @if (Auth::user()->type != 'client')
                                        <div class="d-flex justify-content-center gap-2">
                                            @can('edit lead')
                                                <a href="#!" data-size="md"
                                                    data-url="{{ URL::to('deals/' . $deal->id . '/labels') }}"
                                                    data-ajax-popup="true" class="btn btn-sm btn-primary"
                                                    data-bs-original-title="{{ __('Labels') }}">
                                                    <i class="fa fa-bookmark"></i>
                                                    <span>{{ __('Labels') }}</span>
                                                </a>



                                                <a href="#!" data-size="lg"
                                                    data-url="{{ URL::to('deals/' . $deal->id . '/edit') }}"
                                                    data-ajax-popup="true" class="btn btn-sm btn-primary"
                                                    data-bs-original-title="{{ __('Edit Lead') }}">
                                                    <i class="fa fa-pencil"></i>
                                                    <span>{{ __('Edit') }}</span>
                                                </a>
                                            @endcan
                                            @can('delete lead')
                                                {!! Form::open([
                                                    'method' => 'DELETE',
                                                    'route' => ['deals.destroy', $deal->id],
                                                    'id' => 'delete-form-' . $deal->id,
                                                ]) !!}
                                                <a href="#!" class="btn btn-sm btn-danger bs-pass-para">
                                                    <i class="fa fa-archive"></i>
                                                    <span> {{ __('Delete') }} </span>
                                                </a>
                                                {!! Form::close() !!}
                                            @endcan
                                        </div>
                                    @endif

                                    <ul class="list-inline mb-0 d-flex justify-content-center gap-2 mt-2">
                                        
                                        <li class="list-inline-item d-inline-flex align-items-center btn btn-sm btn-info"
                                            data-bs-toggle="tooltip" title="{{ __('Source') }}">
                                            <i
                                                class="f-16 text-white fa fa-list-check"></i>&nbsp;{{count($deal->tasks)}}/{{count($deal->complete_tasks)}}
                                        </li>

                                        <li class="list-inline-item d-inline-flex align-items-center btn btn-sm btn-info"
                                            data-bs-toggle="tooltip" title="{{ __('Source') }}">
                                            <i
                                                class="f-16 text-white fa fa-share-nodes"></i>&nbsp;{{ count($deal->sources()) }}
                                        </li>
                                    </ul>
                                    @if (count($deal->sources()) > 0)
                                        <div class="d-flex justify-content-center gap-2 mt-2">
                                            @foreach ($deal->sources() as $source)
                                                <span style="background: #d8e9f9;padding:5px;border-radius:5px;color:#183a59;">{{ $source->name }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
