
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <table class="table table-stripped table-bordered">
                <thead>
                    <th>{{ __('Project ID') }}</th>
                    <th>{{ __('Project Name') }}</th>
                    <th>{{ __('Total Hours') }}</th>
                    <th>{{ __('Amount') }}</th>
                    <th>{{ __('Project Content') }}</th>
                    <th>{{ __('Actions') }}</th>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <td>{{ $project->id }}</td>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->total_hours }}</td>
                            <td>{{ $project->amount }}</td>
                            <td>{{ $project->content }}</td>
                            <td>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['suppliers.delete_projects',['project'=>$project->id]],'id'=>'delete-form-'.$project->id]) !!}
                                        <a href="#" class="btn btn-danger bs-pass-para" data-toggle="tooltip" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$project->id}}').submit();">
                                            <i class="fa fa-trash text-white"></i>
                                        </a>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


