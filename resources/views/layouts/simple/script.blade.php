<script src="{{asset('assets/js/jquery-3.5.1.min.js')}}"></script>
<!-- Bootstrap js-->
<script src="{{asset('assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<!-- scrollbar js-->
<script src="{{asset('assets/js/scrollbar/simplebar.js')}}"></script>
<script src="{{asset('assets/js/scrollbar/custom.js')}}"></script>
<!-- Sidebar jquery-->
<script src="{{asset('assets/js/config.js')}}"></script>
<!-- Plugins JS start-->
<script id="menu" src="{{asset('assets/js/sidebar-menu.js')}}"></script>
<script src="{{asset('assets/js/toastr.min.js')}}"></script>
{{--time picker --}}
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
{{--end picker--}}
<script src="{{asset('assets/js/sweet-alert/sweetalert.min.js')}}"></script>
<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
<script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>

@if(Route::current()->getName() != 'popover')
	<script src="{{asset('assets/js/tooltip-init.js')}}"></script>
@endif

<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{asset('assets/js/script.js')}}"></script>
<script src="{{asset('assets/js/theme-customizer/customizer.js')}}"></script>
<script>
    $(document).ready(function() {
        $(".dropdown-toggle").dropdown();
    });
    {{-- image preview --}}
    $(".image").change(function () {

        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.image-preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    function destroy(url) {
        swal({
            title: "{{__('lang.are_you_sure')}}",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((confirmed) => {
            if (confirmed) {
                $.ajax({
                    method: 'DELETE',
                    url: url,
                    dataType: 'json',
                    data:{
                        '_token': '{{ csrf_token() }}',
                    },
                    success: function(result) {
                        if (result.status)
                        {
                            toastr.success(result.message);
                            if (result.data == 'reload')
                                window.location.reload();
                            else
                                $('.dataTable').DataTable().ajax.reload(null, false);
                        }
                        else
                            toastr.error(result.message);
                    }
                });
            }
        });
    }
    function changeModelStatus(url,id){
        $.ajax({
            method: 'post',
            url: url,
            dataType: 'json',
            data:{
                '_token': '{{ csrf_token() }}',
                'id' : id
            },
            success: function(result) {
                if (result.status)
                {
                    toastr.success(result.message);
                    if (result.data == 'reload')
                        window.location.reload();
                    else
                        $('.dataTable').DataTable().ajax.reload(null, false);
                }
                else
                    toastr.error(result.message);
            }
        });
    }
</script>
@yield('script')

