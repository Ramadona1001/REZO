@extends('layouts.admin')

@section('page-title')
    {{ $title }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ $title }}</li>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <h4>{{ $title }}</h4>
            @include('dashboard.charts.projects')
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
