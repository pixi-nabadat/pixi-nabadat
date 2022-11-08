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
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label mt-3" for="name_en">{{ trans('lang.name_en') }}</label>
                                    <input name="name[en]" disabled="true" class="form-control @error('name_en') is-invalid @enderror"
                                        id="name_en" type="text"  value={{ $category->getTranslation('name', 'en') }} required>
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


                             <div class="col-md-12">
                                <div class="row">
                                    @if($category->attachments->count())
                                        @foreach($category->attachments as $attachment)
                                            <div class="col-md-3 col-lg-3 col-sm-12">
                                                <div class="img-container">
                                                    <div class="form-group my-3">
                                                        <img src="{{asset($attachment->path.'/'.$attachment->filename)}}" style="width: 150px;height: 150px" class="img-thumbnail image" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
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