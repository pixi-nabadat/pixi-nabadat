

<div class="d-flex justify-content-center">

    <a role="button" class="btn btn-warning" href="{{route('centers.edit',$center->id)}}" >
        <i class="fa fa-pencil-square-o"></i>
    </a>

    <button role="button" onclick="destroy('{{route("centers.destroy",$center->id)}}')" class="btn btn-danger delete-btn">
        <i class="fa fa-trash-o"></i>
    </button>

    <a href="{{ route('clients.changeStatus', $center) }}" class=" btn-sm btn-warning me-1">
        @if ($center->is_active == 1)
            <i class="fa fa-check my-2">{{trans('lang.de_active')}}</i>
        @else
            <i class="fa fa-times my-2">{{trans('lang.active')}}</i>
        @endif
    </a>
</div>


