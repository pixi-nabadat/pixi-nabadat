@extends('layouts.simple.master')
@section('title', 'Validation Forms')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Governorate Form</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">Governorate Forms</li>
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
					<form class="needs-validation" novalidate="" method="POST" action="{{ route('store.governorate')}}" >
                        @csrf
						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="validationCustom01">{{trans("lang.Slug")}}</label>
								<input name="slug" class="form-control" id="validationCustom01" type="text" placeholder="Slug" required="">
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
                                <div class="col-form-label">Choose Country</div>
                                <select name="parent_id" class="js-example-placeholder-multiple col-sm-12 @error('currency_id') is-invalid @enderror" multiple="multiple">
                                    @foreach ($countries as $country)
                                    <option value="{{$country->id}}">{{$country->title}}</option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                  <div class="checkbox p-0">
                                    <input class="form-check-input" name="is_active" id="invalidCheck" type="checkbox" value="1" required="">
                                    <label class="form-check-label" for="invalidCheck">{{trans("lang.IS_Active")}}</label>
                                  </div>
                                </div>
                            </div>
                        </div>
						<button class="btn btn-primary" type="submit">{{trans("lang.ADD_GOVERNORATE")}}</button>
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
