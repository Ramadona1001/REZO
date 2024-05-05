<div class="col-xl-12">
    <div class="card">
        <div class="card-body table-border-style">
            <div class="table-responsive">
                <table class="table datatable">
                    <thead>
                    <tr>
                        <th>{{__('Project ID')}}</th>
                        <th>{{__('Project')}}</th>
                        <th>{{__('Positions Count')}}</th>
                        <th>{{__('Positions')}}</th>
                        <th>{{__('Employees Assigned')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($projects) && !empty($projects) && count($projects) > 0)
                        @foreach ($projects as $key => $project)
                            @php
                                $project_position_count = \App\Models\ProjectPosition::where('project_id',$project->id)->sum('position_employees_number');
                                $project_position_employee_count = \App\Models\ProjectEmployee::where('project_id',$project->id)->count();
                                $project_position = \App\Models\ProjectPosition::where('project_id',$project->id)->get();
                                $project_services = \App\Models\ProjectService::where('project_id',$project->id)->get();
                            @endphp
                            <tr>
                                <td>{{ $project->id }}</td>
                                <td>
                                    <p class="mb-0"><a href="{{ route('projects.show',$project) }}" class="name mb-0 h6 text-sm">{{ $project->project_name }}</a></p>
                                    <span class="badge bg-{{\App\Models\Project::$status_color[$project->status]}} p-2 px-3 rounded">{{ __(\App\Models\Project::$project_status[$project->status]) }}</span>
                                </td>
                                <td>
                                   <span>{{ __('Total Positions That Need').' : '.$project->positions }}</span><br>
                                   <span>{{ __('Assigned Positions').' : '.$project_position_count }}</span><br>
                                   <span>{{ __('Remain Positions').' : '.$project->positions - $project_position_count }}</span><br>
                                </td>
                                <td>
                                    @if (count($project->project_positions) > 0)
                                        @foreach ($project->project_positions as $pos)
                                            <span>{{ __('Position').' : '.$pos->position->name }}<br>{{ __('Count').' : '.$pos->position_employees_number }}</span><hr>
                                        @endforeach
                                    @else
                                        {{ __('Not Assigned Any Positions') }}
                                    @endif
                                </td>
                                <td>
                                    @if (count($project->project_employees) > 0)
                                        @foreach ($project->project_employees as $emp)
                                            <span>{{ __('Position').' : '.$emp->position->name }}<br>{{ __('Employee').' : '.$emp->employee->name.' | '.$emp->count }}</span><hr>
                                        @endforeach
                                    @else
                                        {{ __('Not Assigned Any Employees') }}
                                    @endif
                                </td>
                                <td style=" display: flex; justify-content: space-between; ">
                                        <ul style="list-style: none;">
                                            @if (count($project_services) > 0)
                                            <li class="mb-2">
                                                <a href="#" class="btn btn-sm btn-info w-100" data-url="{{ URL::to('projects/'.$project->id.'/services') }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Services')}}" data-title="{{__('Services')}}">
                                                    <i class="fa fa-layer-group text-white"></i>
                                                    {{ __('Services') }}
                                                </a>
                                            </li>
                                            @endif
                                            @if($project_position_count < $project->positions)
                                                <li class="mb-2">
                                                    <a href="#" class="btn btn-sm btn-primary w-100" data-url="{{ URL::to('projects/'.$project->id.'/positions') }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Project Positions')}}" data-title="{{__('Project Positions')}}">
                                                        <i class="fa fa-user text-white"></i>
                                                        {{ __('Assign Positions') }}
                                                    </a>
                                                </li>
                                            @endif
                                            @if (($project->positions - $project_position_count) < $project->positions)
                                                <li class="mb-2">
                                                    <a href="#" class="btn btn-sm btn-info w-100" data-url="{{ URL::to('projects/'.$project->id.'/edit-positions') }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit Project Positions')}}" data-title="{{__('Edit Project Positions')}}">
                                                        <i class="fa fa-user text-white"></i>
                                                        {{ __('Edit Positions') }}
                                                    </a>
                                                </li>
                                            @endif
                                            @if (count($project_position) > 0)
                                                @if ($project_position_employee_count < $project->positions)
                                                    <li class="mb-2">
                                                        <a href="{{ URL::to('projects/'.$project->id.'/employees') }}" class="btn btn-sm btn-primary w-100"  title="{{__('Assign Employees')}}" data-title="{{__('Assign Employees')}}">
                                                            <i class="fa fa-user text-white"></i>
                                                            {{ __('Assign Employees') }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endif
                                            <li class="mb-2">
                                                @can('edit project')
                                                <a href="#" class="btn btn-sm btn-warning w-100" data-url="{{ URL::to('projects/'.$project->id.'/edit') }}" data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-title="{{__('Edit Project')}}">
                                                    <i class="fa fa-pencil text-white"></i>
                                                    {{ __('Edit Project') }}
                                                </a>
                                                @endcan
                                            </li>
                                            <li class="mb-2">
                                                @can('delete project')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['projects.destroy', [$project->id]]]) !!}
                                                    <a href="#" class="btn btn-sm btn-danger bs-pass-para w-100" data-bs-toggle="tooltip" title="{{__('Delete')}}"><i class="fa fa-trash text-white"></i> {{ __('Delete Project') }}</a>
                                                    {!! Form::close() !!}
                                                @endcan
                                            </li>
                                        </ul>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th scope="col" colspan="7"><h6 class="text-center">{{__('No Projects Found.')}}</h6></th>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

