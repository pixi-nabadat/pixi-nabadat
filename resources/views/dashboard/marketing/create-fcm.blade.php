@extends('layouts.simple.master')

@section('title', trans('lang.create_fcm'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.create_fcm') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.create_fcm') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="col-sm-12 col-xl-12 xl-100">
            <div class="card height-equal">
                <div class="card-body">
                    <ul class="nav nav-pills" id="pills-icontab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="pills-iconhome-tab" data-bs-toggle="pill" href="#pills-iconhome" role="tab" aria-controls="pills-iconhome" aria-selected="true"><i class="icofont icofont-ui-home"></i>{{ trans('lang.schedule_fcm') }}</a></li>
                        <li class="nav-item"><a class="nav-link" id="pills-iconprofile-tab" data-bs-toggle="pill" href="#pills-iconprofile" role="tab" aria-controls="pills-iconprofile" aria-selected="false"><i class="icofont icofont-man-in-glasses"></i>{{ trans('lang.fcm_messages') }}</a></li>
                    </ul>
                    <div class="tab-content" id="pills-icontabContent">
                        <div class="tab-pane fade show active" id="pills-iconhome" role="tabpanel" aria-labelledby="pills-iconhome-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate=""
                                        action="{{ route('schedule-fcm.store') }}">
                                        @csrf
                                        <div class="row g-3">
                                            {{--event  --}}
                                            <div class="col-md-12 d-flex my-3">
                                                <div class="col-form-label col-3">{{ __('lang.event') }}</div>
                                                <select id="trigger_id" name="trigger" class="form-select btn-square digits">
                                                    @foreach ($triggers as $key=>$trigger)
                                                        <option value="{{ $key }}">{{ trans('lang.'.$trigger) }}</option>
                                                    @endforeach
                                                </select>
                                                @error('trigger')
                                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
            
                                            {{--start channel input--}}
                                            <div class="col-md-12 d-flex my-3">
                                                <div class="col-form-label col-3">{{ __('lang.notification_via') }}</div>
                                                <select id="notification_via" name="notification_via" class="form-select btn-square digits">
                                                    @foreach ($fcm_channels as $key=>$fcm_channel)
                                                        <option value="{{ $key }}">{{ trans('lang.'.$fcm_channel) }}</option>
                                                    @endforeach
                                                </select>
                                                @error('notification_via')
                                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
            
                                            <div class="col-md-12 d-flex my-3">
                                                <div class="col-form-label col-3">{{ __('lang.start_date') }}</div>
                                                <div class="input-group">
                                                    <input name="start_date" class="datepicker-here form-control digits" type="text" data-language="en" data-bs-original-title="" title="">
                                                </div>
                                                @error('start_date')
                                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-12 d-flex my-3">
                                                <div class="col-form-label col-3">{{ __('lang.end_date') }}</div>
                                                <div class="input-group">
                                                    <input name="end_date" class="datepicker-here form-control digits" type="text" data-language="en" data-bs-original-title="" title="">
                                                </div>
                                                @error('end_date')
                                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
            
                                            <div class="col-md-12 d-flex my-3">
                                                <h4 class="form-label">{{ trans('lang.flags') }}</h4>
                                                <div class="row  bg-light-dark">
                                                    @foreach($flags as $key=>$flag)
                                                        <div class="col-md-3 col-lg-3" style="cursor: pointer;padding: 10px;color: black" onclick="copyToClipboard('{{$flag}}')">{{$flag}}</div>
                                                    @endforeach
                                                </div>
                                            </div>
            
            
                                            {{-- title --}}
                                            <div class="col-md-12">
                                                <label class="form-label" for="title">{{ trans('lang.title') }}</label>
                                                <input name="title" class="form-control @error('title') is-invalid @enderror"
                                                    id="title" type="text" required>
                                                @error('title')
                                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            {{-- content --}}
                                            <div class="col-md-12">
                                                <label class="form-label" for="content">{{ trans('lang.content') }}</label>
                                                <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                                          id="content" type="text" required></textarea>
                                                @error('content')
                                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
            
                                            {{--  is_active  --}}
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
                                        <button class="btn btn-primary my-3" type="submit">{{ trans('lang.submit') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-iconprofile" role="tabpanel" aria-labelledby="pills-iconprofile-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" class="needs-validation" novalidate=""
                                        action="{{ route('fcm-messages.store') }}">
                                        @csrf
                                        <div class="row g-3">
                                            {{--event  --}}
                                            <div class="col-md-12 my-3">
                                                <div class="col-form-label col-3">{{ trans('lang.action') }}</div>
                                                <select id="trigger_id" name="fcm_action" class="form-select btn-square digits">
                                                    @foreach (\App\Enum\FcmEventsNames::$FCMACTIONS as $key=>$action)
                                                        <option value="{{ $key }}">{{ trans('lang.'.$action) }}</option>
                                                    @endforeach
                                                </select>
                                                @error('fcm_action')
                                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
            
                                            {{-- title --}}
                                            <div class="col-md-12">
                                                <label class="form-label" for="title">{{ trans('lang.title') }}</label>
                                                <input name="title" class="form-control @error('title') is-invalid @enderror"
                                                    id="title" type="text" required>
                                                @error('title')
                                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
            
                                            <div class="col-md-12 my-3">
                                                <div class="form-label">{{ trans('lang.flags') }}</div>
                                                <div class="row  bg-light-dark">
                                                    @foreach(\App\Enum\FcmEventsNames::$FLAGS as $key=>$flag)
                                                        <div class="col-md-4 col-lg-4" style="cursor: pointer;padding: 10px;color: black" onclick="copyToClipboard('{{$flag}}')">{{$flag}}</div>
                                                    @endforeach
                                                </div>
                                            </div>
            
                                            {{-- content --}}
                                            <div class="col-md-12">
                                                <label class="form-label" for="content">{{ trans('lang.content') }}</label>
                                                <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                                          id="content" type="text" required></textarea>
                                                @error('content')
                                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
            
                                            {{--  is_active  --}}
                                            <div class="media mb-2">
                                                <label class="col-form-label m-r-10">{{ trans('lang.is_active') }}</label>
                                                <div class="media-body  icon-state">
                                                    <label class="switch">
                                                        <input type="checkbox" name="is_active" checked=""><span
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
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')
    <script>
        function copyToClipboard(text) {
            var sampleTextarea = document.createElement("textarea");
            document.body.appendChild(sampleTextarea);
            sampleTextarea.value = text; //save main text in it
            sampleTextarea.select(); //select textarea contenrs
            document.execCommand("copy");
            document.body.removeChild(sampleTextarea);
            toastr.info('Copy to Clipboard')
        }
    </script>
@endsection