@extends('layouts.simple.master')

@section('title', trans('lang.coupons'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.coupons') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.coupons') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate="" action="{{ route('coupons.store') }}">
                            @csrf

                            <div class="row g-3">
                                {{-- code --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="code">{{ trans('lang.code') }}</label>
                                    <input name="code" value="{{old('code')}}" class="form-control @error('code') is-invalid @enderror"
                                        id="code" type="text" required>
                                    @error('code')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- min_buy --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="min_buy">{{ trans('lang.min_buy') }}</label>
                                    <input name="min_buy" class="form-control @error('min_buy') is-invalid @enderror"
                                        id="min_buy" type="number" required>
                                    @error('min_buy')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- allowed_usage --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="allowed_usage">{{ trans('lang.allowed_usage') }}</label>
                                    <input name="allowed_usage" class="form-control @error('allowed_usage') is-invalid @enderror"
                                        id="allowed_usage" type="number" required>
                                    @error('allowed_usage')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- coupon_for --}}
                                <div class="col-md-6  my-3">
                                    <div class="col-form-label  col-3">{{ __('lang.coupon_for') }}</div>
                                    <select id="select_coupon_for" name="coupon_for"
                                        class="col form-control">
                                        <option  value = 'store'>   {{trans('lang.store')}}</option>
                                        <option  value = 'reservation' selected>{{trans('lang.reservation')}}</option>
                                    </select>
                                </div>
                                {{-- discount_type --}}
                                <div class="col-md-6  my-3">
                                    <div class="col-form-label  col-3">{{ __('lang.discount_type') }}</div>
                                    <select id="select_discount_type" name="discount_type"
                                        class="col form-control">
                                        <option  value = "{{\App\Models\Coupon::DISCOUNT_FLAT}}">   {{trans('lang.flat')}}</option>
                                        <option  value = "{{\App\Models\Coupon::DISCOUNT_PERCENTAGE}}" selected>{{trans('lang.percent')}}</option>
                                    </select>
                                </div>
                                {{-- discount --}}
                                <div class="col-md-6  my-3">
                                    <label class="form-label" for="discount">@lang('lang.discount')</label>
                                    <input type="number" name="discount" step="0.01"
                                        class="form-control @error('discount') is-invalid @enderror">
                                    @error('discount')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- start_date --}}
                                <div class="col-md-6  my-3">
                                    <label class="form-label" for="start_date">@lang('lang.start_date')</label>
                                    <div class="input-group date" id="dt-start_date" data-target-input="nearest">
                                        <input name="start_date" class="datepicker-here form-control digits  @error('start_date') is-invalid @enderror" type="text" data-language="en" data-target="#dt-start_date" data-bs-original-title title>
                                        @error('start_date')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="input-group-text" data-target="#dt-start_date" data-toggle="datepicker"><i class="fa fa-calendar"> </i></div>
                                    </div>
                                </div>
                                {{-- end_date --}}
                                <div class="col-md-6 ">
                                    <label class="form-label  col-3" for="end_date">@lang('lang.end_date')</label>
                                    <div class="input-group date" id="dt-end_date" data-target-input="nearest">
                                        <input name="end_date" class="datepicker-here form-control digits @error('end_date') is-invalid @enderror" type="text" data-language="en" data-target="#dt-end_date" data-bs-original-title="" title="">
                                        @error('end_date')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="input-group-text" data-target="#dt-end_date" data-toggle="datepicker"><i class="fa fa-calendar"> </i></div>
                                    </div>
                                </div>
                                {{--  is_active  --}}
                                <div class="media mb-2">
                                    <label class="col-form-label m-r-10">{{ __('lang.is_active') }}</label>
                                    <div class="media-body  icon-state">
                                        <label class="switch">
                                            <input type="checkbox" name="is_active" checked><span
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
