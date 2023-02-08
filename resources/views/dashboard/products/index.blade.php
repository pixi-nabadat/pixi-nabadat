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
                                    <select class="form-select" name="test" id="validationCustom01" required="">
                                        <option  disabled="" value="">Choose...</option>
                                        <option value="1" selected="">eslam</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom02">@lang('lang.last_name')</label>
                                    <input class="form-control" name="tttttt" id="validationCustom02" type="text" value="Otto"
                                           required="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustomUsername">@lang('lang.user_name')</label>
                                    <div class="input-group"><span class="input-group-text"
                                                                   id="inputGroupPrepend">@</span>
                                        <input class="form-control" name="ttttttttttttttttt" id="validationCustomUsername" type="text"
                                               placeholder="Username" value="eslam" aria-describedby="inputGroupPrepend" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <button class="btn btn-primary search_datatable" type="submit">{{trans('lang.search')}}</button>
                                </div>
                                <div class="col-md-3">
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
