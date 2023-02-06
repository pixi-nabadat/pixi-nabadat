<div class="d-flex justify-content-center">

    @can('edit_center_device')
    <a href="{{ route('centerDevices.edit', $centerDevice) }}" class="btn-sm btn-info me-1">
        <i class="fa fa-pencil-square-o  my-2"></i>
    </a>
    @endcan
</div>
