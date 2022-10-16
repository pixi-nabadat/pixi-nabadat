@extends('layouts.simple.master')

@section('title',trans('lang.clinics'))

@section('breadcrumb-title')
    <h3>{{trans('lang.clinics')}}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{trans('lang.dashboard')}}</li>
    <li class="breadcrumb-item active">{{trans('lang.clinics')}}</li>
    <li class="breadcrumb-item active">{{trans('lang.add')}}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" class="needs-validation" novalidate="">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="clinic_name">{{trans('lang.full_clinic_name')}}</label>
                                    <input name="name" class="form-control @error('name') is-invalid @enderror" id="clinic_name" type="text" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="clinic_phones">{{trans('lang.phone')}}</label>
                                    <input class="form-control  @error('phones') is-invalid @enderror" name="phones[]" id="clinic_phones" type="text" required="">
                                    @error('phones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="clinic_address">{{trans('lang.clinic_address')}}</label>
                                    <input name="address" class="form-control  @error('address') is-invalid @enderror" id="clinic_address" type="text" placeholder="City" required="">
                                    @error('address')
                                     <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="validationCustom04">{{trans('lang.doctors')}}</label>
                                    <div class="form-group">
                                        <div class="mb-2">
                                            <div class="col-form-label">{{__('lang.governorates')}}</div>
                                            <select name="doctor_id" id="select_doctor" class="js-example-basic-single col-sm-12">
                                                <option value="AL">Alabama</option>
                                                <option value="WY">Wyoming</option>
                                                <option value="WY">Peter</option>
                                                <option value="WY">Hanry Die</option>
                                                <option value="WY">John Doe</option>
                                            </select>
                                        </div>
                                        @error('doctor_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="mb-2">
                                            <div class="col-form-label">{{__('lang.governorates')}}</div>
                                            <select id="select_governorate" class="js-example-basic-single col-sm-12">
                                                <option value="AL">Alabama</option>
                                                <option value="WY">Wyoming</option>
                                                <option value="WY">Peter</option>
                                                <option value="WY">Hanry Die</option>
                                                <option value="WY">John Doe</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="mb-2">
                                            <label  class="col-form-label" for="select_city">{{__('lang.cities')}}</label>
                                            <select id="select_city" name="location_id" class="js-example-basic-single col-sm-12 @error('location_id') is-invalid @enderror">

                                                <option value="AL">Alabama</option>
                                                <option value="WY">Wyoming</option>
                                                <option value="WY">Peter</option>
                                                <option value="WY">Hanry Die</option>
                                                <option value="WY">John Doe</option>

                                            </select>
                                        </div>
                                        @error('location_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
{{--                                map html herer --}}
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <div class="checkbox p-0">
                                        <input class="form-check-input" id="invalidCheck" type="checkbox" required="">
                                        <label class="form-check-label" for="invalidCheck">{{trans('lang.is_active')}}</label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary" type="submit">{{trans('lang.submit')}}</button>
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
