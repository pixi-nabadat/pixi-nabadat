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
                                {{-- regular_price --}}
                                <div class="col-md-6  my-3">
                                    <label class="form-label" for="regular_price">@lang('lang.regular_price')</label>
                                    <input type="number" name="regular_price" value={{ $centerDevice->regular_price }}  step="0.01"
                                        class="form-control @error('regular_price') is-invalid @enderror">
                                    @error('regular_price')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- nabadat_app_price --}}
                                <div class="col-md-6  my-3">
                                    <label class="form-label" for="nabadat_app_price">@lang('lang.nabadat_app_price')</label>
                                    <input type="number" name="nabadat_app_price" value={{ $centerDevice->nabadat_app_price }}  step="0.01"
                                        class="form-control @error('nabadat_app_price') is-invalid @enderror">
                                    @error('nabadat_app_price')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- auto_service_price --}}
                                <div class="col-md-6  my-3">
                                    <label class="form-label" for="auto_service_price">@lang('lang.auto_service_price')</label>
                                    <input type="number" name="auto_service_price"  value={{ $centerDevice->auto_service_price }}  step="0.01"
                                        class="form-control @error('auto_service_price') is-invalid @enderror">
                                    @error('auto_service_price')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
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