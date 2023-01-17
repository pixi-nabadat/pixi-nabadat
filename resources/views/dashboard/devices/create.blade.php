@extends('layouts.simple.master')

@section('title', trans('lang.devices'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.devices') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.devices') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate="" action="{{ route('devices.store') }}">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label" for="name_ar">{{ trans('lang.name_ar') }}</label>
                                    <input name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror"
                                        id="name_ar" type="text" required>
                                    @error('name.ar')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="name_en">{{ trans('lang.name_en') }}</label>
                                    <input name="name[en]" class="form-control @error('name.en') is-invalid @enderror"
                                        id="name_en" type="text" required>
                                    @error('name.en')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="description_ar">{{ trans('lang.description_ar') }}</label>
                                    <input name="description[ar]" class="form-control @error('description.ar') is-invalid @enderror"
                                        id="description_ar" type="text" required>
                                    @error('description.ar')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="description_en">{{ trans('lang.description_en') }}</label>
                                    <input name="description[en]" class="form-control @error('description.en') is-invalid @enderror"
                                        id="description_en" type="text" required>
                                    @error('description.en')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- device_logo --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="logo">{{ trans('lang.logo') }}</label>
                                    <input name="logo" class="form-control image @error('logo') is-invalid @enderror"
                                        id="logo" type="file">
                                    @error('logo')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <img src="{{ asset('/uploads/device/default.png') }}" style="width: 500px" class="img-thumbnail image-preview " alt="">
                                </div>
                                {{-- device_images --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="image">{{ trans('lang.image') }}</label>
                                    <input name="images[]" class="form-control image @error('image') is-invalid @enderror"
                                        id="image" type="file" multiple>
                                    @error('image')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <img src="{{ asset('/uploads/device/default.png') }}" style="width: 500px" class="img-thumbnail image-preview " alt="">
                                </div>

                            </div>

                            <div class="media mb-2">
                                <label class="col-form-label m-r-10">{{ __('lang.is_active') }}</label>
                                <div class="media-body  icon-state">
                                    <label class="switch">
                                        <input type="checkbox" name="is_active" checked=""><span
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
