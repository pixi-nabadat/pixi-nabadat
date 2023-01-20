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
                        <form method="post" class="needs-validation"  enctype="multipart/form-data" novalidate="" action="{{ route('doctors.store') }}">
                            @csrf
                            <div class="row g-3">
                                {{--centers  --}}
                                <div class="col-md-6">
                                    <div class="col-form-label col-3">{{ __('lang.centers') }}</div>
                                    <select id="center_id" name="center_id" class="js-example-basic-single col-sm-12">
                                        <option disabled>{{trans('lang.please_select_center')}}</option>
                                        @foreach ($centers as $center)
                                            <option value="{{ $center->id }}">{{ $center->user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="name">{{ trans('lang.name') }}</label>
                                    <input name="name[en]" class="form-control @error('name.en') is-invalid @enderror"
                                        id="name" type="text" required>
                                    @error('name.en')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="name">{{ trans('lang.name') }}</label>
                                    <input name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror"
                                           id="name" type="text" required>
                                    @error('name.ar')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="phone">{{ trans('lang.phone') }}</label>
                                    <input class="form-control  @error('phone') is-invalid @enderror" name="phone"
                                        id="phone" type="text" required="">
                                    @error('phone')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="age">{{ trans('lang.age') }}</label>
                                    <input class="form-control  @error('age') is-invalid @enderror" name="age"
                                        id="age" type="text">
                                    @error('age')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label my-2"
                                        for="description_en">{{ trans('lang.description_en') }}</label>
                                    <input name="description[en]"
                                        class="form-control  @error('description.en') is-invalid @enderror" id="description_en"
                                        type="text">
                                    @error('description.en')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label my-2"
                                           for="description">{{ trans('lang.description_ar') }}</label>
                                    <input name="description[ar]"
                                           class="form-control  @error('description.ar') is-invalid @enderror" id="description_ar"
                                           type="text">
                                    @error('description.ar')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label my-2"
                                        for="logo">{{ trans('lang.logo') }}</label>
                                    <input name="logo"
                                        class="form-control  @error('logo') is-invalid @enderror" id="logo"
                                        type="file">
                                    @error('logo')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
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
@endsection
