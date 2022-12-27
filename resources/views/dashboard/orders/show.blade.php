@extends('layouts.simple.master')

@section('title', trans('lang.orders'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.orders') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.orders') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate=""
                            action="{{ route('orders.store') }}">
                            @csrf
                            <div class="row g-3">


                                <div class="card  col-md-8">
                                    <div class="card-header py-4">
                                        <h6 class="card-titel">{{ __('lang.order_items') }}</h6>
                                    </div>
                                    <div class="card-body row">
                                        {{-- items --}}
                                        <div class="col-md-12  my-3">
                                            <table class="table ">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">product_id</th>
                                                        <th scope="col">product_name</th>
                                                        <th scope="col">price</th>
                                                        <th scope="col">quantity</th>
                                                        <th scope="col">discount</th>
                                                        <th scope="col">total</th>
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



                                <div class="card  col-md-3 ms-4">
                                    <div class="card-header py-4 ">
                                        <h6 class="card-titel">{{ __('lang.user_information') }}</h6>
                                    </div>
                                    <div class="card-body row">

                                        {{-- user_id  --}}
                                        <div class="col-md-12 my-3">
                                            <label class="form-label" for="user_id ">{{ trans('lang.user_id ') }}</label>
                                            <p class="form-control" id="user_id "> {{ $order->user_id }} </p>
                                        </div>
                                         {{-- user_name  --}}
                                         <div class="col-md-12 my-3">
                                            <label class="form-label" for="user_id ">{{ trans('lang.user_name ') }}</label>
                                            <p class="form-control" id="user_id "> {{ $order->user->name }} </p>
                                        </div>
                                        {{-- address_info --}}
                                        <div class="col-md-12  my-3">
                                            <label class="form-label" for="address_info">@lang('lang.address_info')</label>
                                            <p class="form-control" id="address_info">{{ $order->address_info }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="card  col-md-12 ms-3">
                                    <div class="card-header py-4">
                                        <h6 class="card-titel">{{ __('lang.payment_information') }}</h6>
                                    </div>
                                    <div class="card-body row">
                                         {{-- payment_status --}}
                                         <div class="col-md-6 my-3">
                                            <label class="form-label"for="payment_status">{{ trans('lang.payment_status') }}</label>
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


                            </div>
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
