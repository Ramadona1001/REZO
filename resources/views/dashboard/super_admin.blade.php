@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection

@push('theme-script')
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
@endpush

@php
$admin_payment_setting = Utility::getAdminPaymentSetting();
@endphp

@section('content')
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
              <div class="block-content block-content-full">
                <div class="d-flex align-items-center justify-content-between p-1">
                  <div class="me-3">
                    <p class="text-muted mb-0">
                        {{__('Total Users')}}
                    </p>
                    <p class="fs-3 mb-0">
                        {{$user->total_user}}
                    </p>
                  </div>
                </div>
              </div>
            </a>
        </div>
        
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
              <div class="block-content block-content-full">
                <div class="d-flex align-items-center justify-content-between p-1">
                  <div class="me-3">
                    <p class="text-muted mb-0">
                        {{__('Paid Users')}}
                    </p>
                    <p class="fs-3 mb-0">
                        {{$user['total_paid_user']}}
                    </p>
                  </div>
                </div>
              </div>
            </a>
        </div>
        
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
              <div class="block-content block-content-full">
                <div class="d-flex align-items-center justify-content-between p-1">
                  <div class="me-3">
                    <p class="text-muted mb-0">
                       {{__('Total Orders')}}
                    </p>
                    <p class="fs-3 mb-0">
                        {{$user->total_orders}}
                    </p>
                  </div>
                </div>
              </div>
            </a>
        </div>
        
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
              <div class="block-content block-content-full">
                <div class="d-flex align-items-center justify-content-between p-1">
                  <div class="me-3">
                    <p class="text-muted mb-0">
                        {{__('Total Order Amount')}}
                    </p>
                    <p class="fs-3 mb-0">
                        {{isset($admin_payment_setting['currency_symbol']) ? $admin_payment_setting['currency_symbol'] : '$'}}{{$user['total_orders_price']}}
                    </p>
                  </div>
                </div>
              </div>
            </a>
        </div>
        
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
              <div class="block-content block-content-full">
                <div class="d-flex align-items-center justify-content-between p-1">
                  <div class="me-3">
                    <p class="text-muted mb-0">
                        {{__('Total Plans')}}
                    </p>
                    <p class="fs-3 mb-0">
                        {{$user->total_plan}}
                    </p>
                  </div>
                </div>
              </div>
            </a>
        </div>
        
        <div class="col-md-6 col-xl-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
              <div class="block-content block-content-full">
                <div class="d-flex align-items-center justify-content-between p-1">
                  <div class="me-3">
                    <p class="text-muted mb-0">
                        {{__('Most Purchase Plan')}}
                    </p>
                    <p class="fs-3 mb-0">
                        {{$user['most_purchese_plan']}}
                    </p>
                  </div>
                </div>
              </div>
            </a>
        </div>
        

        {{-- <div class="col-xxl-12">
            <h4 class="h4 font-weight-400">{{__('Recent Order')}}</h4>
            <div class="card">
                <div class="chart">
                    <div id="chart-sales" data-color="primary" data-height="280" class="p-3"></div>
                </div>
            </div>
        </div> --}}
    </div>


@endsection
