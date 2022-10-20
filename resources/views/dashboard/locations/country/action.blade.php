

<a role="button" class="btn btn-warning" href="{{route('country.edit',$location->id)}}" >
    <i class="fa fa-pencil-square-o"></i>
</a>

<button role="button" onclick="destroy('{{route("country.destroy",$location->id)}}')" class="btn btn-danger delete-btn">
    <i class="fa fa-trash-o"></i>
</button>
