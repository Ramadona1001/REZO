 @extends('layouts.admin')
@section('page-title')
    {{__('Manage Services')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Services')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        {{-- <a href="#" data-size="md"  data-bs-toggle="tooltip" title="{{__('Import')}}" data-url="{{ route('service.file.import') }}" data-ajax-popup="true" data-title="{{__('Import product CSV file')}}" class="btn btn-sm btn-primary">
            <i class="fa fa-file-import"></i>
        </a>
        <a href="{{route('service.export')}}" data-bs-toggle="tooltip" title="{{__('Export')}}" class="btn btn-sm btn-primary">
            <i class="fa fa-file-export"></i>
        </a> --}}

        <a href="#" data-size="lg" data-url="{{ route('service.create') }}" data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Create New Service')}}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus"></i> {{ __('New Service') }}
        </a>

    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('ID')}}</th>
                                <th>{{__('Name')}}</th>
                                <th>{{__('Hourly Rate')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($productServices as $productService)
                                <tr class="font-style">
                                    <td>{{ idFormat('service',$productService->id) }}</td>
                                    <td>{{ $productService->name}}</td>
                                    <td>{{ $productService->hourly_rate }}</td>

                                    @if(Gate::check('edit service') || Gate::check('delete service'))
                                        <td class="Action" style=" display: flex; gap: 5px; ">

                                            {{-- <a href="#" class="btn btn-primary btn-sm align-items-center" data-url="{{ route('service.detail',$productService->id) }}"
                                               data-ajax-popup="true" data-bs-toggle="tooltip" title="{{__('Warehouse Details')}}" data-title="{{__('Warehouse Details')}}">
                                                <i class="fa fa-eye text-white"></i>
                                            </a> --}}
                                            @can('edit service')
                                            <a href="#" class="btn btn-primary btn-sm  align-items-center" data-url="{{ route('service.edit',$productService->id) }}" data-ajax-popup="true"  data-size="lg " data-bs-toggle="tooltip" title="{{__('Edit')}}"  data-title="{{__('Edit Product')}}">
                                                <i class="fa fa-pencil text-white"></i>
                                            </a>
                                            @endcan
                                            @can('delete service')
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['service.destroy', $productService->id],'id'=>'delete-form-'.$productService->id]) !!}
                                            <a href="#" class="btn btn-danger btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" title="{{__('Delete')}}" ><i class="fa fa-trash text-white"></i></a>
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
@endsection

