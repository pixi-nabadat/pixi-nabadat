@extends('layouts.errors.master')
@section('title', 'Error 404')

@section('css')
@endsection

@section('style')
@endsection


@section('content')
<div class="page-wrapper compact-wrapper" id="pageWrapper">
  <!-- error-404 start-->
  <div class="error-wrapper">
    <div class="container"><img class="img-200" src="{{asset('assets/images/referal-images/cons.png')}}" alt="">
      <div class="">
        <h3 class="headline font-danger">{{ trans('lang.user_invitation_code') }}: {{ $referalCode }}</h3>
      </div>
      <div class="col-md-8 offset-md-2">
        <p class="sub-content">Download the app and get more points you can use in purchasing products and more</p>
      </div>
      <div><a class="btn btn-danger-gradien btn-lg" href="{{route('home')}}" target="_blank">Download App</a></div>
    </div>
  </div>
  <!-- error-404 end      -->
</div>
@endsection

@section('script')

@endsection
