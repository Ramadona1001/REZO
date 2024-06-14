@extends('layouts.admin')

@section('page-title')
    {{ $title }}
@endsection

@push('css-page')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ $title }}</li>
@endsection
@section('content')
    <div class="container">
        <div class="row" style="row-gap: 30px">
            <h4>{{ $title }}</h4>
            @include('dashboard.charts.employees')
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
