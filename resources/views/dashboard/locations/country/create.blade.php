@extends('layouts.simple.master')
@section('title', trans('lang.countries'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.countries') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{route('home')}}">{{trans('lang.dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('country.index')}}">{{trans('lang.countries')}}</a></li>
    <li class="breadcrumb-item">{{trans('lang.add')}}</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<form class="needs-validation" novalidate="" method="post" action="{{route('country.store')}}" >
                        @csrf
						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="validationCustom01">Slug</label>
								<input name="slug" class="form-control @error('slug') is-invalid @enderror" id="validationCustom01" type="text" placeholder="Slug" required="">
                                @error('slug')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
                            <div class="col-md-6 mb-3">
								<label for="validationCustom02"> {{trans("lang.title_ar")}}</label>
								<input name="title[ar]" class="form-control @error('title.ar') is-invalid @enderror" id="validationCustom02" type="text" placeholder="Arabic Title" required="">
                                @error('title.ar')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
							<div class="col-md-6 mb-3">
								<label for="validationCustom02">{{trans("lang.title_en")}}</label>
								<input name="title[en]" class="form-control @error('title.en') is-invalid @enderror" id="validationCustom02" type="text" placeholder="English Title" required="">
								@error('title.en')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>

                            <div class="col-md-6 mb-3">
                                <div class="col-form-label">{{trans("lang.Choose_Currency")}}</div>
                                <select name="currency_id" class="js-example-placeholder-multiple col-sm-12 @error('currency_id') is-invalid @enderror" multiple="multiple">
                                    @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                    @endforeach
                                </select>
                                @error('currency_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                            </div>

                            <div class="mb-3">
                                <div class="media mb-2">
                                    <label class="col-form-label m-r-10">{{trans('lang.is_active')}}</label>
                                    <div class="media-body  icon-state">
                                        <label class="switch">
                                            <input type="checkbox" name="is_active" value="1" checked=""><span class="switch-state"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
						<button class="btn btn-primary" type="submit">{{trans("lang.submit")}}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

