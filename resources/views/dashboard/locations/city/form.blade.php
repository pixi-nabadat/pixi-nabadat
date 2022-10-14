@extends('layouts.simple.master')
@section('title', 'Validation Forms')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>City Form</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">City Form</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<form class="needs-validation" novalidate="" method="POST" action="/city/store" >
                        @csrf
						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="validationCustom01">Slug</label>
								<input name="slug" class="form-control @error('slug') is-invalid @enderror" id="validationCustom01" type="text" placeholder="Slug" required="">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
							</div>
                            <div class="col-md-6 mb-3">
								<label for="validationCustom02"> {{trans("lang.ARABIC_TITLE")}}</label>
								<input name="title_ar" class="form-control @error('title_ar') is-invalid @enderror" id="validationCustom02" type="text" placeholder="Arabic Title" required="">
                                @error('title_ar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
							</div>
							<div class="col-md-6 mb-3">
								<label for="validationCustom02">{{trans("lang.ENGLISH_TITLE")}}</label>
								<input name="title_en" class="form-control @error('title_en') is-invalid @enderror" id="validationCustom02" type="text" placeholder="English Title" required="">
								@error('title_en')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
							</div>
                            <div class="mb-2">
                                <div class="col-form-label">{{trans("lang.Choose_Governorate")}}</div>
                                <select name="parent_id" class="js-example-placeholder-multiple col-sm-12 @error('parent_id') is-invalid @enderror" multiple="multiple">
                                    @foreach ($governates as $governate)
                                    <option value="{{$governate->id}}">{{$governate->title}}</option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                  <div class="checkbox p-0">
                                    <input class="form-check-input" name="is_active" id="invalidCheck" type="checkbox" value="1" required="">
                                    <label class="form-check-label" for="invalidCheck">{{trans("lang.IS_Active")}}</label>
                                  </div>
                                  <div class="invalid-feedback">You must agree before submitting.</div>
                                </div>
                            </div>
                        </div>
						<button class="btn btn-primary" type="submit">{{trans("lang.ADD_City")}}</button>
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
