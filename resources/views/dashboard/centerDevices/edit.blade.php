@extends('layouts.simple.master')

@section('title', trans('lang.centerDevices'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.center_devices') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.center_devices') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        
                        <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate="" action="{{ route('centerDevices.update',$centerDevice) }}">
                            @csrf
                            @method('put')
                            <div class="row g-3">
                                {{-- number_of_devices --}}
                                <div class="col-md-6  my-3">
                                    <label class="form-label" for="number_of_devices">@lang('lang.number_of_devices')</label>
                                    <input type="number" name="number_of_devices" value={{ $centerDevice->number_of_devices }} step="1"
                                        class="form-control @error('number_of_devices') is-invalid @enderror">
                                    @error('number_of_devices')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- is_support_auto_service --}}
                                <div class="col-md-12 d-flex">
                                    <div class="media mb-2">
                                        <label
                                            class="col-form-label m-r-10" for="is_support_auto_service">{{ trans('lang.is_support_auto_service') }}</label>
                                        <div class="media-body  icon-state">
                                            <label class="switch">
                                                <input name="is_support_auto_service"
                                                @error('is_support_auto_service') is-invalid @enderror
                                                id="is_support_auto_service"
                                                type="checkbox" {{ $centerDevice->is_support_auto_service ? "checked":"" }}><span class="switch-state"></span>
                                            </label>
                                        </div>
                                        @error('is_support_auto_service')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- is_active --}}
                                <div class="col-md-12 d-flex">
                                    <div class="media mb-2">
                                        <label
                                            class="col-form-label m-r-10" for="is_active">{{ trans('lang.is_active') }}</label>
                                        <div class="media-body  icon-state">
                                            <label class="switch">
                                                <input name="is_active"
                                                @error('is_active') is-invalid @enderror
                                                id="is_active"
                                                type="checkbox" {{ $centerDevice->is_active ? "checked":"" }}><span class="switch-state"></span>
                                            </label>
                                        </div>
                                        @error('is_active')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
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