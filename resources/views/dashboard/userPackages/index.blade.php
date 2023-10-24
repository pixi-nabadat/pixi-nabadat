@extends('layouts.simple.master')

@section('title', trans('lang.user_packages'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.user_packages') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.user_packages') }}</li>
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
                                    <label class="form-label" for="validationCustom02">@lang('lang.center_id')</label>
                                    <input class="form-control" name="center_id" id="validationCustom02" type="number" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.num_nabadat')</label>
                                    <input class="form-control" name="number_pulses" id="validationCustom02" type="number" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.price')</label>
                                    <input class="form-control" name="price" id="validationCustom02" type="number" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.package_id')</label>
                                    <input class="form-control" name="package_id" id="validationCustom02" type="number" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.discount_percentage')</label>
                                    <input class="form-control" name="discount_percentage" id="validationCustom02" type="number" value="">
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
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom01">@lang('lang.status')</label>
                                    <select class="form-select" name="status" id="validationCustom01">
                                        <option value="" selected>Choose...</option>
                                        <option value="{{ App\Enum\UserPackageStatusEnum::PENDING }}">{{ trans('lang.pending') }}</option>
                                        <option value="{{ App\Enum\UserPackageStatusEnum::READYFORUSE }}">{{ trans('lang.ready_for_use') }}</option>
                                        <option value="{{ App\Enum\UserPackageStatusEnum::ONGOING }}">{{ trans('lang.ongoing') }}</option>
                                        <option value="{{ App\Enum\UserPackageStatusEnum::COMPLETED }}">{{ trans('lang.completed') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.used')</label>
                                    <input class="form-control" name="used" id="validationCustom02" type="number" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustom02">@lang('lang.remain')</label>
                                    <input class="form-control" name="remain" id="validationCustom02" type="number" value="">
                                    <div class="valid-feedback">Looks good!</div>
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
                    @can('create_user_package')
                    <div class="card-header">
                        <h5><a role="button" class="btn btn-primary " href={{ route('user-packages.create')}}><i class="fa fa-plus-circle"></i> {{trans('lang.create_user_package')}}</a></h5>
                    </div>
                    @endcan
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