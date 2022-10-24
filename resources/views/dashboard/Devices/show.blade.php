@extends('layouts.simple.master')

@section('title', trans('lang.devices'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.devices') }}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{route('home')}}">{{ trans('lang.dashboard') }}</a></li>
<li class="breadcrumb-item active"><a href="{{route('devices.index')}}">{{ trans('lang.devices') }}</a></li>
<li class="breadcrumb-item active">{{ trans('lang.edit') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">           
                        <form class="needs-validation" novalidate="" action="{{ route('devices.show',$device) }}" method="post" >
                            @csrf
                            @method('put')

                                <div class="col-md-12">
                                    <label class="form-label mt-3" for="name_ar">{{ trans('lang.name_ar') }}</label>
                                    <input name="name[ar]" disabled="true"  class="form-control @error('name_ar') is-invalid @enderror"
                                        id="name_ar" type="text" value={{ $device->getTranslation('name', 'ar') }} required>
                                    @error('name_ar')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label mt-3" for="name_en">{{ trans('lang.name_en') }}</label>
                                    <input name="name[en]" disabled="true" class="form-control @error('name_en') is-invalid @enderror"
                                        id="name_en" type="text"  value={{ $device->getTranslation('name', 'en') }} required>
                                    @error('name_en')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label mt-3" for="description_ar">{{ trans('lang.description_ar') }}</label>

                                    <input name="description[ar]" disabled='true'  class="form-control @error('description_ar') is-invalid @enderror"
                                    id="description_ar" type="text" required value={{ $device->getTranslation('description', 'ar') }} >

                                    @error('description_ar')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label mt-3" for="description_en">{{ trans('lang.description_en') }}</label>
                                    <input name="description[en]" disabled="true"  class="form-control @error('description_en') is-invalid @enderror"
                                        id="description_en" type="text" required  value={{ $device->getTranslation('description', 'en') }}>
                                    @error('description_en')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group my-3">
                                    <img src="{{ asset('uploads/device/images/default.png') }}" style="width: 100px" class="img-thumbnail image-preview " alt="">
                                </div>
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
