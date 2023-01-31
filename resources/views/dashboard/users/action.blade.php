<div class="d-flex justify-content-center">

    <a href="{{ route('clients.show', $user) }}" class="btn-sm btn-primary me-1">
        <i class="fa fa-eye  my-2"></i>
    </a>

    <a href="{{ route('clients.edit', $user) }}" class="btn-sm btn-info me-1">
        <i class="fa fa-pencil-square-o  my-2"></i>
    </a>

    <button role="button" onclick="destroy('{{ route('clients.destroy', $user->id) }}')"
            class="btn btn-danger delete-btn me-1">
        <i class="fa fa-trash-o"></i>
    </button>
</div>
