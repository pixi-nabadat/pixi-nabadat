@extends('layouts.simple.master')

@section('title', trans('lang.packages'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.packages') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('packages.index') }}">{{ trans('lang.packages') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.edit') }}</li>
@endsection
@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        {{-- English Name --}}
                        <div class="col-md-12">
                            <label class="form-label mt-3" for="name_en">{{ trans('lang.name_en') }}</label>
                            <p class="form-control" id="name_en">{{ $package->getTranslation('name', 'en') }}</p>
                        </div>
                        {{-- Arabic Name --}}
                        <div class="col-md-12">
                            <label class="form-label mt-3" for="name_ar">{{ trans('lang.name_ar') }}</label>
                            <p class="form-control" id="name_ar">{{ $package->getTranslation('name', 'ar') }}</p>
                        </div>
                        {{-- num_nabadat --}}
                        <div class="col-md-12">
                            <label class="label-control mt-3" for="num_nabadat">{{ trans('lang.num_nabadat') }}</label>
                            <p class="form-control" id="num_nabadat">{{ $package->num_nabadat }}</p>
                        </div>
                        {{-- price --}}
                        <div class="col-md-12">
                            <label class="label-control  mt-3" for="price">{{ trans('lang.price') }}</label>
                            <p class="form-control" id="price">{{ $package->price }}</p>
                        </div>
                        {{-- is_active --}}
                        <div class="media my-3">
                            <label class="col-form-label m-r-10">{{ __('lang.is_active') }}</label>
                            <div class="media-body  icon-state">
                                <label class="switch">
                                    <input type="checkbox" disabled="true" name="is_active"
                                        {{ $package->is_active == 1 ? 'checked' : '' }}><span class="switch-state"></span>
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
