@extends('layouts.simple.master')
@section('title', 'Product Page')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/owlcarousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/rating.css') }}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>{{ trans('lang.center_page') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Country</li>
    <li class="breadcrumb-item active">Coiuntry Details</li>
@endsection

@section('content')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row ">

            <div class="col-lg-12 col-md-12">
                {{-- center information --}}
                <div class="card  col-md-12">
                    <div class="card-header py-4">
                        <h6 class="card-titel">{{ __('lang.centers') }}</h6>
                    </div>
                    <div class="card-body row">
                        {{-- name  --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3" for="name">{{ trans('lang.name') }}</label>
                            <p class="form-control" id="name">{{ $center->user->name }}</p>
                        </div>

                        {{-- email --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3" for="email">{{ trans('lang.email') }}</label>
                            <p class="form-control" id="email">{{ $center->user->email }}</p>
                        </div>

                        {{--address_ar --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3" for="address_ar">{{ trans('lang.address_ar') }}</label>
                            <p class="form-control" id="address_ar">{{ $center->getTranslation('address', 'ar') }}</p>
                        </div>

                        {{--address_en --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3" for="address_en">{{ trans('lang.address_en') }}</label>
                            <p class="form-control" id="address_en">{{ $center->getTranslation('address', 'en') }}</p>
                        </div>

                        {{--description ar --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3" for="description_ar">{{ trans('lang.description_ar') }}</label>
                            <p class="form-control" id="description_ar">{{ $center->getTranslation('description', 'ar') }}</p>
                        </div>

                        {{--description_en --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3" for="description_en">{{ trans('lang.description_en') }}</label>
                            <p class="form-control" id="description_en">{{ $center->getTranslation('description', 'en') }}</p>
                        </div>
                        
                        {{-- avg_waiting_time --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3" for="avg_waiting_time">{{ trans('lang.avg_waiting_time') }}</label>
                            <p class="form-control" id="avg_waiting_time">{{ $center->getTranslation('description', 'en') }}</p>
                        </div>

                        {{-- pulse_price --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3" for="pulse_price">{{ trans('lang.pulse_price') }}</label>
                            <p class="form-control" id="pulse_price">{{ $center->pulse_price }}</p>
                        </div>

                        {{-- pulse_discount --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3" for="pulse_discount">{{ trans('lang.pulse_discount') }}</label>
                            <p class="form-control" id="pulse_discount">{{ $center->pulse_discount }}</p>
                        </div>

                        {{-- app_discount --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3" for="app_discount">{{ trans('lang.app_discount') }}</label>
                            <p class="form-control" id="app_discount">{{ $center->app_discount }}</p>
                        </div>

                        {{-- phones  --}}
                        <div class="field_wrapper">
                            <div class="col-md-12 d-flex my-3">
                                <label class="col-form-label col-3">{{ trans('lang.phones') }}</label>
                                <div class="input-group">
                                    <select class="form-select form-control mb-3">
                                    @foreach ($center->phones as $phone)
                                        <option>{{ $phone }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- devices_count --}}
                        <div class="col-md-12 d-flex my-3">
                            <label class="form-label col-3" for="devices_count">{{ trans('lang.devices_count') }}</label>
                            <p class="form-control" id="devices_count">{{ $center->devices_count }}</p>
                        </div>
                        {{-- support payments --}}
                        <div class="col-md-12 d-flex my-3">
                            <div class="mb-3">
                                <div class="media mb-2">
                                    <label
                                        class="col-form-label m-r-10">{{ trans('lang.support_payments_credit') }}</label>
                                    <div class="media-body  icon-state">
                                        <label class="switch">
                                            <input type="checkbox" value="1"
                                                {{ Arr::has($center->support_payments, App\Enum\PaymentMethodEnum::CREDIT) ? "checked":"" }} disabled><span class="switch-state"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="media mb-2">
                                    <label
                                        class="col-form-label m-r-10">{{ trans('lang.support_payments_cash') }}</label>
                                    <div class="media-body  icon-state">
                                        <label class="switch">
                                            <input type="checkbox" value="1"
                                            {{ Arr::has($center->support_payments, App\Enum\PaymentMethodEnum::CASH) ? "checked":"" }} disabled><span class="switch-state"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-12 col-sm-12">
                {{-- locations --}}
                <div class="card col-lg-12 col-md-12">
                    <div class="card-header py-4">
                        <h6 class="mb-0 h6">@lang('lang.locations')</h6>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label col-3" for="governorate">{{ trans('lang.governorate') }}</label>
                            <p class="form-control" id="governorate">{{ $center->user->location->slug }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label col-3" for="city">{{ trans('lang.city') }}</label>
                            <p class="form-control" id="city">{{ $center->user->location->title }}</p>
                        </div>
                    </div>
                </div>

                {{-- center lat and lng and google map url --}}
                <div class="col-lg-12 col-md-12">

                    {{-- center information --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6 class="card-titel">{{ __('lang.cordinates') }}</h6>
                        </div>
                        <div class="card-body row">
                            {{-- name_ar  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3" for="lat">{{ trans('lang.lat') }}</label>
                                <p class="form-control" id="lat">{{ $center->lat }}</p>
                                </div>
                            {{-- name_en  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3" for="lng">{{ trans('lang.lng') }}</label>
                                <p class="form-control" id="lng">{{ $center->lng }}</p>
                            </div>

                            {{-- name_en  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3" for="google_map_url">{{ trans('lang.google_map_url') }}</label>
                                <p class="form-control" id="google_map_url">{{ $center->google_map_url }}</p>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- center_images --}}
                <div class="row">
                    <div class="card  col-md-8">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.center_image') }}</h6>
                        </div>
                        <div class="card-body">
                            {{-- center logo --}}
                            <div class="col-md-12  d-flex">
                                <label class="form-label col-3" for="logo">{{ trans('lang.logo') }}</label>
                                <div class="col-md-12">
                                    @if (isset($center->user->attachments))
                                        <div class="col-md-3 col-lg-3 col-sm-12">
                                            <div class="img-container">
                                                <div class="form-group my-3">
                                                    <img src="{{ asset($center->user->attachments->path . '/' . $center->user->attachments->filename) }}"
                                                        style="width: 150px;height: 150px" class="img-thumbnail image"
                                                        alt="">
                                                </div>
                                            </div>
                                        </div>
                                    @endif                                
                                </div>
                                <div class="form-group">
                                    <img src="{{ asset('/uploads/device/default.png') }}" style="width: 500px"
                                        class="img-thumbnail image-preview " alt="">
                                </div>
                            </div>
                            {{-- center logo --}}
                            <div class="col-md-12  d-flex">
                                <label class="form-label col-3" for="images">{{ trans('lang.images') }}</label>
                                <div class="row">
                                    @if ($center->attachments->count())
                                        @foreach ($center->attachments as $attachment)
                                            @if ($attachment->type == App\Enum\ImageTypeEnum::GALARY)
                                                <div class="col-md-4 col-lg-4 col-sm-12">
                                                    <div class="img-container">
                                                        <div class="form-group my-3">
                                                            <img src="{{ asset($attachment->path . '/' . $attachment->filename) }}"
                                                                style="width: 600px;" class="img-thumbnail image"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                        @endforeach
                                    @endif                                </div>
                                <div class="form-group">
                                    <img src="{{ asset('/uploads/device/default.png') }}" style="width: 500px"
                                        class="img-thumbnail image-preview " alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-4'>

                        {{-- activation and autoservice --}}
                        <div class="card col-12">
                            <div class="card-header py-4">
                                <h6>{{ __('lang.activation_and_autoservice') }}</h6>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12 row">
                                    <div class="mb-3">
                                        <div class="media mb-2">
                                            <label
                                                class="col-form-label m-r-10">{{ trans('lang.is_active') }}</label>
                                            <div class="media-body  icon-state">
                                                <label class="switch">
                                                    <input type="checkbox" name="is_active" value="1"
                                                        {{ $center->user->is_active ? "checked":"" }} disabled><span class="switch-state"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="media mb-2">
                                            <label
                                                class="col-form-label m-r-10">{{ trans('lang.is_support_auto_service') }}</label>
                                            <div class="media-body  icon-state">
                                                <label class="switch">
                                                    <input type="checkbox" name="is_support_auto_service"
                                                        value="1" {{ $center->is_support_auto_service ? "checked":"" }} disabled><span
                                                        class="switch-state"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="media mb-2">
                                            <label class="col-form-label m-r-10">{{ __('lang.featured') }}</label>
                                            <div class="media-body  icon-state">
                                                <label class="switch">
                                                    <input type="checkbox" name="featured" {{ $center->featured ? "checked":"" }} disabled><span
                                                        class="switch-state"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- center Devices --}}
                <div class="col-lg-12 col-md-12">

                    {{-- center information --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6 class="card-titel">{{ __('lang.devices') }}</h6>
                        </div>
                        <div class="card-body row">
                            @foreach ($center->devices as $device)
                                {{-- name  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <label class="form-label col-3" for="name">{{ trans('lang.name') }}</label>
                                    <p class="form-control" id="name">{{ $device->name }}</p>
                                </div>
                                {{-- number_of_devices  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <label class="form-label col-3" for="number_of_devices">{{ trans('lang.number_of_devices') }}</label>
                                    <p class="form-control" id="number_of_devices">{{ $device->pivot->number_of_devices }}</p>
                                </div>
                                <div class="mb-3">
                                    <div class="media mb-2">
                                        <label
                                            class="col-form-label m-r-10">{{ trans('lang.is_active') }}</label>
                                        <div class="media-body  icon-state">
                                            <label class="switch">
                                                <input type="checkbox" name="is_active" value="1"
                                                    {{ $device->pivot->is_active ? "checked":"" }} disabled><span class="switch-state"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="media mb-2">
                                        <label
                                            class="col-form-label m-r-10">{{ trans('lang.auto_service') }}</label>
                                        <div class="media-body  icon-state">
                                            <label class="switch">
                                                <input type="checkbox" name="auto_service" value="1"
                                                    {{ $device->pivot->auto_service ? "checked":"" }} disabled><span class="switch-state"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/rating/jquery.barrating.js') }}"></script>
    <script src="{{ asset('assets/js/rating/rating-script.js') }}"></script>
    <script src="{{ asset('assets/js/owlcarousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/js/ecommerce.js') }}"></script>
@endsection
