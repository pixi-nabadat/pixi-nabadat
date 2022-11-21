@extends('layouts.simple.master')

@section('title', trans('lang.cancelReasons'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.cancelReasons') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('cancelReasons.index') }}">{{ trans('lang.cancelReasons') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.edit') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        {{-- English Reason --}}
                        <div class="col-md-12">
                            <label class="form-label mt-3" for="reason_en">{{ trans('lang.reason_en') }}</label>
                            <p name="reason[en]" class="form-control " id="reason_en">
                                {{ $cancelReason->getTranslation('reason', 'en') }}</p>
                        </div>
                        {{-- Arabic Reason --}}
                        <div class="col-md-12">
                            <label class="form-label mt-3" for="reason_ar">{{ trans('lang.reason_ar') }}</label>
                            <p name="reason[ar]" class="form-control" id="reason_ar">
                                {{ $cancelReason->getTranslation('reason', 'ar') }}</p>
                        </div>
                        {{-- Is Active --}}
                        <div class="media my-3">
                            <label class="col-form-label m-r-10">{{ __('lang.is_active') }}</label>
                            <div class="media-body  icon-state">
                                <label class="switch">
                                    <input type="checkbox" disabled="true" name="is_active"
                                        {{ $cancelReason->is_active == 1 ? 'checked' : '' }}>
                                    <span class="switch-state"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')
@endsection
