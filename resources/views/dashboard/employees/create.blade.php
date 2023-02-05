@extends('layouts.simple.master')

@section('title', trans('lang.employeees'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.employees') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.employees') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate="" action="{{ route('employees.store') }}">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <label class="form-label" for="name_ar">{{ trans('lang.name_ar') }}</label>
                                    <input name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror"
                                        id="name_ar" type="text" required>
                                    @error('name.ar')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <label class="form-label" for="name_en">{{ trans('lang.name_en') }}</label>
                                    <input name="name[en]" class="form-control @error('name.en') is-invalid @enderror"
                                        id="name_en" type="text" required>
                                    @error('name.en')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="email">{{ trans('lang.email') }}</label>
                                    <input name="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" type="email" required>
                                    @error('email')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="phone">{{ trans('lang.phone') }}</label>
                                    <input name="phone" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" type="phone" required>
                                    @error('phone')
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
                                    <img src="{{ asset('/uploads/users/default.png') }}" class="img-thumbnail image-preview " alt="">
                                </div>
                                {{-- user_name --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="user_name">{{ trans('lang.user_name') }}</label>
                                    <input name="user_name" class="form-control @error('user_name') is-invalid @enderror"
                                        id="user_name" type="user_name" required>
                                    @error('user_name')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- date_of_birth --}}
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
                            <div class="row">
                                {{-- permissions --}}
                                @foreach($permissions as $key =>$permission)

                                    <div class="col-sm-4 col-xl-4 border-5">
                                        <div class="card card-absolute">
                                            <div class="card-header bg-primary">
                                                <h5 class="text-white">{{trans('lang.'.$key)}}</h5>
                                            </div>

                                                <div class="card-body">
                                                    @foreach($permission as $item)
                                                        <div class="mb-3 m-t-15">
                                                            <div class="form-check checkbox checkbox-primary mb-0">
                                                                <input class="form-check-input" name="permissions[]" value="{{$item->name}}" id="checkbox-primary-{{$item->id}}" type="checkbox" data-bs-original-title="" title="{{$item->name}}">
                                                                <label class="form-check-label" for="checkbox-primary-{{$item->id}}">{{$item->name}}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                        </div>
                                    </div>

                                @endforeach
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
