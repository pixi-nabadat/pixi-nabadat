@extends('layouts.simple.master')

@section('title', trans('lang.packages'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.packages') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('packages.index') }}">{{ trans('lang.packages') }}</a></li>
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
                            action="{{ route('packages.update', $package) }}" method="post">
                            @csrf
                            @method('put')
                            {{--center  --}}
                            <div class="col-md-12 d-flex my-3">
                                <div class="col-form-label col-3">{{ __('lang.centers') }}</div>
                                <select id="center_id" name="center_id" class="js-example-basic-single col-sm-12 @error('price') is-invalid @enderror">
                                    @foreach ($centers as $center)
                                        <option value="{{ $center->id }}" {{ $center->id == $package->center->id ? "selected":"" }}>{{ $center->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('center_id')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- English Name --}}
                            <div class="col-md-12">
                                <label class="form-label mt-3" for="name_en">{{ trans('lang.name_en') }}</label>
                                <input name="name[en]" value={{ $package->getTranslation('name', 'en') }}
                                    class="form-control @error('name.en') is-invalid @enderror" id="name_en"
                                    type="text" required>
                                @error('name.en')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- Arabic Name --}}
                            <div class="col-md-12">
                                <label class="form-label" for="name_ar">{{ trans('lang.name_ar') }}</label>
                                <input name="name[ar]" value={{ $package->getTranslation('name', 'ar') }}
                                    class="form-control @error('name.ar') is-invalid @enderror" id="name_ar"
                                    type="text" required>
                                @error('name.ar')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{--  num_nabadat  --}}
                            <div class="col-md-12">
                                <label class="form-label mt-3" for="num_nabadat">@lang('lang.num_nabadat')</label>
                                <input type="number" name="num_nabadat" step="0.01"
                                    class="form-control @error('num_nabadat') is-invalid @enderror"
                                    value={{ $package->num_nabadat }}>
                                @error('num_nabadat')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{--  price  --}}
                            <div class="col-md-12">
                                <label class="form-label mt-3" for="price">@lang('lang.price')</label>
                                <input type="number" name="price" step="0.01"
                                    class="form-control @error('price') is-invalid @enderror" value={{ $package->price }}>
                                @error('price')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{--  discount percentage  --}}
                            <div class="col-md-12">
                                <label class="form-label" for="discount_percentage">@lang('lang.discount_percentage')</label>
                                <input type="number"  name="discount_percentage" value={{ $package->discount_percentage }} step="0.01"
                                    class="form-control @error('discount_percentage') is-invalid @enderror">
                                @error('discount_percentage')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{--  start date  --}}
                            <div class="col-md-12">
                                <label class="form-label" for="start_date">@lang('lang.start_date')</label>
                                <input type="date" name="start_date" value="{{$package->start_date}}" class="form-control @error('start_date') is-invalid @enderror">
                                @error('start_date')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{--  end date  --}}
                            <div class="col-md-12">
                                <label class="form-label" for="end_date">@lang('lang.end_date')</label>
                                <input type="date" name="end_date" value="{{$package->end_date}}" class="form-control @error('end_date') is-invalid @enderror">
                                @error('end_date')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{--status  --}}
                            <div class="col-md-12 d-flex my-3">
                                <div class="col-form-label col-3">{{ __('lang.status') }}</div>
                                <select id="status" name="center_id" class="form-select form-control-sm digits @error('price') is-invalid @enderror">
                                    <option value="{{\App\Enum\PackageStatusEnum::APPROVED}}" {{$package->status == \App\Enum\PackageStatusEnum::APPROVED ? 'selected' : ''}}>{{ __('lang.approved') }}</option>
                                    <option value="{{\App\Enum\PackageStatusEnum::REJECTED}}" {{$package->status == \App\Enum\PackageStatusEnum::REJECTED ? 'selected' : ''}}>{{ __('lang.cancel') }}</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- package image --}}
                            <div class="card  col-md-12">
                                <div class="card-header py-4">
                                    <h6>{{ __('lang.package_image') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12 d-flex">
                                        <label class="form-label col-3" for="image">{{ trans('lang.image') }}</label>
                                            <input name="image" class="form-control image @error('image') is-invalid @enderror"
                                                id="image" type="file">
                                            @error('image')
                                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                            @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <img src="{{$package->attachments->first() !== null ? asset($package->attachments->first()->path."\\".$package->attachments->first()->filename) : asset('/uploads/packages/default.png')}}" style="width: 500px" class="img-thumbnail image-preview " alt="">
                                    </div>
                                </div>
                            </div>

                            {{-- is_active --}}
                            <div class="media my-2">
                                <label class="col-form-label m-r-10">{{ __('lang.status') }}</label>
                                <div class="media-body  icon-state">
                                    <label class="switch">
                                        <input type="checkbox" name="is_active"
                                            {{ $package->is_active == 1 ? 'checked' : '' }}><span
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
