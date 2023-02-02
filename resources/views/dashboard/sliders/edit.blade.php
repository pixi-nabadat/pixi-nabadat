@extends('layouts.simple.master')

@section('title', trans('lang.sliders'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.sliders') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('sliders.index') }}">{{ trans('lang.sliders') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.edit') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" enctype="multipart/form-data"
                            action="{{ route('sliders.update', $slider) }}" method="post">
                            @csrf
                            @method('put')
                            {{-- order --}}
                            <div class="col-md-12">
                                <label class="form-label mt-3" for="order">{{ trans('lang.order') }}</label>
                                <input name="order" value={{ $slider->order }}
                                    class="form-control @error('order') is-invalid @enderror" id="order"
                                    type="number" required>
                                @error('order')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{--packages  --}}
                            <div class="col-md-12">
                                <div class="col-form-label col-3">{{ __('lang.package') }}</div>
                                <select id="package_id" name="package_id" class="js-example-basic-single col-sm-12">
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}" {{ $package->id == $slider->package_id ? "selected":"" }}>{{ $package->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{--  duration  --}}
                            <div class="col-md-12">
                                <label class="form-label mt-3" for="duration">@lang('lang.duration')</label>
                                <input type="time" name="duration" step="0.01"
                                    class="form-control @error('duration') is-invalid @enderror" value={{ $slider->duration }}>
                                @error('duration')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{--  start data  --}}
                            <div class="col-md-12">
                                <label class="form-label mt-3" for="start_date">@lang('lang.start_date')</label>
                                <input type="date" name="start_date" step="0.01"
                                    class="form-control @error('start_date') is-invalid @enderror" value={{ $slider->start_date }}>
                                @error('start_date')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{--  end date  --}}
                            <div class="col-md-12">
                                <label class="form-label mt-3" for="end_date">@lang('lang.end_date')</label>
                                <input type="date" name="end_date" step="0.01"
                                    class="form-control @error('end_date') is-invalid @enderror" value={{ $slider->end_date }}>
                                @error('end_date')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- is_active --}}
                            <div class="media my-2">
                                <label class="col-form-label m-r-10">{{ __('lang.status') }}</label>
                                <div class="media-body  icon-state">
                                    <label class="switch">
                                        <input type="checkbox" name="is_active"
                                            {{ $slider->is_active == 1 ? 'checked' : '' }}><span
                                            class="switch-state"></span>
                                    </label>
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
