@extends('layouts.simple.master')

@section('title', trans('lang.invoices'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.invoices') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{route('home')}}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.invoice') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
{{--                        <h5><a role="button" class="btn btn-success " href={{ route('cancelReasons.create')}}><i class="fa fa-plus-circle"></i>{{trans('lang.create_transaction')}}</a></h5>--}}
                    </div>
                    <div class="card-body">
                        <div class="table">
                            {!! $dataTable->table() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Zero Configuration  Ends-->
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection

@section('script')
{!! $dataTable->scripts() !!}
    <script>
        function settleInvoice(url,id) {
            swal({
                title: "{{__('lang.are_you_sure')}}",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((confirmed) => {
                if (confirmed) {
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
                        },
                        error: function (xhr, textStatus, errorThrown) {
                            toastr.error(xhr.responseJSON.errors[0].error);
                        }
                    });
                }
            });
        }
    </script>
@endsection