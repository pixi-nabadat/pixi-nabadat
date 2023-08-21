@extends('layouts.simple.master')
@section('title', trans('lang.centers'))

@section('breadcrumb-title')
<h3>{{ trans('lang.centers') }}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{route('home')}}">{{trans('lang.dashboard')}}</a></li>
<li class="breadcrumb-item">{{trans('lang.centers')}}</li>
@endsection

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<form class="needs-validation datatables_parameters" novalidate="">
						<div class="row g-3">
							<div class="col-md-4">
								<label class="form-label" for="validationCustom01">@lang('lang.featured')</label>
								<select class="form-select" name="featured" id="validationCustom01">
									<option value="" selected>Choose...</option>
									<option value="1">{{ trans('lang.yes') }}</option>
									<option value="0">{{ trans('lang.no') }}</option>
								</select>
							</div>
							<div class="col-md-4">
								<label class="form-label" for="validationCustom01">@lang('lang.auto_service')</label>
								<select class="form-select" name="auto_service" id="validationCustom01">
									<option value="" selected>Choose...</option>
									<option value="1">{{ trans('lang.yes') }}</option>
									<option value="0">{{ trans('lang.no') }}</option>
								</select>
							</div>
							<div class="col-md-4">
								<label class="form-label" for="validationCustom01">@lang('lang.status')</label>
								<select class="form-select" name="is_active" id="validationCustom01">
									<option value="" selected>Choose...</option>
									<option value="1">{{ trans('lang.active') }}</option>
									<option value="0">{{ trans('lang.not_active') }}</option>
								</select>
							</div>
							<div class="col-md-6">
								<div class="col-form-label">{{ trans('lang.choose_governorates') }}</div>
								<select id="change_location" data-filling-name="location_id"
									class="form-select form-control mb-3 @error('parent_id') is-invalid @enderror">
									<option selected>{{ trans('lang.choose_governorates') }}</option>
									@foreach ($governorates as $governorate)
										<option value="{{ $governorate->id }}">{{ $governorate->title }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-6">
								<div class="col-form-label">{{ trans('lang.city') }}</div>
								<select name="location_id"
									class="form-select form-control mb-3 @error('location_id') is-invalid @enderror"
									id="city"></select>
								@error('location_id')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>
							<div class="col-md-4 mb-3">
								<label class="form-label" for="validationCustom02">@lang('lang.primary_phone')</label>
								<input class="form-control" name="primary_phone" id="validationCustom02" type="text" value="">
								<div class="valid-feedback">Looks good!</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								<button class="btn btn-primary search_datatable" type="submit">{{trans('lang.search')}}</button>
								<button class="btn btn-primary reset_form_data" type="button">{{trans('lang.rest')}}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="card">
                <div class="card-header">
					<a role="button" class="btn btn-primary" href="{{ route('centers.create')}}"><i class="fa fa-plus-circle"></i> {{ trans('lang.add_center')}}</a>
				</div>
				<div class="card-body">
					{!! $dataTable->table(['class'=>'table table-data table-striped table-bordered']) !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
{!! $dataTable->scripts() !!}
<script src="{{ asset('assets/js/location.js') }}"></script>
<script src="{{asset('assets/js/datatable-filter.js')}}"></script>
@endsection
