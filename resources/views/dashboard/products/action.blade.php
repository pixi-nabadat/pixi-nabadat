<div class="d-flex justify-content-center">

    @can('view_product')
    <a href="{{ route('products.show', $product) }}" class="btn-sm btn-primary me-1">
        <i class="fa fa-eye  my-2"></i>
    </a>
    @endcan

    @can('edit_product')
    <a href="{{ route('products.edit', $product) }}" class="btn-sm btn-info me-1">
        <i class="fa fa-pencil-square-o  my-2"></i>
    </a>
    @endcan

    @can('delete_product')
    <button role="button" onclick="destroy('{{ route('products.destroy', $product->id) }}')"
        class="btn btn-danger delete-btn me-1">
        <i class="fa fa-trash-o"></i>
    </button>
    @endcan
</div>
