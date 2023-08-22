@extends('layouts.simple.master')

@section('title', trans('lang.products'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.products') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.products') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/image-container.css') }}" />
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
         <div class="row ">
                <div class="col-md-8">

                    {{-- product_information --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6 class="card-titel">{{ __('lang.product_information') }}</h6>
                        </div>
                        <div class="card-body row">
                            {{-- name_ar  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3 " for="name_ar">{{ trans('lang.name_ar') }}</label>
                                <p class="form-control" id="name_ar">{{ $product->getTranslation('name', 'ar') }} </p>
                            </div>
                            {{-- name_en  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3" for="name_en">{{ trans('lang.name_en') }}</label>
                                <p class="form-control" id="name_en">{{ $product->getTranslation('name', 'en') }}</p>
                            </div>
                            {{-- categories  --}}
                            <div class="col-md-12 d-flex my-3">
                                <div class="col-form-label col-3">{{ __('lang.categories') }}</div>
                               <p id="select_category" class="form-control">{{ $product->category->name }}</p>
                            </div>
                            {{--  purchase_price  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3" for="purchase_price">@lang('lang.purchase_price')</label>
                                <p class="form-control">{{ $product->purchase_price }} </p>
                            </div>
                            {{--  unit_price  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3" for="unit_price">@lang('lang.unit_price')</label>
                                <p class="form-control">{{ $product->unit_price }}</p>
                            </div>
                            {{--  stock  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3" for="stock">@lang('lang.stock')</label>
                                <p class="form-control">{{ $product->stock }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- description --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6 class="mb-0 h6">@lang('lang.product_description')</h6>
                        </div>
                        <div class="card-body row">
                            {{-- description_ar --}}
                            <div class="col-md-12  d-flex my-3">
                                <label class="form-label col-3"
                                    for="description_ar">{{ trans('lang.description_ar') }}</label>
                                <p class="form-control" id="description_ar">
                                    {{ $product->getTranslation('description', 'ar') }} </p>
                            </div>

                            {{-- description_en --}}
                            <div class="col-md-12  d-flex my-3">
                                <label class="form-label  col-3"
                                    for="description_en">{{ trans('lang.description_en') }}</label>
                                <p class="form-control">{{ $product->getTranslation('description', 'en') }} </p>
                            </div>
                        </div>
                    </div>
                    {{-- product_logo --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.product_logo') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    @if ($product->attachments->count())
                                        @foreach ($product->attachments as $attachment)
                                            @if ($attachment->type == App\Enum\ImageTypeEnum::LOGO)
                                                <div class="col-md-3 col-lg-3 col-sm-12">
                                                    <div class="img-container">
                                                        <div class="form-group my-3">
                                                            <img src="{{ asset($attachment->path . '/' . $attachment->filename) }}"
                                                                style="width: 150px;height: 150px" class="img-thumbnail image"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- product_images --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.product_images') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    @if ($product->attachments->count())
                                        @foreach ($product->attachments as $attachment)
                                            @if ($attachment->type == App\Enum\ImageTypeEnum::GALARY)
                                                <div class="col-md-3 col-lg-3 col-sm-12">
                                                    <div class="img-container">
                                                        <div class="form-group my-3">
                                                            <img src="{{ asset($attachment->path . '/' . $attachment->filename) }}"
                                                                style="width: 150px;height: 150px" class="img-thumbnail image"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- product_discount --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.product_discount') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 row">
                                {{-- discount --}}
                                <div class="col-md-12 d-flex my-3">
                                    <label class="form-label  col-3" for="discount">@lang('lang.discount')</label>
                                    <p class="form-control"> {{ $product->discount }}</p>
                                </div>
                                {{-- discount_start_date --}}
                                <div class="col-md-12  d-flex my-3">
                                    <label class="form-label  col-3" for="discount_start_date">@lang('lang.discount_start_date')</label>
                                    <p class="form-control">{{ $product->discount_start_date }}</p>
                                </div>
                                {{-- discount_end_date --}}
                                <div class="col-md-12  d-flex my-3">
                                    <label class="form-label  col-3" for="discount_end_date">@lang('lang.discount_end_date')</label>
                                    <p class="form-control">{{ $product->discount_end_date }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='col-md-4'>

                    {{-- tax --}}
                    <div class="card col-12">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.vat_tax') }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 row">
                                <label class="form-label  " for="tax">@lang('lang.tax')</label>
                                <div class="col-md-6 ">
                                    <p class="form-control">{{ $product->tax }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- featured --}}
                    <div class="card col-12">
                        <div class="card-header py-4">
                            <h6>{{ __('lang.featured') }}</h6>
                        </div>
                        <div class="card-body row">
                            <div class="media mb-2">
                                <label class="col-form-label m-r-10">{{ __('lang.status') }}</label>
                                <div class="media-body  icon-state">
                                    <label class="switch">
                                        <input type="checkbox" disabled="true"
                                            {{ $product->featured == 1 ? 'checked' : '' }}><span
                                            class="switch-state"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="media mb-2">
                                <label class="col-form-label m-r-10">{{ __('lang.status') }}</label>
                                <div class="media-body  icon-state">
                                    <label class="switch">
                                        <input type="checkbox" disabled="true" name="is_active"
                                            {{ $product->featured == 1 ? 'checked' : '' }}><span
                                            class="switch-state"></span>
                                    </label>
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
