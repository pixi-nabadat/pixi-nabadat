@extends('layouts.simple.master')
@section('title', 'Validation Forms')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Country Form</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">Governorate Form</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>ADD Governorate</h5>
				</div>
				<div class="card-body">
					<form class="needs-validation" novalidate="" method="POST" action="{{route('update.governorate',['id' => $governorate->id])}}" >
                        @csrf
						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="validationCustom01">Slug</label>
								<input name="slug" value="{{$governorate->slug}}" class="form-control @error('slug') is-invalid @enderror" id="validationCustom01" type="text" placeholder="Slug" required="">
								@error('slug')
                                     <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
							</div>
                            <div class="col-md-6 mb-3">
								<label for="validationCustom02"> {{__("TITLE")}}</label>
								<input name="title_en" value="{{$governorate->title_translations['en']}}" class="form-control  @error('title_en') is-invalid @enderror" id="validationCustom02" type="text" placeholder="{{__('TITLE')}}" required="">
								@error('title_en')
                                     <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
							</div>
                            <div class="col-md-6 mb-3">
								<label for="validationCustom02"> {{__("ARABIC_TITLE")}}</label>
								<input name="title_ar" value="{{$governorate->title_translations['ar']}}" class="form-control @error('title_en') is-invalid @enderror" id="validationCustom02" type="text" placeholder="{{__('ARABIC_TITLE')}}" required="">
								@error('title_ar')
                                <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
							</div>
                            <div class="mb-2">
                                <div class="col-form-label">Choose Country</div>
                                <select name="parent_id" value={{$governorate->title}} class="js-example-placeholder-multiple col-sm-12 @error('title_en') is-invalid @enderror" multiple="multiple">
                                    @foreach ($countries as $country)
                                    <option value="{{$country->id}}">{{$country->title}}</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                            </div>
						</div>
						<button class="btn btn-primary" type="submit">ADD Governorate</button>
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
