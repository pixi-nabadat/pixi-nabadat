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
        <div class="col-sm-12 col-xl-12 xl-100">
            <div class="card height-equal">
                <div class="card-body">
                    <ul class="nav nav-pills" id="pills-icontab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="pills-iconhome-tab" data-bs-toggle="pill" href="#pills-iconhome" role="tab" aria-controls="pills-iconhome" aria-selected="true"><i class="icofont icofont-ui-home"></i>{{ trans('lang.reservation_information') }}</a></li>
                        <li class="nav-item"><a class="nav-link" id="pills-iconprofile-tab" data-bs-toggle="pill" href="#pills-iconprofile" role="tab" aria-controls="pills-iconprofile" aria-selected="false"><i class="icofont icofont-man-in-glasses"></i>{{ trans('lang.reservation_devices') }}</a></li>
                        <li class="nav-item"><a class="nav-link" id="reservation_status-tab" data-bs-toggle="pill" href="#reservation_status" role="tab" aria-controls="reservation_status" aria-selected="false"><i class="icofont icofont-man-in-glasses"></i>{{ trans('lang.reservation_status') }}</a></li>
                    </ul>
                    <div class="tab-content" id="pills-icontabContent">
                        <div class="tab-pane fade show active" id="pills-iconhome" role="tabpanel" aria-labelledby="pills-iconhome-tab">
                            <div class="card  col-md-12">
                                <div class="card-body row">
                                    <form method="post" class="needs-validation" novalidate="" action="{{ route('reservations.update', $reservation) }}">
                                        @csrf
                                        @method('put')
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
                                        <div class="media mb-2">
                                            <div class="btn-toolbar float-right mb-3" role="toolbar" aria-label="Toolbar with button groups">
                                                <div class="btn-group mr-2" role="group" aria-label="Third group">
                                                    <button class="btn btn-primary my-3" type="submit">{{ trans('lang.submit') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                        <div class="tab-pane fade" id="pills-iconprofile" role="tabpanel" aria-labelledby="pills-iconprofile-tab">
                            <div class="card  col-md-12">
                                <div class="card-body row">
                                    <form method="post" class="needs-validation" novalidate="" action="{{ route('reservation-devices.store') }}">
                                        @csrf
                                    {{--center  --}}
                                    <div class="col-md-12 d-flex my-3">
                                        <div class="col-form-label col-3">{{ __('lang.device') }}</div>
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
                                    {{-- is_active --}}
                                    <div class="media my-2">
                                        <label class="col-form-label m-r-10">{{ __('lang.auto_service') }}</label>
                                        <div class="media-body  icon-state">
                                            <label class="switch">
                                                <input type="checkbox" name="is_active"
                                                    {{ $reservation->auto_service == 1 ? 'checked' : '' }}><span
                                                    class="switch-state"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="media mb-2">
                                        <div class="btn-toolbar float-right mb-3" role="toolbar" aria-label="Toolbar with button groups">
                                            <div class="btn-group mr-2" role="group" aria-label="Third group">
                                                <button class="btn btn-primary my-3" type="submit">{{ trans('lang.submit') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                            
                        </div>
                        <div class="tab-pane fade" id="reservation_status" role="tabpanel" aria-labelledby="reservation_status-tab">
                            <div class="card  col-md-12">
                                <div class="card-body row">
                                    <form method="post" class="needs-validation" novalidate="" action="{{ route('reservation-history.store') }}">
                                        @csrf
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
                                            <label class="col-form-label m-r-10">{{ __('lang.from') }}</label>
                                            <div class="media-body  icon-state">
                                                <input name="from" type="date" class="form-control" value="confirm">    
                                            </div>
                                        </div>
                                        <div class="media mb-2">
                                            <label class="col-form-label m-r-10">{{ __('lang.to') }}</label>
                                            <div class="media-body  icon-state">
                                                <input name="to" type="date" class="form-control">    
                                            </div>
                                        </div>
                                        <div class="media mb-2">
                                            <div class="btn-toolbar float-right mb-3" role="toolbar" aria-label="Toolbar with button groups">
                                                <div class="btn-group mr-2" role="group" aria-label="Third group">
                                                    <button class="btn btn-primary my-3" type="submit">{{ trans('lang.submit') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
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