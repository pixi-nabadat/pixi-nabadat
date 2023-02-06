<div class="d-flex justify-content-center">
    @can('view_order')
    <a href="{{ route('orders.show', $order) }}" class="btn-sm btn-primary me-1">
        <i class="fa fa-eye my-2"></i>
    </a>
    @endcan

</div>
