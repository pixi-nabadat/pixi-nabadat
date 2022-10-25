@extends('layouts.simple.master')
@section('title', trans('lang.countries'))

@section('breadcrumb-title')
<h3>{{ trans('lang.countries') }}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item"><a href="{{route('home')}}">{{trans('lang.dashboard')}}</a></li>
<li class="breadcrumb-item">{{trans('lang.countries')}}</li>
@endsection

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
                <div class="card-header">
					<a role="button" class="btn btn-success" href="{{ route('country.create')}}"><i class="fa fa-plus-circle"></i> {{ trans('lang.add_country')}}</a>
				</div>
				<div class="card-body">
					{!! $dataTable->table(['width' => '100%','class'=>'table table-striped table-bordered']) !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
{!! $dataTable->scripts() !!}
@endsection
