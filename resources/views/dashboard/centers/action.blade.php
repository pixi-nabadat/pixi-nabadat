


<a role="button" class="btn btn-warning" href="{{route('centers.edit',$center->id)}}" >
    <i class="fa fa-pencil-square-o"></i>
</a>

<button role="button" onclick="destroy('{{route("centers.destroy",$center->id)}}')" class="btn btn-danger delete-btn">
    <i class="fa fa-trash-o"></i>
</button>
