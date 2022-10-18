@extends('layouts.simple.master')

@section('title', trans('lang.doctors'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.doctors') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.doctors') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.show') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" action="{{ route('doctors.update', $user) }}"
                            method="post">
                            @csrf
                            @method('put')
                            <div class="row g-3">
                                
                                <div class="col-md-6">
                                    <label class="form-label" for="user_name">{{ trans('lang.user_name') }}</label>
                                    <input name="user_name" disabled="true" value='{{ $user->user_name }}'
                                        class="form-control  @error('user_name') is-invalid @enderror" id="user_name"
                                        type="text" required>
                                    @error('user_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="email">{{ trans('lang.email') }}</label>
                                    <input name="email" disabled="true" value='{{ $user->email }}'
                                        class="form-control  @error('email') is-invalid @enderror" id="email"
                                        type="text" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="full_name">{{ trans('lang.full_name_en') }}</label>
                                    <input disabled="true" value={{ $user->getTranslation('name', 'en') }}
                                        class="form-control @error('name') is-invalid @enderror" id="clinic_name"
                                        type="text" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="full_name">{{ trans('lang.full_name_ar') }}</label>
                                    <input disabled="true" value={{ $user->getTranslation('name', 'ar') }}
                                        class="form-control @error('name') is-invalid @enderror" id="clinic_name"
                                        type="text" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="phone">{{ trans('lang.phone') }}</label>
                                    <input class="form-control" disabled="true" @error('phone') is-invalid @enderror"
                                        value='{{ $user->phone }}' name="phone" id="phone" type="text"
                                        required="">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="date_of_birth">{{ trans('lang.data_of_birth') }}</label>
                                    <input disabled="true"
                                        class="form-control digits datepicker-here @error('date_of_birth') is-invalid @enderror"
                                        value='{{ $user->date_of_birth }}' name="date_of_birth" id="date_of_birth"
                                        type="text" required="">
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label my-2" for="description">{{ trans('lang.description') }}</label>
                                    <input name="description" disabled="true"
                                        class="form-control  @error('description') is-invalid @enderror" id="description"
                                        value='{{ $user->description }}' type="text">
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
                                            <select disabled="true" id="select_governorate"
                                                class="js-example-basic-single col-sm-12">
                                                <option value=1>Ala bama</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="mb-2">
                                            <label class="col-form-label" for="select_city">{{ __('lang.cities') }}</label>
                                            <select disabled="true" id="select_city" name="location_id"
                                                class="js-example-basic-single col-sm-12 @error('location_id') is-invalid @enderror">
                                                <option value=1>Ala bama</option>
                                            </select>
                                        </div>
                                        @error('location_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="media mb-2">
                                <label class="col-form-label m-r-10">{{__('lang.is_active')}}</label>
                                <div class="media-body  icon-state">
                                    <label class="switch">
                                        <input type="checkbox" disabled="true" name="is_active"
                                            {{ $user->is_active == 1 ? 'checked' : '' }}><span
                                            class="switch-state"></span>
                                    </label>
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
