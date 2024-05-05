@extends('layouts.admin')
@php
    // $profile=asset(Storage::url('uploads/avatar/'));
    $profile = \App\Models\Utility::get_file('uploads/avatar');
@endphp
@section('page-title')
    @if (\Auth::user()->type == 'super admin')
        {{ __('Manage Companies') }}
    @else
        {{ __('Manage User') }}
    @endif
@endsection
@push('css-page')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css">
<style>
    table,th{
        text-align: center !important;
    }
</style>
@endpush
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    @if (\Auth::user()->type == 'super admin')
        <li class="breadcrumb-item">{{ __('Companies') }}</li>
    @else
        <li class="breadcrumb-item">{{ __('User') }}</li>
    @endif
@endsection
@section('action-btn')
    <div class="float-end">
        @if (\Auth::user()->type == 'company' || \Auth::user()->type == 'HR')
            <a href="{{ route('user.userlog') }}" class="btn btn-primary btn-sm {{ Request::segment(1) == 'user' }}"
                data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('User Logs History') }}"><i
                    class="fa fa-user-check"></i>
            </a>
        @endif
        @can('create user')
            <a href="#" data-size="lg" data-url="{{ route('users.create') }}" data-ajax-popup="true"
                data-bs-toggle="tooltip" data-title="{{ \Auth::user()->type == 'super admin' ?  __('Create Company')  : __('Create User') }}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i>
                {{ __('Add New User / Company') }}
            </a>
        @endcan
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <table id="example" class="table table-striped cell-border" style="width:100%;text-align:center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Avatar') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Plan Type') }}</th>
                        @if (\Auth::user()->type == 'super admin')
                        <th>{{ __('Plan Expire') }}</th>
                        {{-- <th>{{ __('Total Users') }}</th>
                        <th>{{ __('Total Customers') }}</th>
                        <th>{{ __('Total Vendors') }}</th> --}}
                        @endif
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ ($index+1) }}</td>
                            <td><img src="{{ !empty($user->avatar) ? asset(Storage::url('uploads/avatar/' . $user->avatar)) : asset(Storage::url('uploads/avatar/avatar.png')) }}"class="img-user round-img rounded-circle" style="width:50px;height:50px;display: block;margin-left: auto;margin-right: auto;"></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if (\Auth::user()->type == 'super admin')
                                    {{ !empty($user->currentPlan) ? $user->currentPlan->name : '' }}
                                @else
                                    {{ ucfirst($user->type) }}
                                @endif
                            </td>
                            @if (\Auth::user()->type == 'super admin')
                            <td>
                                {{ !empty($user->plan_expire_date) ? \Auth::user()->dateFormat($user->plan_expire_date) : __('Lifetime') }}
                            </td>
                            {{-- <td>{{ $user->totalCompanyUser($user->id) }}</td>
                            <td>{{ $user->totalCompanyCustomer($user->id) }}</td>
                            <td>{{ $user->totalCompanyVender($user->id) }}</td> --}}
                            @endif
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ __('Actions') }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if (Gate::check('edit user') || Gate::check('delete user'))
                                            @if ($user->is_active == 1 && $user->is_disable == 1)
                                                <li>
                                                    @can('edit user')
                                                        <a href="#!" data-size="lg"
                                                            data-url="{{ route('users.edit', $user->id) }}"
                                                            data-ajax-popup="true" class="dropdown-item"
                                                            data-bs-original-title="{{ \Auth::user()->type == 'super admin' ?  __('Edit Company')  : __('Edit User') }}">
                                                            <i class="fa fa-pencil"></i>
                                                            <span>{{ __('Edit') }}</span>
                                                        </a>
                                                    @endcan
                                                </li>
                                            
                                                @can('delete user')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['users.destroy', $user['id']],
                                                        'id' => 'delete-form-' . $user['id'],
                                                    ]) !!}
                                                    <li>
                                                        <a href="#!" class="dropdown-item bs-pass-para">
                                                            <i class="fa fa-archive"></i>
                                                            <span>
                                                                @if ($user->delete_status != 0)
                                                                    {{ __('Delete') }}
                                                                @else
                                                                    {{ __('Restore') }}
                                                                @endif
                                                            </span>
                                                        </a>
                                                    </li>
                                                    {!! Form::close() !!}
                                                @endcan

                                                {{-- @if (Auth::user()->type == 'super admin')
                                                    <li>
                                                        <a href="{{ route('login.with.company', $user->id) }}"
                                                            class="dropdown-item"
                                                            data-bs-original-title="{{ __('Login As Company') }}">
                                                            <i class="fa fa-replace"></i>
                                                            <span> {{ __('Login As Company') }}</span>
                                                        </a>
                                                    </li>
                                                @endif --}}

                                                <li>
                                                    <a href="#!"
                                                        data-url="{{ route('users.reset', \Crypt::encrypt($user->id)) }}"
                                                        data-ajax-popup="true" data-size="md" class="dropdown-item"
                                                        data-bs-original-title="{{ __('Reset Password') }}">
                                                        <i class="fa fa-lock"></i>
                                                        <span> {{ __('Reset Password') }}</span>
                                                    </a>
                                                </li>

                                                <li>
                                                    @if ($user->is_enable_login == 1)
                                                    <a href="{{ route('users.login', \Crypt::encrypt($user->id)) }}"
                                                        class="dropdown-item">
                                                        <i class="fa fa-lock"></i>
                                                        <span class="text-danger"> {{ __('Login Disable') }}</span>
                                                    </a>
                                                    @elseif ($user->is_enable_login == 0 && $user->password == null)
                                                        <a href="#" data-url="{{ route('users.reset', \Crypt::encrypt($user->id)) }}"
                                                            data-ajax-popup="true" data-size="md" class="dropdown-item login_enable"
                                                            data-title="{{ __('New Password') }}" class="dropdown-item">
                                                            <i class="fa fa-lock"></i>
                                                            <span class="text-success"> {{ __('Login Enable') }}</span>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('users.login', \Crypt::encrypt($user->id)) }}"
                                                            class="dropdown-item">
                                                            <i class="fa fa-lock"></i>
                                                            <span class="text-success"> {{ __('Login Enable') }}</span>
                                                        </a>
                                                    @endif
                                                </li>
                                            @else
                                                <li>
                                                    <a href="#" class="action-item text-lg"><i class="fa fa-lock"></i></a>
                                                </li>
                                            @endif
                                        @endif
                                        @if (\Auth::user()->type == 'super admin')
                                        <li>
                                            <a href="#!"
                                            class="dropdown-item"
                                            data-url="{{ route('plan.upgrade', $user->id) }}"
                                            data-size="md" data-ajax-popup="true"
                                            data-title="{{ __('Upgrade Plan') }}"
                                            >
                                                <i class="fa fa-trophy"></i>
                                                <span>{{ __('Upgrade Plan') }}</span>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('script-page')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script>
        new DataTable('#example');
        $(document).on('change', '#password_switch', function() {
            if ($(this).is(':checked')) {
                $('.ps_div').removeClass('d-none');
                $('#password').attr("required", true);

            } else {
                $('.ps_div').addClass('d-none');
                $('#password').val(null);
                $('#password').removeAttr("required");
            }
        });
        $(document).on('click', '.login_enable', function() {
            setTimeout(function() {
                $('.modal-body').append($('<input>', {
                    type: 'hidden',
                    val: 'true',
                    name: 'login_enable'
                }));
            }, 2000);
        });
    </script>
@endpush