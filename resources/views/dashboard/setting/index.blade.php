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
            
            @can('edit_general_settings')
            <div class="col-sm-6 col-xl-3 xl-50 col-lg-6 box-col-6">
                <a href="{{ route('general.settings') }}">
                    <div class="card social-widget-card">
                        <div class="card-body">
                            <div class="media">
                                <div class="social-font"><img src="{{asset('assets/images/gear.svg')}}" width="35px" alt=""></div>
                                <div class="media-body p-l-15">
                                    <h4>{{trans('lang.general')}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

            </div>
            @endcan

            @can('edit_points_settings')
            <div class="col-sm-6 col-xl-3 xl-50 col-lg-6 box-col-6">
                <a href="{{ route('points.settings') }}">
                    <div class="card social-widget-card">
                        <div class="card-body">
                            <div class="media">
                                <div class="social-font"><img src="{{asset('assets/images/gear.svg')}}" width="35px" alt=""></div>
                                <div class="media-body p-l-15">
                                    <h4>{{trans('lang.points_settings')}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan

            @can('edit_social_media_settings')
            <div class="col-sm-6 col-xl-3 xl-50 col-lg-6 box-col-6">
                <a href="{{ route('social_media.settings') }}">
                    <div class="card social-widget-card">
                        <div class="card-body">
                            <div class="media">
                                <div class="social-font"><img src="{{asset('assets/images/gear.svg')}}" width="35px" alt=""></div>
                                <div class="media-body p-l-15">
                                    <h4>{{trans('lang.social_media')}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

            </div>
            @endcan

            @can('edit_terms_conditions_settings')
            <div class="col-sm-6 col-xl-3 xl-50 col-lg-6 box-col-6">
                <a href="{{route('terms_and_conditions.settings')}}">
                    <div class="card social-widget-card">
                        <div class="card-body">
                            <div class="media">
                                <div class="social-font"><img src="{{asset('assets/images/gear.svg')}}" width="35px" alt=""></div>
                                <div class="media-body p-l-15">
                                    <h4>{{trans('lang.terms_and_condition')}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan

            @can('edit_schedule_fcm_settings')
            <div class="col-sm-6 col-xl-3 xl-50 col-lg-6 box-col-6">
                <a href="{{route('schedule_fcm.settings')}}">
                    <div class="card social-widget-card">
                        <div class="card-body">
                            <div class="media">
                                <div class="social-font"><img src="{{asset('assets/images/gear.svg')}}" width="35px" alt=""></div>
                                <div class="media-body p-l-15">
                                    <h4>{{trans('lang.schedule_fcm')}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan

        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
@section('script')
@endsection
