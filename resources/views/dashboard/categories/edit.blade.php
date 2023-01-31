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

@section('style')
    <style>
        .img-container {
            position: relative;
            width: 100%;
            max-width: 400px;
        }

        .image {
            display: block;
            width: 100%;
            height: auto;
        }

        .overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            width: 100%;
            opacity: 0;
            transition: .3s ease;
            background-color: #ff5151;
        }

        .img-container:hover .overlay {
            opacity: 1;
        }

        .icon {
            color: white;
            font-size: 50px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .fa-user:hover {
            color: #eee;
        }
    </style>
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

                            {{--type  --}}
                            <div class="col-md-12 d-flex my-3">
                                <div class="col-form-label col-3">{{ __('lang.product_type') }}</div>
                                <select id="type" name="type" class="js-example-basic-single col-sm-12">
                                    <option value="{{\App\Models\Category::USERTYPE}}"   @if($category->getRawOriginal('type') == \App\Models\Category::USERTYPE)selected @endif>{{ __('lang.user') }}</option>
                                    <option value="{{\App\Models\Category::CENTERTYPT}}" @if($category->getRawOriginal('type') == \App\Models\Category::CENTERTYPT)selected @endif>{{ __('lang.center') }}</option>
                                </select>
                            </div>

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
                                    @if($category->attachments->count())
                                        @foreach($category->attachments as $attachment)
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
                                        @endforeach
                                    @endif
                                </div>
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
