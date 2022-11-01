@extends('layouts.simple.master')

@section('title', trans('lang.categories'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.categories') }}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{route('home')}}">{{ trans('lang.dashboard') }}</a></li>
<li class="breadcrumb-item active"><a href="{{route('categories.index')}}">{{ trans('lang.categories') }}</a></li>
<li class="breadcrumb-item active">{{ trans('lang.edit') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">           
                        <form class="needs-validation" novalidate="" enctype="multipart/form-data"  action="{{ route('categories.update',$category) }}" method="post" >
                            @csrf
                            @method('put')

                                <div class="col-md-12">
                                    <label class="form-label" for="name_ar">{{ trans('lang.name_ar') }}</label>
                                    <input name="name[ar]"   value={{ $category->getTranslation('name', 'ar') }} class="form-control @error('name.ar') is-invalid @enderror"
                                        id="name_ar" type="text" required>
                                    @error('name.ar')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label mt-3" for="name_en">{{ trans('lang.name_en') }}</label>
                                    <input name="name[en]" value={{ $category->getTranslation('name', 'en') }} class="form-control @error('name.en') is-invalid @enderror"
                                        id="name_en" type="text" required>
                                    @error('name.en')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="media my-3">
                                    <label class="col-form-label m-r-10">{{ __('lang.is_active') }}</label>
                                    <div class="media-body  icon-state">
                                        <label class="switch">
                                            <input type="checkbox" name="is_active"
                                                {{ $category->is_active == 1 ? 'checked' : '' }}><span
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