@extends('layouts.simple.master')

@section('title', trans('lang.orders'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.orders') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{route('home')}}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.orders') }}</li>
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
                                    <label class="form-label" for="validationCustom02">@lang('lang.user_id')</label>
                                    <input class="form-control" name="user_id" id="validationCustom02" type="number" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.user_phone')</label>
                                    <input class="form-control" name="user_phone" id="validationCustom02" type="text" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.shipping_fees')</label>
                                    <input class="form-control" name="shipping_fees" id="validationCustom02" type="number" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.sub_total')</label>
                                    <input class="form-control" name="sub_total" id="validationCustom02" type="number" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.grand_total')</label>
                                    <input class="form-control" name="grand_total" id="validationCustom02" type="number" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.coupon_discount')</label>
                                    <input class="form-control" name="coupon_discount" id="validationCustom02" type="number" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom01">@lang('lang.payment_method')</label>
                                    <select class="form-select" name="payment_method" id="validationCustom01">
                                        <option value="" selected>Choose...</option>
                                        <option value="{{ App\Enum\PaymentMethodEnum::CASH }}">{{ trans('lang.cash') }}</option>
                                        <option value="{{ App\Enum\PaymentMethodEnum::CREDIT }}">{{ trans('lang.credit') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom01">@lang('lang.payment_status')</label>
                                    <select class="form-select" name="payment_status" id="validationCustom01">
                                        <option value="" selected>Choose...</option>
                                        <option value="{{ App\Enum\PaymentStatusEnum::PAID }}">{{ trans('lang.paid') }}</option>
                                        <option value="{{ App\Enum\PaymentStatusEnum::UNPAID }}">{{ trans('lang.unpaid') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustom01">@lang('lang.order_status')</label>
                                    <select class="form-select" name="status" id="validationCustom01">
                                        <option value="" selected>Choose...</option>
                                        <option value="{{ App\Models\Order::PENDING }}">{{ trans('lang.pending') }}</option>
                                        <option value="{{ App\Models\Order::CONFIRMED }}">{{ trans('lang.confirmed') }}</option>
                                        <option value="{{ App\Models\Order::SHIPPED }}">{{ trans('lang.shipped') }}</option>
                                        <option value="{{ App\Models\Order::DELIVERED }}">{{ trans('lang.delivered') }}</option>
                                        <option value="{{ App\Models\Order::CANCELED }}">{{ trans('lang.canceled') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button class="btn btn-success search_datatable" type="submit">{{trans('lang.search')}}</button>
                                    <button class="btn btn-danger reset_form_data" type="button">{{trans('lang.rest')}}</button>
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
                        <div class="table">
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
@endsection