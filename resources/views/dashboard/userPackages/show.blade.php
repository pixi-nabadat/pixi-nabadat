@extends('layouts.simple.master')

@section('title', trans('lang.user_packages'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.user_packages') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('userPackages.index') }}">{{ trans('lang.user_packages') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.edit') }}</li>
@endsection
@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        {{-- center --}}
                        <div class="col-md-12">
                            <label class="form-label mt-3" for="center">{{ trans('lang.center') }}</label>
                            <p class="form-control" id="center">{{ $userPackage->getTranslation('center_id', 'en') }}</p>
                        </div>
                        {{-- user --}}
                        <div class="col-md-12">
                            <label class="form-label mt-3" for="user">{{ trans('lang.user') }}</label>
                            <p class="form-control" id="user">{{ $userPackage->getTranslation('user_id', 'ar') }}</p>
                        </div>
                        {{-- num_nabadat --}}
                        <div class="col-md-12">
                            <label class="label-control mt-3" for="num_nabadat">{{ trans('lang.num_nabadat') }}</label>
                            <p class="form-control" id="num_nabadat">{{ $userPackage->num_nabadat }}</p>
                        </div>
                        {{-- price --}}
                        <div class="col-md-12">
                            <label class="label-control  mt-3" for="price">{{ trans('lang.price') }}</label>
                            <p class="form-control" id="price">{{ $userPackage->price }}</p>
                        </div>
                        {{-- package --}}
                        <div class="col-md-12">
                            <label class="label-control  mt-3" for="package">{{ trans('lang.package') }}</label>
                            <p class="form-control" id="package">{{ $userPackage->package->name }}</p>
                        </div>
                        {{-- discount_percentage --}}
                        <div class="col-md-12">
                            <label class="label-control  mt-3" for="discount_percentage">{{ trans('lang.discount_percentage') }}</label>
                            <p class="form-control" id="discount_percentage">{{ $userPackage->discount_percentage }}</p>
                        </div>
                        {{-- payment_method --}}
                        <div class="col-md-12">
                            <label class="label-control  mt-3" for="payment_method">{{ trans('lang.payment_method') }}</label>
                            <p class="form-control" id="payment_method">{{ $userPackage->payment_method }}</p>
                        </div>
                        {{-- payment_status --}}
                        <div class="col-md-12">
                            <label class="label-control  mt-3" for="payment_status">{{ trans('lang.payment_status') }}</label>
                            <p class="form-control" id="payment_status">{{ $userPackage->payment_status }}</p>
                        </div>
                        {{-- status --}}
                        <div class="col-md-12">
                            <label class="label-control  mt-3" for="status">{{ trans('lang.status') }}</label>
                            <p class="form-control" id="status">{{ $userPackage->status }}</p>
                        </div>
                        {{-- used --}}
                        <div class="col-md-12">
                            <label class="label-control  mt-3" for="used">{{ trans('lang.used') }}</label>
                            <p class="form-control" id="used">{{ $userPackage->used }}</p>
                        </div>
                        {{-- remain --}}
                        <div class="col-md-12">
                            <label class="label-control  mt-3" for="remain">{{ trans('lang.remain') }}</label>
                            <p class="form-control" id="remain">{{ $userPackage->remain }}</p>
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
