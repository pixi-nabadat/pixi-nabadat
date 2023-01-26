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

        <form class="needs-validation" novalidate="" enctype="multipart/form-data" action="{{ route('reservations.update',$reservation) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row ">

                <div class="col-md-8">

                    {{-- reservation_information --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6 class="card-titel">{{ __('lang.reservation_information') }}</h6>
                        </div>
                        <div class="card-body row">

                                {{--center  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <div class="col-form-label col-3">{{ __('lang.center') }}</div>
                                    <select id="center_id" name="center_id" class="js-example-basic-single col-sm-12 @error('center_id') is-invalid @enderror">
                                        @foreach ($centers as $center)
                                            <option value="{{ $center->id }}"
                                                {{ $reservation->center_id == $center->id ? 'selected' : '' }}>
                                                {{ $center->user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('center_id')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{--user  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <div class="col-form-label col-3">{{ __('lang.user') }}</div>
                                    <select id="customer_id" name="customer_id" class="js-example-basic-single col-sm-12 @error('center_id') is-invalid @enderror">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ $reservation->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('center_id')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{--payment_type  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <div class="col-form-label col-3">{{ __('lang.payment_type') }}</div>
                                    <select id="payment_type" name="payment_type" class="js-example-basic-single col-sm-12">
                                        <option value="{{ App\Enum\PaymentMethodEnum::CASH }}" {{ App\Enum\PaymentMethodEnum::CASH == $reservation->payment_type ? "selected":''}}>{{ App\Enum\PaymentMethodEnum::CASH }}</option>
                                        <option value="{{ App\Enum\PaymentMethodEnum::CREDIT }}" {{ App\Enum\PaymentMethodEnum::CREDIT == $reservation->payment_type ? "selected":''}}>{{ App\Enum\PaymentMethodEnum::CREDIT }}</option>
                                    </select>
                                </div>

                        </div>
                    </div>

                    {{-- reservation_devices --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.reservation_devices') }}</h6>
                        </div>
                        <div class="card-body">
                            {{--center  --}}
                            <div class="col-md-12 d-flex my-3">
                                <div class="col-form-label col-3">{{ __('lang.center') }}</div>
                                <select id="center_id" name="center_id" class="js-example-basic-single col-sm-12 @error('center_id') is-invalid @enderror">
                                    <option selected disabled>...</option>
                                    @foreach ($centerDevices as $device)
                                        <option value="{{ $device->id }}">{{ $device->name }}</option>
                                    @endforeach
                                </select>
                                @error('center_id')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>                            
                            {{--  num_nabdat  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3">@lang('lang.num_nabdat')</label>
                                <input type="number" name="num_nabadat" class="form-control">
                                @error('center_id')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
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
                    {{-- featured --}}
                    <div class="card col-12">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.status') }}</h6>
                        </div>
                        <div class="card-body row">
                            <div class="media mb-2">
                                <label class="col-form-label m-r-10">{{ __('lang.current_status') }}</label>
                                <div class="media-body  icon-state">
                                    <input type="text" class="form-control" value="{{ $reservation->history->last()->status }}" @disabled(true)>    
                                </div>
                            </div>
                            <div class="media mb-2">
                                <label class="col-form-label m-r-10">{{ __('lang.next_status') }}</label>
                                <div class="media-body  icon-state">
                                    <input type="text" class="form-control" value="confirm" @disabled(true)>    
                                </div>
                            </div>
                            <div class="media mb-2">
                                <div class="btn-toolbar float-right mb-3" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group mr-2" role="group" aria-label="Third group">
                                        <button class="btn btn-primary my-3" type="submit">{{ trans('lang.submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>

        </form>

    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')

@endsection