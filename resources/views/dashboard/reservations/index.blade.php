@extends('layouts.simple.master')

@section('title', trans('lang.reservations'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.reservations') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{route('home')}}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.reservations') }}</li>
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
                                    <label class="form-label" for="validationCustom01">@lang('lang.status')</label>
                                    <select class="form-select" name="status" id="validationCustom01">
                                        <option value="" selected>Choose...</option>
                                        <option value="{{ App\Models\Reservation::PENDING }}">{{ trans('lang.pending') }}</option>
                                        <option value="{{ App\Models\Reservation::APPROVED }}">{{ trans('lang.approved') }}</option>
                                        <option value="{{ App\Models\Reservation::CONFIRMED }}">{{ trans('lang.confirmed') }}</option>
                                        <option value="{{ App\Models\Reservation::ATTEND }}">{{ trans('lang.attend') }}</option>
                                        <option value="{{ App\Models\Reservation::COMPLETED }}">{{ trans('lang.completed') }}</option>
                                        <option value="{{ App\Models\Reservation::CANCELED }}">{{ trans('lang.canceled') }}</option>
                                        <option value="{{ App\Models\Reservation::Expired }}">{{ trans('lang.expired') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustom02">@lang('lang.check_date')</label>
                                    <input class="form-control" name="check_date" id="validationCustom02" type="date" value="">
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
                    <div class="card-header">
                        <a role="button" class="btn btn-primary" href="{{ route('reservations.create')}}"><i class="fa fa-plus-circle"></i> {{ trans('lang.add_reservation')}}</a>
                    </div>
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
    <script src="{{asset('assets/js/datatable-filter.js')}}"></script>
@endsection