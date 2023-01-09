@extends('layouts.simple.master')
@section('title', trans('lang.centers'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.centers') }}</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('centers.index') }}">{{ trans('lang.centers') }}</a></li>
    <li class="breadcrumb-item">{{ trans('lang.add') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-xl-3 col-lg-6">
               <a href="{{ route('general.settings') }}">
                   <div class="card o-hidden static-top-widget-card">
                       <div class="card-body">
                           <div class="media static-top-widget">
                               <div class="media-body">
                                   <h6 class="font-roboto"><i class="fa fa-gears fa-2x p-b-10"></i>{{trans('lang.settings_general')}}</h6>
                               </div>
                           </div>
                       </div>
                   </div>
               </a>
            </div>

            <div class="col-sm-6 col-xl-3 col-lg-6">
                <a href="{{ route('points.settings') }}">
                    <div class="card o-hidden static-top-widget-card">
                        <div class="card-body">
                            <div class="media static-top-widget">
                                <div class="media-body">
                                    <h6 class="font-roboto"><i class="fa fa-gears fa-2x p-b-10"></i>{{trans('lang.points_setting')}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-xl-3 col-lg-6">
                <a href="{{ route('social_media.settings') }}">
                    <div class="card o-hidden static-top-widget-card">
                        <div class="card-body">
                            <div class="media static-top-widget">
                                <div class="media-body">
                                    <h6 class="font-roboto"><i class="fa fa-gears fa-2x p-b-10"></i>{{trans('lang.social_media_settings')}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-xl-3 col-lg-6">
                <a href="{{ route('terms_and_conditions.settings') }}">
                    <div class="card o-hidden static-top-widget-card">
                        <div class="card-body">
                            <div class="media static-top-widget">
                                <div class="media-body">
                                    <h6 class="font-roboto"><i class="fa fa-gears fa-2x p-b-10"></i>{{trans('lang.terms_and_condition_settings')}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
@section('script')
@endsection
