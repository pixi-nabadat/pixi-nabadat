<div class="d-flex justify-content-center">

    <a href="{{ route('devices.show', $device) }}" class="btn-sm btn-primary me-1">
        <i class="fa fa-eye  my-2"></i>
    </a>

    <a href="{{ route('devices.edit', $device) }}" class="btn-sm btn-info me-1">
        <i class="fa fa-pencil-square-o  my-2"></i>
    </a>

    <button role="button" onclick="destroy('{{ route('devices.destroy', $device->id) }}')"
        class="btn btn-danger delete-btn me-1">
        <i class="fa fa-trash-o"></i>
    </button>

    <a href="{{ route('devices.changeStatus', $device) }}" class=" btn-sm btn-primary me-1">
        @if ($device->is_active == 1)
            <i class="fa fa-check my-2"></i>
        @else
            <i class="fa fa-times my-2"></i>
        @endif
    </a>
</div>
