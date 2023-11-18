@extends('layouts.simple.master')

@section('title', trans('lang.rates'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.rates') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{route('home')}}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{route('rates.index')}}">{{ trans('lang.rates') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.show') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            {{--  user name  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3" for="unit_price">@lang('lang.user_name')</label>
                                <p class="form-control">{{ $rate->user->name }}</p>
                            </div>
                            {{--  ratable name  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3" for="unit_price">@lang('lang.ratable_name')</label>
                                <p class="form-control">{{ $rate->ratable_type == App\Models\CenterDevice::class ? $rate->ratable->device->name:$rate->ratable->getTranslation('name', app()->getLocale()) }}</p>
                            </div>
                            {{--  comment  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3" for="unit_price">@lang('lang.comment')</label>
                                <p class="form-control">{{ $rate->comment }}</p>
                            </div>
                            {{--  rate number  --}}
                            <div class="col-md-12 d-flex my-3">
                                <label class="form-label col-3" for="unit_price">@lang('lang.rate_number')</label>
                                <p class="form-control">{{ $rate->rate_number }}</p>
                            </div>
                        </div>
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
