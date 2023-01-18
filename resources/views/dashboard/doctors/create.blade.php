@extends('layouts.simple.master')

@section('title', trans('lang.doctors'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.doctors') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.doctors') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" class="needs-validation"  enctype="multipart/form-data" novalidate="" action="{{ route('doctors.store') }}">
                            @csrf
                            <div class="row g-3">
                                {{--centers  --}}
                                <div class="col-md-6">
                                    <div class="col-form-label col-3">{{ __('lang.centers') }}</div>
                                    <select id="center_id" name="center_id" class="js-example-basic-single col-sm-12">
                                        <option></option>
                                        @foreach ($centers as $center)
                                            <option value="{{ $center->id }}">{{ $center->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="name">{{ trans('lang.name') }}</label>
                                    <input name="name" class="form-control @error('name') is-invalid @enderror"
                                        id="name" type="text" required>
                                    @error('name')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                


                                <div class="col-md-6">
                                    <label class="form-label" for="phone">{{ trans('lang.phone') }}</label>
                                    <input class="form-control  @error('phone') is-invalid @enderror" name="phone"
                                        id="phone" type="text" required="">
                                    @error('phone')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="age">{{ trans('lang.age') }}</label>
                                    <input class="form-control  @error('age') is-invalid @enderror" name="age"
                                        id="age" type="text" required="">
                                    @error('age')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label my-2"
                                        for="description">{{ trans('lang.description') }}</label>
                                    <input name="description"
                                        class="form-control  @error('description') is-invalid @enderror" id="description"
                                        type="text">
                                    @error('address')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label my-2"
                                        for="logo">{{ trans('lang.logo') }}</label>
                                    <input name="logo"
                                        class="form-control  @error('logo') is-invalid @enderror" id="logo"
                                        type="file">
                                    @error('logo')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <button class="btn btn-primary" type="submit">{{ trans('lang.submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $("#select_city").find("option:gt(0)").hide();
        $("#select_governorate").change(function (){
            $("#select_city").find("option:gt(0)").hide();
            $(".city_"+$(this).val()).show();
        });
    });
</script>
@endsection
