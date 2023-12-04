<div class="d-flex justify-content-center">

    {{--    <a href="{{ route('packages.show', $package) }}" class="btn-sm btn-primary me-1">--}}
    {{--        <i class="fa fa-eye  my-2"></i>--}}
    {{--    </a>--}}
    
        @can('edit_fcm_message')
        <a href="{{ route('fcm-messages.edit', $fcmMessage) }}" class="btn-sm btn-info me-1">
            <i class="fa fa-pencil-square-o  my-2"></i>
        </a>
        @endcan
    
        @can('delete_fcm_message')
        <button role="button" onclick="destroy('{{ route('fcm-messages.destroy', $fcmMessage->id) }}')"
            class="btn btn-danger delete-btn me-1">
            <i class="fa fa-trash-o"></i>
        </button>
        @endcan
    
    </div>