@extends('layouts.admin')
@section('page-title')
    {{ __('Dashboard') }}
@endsection
@push('script-page')

@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Home') }}</li>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <h4>{{ __('Statistics') }}</h4>
            @foreach ($statistics as $key => $state)
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mb-3 mb-sm-0">
                                    <div class="d-flex align-items-center">
                                        <div class="ms-3">
                                            <small class="text-muted">{{ __('Total Of') }}</small>
                                            <h6 class="m-0">{{ $key }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto text-end">
                                    <h4 class="m-0">{{ $state }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
    </div>
@endsection

@push('script-page')
    <script>
        if (window.innerWidth <= 500) {
            $('p').removeClass('text-sm');
        }
    </script>
@endpush
