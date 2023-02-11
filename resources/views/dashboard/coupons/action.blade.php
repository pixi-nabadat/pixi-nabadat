<div class="d-flex justify-content-center">

    @can('edit_coupon')
    <a href="{{ route('coupons.edit', $coupon) }}" class="btn-sm btn-info me-1">
        <i class="fa fa-pencil-square-o  my-2"></i>
    </a>
    @endcan

    @can('delete_coupon')
    <button role="button" onclick="destroy('{{ route('coupons.destroy', $coupon->id) }}')"
        class="btn btn-danger delete-btn me-1">
        <i class="fa fa-trash-o"></i>
    </button>
    @endcan

</div>
