@extends('layouts.simple.master')

@section('title', trans('lang.employees'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.employees') }}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{route('home')}}">{{ trans('lang.dashboard') }}</a></li>
<li class="breadcrumb-item active"><a href="{{route('employees.index')}}">{{ trans('lang.employees') }}</a></li>
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
                        <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate="" action="{{ route('employees.update', $employee) }}">
                            @csrf
                            @method('put')
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label" for="name_ar">{{ trans('lang.name_ar') }}</label>
                                    <input name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror"
                                        id="name_ar" type="text" value="{{ $employee->getTranslation('name', 'ar') }}" required>
                                    @error('name.ar')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="name_en">{{ trans('lang.name_en') }}</label>
                                    <input name="name[en]" class="form-control @error('name.en') is-invalid @enderror"
                                        id="name_en" type="text" value="{{ $employee->getTranslation('name', 'en') }}" required>
                                    @error('name.en')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="email">{{ trans('lang.email') }}</label>
                                    <input name="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" type="email" value="{{ $employee->email }}" required>
                                    @error('email')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label" for="phone">{{ trans('lang.phone') }}</label>
                                    <input name="phone" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" type="phone" value="{{ $employee->phone }}" required>
                                    @error('phone')
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
                                    <img src="{{ asset('/uploads/users/default.png') }}" style="width: 500px" class="img-thumbnail image-preview " alt="">
                                </div>
                                {{-- show_logo --}}
                                <div class="col-md-12">
                                    <div class="row">
                                        @if($employee->attachments()->count())
                                            @foreach(array($employee->attachments) as $attachment)
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

                                {{-- user_name --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="user_name">{{ trans('lang.user_name') }}</label>
                                    <input name="user_name" class="form-control @error('user_name') is-invalid @enderror"
                                        id="user_name" type="user_name" value="{{ $employee->user_name }}" required>
                                    @error('user_name')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- date_of_birth --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="date_of_birth">{{ trans('lang.date_of_birth') }}</label>
                                    <input name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror"
                                        id="date_of_birth" type="date" value="{{ $employee->date_of_birth }}" required>
                                    @error('date_of_birth')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">{{ trans('lang.location') }}</label>

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
                                {{-- permissions --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="date_of_birth">{{ trans('lang.permissions') }}</label>

                                    <div class="form-group">

                                    @foreach ($permissions as $permission)
                                        <label class="ui-checkbox">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" {{ $employee->can($permission->name) ? "checked":""}}>
                                            <span class="input-span"></span>{{ trans('lang.'.$permission->name) }}</label>
                                    
                                    @endforeach
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
