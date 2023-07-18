@extends('layouts.simple.master')

@section('title', trans('lang.products'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.products') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{route('home')}}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.products') }}</li>
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
                                        <option value="1">{{ trans('lang.acitve') }}</option>
                                        <option value="0">{{ trans('lang.not_acitve') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom01">@lang('lang.feature')</label>
                                    <select class="form-select" name="featured" id="validationCustom01">
                                        <option selected value="">Choose...</option>
                                        <option value="1">{{ trans('lang.yes') }}</option>
                                        <option value="0">{{ trans('lang.no') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom01">@lang('lang.type')</label>
                                    <select class="form-select" name="type" id="validationCustom01">
                                        <option selected value="">Choose...</option>
                                        <option value="1">{{ trans('lang.center') }}</option>
                                        <option value="2">{{ trans('lang.user') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom01">@lang('lang.added_by')</label>
                                    <select class="form-select" name="added_by" id="validationCustom01">
                                        <option selected value="">Choose...</option>
                                        @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom01">@lang('lang.category')</label>
                                    <select class="form-select" name="category_id" id="validationCustom01">
                                        <option selected value="">Choose...</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustom02">@lang('lang.stock_less_than')</label>
                                    <input class="form-control" name="stock_less_than" id="validationCustom02" type="number" value="">
                                    <div class="valid-feedback">Looks good!</div>
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
                        <h5><a role="button" class="btn btn-success " href={{ route('products.create')}}><i
                                    class="fa fa-plus-circle"></i>{{trans('lang.add_product')}}</a></h5>
                    </div>
                    <div class="card-body">
                        <div class="table">
                            {!! $dataTable->table(['class'=>'table-data']) !!}
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
