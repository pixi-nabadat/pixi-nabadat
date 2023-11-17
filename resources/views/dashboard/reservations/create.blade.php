@extends('layouts.simple.master')

@section('title', trans('lang.reservations'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.reservations') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.reservations') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">

        <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate="" action="{{ route('reservations.store') }}">
            @csrf

            <div class="row ">

                <div class="col-md-12">

                    {{-- reservation_information --}}
                    <div class="card  col-md-12">
                        <div class="card-header py-4">
                            <h6 class="card-titel">{{ __('lang.reservation_information') }}</h6>
                        </div>
                        <div class="card-body row">
                                {{--centers  --}}
                                <div class="col-md-12 mt-3">
                                    <div class="form-label">{{ __('lang.center') }}</div>
                                    <select id="center_id" name="center_id" class="js-example-basic-single col-sm-12">
                                        <option selected disabled>...</option>
                                        @foreach ($centers as $center)
                                            <option value="{{ $center->id }}">{{ $center->user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('center_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{--users  --}}
                                <div class="col-md-12 mt-3">
                                    <div class="form-label">{{ __('lang.user') }}</div>
                                    <select id="customer_id" name="customer_id" class="js-example-basic-single col-sm-12">
                                        <option selected disabled>...</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{--  check_date  --}}
                                <div class="col-md-12 mt-3">
                                    <label class="form-label" for="check_date">@lang('lang.check_date')</label>
                                    <input type="date" name="check_date" step="0.01"
                                        class="form-control @error('check_date') is-invalid @enderror">
                                    @error('check_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                        </div>
                    </div>

                </div>

                <div class="btn-toolbar float-right mb-3" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group" aria-label="Third group">
                        <button class="btn btn-primary my-3" type="submit">{{ trans('lang.submit') }}</button>
                    </div>
                </div>
            </div>

        </form>

    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')

@endsection