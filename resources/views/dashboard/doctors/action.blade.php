<div class="d-flex justify-content-center">

    @can('edit_doctor')
    <a href="{{ route('doctors.edit', $doctor) }}" class="btn-sm btn-info me-1">
        <i class="fa fa-pencil-square-o  my-2"></i>
    </a>
    @endcan

    @can('delete_doctor')
    <button role="button" onclick="destroy('{{ route('doctors.destroy', $doctor->id) }}')"
        class="btn btn-danger delete-btn me-1">
        <i class="fa fa-trash-o"></i>

    </button>
    @endcan
</div>
