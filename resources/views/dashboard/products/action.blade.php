<div class="d-flex justify-content-center">

    <a href="{{ route('products.show', $product) }}" class="btn-sm btn-primary me-1">
        <i class="fa fa-eye  my-2"></i>
    </a>

    <a href="{{ route('products.edit', $product) }}" class="btn-sm btn-info me-1">
        <i class="fa fa-pencil-square-o  my-2"></i>
    </a>

    <button role="button" onclick="destroy('{{ route('products.destroy', $product->id) }}')"
        class="btn btn-danger delete-btn me-1">
        <i class="fa fa-trash-o"></i>
    </button>

    <a href="{{ route('products.featured', $product) }}" class=" btn-sm btn-primary me-1">
        @if ($product->featured == 1)
            <i class="fa fa-check my-2">featured</i>
        @else
            <i class="fa fa-times my-2">featured</i>
        @endif
    </a>

</div>