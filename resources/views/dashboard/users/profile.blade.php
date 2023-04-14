@extends('layouts.simple.master')

@section('title', trans('lang.profile'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.profile') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.profile') }}</li>
@endsection
<style>
    .profile-image{
        position: relative;
    }
    .profile-image:hover{
        border: 1px solid #DDD;
    }

    .profile-image img{
        width: 100%;
        max-height: 250px;
        z-index: 1;
        border-radius: 50%;
    }
    .profile-image input[type="file"]{
        position: absolute;
        top:0;
        left: 0;
        z-index: 2;
        width: 100%;
        height: 100%;
        opacity: 0;
    }

</style>
@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">

        
            <div class="row ">

                <div class="col-md-8">
                    <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate="" action="{{ route('update_profile', Auth::user()->id) }}">
                        @csrf
                        @method('patch')

                    {{-- personal_information --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6 class="card-titel">{{ __('lang.personal_information') }}</h6>
                        </div>
                        <div class="card-body row">
    
                                <div class="row g-3">
                                    <div class="col-md-6 col-lg-6 col-sm-6">
                                        <label class="form-label" for="name_ar">{{ trans('lang.name_ar') }}</label>
                                        <input name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror"
                                            id="name_ar" type="text" value="{{ Auth::user()->getTranslation('name','ar') }}" required>
                                        @error('name.ar')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
    
                                    <div class="col-md-6 col-lg-6 col-sm-6">
                                        <label class="form-label" for="name_en">{{ trans('lang.name_en') }}</label>
                                        <input name="name[en]" class="form-control @error('name.en') is-invalid @enderror"
                                            id="name_en" type="text" value="{{ Auth::user()->getTranslation('name','en') }}" required>
                                        @error('name.en')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
    
                                    <div class="col-md-12">
                                        <label class="form-label" for="email">{{ trans('lang.email') }}</label>
                                        <input name="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" type="email" value="{{ Auth::user()->email }}" required>
                                        @error('email')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
    
                                    <div class="col-md-12">
                                        <label class="form-label" for="phone">{{ trans('lang.phone') }}</label>
                                        <input name="phone" class="form-control @error('phone') is-invalid @enderror"
                                            id="phone" type="phone" value="{{ Auth::user()->phone }}" required>
                                        @error('phone')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
    
                                    <div class="col-md-12">
                                        <label class="form-label" for="date_of_birth">{{ trans('lang.date_of_birth') }}</label>
                                        <input name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror"
                                            id="date_of_birth" type="date" value="{{ Auth::user()->date_of_birth }}" required>
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

                                     {{-- confirmed password --}}
                                    <div class="col-md-12">
                                        <label class="form-label" for="password_confirmation">{{ trans('lang.password_confirmation') }}</label>
                                        <input name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                                            id="password_confirmation" type="password" required>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- location --}}
                                    <div class="col-md-12">
                                        <div class="col-md-12 mb-3">
                                            <div class="col-form-label">{{ trans('lang.choose_governorates') }}</div>
                                            <select id="change_location" data-filling-name="location_id"
                                                class="form-select form-control mb-3 @error('parent_id') is-invalid @enderror">
                                                <option selected>{{ trans('lang.choose_governorates') }}</option>
                                                @foreach ($governorates as $governorate)
                                                    <option value="{{ $governorate->id }}" @if($governorate->id == $governorate_city->id)selected @endif>{{ $governorate->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="col-form-label">{{ trans('lang.city') }}</div>
                                            <select name="location_id" class="form-select form-control mb-3 @error('location_id') is-invalid @enderror" id="city">
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}" @if($city->id == Auth::user()->location_id)selected @endif>{{ $city->title }}</option>
                                                @endforeach
                                            </select>
                                            @error('location_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- allow_notification --}}
                                    <div class="media mb-2">
                                        <label class="col-form-label m-r-10">{{ __('lang.allow_notification') }}</label>
                                        <div class="media-body  icon-state">
                                            <label class="switch">
                                                <input type="checkbox" name="allow_notification" {{ Auth::user()->allow_notification ? "checked":"" }}><span
                                                    class="switch-state"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="btn-toolbar float-right mb-3" role="toolbar" aria-label="Toolbar with button groups">
                                    <div class="btn-group mr-2" role="group" aria-label="Third group">
                                        <button class="btn btn-primary my-3" type="submit">{{ trans('lang.submit') }}</button>
                                    </div>
                                </div>                        
                        </div>

                    </div>
                    
                    </form>
                </div>

                <div class='col-md-4'>

                    {{-- tax --}}
                    <div class="card col-12">
                        
                        <div class="card-body">
                            <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate="" action="{{ route('update_logo')}}">
                                @csrf
                                @method('patch')
                            <div class="ibox">
                                <div class="ibox-body text-center">
                                    <div class="profile-image m-t-20">
                                        <img class="img-thumbnail img-circle image-preview" src="{{ Auth::user()->image }}" />
                                        <input name="logo" class="form-control image @error('logo') is-invalid @enderror"
                                            id="logo" type="file">
                                        @error('logo')
                                            <div class="invalid-feedback text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <h5 class="font-strong m-b-10 m-t-10">{{ Auth::user()->name }}</h5>
                                    <div class="m-b-20 text-muted">{{ Auth::user()->userType }}</div>
                                    <div>
                                        <button class="btn btn-info btn-rounded m-b-5"><i class="fa fa-image"></i> upload</button>
                                    </div>
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
<script src="{{ asset('assets/js/location.js') }}"></script>
@endsection
