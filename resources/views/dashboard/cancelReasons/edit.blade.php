@extends('layouts.simple.master')

@section('title', trans('lang.cancel_reasons'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.cancel_reasons') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('cancelReasons.index') }}">{{ trans('lang.cancel_reasons') }}</a></li>
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
                            action="{{ route('cancelReasons.update', $cancelReason) }}" method="post">
                            @csrf
                            @method('put')
                            <div class="row g-3">
                                {{-- English Reason --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="reason_en">{{ trans('lang.reason_en') }}</label>
                                    <input name="reason[en]" value={{ $cancelReason->getTranslation('reason', 'en') }}
                                        class="form-control @error('reason.en') is-invalid @enderror" id="reason_en"
                                        type="text" required>
                                    @error('reason.en')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- Arabic Reason --}}
                                <div class="col-md-6">
                                    <label class="form-label" for="reason_ar">{{ trans('lang.reason_ar') }}</label>
                                    <input name="reason[ar]" value={{ $cancelReason->getTranslation('reason', 'ar') }}
                                        class="form-control @error('reason.ar') is-invalid @enderror" id="reason_ar"
                                        type="text" required>
                                    @error('reason.ar')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- is Active --}}
                            <div class="media my-3">
                                <label class="col-form-label m-r-10">{{ __('lang.is_active') }}</label>
                                <div class="media-body  icon-state">
                                    <label class="switch">
                                        <input type="checkbox" name="is_active"
                                            {{ $cancelReason->is_active == 1 ? 'checked' : '' }}><span
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
@endsection
