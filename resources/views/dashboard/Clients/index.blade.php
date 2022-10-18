@extends('layouts.simple.master')

@section('title',trans('lang.clinics'))

@section('breadcrumb-title')
    <h3>{{trans('lang.clinics')}}</h3>
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{trans('lang.dashboard')}}</li>
    <li class="breadcrumb-item active">{{trans('lang.clinics')}}</li>
@endsection

@section('content')


    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Clients</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
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
    <script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    {!! $dataTable->scripts() !!}
@endsection
