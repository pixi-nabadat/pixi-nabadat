<div class="d-flex justify-content-center">

    @can('edit_category')
    <a href="{{ route('categories.edit', $category) }}" class="btn-sm btn-info me-1">
        <i class="fa fa-pencil-square-o  my-2"></i>
    </a>
    @endcan
    @can('delete_category')
    <button role="button" onclick="destroy('{{ route('categories.destroy', $category->id) }}')"
        class="btn btn-danger delete-btn me-1">
        <i class="fa fa-trash-o"></i>
    </button>
    @endcan
</div>
