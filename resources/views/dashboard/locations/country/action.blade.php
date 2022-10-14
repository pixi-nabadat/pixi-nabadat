<a href="{{ route('show.country',['id' => $location->id]) }}" >
    <i class="fa fa-eye"></i>
</a>

<a href="{{ route('edit.country',['id' => $location->id]) }}" >
    <i class="fa fa-pencil-square-o"></i>
</a>


<form class="delete_form" id="myformarticle{{$location->id}}"  action="{{ route('delete.country',['id' => $location->id])}}" method="post">
    {{csrf_field()}}<input type="hidden" name="_method" value="DELETE" /><input type="hidden" name="action_type" value="delete" />
    <a type="submit" class="delete_btnn" name="Delete">
        <i class="fa fa-trash"></i>
    </a>
</form>



<script type="text/javascript">


    $(".delete_btnn").click(function (event) {
        var form_id = $( this ).parent().attr('id');
      event.preventDefault();
    swal.fire({
      title: "هل انت متاكد",
      text: "تريد حذف الرساله",
      icon: "warning",
      buttons: [
            'رفض',
            'نعم موافق'
          ],
      dangerMode: true,
    }).then(function(isConfirm) {
          if (isConfirm) {
          $("#" + form_id).submit();
          } else {
            swal("رفض", "تم الغاء طلب الحذف :)", "error");
          }
        });


    });
</script>
