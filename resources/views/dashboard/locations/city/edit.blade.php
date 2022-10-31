@extends('layouts.simple.master')
@section('title', 'Validation Forms')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>{{trans('lang.cities')}}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{{trans('lang.dashboard')}}</li>
    <li class="breadcrumb-item active">{{trans('lang.cities')}}</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>{{trans("lang.Edit_City")}}</h5>
				</div>
				<div class="card-body">
					<form class="needs-validation" novalidate="" method="POST" action="{{route('city.update',['city' => $city->id])}}" >
                        @csrf
                        @method('PUT')
						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="validationCustom01">{{trans('lang.Slug')}}</label>
								<input name="slug" value="{{$city->slug}}" class="form-control" id="validationCustom01" type="text" placeholder="Slug" required="">
								<div class="valid-feedback">Looks good!</div>
							</div>
                            <div class="col-md-6 mb-3">
								<label for="validationCustom02"> {{trans("lang.title_ar")}}</label>
								<input name="title[ar]" value="{{$city->getTranslation('title','ar')}}" class="form-control @error('title.ar') is-invalid @enderror" id="validationCustom02" type="text" placeholder="Arabic Title" required="">
                                @error('title.ar')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
							<div class="col-md-6 mb-3">
								<label for="validationCustom02">{{trans("lang.title_en")}}</label>
								<input name="title[en]" value="{{$city->getTranslation('title','en')}}" class="form-control @error('title.en') is-invalid @enderror" id="validationCustom02" type="text" placeholder="English Title" required="">
								@error('title.en')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
                            <div class="col-md-6 mb-3">
                                <div class="col-form-label">Choose Governorate</div>
                                <select name="parent_id"  class="js-example-placeholder-multiple col-sm-12" multiple="multiple">
                                    @foreach ($governorates as $governate)
                                    <option value="{{$governate->id}}">{{$governate->title}}</option>
                                    @endforeach
                                </select>
                            </div>
						</div>
						<button class="btn btn-primary" type="submit">ADD City</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/form-validation-custom.js')}}"></script>
<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
@endsection
