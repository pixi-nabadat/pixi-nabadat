@extends('layouts.simple.master')

@section('title', trans('lang.packages'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.packages') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.packages') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate=""
                            action="{{ route('packages.store') }}">
                            @csrf
                            <div class="row g-3">
                                {{--center  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <div class="col-form-label col-3">{{ __('lang.centers') }}</div>
                                    <select id="center_id" name="center_id" class="js-example-basic-single col-sm-12">
                                        <option selected>...</option>
                                        @foreach ($centers as $center)
                                            <option value="{{ $center->id }}">{{ $center->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- English Name --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="name_en">{{ trans('lang.name_en') }}</label>
                                    <input name="name[en]" class="form-control @error('name.en') is-invalid @enderror"
                                        id="name_en" type="text" required>
                                    @error('name.en')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- Arabic Name --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="name_ar">{{ trans('lang.name_ar') }}</label>
                                    <input name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror"
                                        id="name_ar" type="text" required>
                                    @error('name.ar')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{--  num_nabadat  --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="num_nabadat">@lang('lang.num_nabadat')</label>
                                    <input type="number" name="num_nabadat" step="1"
                                        class="form-control @error('num_nabadat') is-invalid @enderror">
                                    @error('num_nabadat')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{--  price  --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="price">@lang('lang.price')</label>
                                    <input type="number" name="price" step="0.01"
                                        class="form-control @error('price') is-invalid @enderror">
                                    @error('price')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{--  discount percentage  --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="discount_percentage">@lang('lang.discount_percentage')</label>
                                    <input type="number" name="discount_percentage" step="0.01"
                                        class="form-control @error('discount_percentage') is-invalid @enderror">
                                    @error('discount_percentage')
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
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')

@endsection
