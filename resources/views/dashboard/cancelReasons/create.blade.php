@extends('layouts.simple.master')

@section('title', trans('lang.cancel_reasons'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.cancel_reasons') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.cancel_reasons') }}</li>
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
                            action="{{ route('cancelReasons.store') }}">
                            @csrf
                            <div class="row g-3">
                                {{-- English Reason --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="reason_en">{{ trans('lang.reason_en') }}</label>
                                    <input name="reason[en]" class="form-control @error('reason.en') is-invalid @enderror"
                                        id="reason_en" type="text" required>
                                    @error('reason.en')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- Arabic Reason --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="reason_ar">{{ trans('lang.reason_ar') }}</label>
                                    <input name="reason[ar]" class="form-control @error('reason.ar') is-invalid @enderror"
                                        id="reason_ar" type="text" required>
                                    @error('reason.ar')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- is Active --}}
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
                            {{-- Submit Button --}}
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
