<div class="d-flex justify-content-center">

    <a href="{{ route('user-packages.show', $userPackage) }}" class="btn-sm btn-primary me-1">
        <i class="fa fa-eye  my-2"></i>
     </a>
 
     <a href="{{ route('user-packages.edit', $userPackage) }}" class="btn-sm btn-info me-1">
         <i class="fa fa-pencil-square-o  my-2"></i>
     </a>
 
     <button role="button" onclick="destroy('{{ route('user-packages.destroy', $userPackage->id) }}')"
         class="btn btn-danger delete-btn me-1">
         <i class="fa fa-trash-o"></i>
     </button>
 
 </div>