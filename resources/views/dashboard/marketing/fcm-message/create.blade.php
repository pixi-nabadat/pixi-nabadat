@extends('layouts.simple.master')

@section('title', trans('lang.fcm_message'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.fcm_message') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.fcm_message') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
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