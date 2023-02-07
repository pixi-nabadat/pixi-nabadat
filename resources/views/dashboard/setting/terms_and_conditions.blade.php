@extends('layouts.simple.master')
@section('title', trans('lang.settings'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.settings') }}</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('settings') }}">{{ trans('lang.settings') }}</a></li>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="container-fluid">

            <form class="needs-validation" novalidate="" method="post" enctype="multipart/form-data"
                action="{{ route('settings.store.terms_and_conditions') }}">
                @csrf
                <div class="row ">

                    <div class="col-md-12 col-lg-12 col-sm-12">

                        @if(count(config('setting_fields', [])) )
                        {{-- center lat and lng and google map url --}}
                        <div class="col-lg-12 col-md-12">

                            {{-- center information --}}
                            <div class="card  col-md-12">
                                <div class="card-header py-4">
                                    <h6 class="card-titel">{{config('setting_fields.terms_and_conditions.title') }}</h6>
                                </div>
                                <div class="card-body row">

                                    @foreach(config('setting_fields.terms_and_conditions.elements') as $field)
                                        {{-- name_ar  --}}
                                        <div class="col-md-12 d-flex my-3">
                                            <label class="form-label col-3 " for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                            <textarea name="{{ $field['name'] }}" class="{{ $field['class'] }}"
                                                id="validationCustom01" type="{{ $field['type'] }}" placeholder="{{ $field['label'] }}"
                                                required="" rows="5" cols="5">{{ config('global.'.$field['name'])}}</textarea>
                                            @error($field['name'])
                                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        @endif


                    </div>


                    <div class="btn-toolbar float-right mb-3" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="Third group">
                            <button class="btn btn-primary my-3" type="submit">{{ trans('lang.submit') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
@endsection
