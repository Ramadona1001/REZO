@extends('layouts.admin')
@section('page-title')
    {{ $project->project_name.' '.__('Assign Employees') }}
@endsection

@push('css-page')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.dataTables.css">
<style>
    table,th.dt-orderable-asc.dt-orderable-desc,th.dt-type-numeric.dt-orderable-asc.dt-orderable-desc.dt-ordering-asc,td,td.dt-type-numeric.sorting_1{
        text-align: center !important;
    }
</style>
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Projects')}}</li>
@endsection
@section('content')
{{ Form::model($project, ['route' => ['projects.store.employees', $project->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
<div class="row">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            @foreach ($project_position as $index => $position)
                <button class="nav-link @if($index == 0) active @endif" id="{{ 'position_'.$position->id }}-tab" data-bs-toggle="tab" data-bs-target="#{{ 'position_'.$position->id }}" type="button" role="tab" aria-controls="{{ 'position_'.$position->id }}" aria-selected="true">{{ __('Position:').' '.$position->position->name }}</button>
            @endforeach
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        @foreach ($project_position as $index => $position)
        <div class="tab-pane fade @if($index == 0) show active @endif" id="{{ 'position_'.$position->id }}" role="tabpanel" aria-labelledby="{{ 'position_'.$position->id }}-tab" tabindex="0">
            <div style=" padding: 10px; border: 2px solid white; ">
                <table  class="display example text-center" style="width:100%">
                    <thead>
                        <th>{{ __('Employee ID') }}</th>
                        <th>{{ __('Employee Name') }}</th>
                        <th>{{ __('Position No. Need') }}</th>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            @php
                                $emp_pos = \App\Models\ProjectEmployee::where('employee_id',$employee->id)->where('project_id',$project->id)->where('position_id',$position->position->id)->first();
                                $pos_count = 0;
                                if ($emp_pos != null) {
                                    $pos_count = $emp_pos->count;
                                }
                            @endphp
                            @if($employee->position_id == $position->position->id)
                            <tr>
                                <td>{{ $employee->id }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ Form::number('positions_count['.$position->position->id.']['.$employee->id.']',$pos_count, ['class' => 'form-control','step'=>0.01,'min' => 0]) }}</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
</div>
<input type="submit" value="{{__('Save')}}" class="btn  btn-primary mt-3">
{{Form::close()}}
@endsection

@push('script-page')
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
<script>
    new DataTable('.example', {
        layout: {
            bottomEnd: {
                paging: {
                    boundaryNumbers: false
                }
            }
        }
    });
</script>
@endpush