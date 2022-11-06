@extends('layouts.simple.master')
@section('title', 'Validation Forms')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>{{trans('lang.countries')}}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{{trans('lang.dashboard')}}</li>
    <li class="breadcrumb-item active">{{trans('lang.countries')}}</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>{{trans("lang.Edit_Country")}}</h5>
				</div>
				<div class="card-body">
					<form class="needs-validation" novalidate="" method="POST" action="{{route('country.update',['country' => $country->id])}}" >
                        @csrf
                        @method('PUT')
						<div class="row">
                            <div class="col-md-6 mb-3">
								<label for="validationCustom01">{{trans('lang.Slug')}}</label>
								<input name="slug" value="{{$country->slug}}" class="form-control" id="validationCustom01" type="text" placeholder="Slug" required="">
								<div class="valid-feedback">Looks good!</div>
							</div>
                            <div class="col-md-6 mb-3">
								<label for="validationCustom02"> {{trans("lang.title_ar")}}</label>
								<input name="title[ar]" value="{{$country->getTranslation('title','ar')}}" class="form-control @error('title.ar') is-invalid @enderror" id="validationCustom02" type="text" placeholder="Arabic Title" required="">
                                @error('title.ar')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
							<div class="col-md-6 mb-3">
								<label for="validationCustom02">{{trans("lang.title_en")}}</label>
								<input name="title[en]" value="{{$country->getTranslation('title','en')}}" class="form-control @error('title.en') is-invalid @enderror" id="validationCustom02" type="text" placeholder="English Title" required="">
								@error('title.en')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
                            <div class="col-md-6 mb-3">
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
						</div>
						<button class="btn btn-primary" type="submit">ADD country</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
@endsection