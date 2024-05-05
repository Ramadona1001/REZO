<div class="col-xl-12">
    <div class="card">
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                    <tr>
                        <th>{{__('Request ID')}}</th>
                        <th>{{__('Request Name')}}</th>
                        <th>{{__('Request Type')}}</th>
                        <th>{{__('Unit')}}</th>
                        <th>{{__('Positions')}}</th>
                        <th>{{__('Positions Need')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($custom_requests) && !empty($custom_requests) && count($custom_requests) > 0)
                        @foreach ($custom_requests as $key => $custom_request)
                            @php
                                $custom_request_position_count = \App\Models\CustomRequestPosition::where('custom_request_id',$custom_request->id)->sum('position_employees_number');
                                $custom_request_position = \App\Models\CustomRequestPosition::where('custom_request_id',$custom_request->id)->get();
                            @endphp
                            <tr>
                                <td>{{ idFormat('custom_request',$custom_request->id) }}</td>
                                <td>
                                    <p class="mb-0"><a href="{{ route('customs.show',$custom_request) }}" class="name mb-0 h6 text-sm">{{ $custom_request->request_name }}</a></p>
                                    <span class="badge bg-{{\App\Models\Project::$status_color[$custom_request->status]}} p-2 px-3 rounded">{{ __(\App\Models\CustomRequest::$project_status[$custom_request->status]) }}</span>
                                </td>
                                <td>
                                    @if ($custom_request->unit_position == 1)
                                        <span class="badge bg-info">{{ __('Unit') }}</span>
                                    @else
                                        <span class="badge bg-info">{{ __('Position') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($custom_request->unit != null)
                                        {{ $custom_request->unit->name }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $custom_request->positions }}</td>
                                <td>
                                    @if (count($custom_request->custom_positions) > 0)
                                        @foreach ($custom_request->custom_positions as $pos)
                                            <span>{{ __('Position').' : '.$pos->position->name }}<br>{{ __('Count').' : '.$pos->position_employees_number }}</span><hr>
                                        @endforeach
                                    @else
                                        {{ __('Not Assigned Any Positions') }}
                                    @endif
                                </td>
                                
                                <td style=" display: flex; justify-content: space-between; ">
                                        <ul style="list-style: none;">
                                            @if($custom_request_position_count < $custom_request->positions)
                                                <li class="mb-2">
                                                    <a href="#" class="btn btn-sm btn-primary w-100" data-url="{{ URL::to('customs/'.$custom_request->id.'/positions') }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Project Positions')}}" data-title="{{__('Project Positions')}}">
                                                        <i class="fa fa-user text-white"></i>
                                                        {{ __('Assign Positions') }}
                                                    </a>
                                                </li>
                                            @endif
                                            @if (($custom_request->positions - $custom_request_position_count) < $custom_request->positions)
                                                <li class="mb-2">
                                                    <a href="#" class="btn btn-sm btn-info w-100" data-url="{{ URL::to('customs/'.$custom_request->id.'/edit-positions') }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit Project Positions')}}" data-title="{{__('Edit Project Positions')}}">
                                                        <i class="fa fa-user text-white"></i>
                                                        {{ __('Edit Positions') }}
                                                    </a>
                                                </li>
                                            @endif
                                            <li class="mb-2">
                                                @can('edit project')
                                                <a href="#" class="btn btn-sm btn-warning w-100" data-url="{{ URL::to('customs/'.$custom_request->id.'/edit') }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Project')}}">
                                                    <i class="fa fa-pencil text-white"></i>
                                                    {{ __('Edit Request') }}
                                                </a>
                                                @endcan
                                            </li>
                                            <li class="mb-2">
                                                @can('delete project')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['customs.destroy', [$custom_request->id]]]) !!}
                                                    <a href="#" class="btn btn-sm btn-danger bs-pass-para w-100" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="fa fa-trash text-white"></i> {{ __('Delete Request') }}</a>
                                                    {!! Form::close() !!}
                                                @endcan
                                            </li>
                                        </ul>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th scope="col" colspan="7"><h6 class="text-center">{{__('No Custom Requests Found.')}}</h6></th>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

