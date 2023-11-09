@extends('layouts.simple.master')

@section('title', trans('lang.invoices'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.invoices') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item active"><a href="{{ route('invoices.index') }}">{{ trans('lang.invoices') }}</a></li>
    <li class="breadcrumb-item active">{{ trans('lang.show') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Invoice</h3>
                    </div>
                </div>
            </div>
        <!-- Container-fluid starts-->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice">
                            <div>
                                <div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="media">
                                                <div class="media-left"><img class="media-object img-60" src="{{asset('images/icons/5.png')}}" alt=""></div>
                                                <div class="media-body m-l-20 text-right">
                                                    <h4 class="media-heading">{{config('global.company_name_ar')??trans('lang.company_name')}}</h4>
                                                    <p>{{config('global.primary_phone')??'phone'}}<br><span></span></p>
                                                    <p>{{config('global.primary_phone')??'address'}}<br><span></span></p>
                                                </div>
                                            </div>
                                            <!-- End Info-->
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="text-md-end text-xs-center">
                                                <h4 class="media-heading">{{$invoice->center->user->name}}</h4>
                                                <p><span>{{$invoice->center->user->phone}}</span></p>
                                                <p>{{trans('lang.address')}}:
                                                    <span> {{$invoice->center->address}}</span><br>
                                                </p>
                                            </div>
                                            <!-- End Title-->
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="text-md-end text-xs-center">
                                                <h5>Invoice #<span class="counter">{{$invoice->id}}</span></h5>
                                                <h6 class="media-heading">{{$invoice->status_text}}</h6>
                                                <p>
                                                    Total center amount : {{$invoice->total_center_dues}}
                                                </p>
                                                <p>
                                                    Total center amount : {{$invoice->total_nabadat_dues}}
                                                </p>
                                                <p>{{trans('lang.started_date')}}:
                                                    <span> {{$invoice->created_at}}</span><br>
                                                </p>
                                                @isset($invoice->completed_date)
                                                    <p>{{trans('lang.completed_date')}}:
                                                        <span> {{$invoice->completed_date}}</span><br>
                                                    </p>
                                                @endisset
                                            </div>
                                            <!-- End Title-->
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div>
                                    <div class="table-responsive invoice-table" id="table">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <td>#</td>
                                                    <td>{{trans('lang.num_nabadat')}}</td>
                                                    <td>{{trans('lang.center_dues')}}</td>
                                                    <td>{{trans('lang.company_dues')}}</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @foreach($invoice->transactions as $key =>$transaction)
                                                   <tr>
                                                       <td>{{$key+1}}</td>
                                                       <td>{{$transaction->num_pulses}}</td>
                                                       <td>{{$transaction->center_dues}}</td>
                                                       <td>{{$transaction->nabadat_app_dues}}</td>
                                                   </tr>
                                               @endforeach
                                            <tr>
                                                <td>
                                                    <p>
                                                        Total center amount : {{$invoice->total_center_dues}}
                                                    </p>
                                                    <p>
                                                        Total nabadat amount : {{$invoice->total_nabadat_dues}}
                                                    </p>
                                                    <p>
                                                        Total center cash amount : {{$invoice->center_cash_dues}}
                                                    </p>
                                                    <p>
                                                        Total center credit amount : {{$invoice->center_credit_dues}}
                                                    </p>
                                                    <p>
                                                        Total nabadat cash amount : {{$invoice->nabadat_cash_dues}}
                                                    </p>
                                                    <p>
                                                        Total nabadat credit amount : {{$invoice->nabadat_credit_dues}}
                                                    </p>
                                                </td>

                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- End Table-->
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div>
                                                <p class="legal"><strong>Thank you for your business!</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End InvoiceBot-->
                            </div>
                            {{-- <div class="col-sm-12 text-center mt-3">
                                <a href="{{route('invoices.print',$invoice->id)}}" class="btn btn btn-primary me-2" type="button" data-bs-original-title="" title="">Print</a>
                            </div> --}}
                            <!-- End Invoice-->
                            <!-- End Invoice Holder-->
                            <!-- Container-fluid Ends-->
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
