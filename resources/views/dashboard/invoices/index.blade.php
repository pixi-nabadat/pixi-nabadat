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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation datatables_parameters" novalidate="">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.center_id')</label>
                                    <input class="form-control" name="center_id" id="validationCustom02" type="number" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.total_center_dues')</label>
                                    <input class="form-control" name="total_center_dues" id="validationCustom02" type="number" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.total_nabadat_dues')</label>
                                    <input class="form-control" name="total_nabadat_dues" id="validationCustom02" type="number" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.completed_date')</label>
                                    <input class="form-control" name="completed_date" id="validationCustom02" type="date" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustom01">@lang('lang.status')</label>
                                    <select class="form-select" name="status" id="validationCustom01">
                                        <option value="" selected>Choose...</option>
                                        <option value="{{ App\Models\Invoice::PENDING }}">{{ trans('lang.pending') }}</option>
                                        <option value="{{ App\Models\Invoice::COMEPELETED }}">{{ trans('lang.completed') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button class="btn btn-primary search_datatable" type="submit">{{trans('lang.search')}}</button>
                                    <button class="btn btn-primary reset_form_data" type="button">{{trans('lang.rest')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table" style="overflow-x: scroll">
                            {!! $dataTable->table(['class'=>'table table-data table-striped table-bordered']) !!}
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