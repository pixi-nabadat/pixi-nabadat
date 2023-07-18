@extends('layouts.simple.master')

@section('title', trans('lang.clients'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.clients') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{route('home')}}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.clients') }}</li>
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
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.phone')</label>
                                    <input class="form-control" name="phone" id="validationCustom02" type="text" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.email')</label>
                                    <input class="form-control" name="email" id="validationCustom02" type="email" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-form-label">{{ trans('lang.choose_governorates') }}</div>
                                    <select id="change_location" data-filling-name="location_id"
                                        class="form-select form-control mb-3 @error('parent_id') is-invalid @enderror">
                                        <option selected>{{ trans('lang.choose_governorates') }}</option>
                                        @foreach ($governorates as $governorate)
                                            <option value="{{ $governorate->id }}">{{ $governorate->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="col-form-label">{{ trans('lang.city') }}</div>
                                    <select name="location_id"
                                        class="form-select form-control mb-3 @error('location_id') is-invalid @enderror"
                                        id="city"></select>
                                    @error('location_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                    <div class="card-header">
                        <h5><a role="button" class="btn btn-success " href={{ route('clients.create')}}><i class="fa fa-plus-circle"></i>{{trans('lang.add_client')}}</a></h5>
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
<script src="{{ asset('assets/js/location.js') }}"></script>
<script src="{{asset('assets/js/datatable-filter.js')}}"></script>
@endsection