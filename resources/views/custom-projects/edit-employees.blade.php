{{ Form::model($project, ['route' => ['projects.store.employees', $project->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <h4>{{ __('Project').' : ('.$project->project_name.') '.__('Positions') }}</h4>
    <div class="row">
        <table class="table table-stripped table-bordered">
            <thead>
                <th>{{ __('Position') }}</th>
                <th>{{ __('Employee') }}</th>
                <th>{{ __('Delete') }}</th>
            </thead>
            <tbody>
                @foreach ($project_positions as $data)
                    <tr>
                        <td>{{ $data->position->name }}</td>
                        <td>{{ $data->employee->name }}</td>
                        <td>
                            <a href="{{ route('projects.deleteEmployees',['id'=>$data->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure?')"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Save')}}" class="btn  btn-primary">
</div>
{{Form::close()}}