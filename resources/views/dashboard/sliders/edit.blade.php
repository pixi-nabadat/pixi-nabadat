@extends('layouts.simple.master')

@section('title', trans('lang.sliders'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.sliders') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('sliders.index') }}">{{ trans('lang.sliders') }}</a></li>
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
                            action="{{ route('sliders.update', $slider) }}" method="post">
                            @csrf
                            @method('put')
                            {{-- order --}}
                            <div class="col-md-12">
                                <label class="form-label mt-3" for="order">{{ trans('lang.order') }}</label>
                                <input name="order" value={{ $slider->order }}
                                    class="form-control @error('order') is-invalid @enderror" id="order"
                                    type="number" required>
                                @error('order')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            {{--centers  --}}
                            <div class="col-md-12">
                                <div class="col-form-label col-3">{{ __('lang.center') }}</div>
                                <select id="center_id" name="center_id" class="js-example-basic-single col-sm-12">
                                    @foreach ($centers as $center)
                                        <option value="{{ $center->id }}" {{ $center->id == $slider->center_id ? "selected":"" }}>{{ $center->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{--  duration  --}}
{{--                            <div class="col-md-12">--}}
{{--                                <label class="form-label mt-3" for="duration">@lang('lang.duration')</label>--}}
{{--                                <input type="time" name="duration" step="0.01"--}}
{{--                                    class="form-control @error('duration') is-invalid @enderror" value={{ $slider->duration }}>--}}
{{--                                @error('duration')--}}
{{--                                    <div class="invalid-feedback text-danger">{{ $message }}</div>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
                            {{--  start data  --}}
                            <div class="col-md-12">
                                <label class="form-label mt-3" for="start_date">@lang('lang.start_date')</label>
                                <div class="input-group date" id="dt-start_date" data-target-input="nearest">
                                    <input name="start_date" value="{{ $slider->start_date }}" class="datepicker-here form-control digits  @error('start_date') is-invalid @enderror" type="text" data-language="en" data-target="#dt-start_date" data-bs-original-title title>
                                    @error('start_date')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="input-group-text" data-target="#dt-start_date" data-toggle="datepicker"><i class="fa fa-calendar"> </i></div>
                                </div>
                            </div>
                            {{--  end date  --}}
                            <div class="col-md-12">
                                <label class="form-label mt-3" for="end_date">@lang('lang.end_date')</label>

                                <div class="input-group date" id="dt-start_date" data-target-input="nearest">
                                    <input name="end_date" value="{{ $slider->end_date }}" class="datepicker-here form-control digits  @error('end_date') is-invalid @enderror" type="text" data-language="en" data-target="#dt-start_date" data-bs-original-title title>
                                    @error('end_date')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                    <div class="input-group-text" data-target="#dt-start_date" data-toggle="datepicker"><i class="fa fa-calendar"> </i></div>
                                </div>
                            </div>
                            {{-- slider_logo --}}
                            <div class="col-md-12">
                                <label class="form-label mt-3" for="logo">{{ trans('lang.logo') }}</label>
                                <input name="logo" class="form-control image @error('logo') is-invalid @enderror"
                                    id="logo" type="file">
                                @error('logo')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    @if($slider->attachments->count())
                                        @foreach($slider->attachments as $attachment)
                                        @if ($attachment->type == App\Enum\ImageTypeEnum::LOGO)
                                        <div class="col-md-3 col-lg-3 col-sm-12">
                                            <div class="img-container">
                                                <div class="form-group my-3">
                                                    <img src="{{asset($attachment->path.'/'.$attachment->filename)}}" style="width: 150px;height: 150px" class="img-thumbnail image" alt="">
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

                            {{-- is_active --}}
                            <div class="media my-2">
                                <label class="col-form-label m-r-10">{{ __('lang.status') }}</label>
                                <div class="media-body  icon-state">
                                    <label class="switch">
                                        <input type="checkbox" name="is_active"
                                            {{ $slider->is_active == 1 ? 'checked' : '' }}><span
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
