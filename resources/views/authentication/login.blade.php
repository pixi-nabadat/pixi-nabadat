@extends('layouts.authentication.master')
@section('title', 'Login-two')

@section('css')
@endsection

@section('style')
@endsection

@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-xl-5"><img class="bg-img-cover bg-center" src="{{asset('assets/images/login/3.jpg')}}" alt="looginpage"></div>
      <div class="col-xl-7 p-0">
         <div class="login-card">
            <div>
               <div><a class="logo text-start" href="index.html"><img class="img-fluid for-light" src="{{asset('assets/images/logo/login.png')}}" alt="looginpage"><img class="img-fluid for-dark" src="{{asset('assets/images/logo/logo_dark.png')}}" alt="looginpage"></a></div>
               <div class="login-main">
                  <form action="{{route('login')}}" method="post" role="form" class="theme-form">
                      @csrf
                     <h4>{{__('lang.Sign_in_to_account')}}</h4>
                     <p>{{__('lang.enter_your_credential')}}</p>
                     <div class="form-group">
                        <label class="col-form-label">{{__('lang.email_or_phone')}}</label>
                        <input class="form-control @error('identifier') is-invalid @enderror" name="identifier" type="text" required placeholder="Test@gmail.com">
                        @error('identifier')
                            <div class="invalid-feedback">{{ $message }}</div>
                         @enderror
                     </div>
                     <div class="form-group">
                        <label class="col-form-label">{{__('lang.password')}}</label>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required placeholder="*********">
                         @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                         @enderror
{{--                         <div class="show-hide"><span class="show"></span></div>--}}
                     </div>
                     <div class="form-group mb-0">
                        <div class="checkbox p-0">
                           <input id="checkbox1" type="checkbox">
                           <label class="text-muted" for="checkbox1">{{__('lang.remember_password')}}</label>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">{{__('lang.sign_in')}}</button>
                     </div>
                     <p class="mt-4 mb-0">{{__('lang.create_account')}}<a class="ms-2" href="{{ route('sign-up') }}">{{__('lang.create_account')}}</a></p>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
    @include('layouts.included.toast')
@endsection
