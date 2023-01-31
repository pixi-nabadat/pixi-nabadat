@extends('layouts.simple.master')

@section('title', trans('lang.sliders'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.sliders') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('sliders.index') }}">{{ trans('lang.packages') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.edit') }}</li>
@endsection
@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        {{-- order --}}
                        <div class="col-md-12">
                            <label class="form-label mt-3" for="order">{{ trans('lang.order') }}</label>
                            <p class="form-control" id="order">{{ $slider->order }}</p>
                        </div>
                        {{-- package --}}
                        <div class="col-md-12">
                            <label class="form-label mt-3" for="package_id">{{ trans('lang.package_id') }}</label>
                            <p class="form-control" id="package_id">{{ $slider->package_id }}</p>
                        </div>
                        {{-- duration --}}
                        <div class="col-md-12">
                            <label class="label-control mt-3" for="duration">{{ trans('lang.duration') }}</label>
                            <p class="form-control" id="duration">{{ $slider->duration }}</p>
                        </div>
                        {{-- start date --}}
                        <div class="col-md-12">
                            <label class="label-control  mt-3" for="start_date">{{ trans('lang.start_date') }}</label>
                            <p class="form-control" id="start_date">{{ $slider->start_date }}</p>
                        </div>
                        {{-- end date --}}
                        <div class="col-md-12">
                            <label class="label-control  mt-3" for="end_date">{{ trans('lang.end_date') }}</label>
                            <p class="form-control" id="end_date">{{ $slider->end_date }}</p>
                        </div>
                        {{-- is_active --}}
                        <div class="media my-3">
                            <label class="col-form-label m-r-10">{{ __('lang.is_active') }}</label>
                            <div class="media-body  icon-state">
                                <label class="switch">
                                    <input type="checkbox" disabled="true" name="is_active"
                                        {{ $slider->is_active == 1 ? 'checked' : '' }}><span class="switch-state"></span>
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
