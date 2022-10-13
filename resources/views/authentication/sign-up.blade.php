@extends('layouts.authentication.master')
@section('title', 'Sign-up-two')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
@endsection

@section('style')
    <style>
        .login-main
        {
            width: 750px !important;
        }
    </style>
@endsection

@section('content')
<div class="container-fluid p-0">
  <div class="row m-0">
    <div class="col-xl-5 p-0"><img class="bg-img-cover bg-center" src="{{asset('assets/images/login/1.jpg')}}" alt="looginpage"></div>
    <div class="col-xl-7 p-0">
      <div class="login-card">
        <div>
          <div><a class="logo" href="#"><img class="img-fluid for-light" src="{{asset('assets/images/logo/login.png')}}" alt="looginpage"><img class="img-fluid for-dark" src="{{asset('assets/images/logo/logo_dark.png')}}" alt="looginpage"></a></div>
          <div class="login-main">
            <form action="{{route('sign-up')}}" method="post" role="form" class="theme-form">
                @csrf
                <h4>{{__('lang.create_account')}}</h4>
                <p>{{__('lang.enter_register_data')}}</p>

                <div class="form-group">
                    <label class="col-form-label">{{__('lang.name')}}</label>
                    <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" required/>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label">{{__('lang.email')}}</label>
                    <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" required placeholder="Test@gmail.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label">{{__('lang.password')}}</label>
                    <input class="form-control @error('password') is-invalid @enderror" type="password" min="6" name="password" required
                           placeholder="*********">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label">{{__('lang.confirm_password')}}</label>
                    <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" min="6" name="password_confirmation" required
                           placeholder="*********">
                    @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label">{{__('lang.phone')}}</label>
                    <input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" required>
                    @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="col-form-label">{{__('lang.data_of_birth')}}</label>
                    <div class="input-group">
                        <input name="date_of_birth" class="datepicker-here form-control digits @error('date_of_birth') is-invalid @enderror" type="text"
                               data-language="en">
                    </div>
                    @error('date_of_birth')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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
                        <div class="col-form-label">{{__('lang.cities')}}</div>
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


              <div class="form-group mb-0">
                <button class="btn btn-primary btn-block" type="submit">Create Account</button>
              </div>
{{--              <h6 class="text-muted mt-4 or">Or signup with</h6>--}}
{{--              <div class="social mt-4">--}}
{{--                <div class="btn-showcase"><a class="btn btn-light" href="https://www.linkedin.com/login" target="_blank"><i class="txt-linkedin" data-feather="linkedin"></i> LinkedIn </a><a class="btn btn-light" href="https://twitter.com/login?lang=en" target="_blank"><i class="txt-twitter" data-feather="twitter"></i>twitter</a><a class="btn btn-light" href="https://www.facebook.com/" target="_blank"><i class="txt-fb" data-feather="facebook"></i>facebook</a></div>--}}
{{--              </div>--}}
              <p class="mt-4 mb-0">Already have an account?<a class="ms-2" href="{{ route('login') }}">Sign in</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
    <script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
    <script src="{{asset('assets/js/datepicker/date-picker/datepicker.js')}}"></script>
    <script src="{{asset('assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
    <script src="{{asset('assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
@endsection
