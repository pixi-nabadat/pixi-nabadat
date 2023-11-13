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
                                    <p class="form-control" id="code"> {{ $coupon->code }} </p>
                                </div>
                                {{-- min_buy --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="min_buy">{{ trans('lang.min_buy') }}</label>
                                    <p class="form-control" id="min_buy">{{ $coupon->min_buy }}</p>
                                </div>
                                {{-- discount --}}
                                <div class="col-md-6  my-3">
                                    <label class="form-label" for="discount">@lang('lang.discount')</label>
                                    <p class="form-control" id="discount" >{{ $coupon->discount }}</p>
                                </div>
                                {{-- start_date --}}
                                <div class="col-md-6  my-3">
                                    <label class="form-label" for="start_date">@lang('lang.start_date')</label>
                                    <p class="form-control" id="start_date">{{ $coupon->start_date }}</p>
                                </div>
                                {{-- end_date --}}
                                <div class="col-md-6  my-3">
                                    <label class="form-label" for="end_date">@lang('lang.end_date')</label>
                                    <p class="form-control" id="end_date">{{ $coupon->end_date }}</p>
                                </div>

                            </div>
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