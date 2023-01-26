@extends('layouts.simple.master')

@section('title', trans('lang.reservations'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.reservations') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.reservations') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('style')
<link rel="stylesheet" href="{{asset('assets/css/image-container.css')}}"/>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row ">

            <div class="col-md-8">

                {{-- reservation_information --}}
                <div class="card  col-md-12">
                    <div class="card-header py-4">
                        <h6 class="card-titel">{{ __('lang.reservation_information') }}</h6>
                    </div>
                    <div class="card-body row">

                            {{--  center  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3">@lang('lang.center')</label>
                                <input type="text" class="form-control" value="{{ $reservation->center->user->name }}" @disabled(true)>
                            </div>

                            {{--  user  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3">@lang('lang.user')</label>
                                <input type="text" class="form-control" value="{{ $reservation->user->name }}" @disabled(true)>
                            </div>


                            {{--  payment_type  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3">@lang('lang.payment_type')</label>
                                <input type="text" class="form-control" value="{{ $reservation->payment_type }}" @disabled(true)>
                            </div>
                            {{--  payment_status  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3">@lang('lang.payment_status')</label>
                                <input type="text" class="form-control" value="{{ $reservation->payment_status }}" @disabled(true)>
                            </div>
                            {{--  status  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3">@lang('lang.status')</label>
                                <input type="text" class="form-control" value="{{ $reservation->history->last()->status }}" @disabled(true)>
                            </div>

                    </div>
                </div>

                {{-- reservation_devices --}}
                <div class="card  col-md-12">
                    <div class="card-header py-4">
                        <h6>{{ __('lang.reservation_devices') }}</h6>
                    </div>
                    <div class="card-body">
                        @foreach($reservation->nabadatHistory as $item)
                        {{--  device_name  --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3">@lang('lang.device_name')</label>
                            <input type="text" class="form-control" value="{{ $item->device->name }}" @disabled(true)>
                        </div>
                        {{--  num_nabdat  --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3">@lang('lang.num_nabdat')</label>
                            <input type="text" class="form-control" value="{{ $item->num_nabadat }}" @disabled(true)>
                        </div>
                        {{--  nabada_price  --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3">@lang('lang.nabada_price')</label>
                            <input type="text" class="form-control" value="{{ $item->nabada_price }}" @disabled(true)>
                        </div>
                        {{--  total_price  --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3">@lang('lang.total_price')</label>
                            <input type="text" class="form-control" value="{{ $item->total_price }}" @disabled(true)>
                        </div>
                        <hr>
                        @endforeach
                    </div>
                </div>

            </div>

            <div class='col-md-4'>

                {{-- qr_code --}}
                <div class="card col-12">
                    <div class="card-header py-4">
                        <h6>{{ __('lang.qr_code') }}</h6>
                    </div>
                    <div class="card-body">
                        {{--  qr_code  --}}
                        <div class="col-md-12 d-flex my-3">
                            <img class="img-responsive" src="{{ asset('uploads/reservations/qr_code.png') }}">
                        </div>
                    </div>
                </div>
                {{-- reservation_time --}}
                <div class="card col-12">
                    <div class="card-header py-4">
                        <h6>{{ __('lang.reservation_time') }}</h6>
                    </div>
                    <div class="card-body row">
                        {{--  check_date  --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3">@lang('lang.check_date')</label>
                            <input type="date" class="form-control" value="{{ $reservation->check_date }}" @disabled(true)>
                        </div>
                        {{--  from  --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3">@lang('lang.from')</label>
                            <input type="time" class="form-control" value="{{ $reservation->from }}" @disabled(true)>
                        </div>
                        {{--  to  --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3">@lang('lang.to')</label>
                            <input type="time" class="form-control" value="{{ $reservation->to }}" @disabled(true)>
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