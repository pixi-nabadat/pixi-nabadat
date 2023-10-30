@extends('layouts.simple.master')

@section('title', trans('lang.sliders'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.sliders') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.sliders') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="col-sm-12 col-xl-12 xl-100">
            <div class="card height-equal">
                <div class="card-body">
                    <ul class="nav nav-pills" id="pills-icontab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="pills-iconhome-tab" data-bs-toggle="pill" href="#pills-iconhome" role="tab" aria-controls="pills-iconhome" aria-selected="true"><i class="icofont icofont-ui-home"></i>{{ trans('lang.center_slider') }}</a></li>
                        <li class="nav-item"><a class="nav-link" id="pills-iconprofile-tab" data-bs-toggle="pill" href="#pills-iconprofile" role="tab" aria-controls="pills-iconprofile" aria-selected="false"><i class="icofont icofont-man-in-glasses"></i>{{ trans('lang.product_slider') }}</a></li>
                    </ul>
                    <div class="tab-content" id="pills-icontabContent">
                        <div class="tab-pane fade show active" id="pills-iconhome" role="tabpanel" aria-labelledby="pills-iconhome-tab">
                            <div class="card">
                                <div class="card-body">
                                    <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate=""
                                        action="{{ route('sliders.store') }}">
                                        @csrf
                                        <div class="row g-3">
                                            <input name="type" hidden class="form-control type="number" value="{{ App\Models\Slider::CENTER }}">
                                            
                                            {{-- order --}}
                                            <div class="col-md-6">
                                                <label class="form-label" for="order">{{ trans('lang.order') }}</label>
                                                <input name="order" class="form-control @error('order') is-invalid @enderror"
                                                    id="order" type="number" required>
                                                @error('order')
                                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            {{--centers  --}}
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('lang.center') }}</label>
                                                <select id="sliderable_id" name="sliderable_id" class="js-example-basic-single col-sm-12">
                                                    <option selected>...</option>
                                                    @foreach ($centers as $center)
                                                        <option value="{{ $center->id }}">{{ $center->user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{--  start date  --}}
                                            <div class="col-md-6">
                                                <label class="form-label" for="start_date">@lang('lang.start_date')</label>
                                                <div class="input-group date" id="dt-start_date" data-target-input="nearest">
                                                    <input name="start_date" class="datepicker-here form-control digits  @error('start_date') is-invalid @enderror" type="text" data-language="en" data-target="#dt-start_date" data-bs-original-title title>
                                                    @error('start_date')
                                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <div class="input-group-text" data-target="#dt-start_date" data-toggle="datepicker"><i class="fa fa-calendar"> </i></div>
                                                </div>
                                            </div>
                                            {{--  end date  --}}
                                            <div class="col-md-6">
                                                <label class="form-label" for="start_date">@lang('lang.end_date')</label>
                                                <div class="input-group date" id="dt-start_date" data-target-input="nearest">
                                                    <input name="end_date" class="datepicker-here form-control digits  @error('end_date') is-invalid @enderror" type="text" data-language="en" data-target="#dt-end_date" data-bs-original-title title>
                                                    @error('end_date')
                                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <div class="input-group-text" data-target="#dt-start_date" data-toggle="datepicker"><i class="fa fa-calendar"> </i></div>
                                                </div>
                                            </div>
                                            {{-- slider_logo --}}
                                            <div class="col-md-12">
                                                <label class="form-label col-3" for="logo">{{ trans('lang.logo') }}</label>
                                                    <input name="logo" class="form-control image @error('logo') is-invalid @enderror"
                                                        id="logo" type="file">
                                                    @error('logo')
                                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                    @enderror
                                            </div>
            
                                            <div class="form-group mt-3">
                                                <img src="{{ asset('/uploads/products/default.png') }}" style="width: 500px" class="img-thumbnail image-preview " alt="">
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
                                    <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate=""
                                        action="{{ route('sliders.store') }}">
                                        @csrf
                                        <div class="row g-3">
                                            <input name="type" hidden class="form-control type="number" value="{{ App\Models\Slider::PRODUCT }}">
                                            
                                            {{-- order --}}
                                            <div class="col-md-6">
                                                <label class="form-label" for="order">{{ trans('lang.order') }}</label>
                                                <input name="order" class="form-control @error('order') is-invalid @enderror"
                                                    id="order" type="number" required>
                                                @error('order')
                                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            {{--products  --}}
                                            <div class="col-md-6">
                                                <label class="form-label">{{ __('lang.product') }}</label>
                                                <select id="sliderable_id" name="sliderable_id" class="js-example-basic-single col-sm-12">
                                                    <option selected>...</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->getTranslation('name', app()->getLocale()) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            {{--  start date  --}}
                                            <div class="col-md-6">
                                                <label class="form-label" for="start_date">@lang('lang.start_date')</label>
                                                <div class="input-group date" id="dt-start_date" data-target-input="nearest">
                                                    <input name="start_date" class="datepicker-here form-control digits  @error('start_date') is-invalid @enderror" type="text" data-language="en" data-target="#dt-start_date" data-bs-original-title title>
                                                    @error('start_date')
                                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <div class="input-group-text" data-target="#dt-start_date" data-toggle="datepicker"><i class="fa fa-calendar"> </i></div>
                                                </div>
                                            </div>
                                            {{--  end date  --}}
                                            <div class="col-md-6">
                                                <label class="form-label" for="start_date">@lang('lang.end_date')</label>
                                                <div class="input-group date" id="dt-start_date" data-target-input="nearest">
                                                    <input name="end_date" class="datepicker-here form-control digits  @error('end_date') is-invalid @enderror" type="text" data-language="en" data-target="#dt-end_date" data-bs-original-title title>
                                                    @error('end_date')
                                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <div class="input-group-text" data-target="#dt-start_date" data-toggle="datepicker"><i class="fa fa-calendar"> </i></div>
                                                </div>
                                            </div>
                                            {{-- slider_logo --}}
                                            <div class="col-md-12">
                                                <label class="form-label col-3" for="logo">{{ trans('lang.logo') }}</label>
                                                    <input name="logo" class="form-control image @error('logo') is-invalid @enderror"
                                                        id="logo" type="file">
                                                    @error('logo')
                                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                                    @enderror
                                            </div>
            
                                            <div class="form-group mt-3">
                                                <img src="{{ asset('/uploads/products/default.png') }}" style="width: 500px" class="img-thumbnail image-preview " alt="">
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
