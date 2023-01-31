@extends('layouts.simple.master')

@section('title', trans('lang.roles'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.roles') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.roles') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <form method="post" class="needs-validation" novalidate="" action="{{ route('roles.store') }}">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label" for="name">{{ trans('lang.name') }}</label>
                                    <input name="name" class="form-control @error('name') is-invalid @enderror"
                                        id="name" type="text" required>
                                    @error('name')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            
                            <button class="btn btn-primary my-3" type="submit">{{ trans('lang.submit') }}</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')

@endsection
