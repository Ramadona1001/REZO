<div class="modal-body">
    <div class="row mb-3">
        <table class="table table-bordered table-stripped">
            <thead>
                <th>{{ __('Service') }}</th>
                <th>{{ __('Financial Value') }}</th>
                <th>{{ __('Actions') }}</th>
            </thead>
            <tbody>
                @foreach ($project_services as $s)
                    <tr>
                        <td>{{ $s->service->name }}</td>
                        <td>{{ $s->financial_value }}</td>
                        <td>
                            <a href="{{ route('projects.deleteServices',['id'=>$s->id]) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are You Sure?')">
                                <i class="fa fa-trash"></i>
                            </a>    
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>