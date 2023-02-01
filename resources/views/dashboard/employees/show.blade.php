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
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label mt-3" for="name_ar">{{ trans('lang.name_ar') }}</label>
                                <p class="form-control" id="name_ar">{{ $employee->getTranslation('name', 'ar') }}</p>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label mt-3" for="name_ar">{{ trans('lang.name_en') }}</label>
                                <p class="form-control" id="name_ar">{{ $employee->getTranslation('name', 'en') }}</p>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label mt-3" for="name_ar">{{ trans('lang.email') }}</label>
                                <p class="form-control" id="name_ar">{{ $employee->email }}</p>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label mt-3" for="name_ar">{{ trans('lang.phone') }}</label>
                                <p class="form-control" id="name_ar">{{ $employee->phone }}</p>
                            </div>
                             {{-- logo --}}
                            <div class="col-md-12">
                                <label class="form-label mt-3" for="logo">{{ trans('lang.logo') }}</label>
                                <div class="row">
                                    @if($employee->attachments()->count())
                                        @foreach(array($employee->attachments) as $attachment)
                                            @if($attachment->type == App\Enum\ImageTypeEnum::LOGO)
                                            <div class="col-md-3 col-lg-3 col-sm-12">
                                                <div class="img-container">
                                                    <div class="form-group my-3">
                                                        <img src="{{asset($attachment->path.'/'.$attachment->filename)}}" class="img-fluid image" alt="">
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
                                <label class="form-label mt-3" for="name_ar">{{ trans('lang.user_name') }}</label>
                                <p class="form-control" id="name_ar">{{ $employee->user_name }}</p>
                            </div>
                            {{-- date_of_birth --}}
                            <div class="col-md-12">
                                <label class="form-label mt-3" for="name_ar">{{ trans('lang.date_of_birth') }}</label>
                                <p class="form-control" id="name_ar">{{ $employee->date_of_birth }}</p>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">{{ trans('lang.location') }}</label>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label mt-3" for="name_ar">{{ trans('lang.choose_governorates') }}</label>
                                    <p class="form-control" id="name_ar">{{ $employee->date_of_birth }}</p>
    
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
                                    <label class="form-label mt-3" for="name_ar">{{ trans('lang.city') }}</label>
                                    <p class="form-control" id="name_ar">{{ optional($employee->location)->title ??"-" }}</p>
                                </div>
                            </div>
                            {{-- permissions --}}
                            <div class="col-md-12">
                                <label class="form-label" for="date_of_birth">{{ trans('lang.permissions') }}</label>

                                <div class="form-group">

                                @foreach ($permissions as $permission)
                                    <label class="ui-checkbox">
                                        <input type="checkbox" {{ $employee->can($permission->name) ? "checked":""}} @disabled(true)>
                                        <span class="input-span"></span>{{ $permission->name }}</label>
                                
                                @endforeach
                                </div>
                                
                            </div>
                        </div>
                        
                    
                       

                        <div class="media my-3">
                            <label class="col-form-label m-r-10">{{ __('lang.is_active') }}</label>
                            <div class="media-body  icon-state">
                                <label class="switch">
                                    <input type="checkbox" disabled="true" name="is_active"
                                        {{ $employee->is_active == 1 ? 'checked' : '' }}><span
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
    <!-- Container-fluid Ends-->
@endsection

@section('script')
@endsection
