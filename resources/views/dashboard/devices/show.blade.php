@extends('layouts.simple.master')

@section('title', trans('lang.devices'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.devices') }}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{route('home')}}">{{ trans('lang.dashboard') }}</a></li>
<li class="breadcrumb-item active"><a href="{{route('devices.index')}}">{{ trans('lang.devices') }}</a></li>
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
                        <div class="col-md-12">
                            <label class="form-label mt-3" for="name_ar">{{ trans('lang.name_ar') }}</label>
                            <p class="form-control" id="name_ar">{{ $device->getTranslation('name', 'ar') }}</p>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label mt-3" for="name_en">{{ trans('lang.name_en') }}</label>
                            <p  class="form-control" id="name_en">{{ $device->getTranslation('name', 'en') }}</p>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label mt-3" for="description_ar">{{ trans('lang.description_ar') }}</label>

                            <p class="form-control" id="description_ar">{{ $device->getTranslation('description', 'ar') }} </p>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label mt-3" for="description_en">{{ trans('lang.description_en') }}</label>
                            <p class="form-control" id="description_en">{{ $device->getTranslation('description', 'en') }}</p>
                        </div>
                        {{-- image --}}
                        <div class="col-md-12">
                        <div class="row">
                            @if($device->attachments->count())
                                @foreach($device->attachments as $attachment)
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
                                @endforeach
                            @endif

                        </div>

                        <div class="media my-3">
                            <label class="col-form-label m-r-10">{{ __('lang.is_active') }}</label>
                            <div class="media-body  icon-state">
                                <label class="switch">
                                    <input type="checkbox" disabled="true" name="is_active"
                                        {{ $device->is_active == 1 ? 'checked' : '' }}><span
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
