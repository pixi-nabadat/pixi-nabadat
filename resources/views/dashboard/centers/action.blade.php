<div class="d-flex justify-content-center">

    @can('view_center')
    <a href="{{ route('centers.show', $center) }}" class="btn-sm btn-primary me-1">
        <i class="fa fa-eye  my-2"></i>
    </a>
    @endcan

    @can('edit_center')
    <a href="{{ route('centers.edit', $center) }}" class="btn-sm btn-info me-1">
        <i class="fa fa-pencil-square-o  my-2"></i>
    </a>
    @endcan

    @can('delete_center')
    <button role="button" onclick="destroy('{{ route('centers.destroy', $center->id) }}')"
        class="btn btn-danger delete-btn me-1">
        <i class="fa fa-trash-o"></i>
    </button>
    @endcan
</div>
