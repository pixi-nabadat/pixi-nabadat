@extends('layouts.simple.master')
@section('title', 'Validation Forms')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
{{-- <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/main.css')}}"> --}}
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/main.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/datatable/style/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/datatable/style/jquery.dataTables.min.css')}}">

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/range-slider.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/owlcarousel.css')}}">

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endsection

@section('style')

@endsection

@section('breadcrumb-title')
<h3>Country Form</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">Country Form</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
                <div class="card-header">
					<a href="{{ route('create.country')}}"> {{ trans('lang.ADD_NEW_COUNTRY')}}</a>
				</div>
				<div class="card-header">
                    {!! $dataTable->table(['width' => '100%','class'=>'table table-striped table-bordered']) !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
{!! $dataTable->scripts() !!}
<script>
    $(document).ready(function () {
    $('table.display').DataTable();
});
</script>
<script src="{{asset('assets/js/form-validation-custom.js')}}"></script>
<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
<script src="{{asset('assets/datatable/js/jquery-3.5.1.js')}}"></script>
<script src="{{asset('assets/datatable/js/jquery.dataTables.min.js')}}"></script>

<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="{{asset('assets/js/owlcarousel/owl.carousel.js')}}"></script>


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
@endsection
