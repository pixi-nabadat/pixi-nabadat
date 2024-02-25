@extends('layouts.simple.master')

@section('title', trans('lang.clients'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.clients') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.clients') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate="" action="{{ route('clients.store') }}">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <label class="form-label" for="name">{{ trans('lang.name') }}</label>
                                    <input name="name" class="form-control @error('name') is-invalid @enderror"
                                        id="name" type="text" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="email">{{ trans('lang.email') }}</label>
                                    <input name="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" type="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="phone">{{ trans('lang.phone') }}</label>
                                    <input name="phone" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" type="phone" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="date_of_birth">{{ trans('lang.date_of_birth') }}</label>
                                    <input name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror"
                                        id="date_of_birth" type="date" value="{{ old('date') }}" required>
                                    @error('date_of_birth')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- password --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="password">{{ trans('lang.password') }}</label>
                                    <input name="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" type="password" required>
                                    @error('password')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{--password--}}
                                <div class="col-md-12">
                                    <div class="col-form-label">{{ trans('lang.password_confirmation') }}</div>
                                    <input name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                                           id="name_ar" type="password_confirmation" required>
                                    @error('password_confirmation')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                {{-- device_logo --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="logo">{{ trans('lang.logo') }}</label>
                                    <input name="logo" class="form-control image @error('logo') is-invalid @enderror"
                                        id="logo" type="file">
                                    @error('logo')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <img src="{{ asset('/uploads/users/default.png') }}" class="image-preview " alt="">
                                </div>
                                {{-- location --}}
                                <div class="col-md-12">
                                    <div class="col-md-12 mb-3">
                                        <div class="col-form-label">{{ trans('lang.choose_governorates') }}</div>
                                        <select id="change_location" data-filling-name="location_id"
                                            class="form-select form-control mb-3 @error('parent_id') is-invalid @enderror">
                                            <option selected>{{ trans('lang.choose_governorates') }}</option>
                                            @foreach ($governorates as $governorate)
                                                <option value="{{ $governorate->id }}">{{ $governorate->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
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
                                                    
                            {{-- is_active --}}
                            <div class="media mb-2">
                                <label class="col-form-label m-r-10">{{ __('lang.is_active') }}</label>
                                <div class="media-body  icon-state">
                                    <label class="switch">
                                        <input type="checkbox" name="is_active" checked=""><span
                                            class="switch-state"></span>
                                    </label>
                                </div>
                            </div>

                            {{-- allow_notification --}}
                            <div class="media mb-2">
                                <label class="col-form-label m-r-10">{{ __('lang.allow_notification') }}</label>
                                <div class="media-body  icon-state">
                                    <label class="switch">
                                        <input type="checkbox" name="allow_notification" checked><span
                                            class="switch-state"></span>
                                    </label>
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
    <script src="{{ asset('assets/js/location.js') }}"></script>
@endsection

