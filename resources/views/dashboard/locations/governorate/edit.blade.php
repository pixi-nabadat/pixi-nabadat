@extends('layouts.simple.master')
@section('title', 'Validation Forms')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>{{trans('lang.governorates')}}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{{trans('lang.dashboard')}}</li>
    <li class="breadcrumb-item active">{{trans('lang.governorates')}}</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>{{trans("lang.edit_governorate")}}</h5>
				</div>
				<div class="card-body">
					<form class="needs-validation" novalidate="" method="POST" action="{{route('governorate.update',['governorate' => $governorate->id])}}" >
                        @csrf
                        @method('PUT')
						<div class="row">
                            <div class="col-md-6 mb-3">
								<label for="validationCustom01">{{trans('lang.slug')}}</label>
								<input name="slug" value="{{$governorate->slug}}" class="form-control" id="validationCustom01" type="text" placeholder="Slug" required="">
								@error('slug')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
                            <div class="col-md-6 mb-3">
								<label for="validationCustom02">{{trans("lang.title_ar")}}</label>
								<input name="title[ar]" value="{{$governorate->getTranslation('title','ar')}}" class="form-control @error('title.ar') is-invalid @enderror" id="validationCustom02" type="text" placeholder="English Title" required="">
								@error('title.ar')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
							<div class="col-md-6 mb-3">
								<label for="validationCustom02">{{trans("lang.title_en")}}</label>
								<input name="title[en]" value="{{$governorate->getTranslation('title','en')}}" class="form-control @error('title.en') is-invalid @enderror" id="validationCustom02" type="text" placeholder="English Title" required="">
								@error('title.en')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
                            <div class="col-md-6 mb-3">
                                <div class="col-form-label">Choose Country</div>
                                <select name="parent_id"  class="js-example-placeholder-multiple col-sm-12 @error('title_en') is-invalid @enderror" multiple="multiple">
                                    @foreach ($countries as $country)
                                    <option value="{{$country->id}}">{{$country->title}}</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
						</div>
						<button class="btn btn-primary" type="submit">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
@endsection

