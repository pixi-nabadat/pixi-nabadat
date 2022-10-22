<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "2000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>
@if(session()->has('toast'))
    <script>
        @switch(session('toast')['type']??'success')

        @case('error')
            toastr.error("{{session('toast')['message']}}","{{session('toast')['title']}}");
        @break

        @case('info')
            toastr.info("{{session('toast')['message']}}","{{session('toast')['title']}}")
        @break

        @default
            toastr.success("{{session('toast')['message']}}","{{session('toast')['title']}}")
        @endswitch

    </script>

@endif
