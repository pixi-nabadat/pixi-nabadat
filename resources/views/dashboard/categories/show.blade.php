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
                        <form class="needs-validation" novalidate="" action="{{ route('categories.show',$category) }}" method="post" >
                            @csrf
                            @method('put')

                                <div class="col-md-12">
                                    <label class="form-label mt-3" for="name_ar">{{ trans('lang.name_ar') }}</label>
                                    <input name="name[ar]" disabled="true"  class="form-control @error('name_ar') is-invalid @enderror"
                                        id="name_ar" type="text" value={{ $category->getTranslation('name', 'ar') }} required>
                                    @error('name_ar')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label mt-3" for="name_en">{{ trans('lang.name_en') }}</label>
                                    <input name="name[en]" disabled="true" class="form-control @error('name_en') is-invalid @enderror"
                                        id="name_en" type="text"  value={{ $category->getTranslation('name', 'en') }} required>
                                    @error('name_en')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="media my-3">
                                 <label class="col-form-label m-r-10">{{ __('lang.is_active') }}</label>
                                 <div class="media-body  icon-state">
                                     <label class="switch">
                                         <input type="checkbox" disabled="true" name="is_active"
                                             {{ $category->is_active == 1 ? 'checked' : '' }}><span
                                             class="switch-state"></span>
                                     </label>
                                 </div>
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