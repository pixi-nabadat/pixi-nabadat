@extends('layouts.simple.master')
@section('title', 'Validation Forms')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>{{trans('lang.Country_Form')}}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">{{trans('lang.Country_Form')}}</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>{{trans('lang.ADD_COUNTRY')}}</h5>
				</div>
				<div class="card-body">
					<form class="needs-validation" novalidate="" method="POST" action="{{route('store.country')}}" >
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
								<div class="valid-feedback">Looks good!</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="validationCustom02">{{trans("lang.ENGLISH_TITLE")}}</label>
								<input name="title_en" class="form-control @error('title_en') is-invalid @enderror" id="validationCustom02" type="text" placeholder="English Title" required="">
                                @error('title_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
							</div>
                            <div class="mb-2">
                                <div class="col-form-label">{{trans("lang.Choose_Currency")}}</div>
                                <select name="currency_id" class="js-example-placeholder-multiple col-sm-12 @error('currency_id') is-invalid @enderror" multiple="multiple">
                                    {{-- @foreach ($currencies as $currency) --}}
                                    <option value="1">£EGP</option>
                                    <option value="2">$US</option>
                                    <option value="3">€EUR</option>
                                    <option value="4">﷼SAR</option>
                                    {{-- @endforeach --}}
                                </select>
                                @error('currency_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                  <div class="checkbox p-0">
                                    <input class="form-check-input" name="is_active" id="invalidCheck" type="checkbox" value="1"  required="">
                                    <label class="form-check-label" for="invalidCheck">{{trans("lang.IS_Active")}}</label>
                                  </div>
                                  <div class="invalid-feedback">You must agree before submitting.</div>
                                </div>
                            </div>
						</div>
						<button class="btn btn-primary" type="submit">{{trans("lang.ADD_COUNTRY")}}</button>
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
