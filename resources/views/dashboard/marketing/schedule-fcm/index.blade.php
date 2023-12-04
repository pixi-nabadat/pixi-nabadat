@extends('layouts.simple.master')

@section('title', trans('lang.schedule_fcm'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.schedule_fcm') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.schedule_fcm') }}</li>
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
                                    <label class="form-label" for="validationCustom01">@lang('lang.trigger')</label>
                                    <select class="form-select" name="trigger" id="validationCustom01">
                                        <option value="" selected>Choose...</option>
                                        @foreach ($triggers as $key=>$trigger)
                                            <option value="{{ $key }}">{{ trans('lang.'.$trigger) }}</option>
                                        @endforeach
                                     </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustom02">@lang('lang.start_date')</label>
                                    <input class="form-control" name="start_date" id="validationCustom02" type="date" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustom02">@lang('lang.end_date')</label>
                                    <input class="form-control" name="end_date" id="validationCustom02" type="date" value="">
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="validationCustom01">@lang('lang.notification_via')</label>
                                    <select class="form-select" name="notification_via" id="validationCustom01">
                                        <option value="" selected>Choose...</option>
                                        @foreach ($fcm_channels as $key=>$fcm_channel)
                                            <option value="{{ $key }}">{{ trans('lang.'.$fcm_channel) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="validationCustom01">@lang('lang.status')</label>
                                    <select class="form-select" name="is_active" id="validationCustom01">
                                        <option value="" selected>Choose...</option>
                                        <option value="1">{{ trans('lang.active') }}</option>
                                        <option value="0">{{ trans('lang.not_active') }}</option>
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
                    {{-- TODO: add the fcm permission to create fcm --}}
                    <div class="card-header">
                        @can('create_fcm')
                        <h5><a role="button" class="btn btn-primary " href={{ route('fcm-messages.create')}}><i class="fa fa-plus-circle"></i>{{trans('lang.add_notification')}}</a></h5>
                        @endcan
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