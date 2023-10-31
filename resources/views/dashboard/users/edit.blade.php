@extends('layouts.simple.master')

@section('title', trans('lang.clients'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.clients') }}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{route('home')}}">{{ trans('lang.dashboard') }}</a></li>
<li class="breadcrumb-item active"><a href="{{route('clients.index')}}">{{ trans('lang.clients') }}</a></li>
<li class="breadcrumb-item active">{{ trans('lang.edit') }}</li>
@endsection
@section('style')
    <style>
        .img-container {
            position: relative;
            width: 100%;
            max-width: 400px;
        }

        .image {
            display: block;
            width: 100%;
            height: auto;
        }

        .overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            width: 100%;
            opacity: 0;
            transition: .3s ease;
            background-color: #ff5151;
        }

        .img-container:hover .overlay {
            opacity: 1;
        }

        .icon {
            color: white;
            font-size: 50px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .fa-user:hover {
            color: #eee;
        }
    </style>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate="" action="{{ route('clients.update', $client) }}">
                            @csrf
                            @method('put')
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label" for="name">{{ trans('lang.name') }}</label>
                                    <input name="name" class="form-control @error('name') is-invalid @enderror"
                                        id="name_ar" type="text" value="{{ $client->name }}" required>
                                    @error('name')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="email">{{ trans('lang.email') }}</label>
                                    <input name="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" type="email" value="{{ $client->email }}" required>
                                    @error('email')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="phone">{{ trans('lang.phone') }}</label>
                                    <input name="phone" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" type="phone" value="{{ $client->phone }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="date_of_birth">{{ trans('lang.date_of_birth') }}</label>
                                    <input name="date_of_birth" data-language="en" class="datepicker-here form-control digits @error('date_of_birth') is-invalid @enderror"
                                        id="date_of_birth" type="text" value="{{ $client->date_of_birth }}">
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
                                    <img src="{{ asset('/uploads/users/default.png') }}" style="width: 100px" class="image-preview " alt="">
                                </div>
                                {{-- show_logo --}}
                                <div class="col-md-12">
                                    <div class="row">
                                        @if($client->attachments()->count())
                                            @foreach(array($client->attachments) as $attachment)
                                                 @if($attachment->type == App\Enum\ImageTypeEnum::LOGO)
                                                <div class="col-md-3 col-lg-3 col-sm-12">
                                                    <div class="img-container">
                                                        <div class="form-group my-3">
                                                            <img src="{{asset($attachment->path.'/'.$attachment->filename)}}" class="img-fluid image" alt="">
                                                        </div>
                                                        <div class="overlay">
                                                            <a role="button" onclick="destroy('{{route('attachment.destroy',$attachment->id)}}')" class="icon" title="{{trans('lang.delete_image')}}">
                                                                <i class="fa fa-trash-o"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        @endif
            
                                    </div>
                                </div>
                                {{-- date_of_birth --}}
                                <div class="col-md-12">
                                   <div class="col-md-12 mb-3">
                                        <div class="col-form-label">{{ trans('lang.choose_governorates') }}</div>
                                        <select id="change_location" data-filling-name="location_id"
                                            class="form-select form-control mb-3 @error('parent_id') is-invalid @enderror">
                                            <option selected>{{ trans('lang.choose_governorates') }}</option>
                                            @foreach ($governorates as $governorate)
                                                <option value="{{ $governorate->id }}" {{ (($client->location->parent_id ?? null) == $governorate->id) ? "selected":"" }}>{{ $governorate->getTranslation('title', app()->getLocale()) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="col-form-label">{{ trans('lang.city') }}</div>
                                        <select name="location_id" class="form-select form-control mb-3 @error('location_id') is-invalid @enderror" id="city">
                                            <option value="{{ $client->location_id }}" selected>{{ $client->location->getTranslation('title', app()->getLocale()) }}</option>
                                        </select>
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
                                        <input type="checkbox" name="is_active" {{ $client->is_active ? "checked":"" }}><span
                                            class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            
                            {{-- allow_notification --}}
                            <div class="media mb-2">
                                <label class="col-form-label m-r-10">{{ __('lang.allow_notification') }}</label>
                                <div class="media-body  icon-state">
                                    <label class="switch">
                                        <input type="checkbox" name="allow_notification" {{ $client->allow_notification ? "checked":"" }}><span
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
