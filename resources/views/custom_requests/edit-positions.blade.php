<div class="modal-body">
    <h4>{{ __('Request').' : ('.$custom_request->request_name.') '.__('Positions') }}</h4>
    @foreach ($custom_request_position as $position)
    <form action="{{ route('customs.edit.positions',['id'=>$position->id]) }}" method="post">
        @csrf
        <table class="table table-bordered" style="text-align: center">
            <thead>
                <th>{{ __('Request') }}</th>
                <th>{{ __('Positions Count') }}</th>
                <th>{{ __('Actions') }}</th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @if ($position->position != null)
                            <p>{{ $position->position->name }}</p>
                        @endif
                    </td>
                    <td>
                        <input type="number" name="positions_count" style="text-align: center" class="form-control" value="{{ $position->position_employees_number }}" min="0" step="0.5" required>
                    </td>
                    <td>
                        <input type="submit" value="{{__('Save')}}" class="btn  btn-primary">
                        <a href="{{ route('customs.deletePositions',['id'=>$position->id]) }}" onclick="return confirm ('Are You Sure?')" class="btn btn-danger">{{__('Delete')}}</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    @endforeach
    
</div>
<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
</div>

