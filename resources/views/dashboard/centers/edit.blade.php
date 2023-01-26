@extends('layouts.simple.master')
@section('title', trans('lang.centers'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.centers') }}</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('centers.index') }}">{{ trans('lang.centers') }}</a></li>
    <li class="breadcrumb-item">{{ trans('lang.edit') }}</li>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="container-fluid">

            <form class="needs-validation" novalidate="" method="post" enctype="multipart/form-data"
                action="{{ route('centers.update', $center) }}">
                @csrf
                @method('put')
                <div class="row ">

                    <div class="col-lg-12 col-md-12">
                        {{-- center information --}}
                        <div class="card  col-md-12">
                            <div class="card-header py-4">
                                <h6 class="card-titel">{{ __('lang.centers') }}</h6>
                            </div>
                            <div class="card-body row">
                                {{-- name_ar  --}}
                                <div class="col-md-6 my-3">
                                    <label class="form-label col-3 " for="name_ar">{{ trans('lang.name_ar') }}</label>
                                    <input name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror"
                                        id="name_ar" value="{{ $center->user->getTranslation('name', 'ar') }}" type="text" required>
                                    @error('name.ar')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- name_en  --}}
                                <div class="col-md-6 my-3">
                                    <label class="form-label col-3" for="name_en">{{ trans('lang.name_en') }}</label>
                                    <input name="name[en]" value="{{ $center->user->getTranslation('name', 'en') }}"
                                        class="form-control @error('name.en') is-invalid @enderror" id="name_en"
                                        type="text" required>
                                    @error('name.en')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- username  --}}
                                <div class="col-md-6 my-3">
                                    <label class="form-label col-3 " for="user_name">{{ trans('lang.user_name') }}</label>
                                    <input name="user_name" class="form-control @error('user_name') is-invalid @enderror"
                                        id="user_name" value="{{ $center->user->user_name }}" type="text" required>
                                    @error('user_name')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- email --}}
                                <div class="col-md-6 my-3">
                                    <label class="form-label col-3 " for="email">{{ trans('lang.email') }}</label>
                                    <input name="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" value="{{ $center->user->email }}" type="email" required>
                                    @error('email')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- password  --}}
                                <div class="col-md-6 my-3">
                                    <label class="form-label col-3 " for="password">{{ trans('lang.password') }}</label>
                                    <input name="password" class="form-control @error('password') is-invalid @enderror"
                                        id="name_ar" type="password" required>
                                    @error('password')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="col-form-label">{{ trans('lang.primary_phone') }}</div>
                                    <input name="primary_phone" class="form-control @error('primary_phone') is-invalid @enderror"
                                           id="name_ar" value="{{ $center->user->phone}}" type="text" required>
                                    @error('primary_phone')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{--address_ar --}}
                                <div class="col-md-12 d-flex my-3">
                                    <label class="form-label col-3" for="address_ar">{{ trans('lang.address_ar') }}</label>
                                    <textarea name="address[ar]" class="form-control @error('address.ar') is-invalid @enderror">{{ $center->getTranslation('address', 'ar') }}</textarea>
                                    @error('address.ar')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{--address_en --}}
                                <div class="col-md-12 d-flex my-3">
                                    <label class="form-label col-3" for="address_ar">{{ trans('lang.address_en') }}</label>
                                    <textarea name="address[en]" class="form-control @error('address.en') is-invalid @enderror">{{ $center->getTranslation('address', 'ar') }}</textarea>
                                    @error('address.en')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{--description ar --}}
                                <div class="col-md-12 d-flex my-3">
                                    <label class="form-label col-3"
                                        for="address_ar">{{ trans('lang.description_ar') }}</label>
                                    <textarea name="description[ar]" class="form-control @error('description.ar') is-invalid @enderror">{{ $center->getTranslation('description', 'ar') }}</textarea>
                                    @error('description.ar')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{--description_en --}}
                                <div class="col-md-12 d-flex my-3">
                                    <label class="form-label col-3"
                                        for="address_ar">{{ trans('lang.description_en') }}</label>
                                    <textarea name="description[en]" class="form-control @error('description.en') is-invalid @enderror">{{ $center->getTranslation('description', 'en') }}</textarea>
                                    @error('description.en')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                {{-- avg_wating_time --}}
                                <div class="col-md-6 my-3">
                                    <label class="form-label  col-3" for="avg_waiting_time">@lang('lang.avg_waiting_time')</label>
                                    <input type="number" name="avg_waiting_time" step="0.1"
                                        class="form-control @error('avg_waiting_time') is-invalid @enderror"
                                        value="{{ $center->avg_waiting_time }}">
                                    @error('avg_waiting_time')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- app_discount --}}
                                <div class="col-md-6 my-3">
                                    <label class="form-label  col-3" for="app_discount">@lang('lang.app_discount')</label>
                                    <input type="number" name="app_discount" step="0.1"
                                        class="form-control @error('app_discount') is-invalid @enderror"
                                        value="{{ $center->app_discount }}">
                                    @error('app_discount')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- phones  --}}
                                <div class="field_wrapper">
                                    <div class="col-md-6 my-3">
                                        <label class="col-form-label col-3">{{ trans('lang.phones') }}</label>
                                        @foreach ($center->phones as $phone)
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <a href="javascript:void(0);" class="add_button" title="Add field">
                                                    <i class="fa fa-plus-circle fa-2x"></i>
                                                </a>
                                            </div>
                                            <input type="text"
                                                class="form-control @error('phones') is-invalid @enderror" name="phones[]"
                                                value="{{ $phone }}" placeholder="primary phone" />
                                        </div>
                                        @endforeach
                                        
                                        @error('phones')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- support payments credit --}}
                                <div class="col-md-12" data-flex>
                                    <div class="media mb-2">
                                        <label
                                            class="col-form-label m-r-10" for="support_payments_credit">{{ trans('lang.support_payments_credit') }}</label>
                                        <div class="media-body  icon-state">
                                            <label class="switch">
                                                <input name="support_payments[credit]"
                                                @error('support_payments.credit') is-invalid @enderror
                                                id="support_payments_credit"
                                                type="checkbox" value="1"
                                                {{ Arr::has($center->support_payments, App\Enum\PaymentMethodEnum::CREDIT) ? "checked":"" }}><span class="switch-state"></span>
                                            </label>
                                        </div>
                                        @error('support_payments.credit')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 d-flex">
                                    
                                    <div class="media mb-2">
                                        <label
                                            class="col-form-label m-r-10" for="support_payments_cash">{{ trans('lang.support_payments_cash') }}</label>
                                        <div class="media-body  icon-state">
                                            <label class="switch">
                                                <input name="support_payments[cash]"
                                                @error('support_payments.cash') is-invalid @enderror
                                                id="support_payments_cash"
                                                type="checkbox" value="1"
                                                {{ Arr::has($center->support_payments, App\Enum\PaymentMethodEnum::CASH) ? "checked":"" }}><span class="switch-state"></span>
                                            </label>
                                        </div>
                                        @error('support_payments.cash')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                                                        
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12 col-sm-12">
                        {{-- locations --}}
                        <div class="card col-lg-12 col-md-12">
                            <div class="card-header py-4">
                                <h6 class="mb-0 h6">@lang('lang.Locations')</h6>
                            </div>
                            <div class="card-body row">
                                <div class="col-md-6 mb-3">
                                    <div class="col-form-label">{{ trans('lang.choose_governorates') }}</div>
                                    <select id="change_location" data-filling-name="location_id"
                                        class="form-select form-control mb-3 @error('parent_id') is-invalid @enderror">
                                        <option selected>{{ trans('lang.choose_governorates') }}</option>
                                        @foreach ($governorates as $governorate)
                                            <option value="{{ $governorate->id }}">{{ $governorate->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="col-form-label">{{ trans('lang.city') }}</div>
                                    <select name="location_id"
                                        class="form-select form-control mb-3 @error('location_id') is-invalid @enderror"
                                        id="city"></select>
                                    @error('location_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                        <label class="form-label col-3 " for="lat">{{ trans('lang.lat') }}</label>
                                        <input name="lat" class="form-control @error('lat') is-invalid @enderror"
                                            id="validationCustom01" type="text" value="{{ $center->lat }}"
                                            required="">
                                        @error('lat')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- name_en  --}}
                                    <div class="col-md-12 d-flex my-3">
                                        <label class="form-label col-3" for="lng">{{ trans('lang.lng') }}</label>
                                        <input name="lng" class="form-control @error('lng') is-invalid @enderror"
                                            id="validationCustom01" type="text" value="{{ $center->lng }}"
                                            required="">
                                        @error('lng')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- name_en  --}}
                                    <div class="col-md-12 d-flex my-3">
                                        <label class="form-label col-3"
                                            for="google_map_url">{{ trans('lang.google_map_url') }}</label>
                                        <input name="google_map_url"
                                            class="form-control @error('google_map_url') is-invalid @enderror"
                                            id="validationCustom01" type="text"
                                            value="{{ $center->google_map_url }}" required>
                                        @error('google_map_url')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
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
                                        <div class="col-md-12">
                                            <label class="form-label" for="logo">{{ trans('lang.logo') }}</label>
                                            <input name="logo"
                                                class="form-control image @error('logo') is-invalid @enderror"
                                                id="logo" type="file">
                                            @error('logo')
                                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <img src="{{ asset('/uploads/device/default.png') }}" style="width: 500px"
                                                class="img-thumbnail image-preview " alt="">
                                        </div>
                                    </div>
                                    {{-- center logo --}}
                                    <div class="col-md-12  d-flex">
                                        <div class="col-md-12">
                                            <label class="form-label" for="image">{{ trans('lang.image') }}</label>
                                            <input name="images[]"
                                                class="form-control image @error('image') is-invalid @enderror"
                                                id="image" type="file" multiple>
                                            @error('image')
                                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
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
                                                                {{ $center->user->is_active ? "checked":"" }}><span class="switch-state"></span>
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
                                                                value="1" {{ $center->is_support_auto_service ? "checked":"" }}><span
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
                                                            <input type="checkbox" name="featured" {{ $center->featured ? "checked":"" }}><span
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

                    </div>


                    <div class="btn-toolbar float-right mb-3" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="Third group">
                            <button class="btn btn-primary my-3" type="submit">{{ trans('lang.submit') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')

    <script src="{{ asset('assets/js/location.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var maxField = 4; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapperr
            var fieldHTML =
                '<div class="col-md-6 my-3 child">' +
                '<label class="col-form-label col-3"></label>' +
                '<div class="input-group">' +
                '<div class="input-group-prepend">' +
                '<a href="javascript:void(0);" class="remove_button" title="remove">' +
                '<i class="fa fa-minus-circle fa-2x"></i>' +
                '</a>' +
                '</div>' +
                '<input type="text" class="form-control  @error('phone') is-invalid @enderror" name="phone[]"/></div></div>'; //New input field html
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function() {
                //Check maximum number of input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).closest(".child").remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>

@endsection
