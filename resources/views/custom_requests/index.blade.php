@extends('layouts.admin')
@section('page-title')
    {{__('Manage Custom Requests')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Custom Requests')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        


        {{------------ Start Filter ----------------}}
                <a href="#" class="btn btn-sm btn-primary action-item" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-filter"></i>
                </a>
                <div class="dropdown-menu  dropdown-steady" id="project_sort">
                    <a class="dropdown-item active" href="#" data-val="created_at-desc">
                        <i class="fa fa-sort-descending"></i>{{__('Newest')}}
                    </a>
                    <a class="dropdown-item" href="#" data-val="created_at-asc">
                        <i class="fa fa-sort-ascending"></i>{{__('Oldest')}}
                    </a>

                    <a class="dropdown-item" href="#" data-val="project_name-desc">
                        <i class="fa fa-sort-descending-letters"></i>{{__('From Z-A')}}
                    </a>
                    <a class="dropdown-item" href="#" data-val="project_name-asc">
                        <i class="fa fa-sort-ascending-letters"></i>{{__('From A-Z')}}
                    </a>
                </div>

            {{------------ End Filter ----------------}}

            {{------------ Start Status Filter ----------------}}
                <a href="#" class="btn btn-sm btn-primary action-item" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="btn-inner--icon">{{__('Status')}}</span>
                </a>
                <div class="dropdown-menu  project-filter-actions dropdown-steady" id="project_status">
                    <a class="dropdown-item filter-action filter-show-all pl-4 active" href="#">{{__('Show All')}}</a>
                    @foreach(\App\Models\CustomRequest::$project_status as $key => $val)
                        <a class="dropdown-item filter-action pl-4" href="#" data-val="{{ $key }}">{{__($val)}}</a>
                    @endforeach
                </div>
            {{------------ End Status Filter ----------------}}

        @can('create custom request')
            <a href="#" data-size="lg" data-url="{{ route('customs.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Custom Request')}}" data-title="{{__('Create Custom Request')}}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i>
            </a>
        @endcan
    </div>
@endsection

@section('content')
    <div class="row min-750" id="project_view"></div>
@endsection

@push('script-page')


<script>
    $( document ).ajaxComplete(function() {
        $("#addPosition").on('click',function () {
            newRowAdd = `
            <div class="row mb-3" id="row">
                <div class="col-sm-5 col-md-5">
                    <div class="form-group">
                        {{ Form::label('positions[]', __('Position Name'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                        {{ Form::select('positions[]', $positions,null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-sm-5 col-md-5">
                    <div class="form-group">
                        {{ Form::label('positions_count[]', __('Position Count'), ['class' => 'form-label']) }}<span class="text-danger">*</span>
                        {{ Form::number('positions_count[]',0, ['class' => 'form-control','step'=>0.5,'min' => 0]) }}
                    </div>
                </div>
                <div class="col-sm-2 col-md-2">
                    <div class="form-group">
                        <label>{{ __('Delete') }}</label><br>
                        <button type="button" class="btn btn-sm btn-danger" id="DeleteRow"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
            </div>
            `;

            $('#positionsData').append(newRowAdd);
        });
        $("body").on("click", "#DeleteRow", function () {
            $(this).parents("#row").remove();
        });
    });
    $(document).ready(function () {

        
        var sort = 'created_at-desc';
        var status = '';
        ajaxFilterProjectView('created_at-desc');
        $(".project-filter-actions").on('click', '.filter-action', function (e) {
            if ($(this).hasClass('filter-show-all')) {
                $('.filter-action').removeClass('active');
                $(this).addClass('active');
            } else {
                $('.filter-show-all').removeClass('active');
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $(this).blur();
                } else {
                    $(this).addClass('active');
                }
            }

            var filterArray = [];
            var url = $(this).parents('.project-filter-actions').attr('data-url');
            $('div.project-filter-actions').find('.active').each(function () {
                filterArray.push($(this).attr('data-val'));
            });

            status = filterArray;

            ajaxFilterProjectView(sort, $('#project_keyword').val(), status);
        });

        // when change sorting order
        $('#project_sort').on('click', 'a', function () {
            sort = $(this).attr('data-val');
            ajaxFilterProjectView(sort, $('#project_keyword').val(), status);
            $('#project_sort a').removeClass('active');
            $(this).addClass('active');
        });

        // when searching by project name
        $(document).on('keyup', '#project_keyword', function () {
            ajaxFilterProjectView(sort, $(this).val(), status);
        });


    });

    var currentRequest = null;

    function ajaxFilterProjectView(project_sort, keyword = '', status = '') {
        var mainEle = $('#project_view');
        var view = '{{$view}}';
        var data = {
            view: view,
            sort: project_sort,
            keyword: keyword,
            status: status,
        }

        currentRequest = $.ajax({
            url: '{{ route('filter.custom.view') }}',
            data: data,
            beforeSend: function () {
                if (currentRequest != null) {
                    currentRequest.abort();
                }
            },
            success: function (data) {
                mainEle.html(data.html);
                $('[id^=fire-modal]').remove();
                loadConfirm();
            }
        });
    }
</script>
@endpush
