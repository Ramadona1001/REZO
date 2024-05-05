@extends('layouts.admin')
@php
   // $profile=asset(Storage::url('uploads/avatar/'));
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
@section('page-title')
    {{__('Manage Client')}}
@endsection
@push('script-page')
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Clients')}}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="#" data-size="md" data-url="{{ route('clients.create') }}" data-ajax-popup="true"  data-bs-toggle="tooltip" title="{{__('Create Client')}}"  data-bs-original-title="{{__('create')}}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus"></i> {{ __('New Client') }}
        </a>
    </div>
@endsection
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                    <thead>
                    <tr>
                        <th>{{__('ID')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Industry')}}</th>
                        <th>{{__('Address')}}</th>
                        <th>{{__('Contact Data')}}</th>
                        <th width="200px">{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody class="font-style">
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{ idFormat('client',$client->id) }}</td>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->industry }}</td>
                            <td>{{ $client->address }}</td>
                            <td>
                                @foreach ($client->contacts as $contact)
                                    <ul>
                                        <li>{{ __('Contact Name').' : '.$contact->contact_name }}</li>
                                        <li>{{ __('Position').' : '.$contact->position }}</li>
                                        <li>{{ __('Mobile').' : '.$contact->mobile }}</li>
                                        <li>{{ __('Email').' : '.$contact->email }}</li>
                                    </ul>
                                @endforeach    
                            </td>

                            <td class="Action d-flex justify-content-between">
                                @can('edit client')
                                    <a href="#" class="btn btn-primary" data-url="{{route('clients.edit',$client->id) }}" data-ajax-popup="true" data-title="{{__('Edit Client')}}" data-toggle="tooltip" data-original-title="{{__('Edit')}}">
                                        <i class="fa fa-pencil text-white"></i>
                                    </a>
                                    @endcan

                                    @can('delete client')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['clients.destroy', $client['id']],'id'=>'delete-form-'.$client['id']]) !!}
                                        <a href="#" class="btn btn-danger bs-pass-para" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$client->id}}').submit();">
                                            <i class="fa fa-trash text-white"></i>
                                        </a>
                                    {!! Form::close() !!}
                                    @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-page')
    <script type="text/javascript">
    $(document).on('click', '#rowAdder', function() {
            newRowAdd = `<div class="row mt-3" id="row" style="background: #ededed; padding: 10px; border-top: 2px solid #c9c9c9; border-bottom: 2px solid #c9c9c9;">
                <div class="col-6 mb-3">
                    <label for="contact_name">{{ __('Contact Name') }}</label>
                    <input type="text" name="contact_name[]" id="contact_name" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="position">{{ __('Contact Position') }}</label>
                    <input type="text" name="position[]" id="position" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="mobile">{{ __('Contact Mobile') }}</label>
                    <input type="text" name="mobile[]" id="mobile" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="email">{{ __('Contact Email') }}</label>
                    <input type="email" name="email[]" id="email" class="form-control" required>
                </div>
                <div class="col-12">
                    <button class="btn btn-danger" id="DeleteRow" type="button"><i class="fa fa-trash"></i></button>
                </div>
            </div>`;
            $('#newinput').append(newRowAdd);
        });
        $("body").on("click", "#DeleteRow", function () {
            $(this).parents("#row").remove();
        })
    </script>

    <script>
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