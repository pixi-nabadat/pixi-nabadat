@extends('layouts.simple.master')

@section('title', trans('lang.doctors'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.doctors') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.doctors') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" class="needs-validation" novalidate="" action="{{ route('doctors.store') }}">
                            @csrf
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label" for="user_name">{{ trans('lang.user_name') }}</label>
                                    <input name="user_name" class="form-control @error('user_name') is-invalid @enderror"
                                        id="user_name" type="text" required>
                                    @error('user_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="email">{{ trans('lang.email') }}</label>
                                    <input name="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" type="text" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="full_name">{{ trans('lang.full_name_en') }}</label>
                                    <input name="name[en]" class="form-control @error('name') is-invalid @enderror"
                                        id="clinic_name" type="text" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="full_name">{{ trans('lang.full_name_ar') }}</label>
                                    <input name="name[ar]" class="form-control @error('name') is-invalid @enderror"
                                        id="clinic_name" type="text" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="phone">{{ trans('lang.phone') }}</label>
                                    <input class="form-control  @error('phone') is-invalid @enderror" name="phone"
                                        id="phone" type="text" required="">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="date_of_birth">{{ trans('lang.data_of_birth') }}</label>
                                    <input
                                        class="form-control digits datepicker-here @error('date_of_birth') is-invalid @enderror"
                                        name="date_of_birth" id="date_of_birth" type="text" required="">
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="password">{{ trans('lang.password') }}</label>
                                    <input class="form-control @error('password') is-invalid @enderror" name="password"
                                        id="password" type="password" required="">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label"
                                        for="password_confirmation">{{ trans('lang.password_confirmation') }}</label>
                                    <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" id="password" type="password" required="">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label my-2"
                                        for="description">{{ trans('lang.description') }}</label>
                                    <input name="description"
                                        class="form-control  @error('description') is-invalid @enderror" id="description"
                                        type="text">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="mb-2">
                                            <div class="col-form-label">{{ __('lang.governorates') }}</div>
                                            <select id="select_governorate" name="governorate"
                                                class="js-example-basic-single col-sm-12">
                                                <option>{{trans('lang.please_select...')}}</option>
                                                @foreach ($governorates as $governorate)
                                                    <option value="{{ $governorate->id }}">{{ $governorate->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="mb-2">
                                            <label class="col-form-label"
                                                for="select_city">{{ __('lang.cities') }}</label>
                                            <select id="select_city" name="location_id" class="form-control col-sm-12 @error('location_id') is-invalid @enderror">
                                                <option value="0" disabled selected>{{trans('lang.please_select...')}}</option>
                                                @foreach ($cities as $city)
                                                    <option class="city_{{$city->parent_id}}" value="{{ $city->id }}">{{ $city->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('location_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
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

                            <button class="btn btn-primary" type="submit">{{ trans('lang.submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $("#select_city").find("option:gt(0)").hide();
        $("#select_governorate").change(function (){
            $("#select_city").find("option:gt(0)").hide();
            $(".city_"+$(this).val()).show();
        });
    });
</script>
@endsection
