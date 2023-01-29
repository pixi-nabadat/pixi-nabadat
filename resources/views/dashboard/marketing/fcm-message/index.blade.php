@extends('layouts.simple.master')

@section('title', trans('lang.fcm_message'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.fcm_message') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.fcm_message') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">
                   <div class="card-header">
                       <h5><a role="button" class="btn btn-success " href={{ route('fcm-messages.create') }}>
                            <i class="fa fa-plus-circle"></i>{{ trans('lang.fcm_message') }}</a>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table">
                            {!! $dataTable->table() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Zero Configuration  Ends-->
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection

@section('script')
    {!! $dataTable->scripts() !!}
@endsection