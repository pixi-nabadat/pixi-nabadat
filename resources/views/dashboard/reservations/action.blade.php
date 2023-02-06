<div class="d-flex justify-content-center">

    @can('edit_reservation')
    {{-- <a href="{{ route('reservations.edit', $reservation) }}" class="btn-sm btn-info me-1">
        <i class="fa fa-pencil-square-o  my-2"></i>
    </a>
    @endcan

    @can('delete_reservation')
    <button role="button" onclick="destroy('{{ route('reservations.destroy', $reservation->id) }}')"
        class="btn btn-danger delete-btn me-1">
        <i class="fa fa-trash-o"></i>
    </button> --}}
    @endcan
</div>
