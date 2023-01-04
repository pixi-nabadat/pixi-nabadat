@extends('layouts.simple.master')

@section('title', trans('lang.order'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.order') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.order') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">

                            {{-- user_information --}}
                            <div class="card  col-md-4">
                                <div class="card-header py-4 text-white bg-dark">
                                    <h6 class="card-titel">{{ __('lang.user_information') }}</h6>
                                </div>
                                <div class="card-body row">
                                    {{-- user_name  --}}
                                    <div class="col-md-12 ">
                                        <label class="form-label" for="user_name ">{{ trans('lang.user_name ') }}</label>
                                        <p class="form-control" id="user_name "> {{ $order->user->name }} </p>
                                    </div>
                                    {{-- user_phone  --}}
                                    <div class="col-md-12 ">
                                        <label class="form-label" for="user_phone ">{{ trans('lang.user_phone ') }}</label>
                                        <p class="form-control" id="user_phone"> {{ $order->user->phone }} </p>
                                    </div>
                                    {{-- address_info --}}
                                    <div class="col-md-12  my-3">
                                        <label class="form-label" for="address_info">@lang('lang.address_info')</label>
                                        {{-- <p class="form-control" id="address_info">{{ $order->address_info->adderss }}</p> --}}
                                    </div>
                                </div>
                            </div>
                            {{-- payment_information --}}
                            <div class="card  col-md-7 ms-4">
                                <div class="card-header py-4 text-white bg-dark">
                                    <h6 class="card-titel">{{ __('lang.payment_information') }}</h6>
                                </div>
                                <div class="card-body row">
                                    {{-- payment_status --}}
                                    <div class="col-md-6 my-3">
                                        <label
                                            class="form-label"for="payment_status">{{ trans('lang.payment_status') }}</label>
                                        <p class="form-control" id="payment_status">{{ $order->payment_status }}</p>
                                    </div>
                                    {{-- payment_type --}}
                                    <div class="col-md-6  my-3">
                                        <label class="form-label" for="payment_type">@lang('lang.payment_type')</label>
                                        <p class="form-control" id="payment_type">{{ $order->payment_type }}</p>
                                    </div>

                                    {{-- shipping_fees --}}
                                    <div class="col-md-6  my-3">
                                        <label class="form-label" for="shipping_fees">@lang('lang.shipping_fees')</label>
                                        <p class="form-control" id="shipping_fees">{{ $order->shipping_fees }}</p>
                                    </div>
                                    {{-- sub_total --}}
                                    <div class="col-md-6  my-3">
                                        <label class="form-label" for="sub_total">@lang('lang.sub_total')</label>
                                        <p class="form-control" id="sub_total">{{ $order->sub_total }}</p>
                                    </div>

                                    {{-- grand_total --}}
                                    <div class="col-md-6  my-3">
                                        <label class="form-label" for="grand_total">@lang('lang.grand_total')</label>
                                        <p class="form-control" id="grand_total">{{ $order->grand_total }}</p>
                                    </div>

                                    {{-- coupon_discount --}}
                                    <div class="col-md-6  my-3">
                                        <label class="form-label" for="coupon_discount">@lang('lang.coupon_discount')</label>
                                        <p class="form-control" id="coupon_discount">{{ $order->coupon_discount }}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- order_items --}}
                            <div class="card  col-md-11">
                                <div class="card-header  text-white bg-dark py-4">
                                    <h6 class="card-titel">{{ __('lang.order_items') }}</h6>
                                </div>
                                <div class="card-body row">
                                    {{-- items --}}
                                    <div class="col-md-12  my-3">
                                        <table class="table table-striped ">
                                            <thead class="">
                                                <tr>
                                                    <th scope="col">{{ __('lang.product_id') }}</th>
                                                    <th scope="col">{{ __('lang.product_name') }}</th>
                                                    <th scope="col">{{ __('lang.price') }}</th>
                                                    <th scope="col">{{ __('lang.quantity') }}</th>
                                                    <th scope="col">{{ __('lang.discount') }}</th>
                                                    <th scope="col">{{ __('lang.total') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->items as $item)
                                                    <tr>
                                                        <td>{{ $item->product_id }}</td>
                                                        <td>{{ $item->product->name }}</td>
                                                        <td>{{ $item->price }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ $item->discount }}</td>
                                                        <td>{{ $item->price * $item->quantity }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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

@endsection
