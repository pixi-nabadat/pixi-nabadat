@extends('layouts.simple.master')

@section('title', trans('lang.sliders'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.sliders') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.sliders') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate=""
                            action="{{ route('sliders.store') }}">
                            @csrf
                            <div class="row g-3">
                                {{-- order --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="order">{{ trans('lang.order') }}</label>
                                    <input name="order" class="form-control @error('order') is-invalid @enderror"
                                        id="order" type="number" required>
                                    @error('order')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                {{--centers  --}}
                                <div class="col-md-12">
                                    <div class="col-form-label col-3">{{ __('lang.center') }}</div>
                                    <select id="center_id" name="center_id" class="js-example-basic-single col-sm-12">
                                        <option selected>...</option>
                                        @foreach ($centers as $center)
                                            <option value="{{ $center->id }}">{{ $center->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{--  duration  --}}
{{--                                <div class="col-md-12">--}}
{{--                                    <label class="form-label" for="duration">@lang('lang.duration')</label>--}}
{{--                                    <input type="time" name="duration" step="0.01"--}}
{{--                                        class="form-control @error('duration') is-invalid @enderror">--}}
{{--                                    @error('duration')--}}
{{--                                        <div class="invalid-feedback text-danger">{{ $message }}</div>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
                                {{--  start date  --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="start_date">@lang('lang.start_date')</label>
                                    <div class="input-group date" id="dt-start_date" data-target-input="nearest">
                                        <input name="start_date" class="datepicker-here form-control digits  @error('start_date') is-invalid @enderror" type="text" data-language="en" data-target="#dt-start_date" data-bs-original-title title>
                                        @error('start_date')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="input-group-text" data-target="#dt-start_date" data-toggle="datepicker"><i class="fa fa-calendar"> </i></div>
                                    </div>
                                </div>
                                {{--  end date  --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="start_date">@lang('lang.end_date')</label>
                                    <div class="input-group date" id="dt-start_date" data-target-input="nearest">
                                        <input name="end_date" class="datepicker-here form-control digits  @error('end_date') is-invalid @enderror" type="text" data-language="en" data-target="#dt-end_date" data-bs-original-title title>
                                        @error('end_date')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="input-group-text" data-target="#dt-start_date" data-toggle="datepicker"><i class="fa fa-calendar"> </i></div>
                                    </div>
                                </div>
                                {{-- slider_logo --}}
                                <div class="col-md-12">
                                    <label class="form-label col-3" for="logo">{{ trans('lang.logo') }}</label>
                                        <input name="logo" class="form-control image @error('logo') is-invalid @enderror"
                                            id="logo" type="file">
                                        @error('logo')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                </div>

                                <div class="form-group mt-3">
                                    <img src="{{ asset('/uploads/products/default.png') }}" style="width: 500px" class="img-thumbnail image-preview " alt="">
                                </div>
                                {{--  is_active  --}}
                                <div class="media mb-2">
                                    <label class="col-form-label m-r-10">{{ __('lang.is_active') }}</label>
                                    <div class="media-body  icon-state">
                                        <label class="switch">
                                            <input type="checkbox" name="is_active" checked=""><span
                                                class="switch-state"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary my-3" type="submit">{{ trans('lang.submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')

@endsection
