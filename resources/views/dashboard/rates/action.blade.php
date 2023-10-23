<div class="d-flex justify-content-center">

    @can('view_rate')
    <a href="{{ route('rates.show', $rate) }}" class="btn-sm btn-info me-1">
        <i class="fa fa-eye my-2"></i>
    </a>
    @endcan

    @can('delete_rate')
    <button role="button" onclick="destroy('{{ route('rates.destroy', $rate->id) }}')"
        class="btn btn-danger delete-btn me-1">
        <i class="fa fa-trash-o"></i>

    </button>
    @endcan
</div>
