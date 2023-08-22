@extends('layouts.simple.master')

@section('title', trans('lang.sliders'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.sliders') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.sliders') }}</li>
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
                                    <select class="form-select" name="is_active" id="validationCustom01">
                                        <option value="" selected>Choose...</option>
                                        <option value="1">{{ trans('lang.active') }}</option>
                                        <option value="0">{{ trans('lang.not_active') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustom02">@lang('lang.start_date')</label>
                                    <input class="form-control" name="start_date_equal" id="validationCustom02" type="date" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustom02">@lang('lang.end_date')</label>
                                    <input class="form-control" name="end_date_equal" id="validationCustom02" type="date" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustom02">@lang('lang.order')</label>
                                    <input class="form-control" name="order" id="validationCustom02" type="number" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustom02">@lang('lang.center_id')</label>
                                    <input class="form-control" name="center_id" id="validationCustom02" type="number" value="">
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
                        <h5><a role="button" class="btn btn-primary " href={{ route('sliders.create') }}><i
                                    class="fa fa-plus-circle"></i>{{ trans('lang.add_slider') }}</a></h5>
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
@endsection
