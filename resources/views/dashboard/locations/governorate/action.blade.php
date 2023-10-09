
@can('edit_governorate')
<a role="button" class="btn btn-primary" href="{{route('governorate.edit',$location->id)}}" >
    <i class="fa fa-pencil-square-o"></i>
</a>
@endcan

@can('delete_governorate')
<button role="button" onclick="destroy('{{route("governorate.destroy",$location->id)}}')" class="btn btn-danger delete-btn">
    <i class="fa fa-trash-o"></i>
</button>
@endcan
