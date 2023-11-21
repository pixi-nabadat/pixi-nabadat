@extends('layouts.simple.master')

@section('title', trans('lang.schedule_fcm'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.schedule_fcm') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('schedule-fcm.index') }}">{{ trans('lang.schedule_fcm') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.edit') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" novalidate="" enctype="multipart/form-data"
                            action="{{ route('schedule-fcm.update', $scheduleFcm) }}" method="post">
                            @method('put')
                            @csrf
                            <div class="row g-3">
                                {{--event  --}}
                                <div class="col-md-12 my-3">
                                    <div class="col-form-label col-3">{{ __('lang.event') }}</div>
                                    <select id="trigger_id" name="trigger" class="form-select btn-square digits">
                                        @foreach ($triggers as $key=>$trigger)
                                            <option value="{{ $key }}" {{ $scheduleFcm->trigger == $key? "selected":"" }}>{{ trans('lang.'.$trigger) }}</option>
                                        @endforeach
                                    </select>
                                    @error('trigger')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{--start channel input--}}
                                <div class="col-md-12 my-3">
                                    <div class="col-form-label col-3">{{ __('lang.notification_via') }}</div>
                                    <select id="notification_via" name="notification_via" class="form-select btn-square digits">
                                        @foreach ($fcm_channels as $key=>$fcm_channel)
                                            <option value="{{ $key }}" {{ $scheduleFcm->notification_via == $key? "selected":"" }}>{{ trans('lang.'.$fcm_channel) }}</option>
                                        @endforeach
                                    </select>
                                    @error('notification_via')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- title --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="title">{{ trans('lang.title') }}</label>
                                    <input name="title" class="form-control @error('title') is-invalid @enderror"
                                        id="title" type="text" value="{{ $scheduleFcm->title }}" required>
                                    @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 my-3">
                                    <h4 class="form-label">{{ trans('lang.flags') }}</h4>
                                    <div class="row  bg-light-dark">
                                        @foreach($flags as $key=>$flag)
                                            <div class="col-md-3 col-lg-3" style="cursor: pointer;padding: 10px;color: black" onclick="copyToClipboard('{{$flag}}')">{{$flag}}</div>
                                        @endforeach
                                    </div>
                                </div>


                                {{-- content --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="content">{{ trans('lang.content') }}</label>
                                    <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                              id="content" type="text" required>{{ $scheduleFcm->content }}</textarea>
                                    @error('content')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{--  is_active  --}}
                                <div class="media mb-2">
                                    <label class="col-form-label m-r-10">{{ __('lang.is_active') }}</label>
                                    <div class="media-body  icon-state">
                                        <label class="switch">
                                            <input type="checkbox" name="is_active" {{ $scheduleFcm->is_active == 1 ? "checked":"" }}><span
                                                class="switch-state"></span>
                                        </label>
                                    </div>
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
@endsection