@extends('layouts.simple.master')
@section('title', 'Product Page')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/owlcarousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/rating.css') }}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h3>Product Page</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Country</li>
    <li class="breadcrumb-item active">Coiuntry Details</li>
@endsection

@section('content')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div>
            <div class="row product-page-main p-0">
                <div class="col-xl-4 xl-cs-65 box-col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-slider owl-carousel owl-theme" id="sync1">
                                @if ($center->attachments->count())
                                    @foreach ($center->attachments as $attachment)
                                        <div class="item"><img
                                                src="{{ asset($attachment->path . '/' . $attachment->filename) }}"
                                                alt=""></div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="owl-carousel owl-theme" id="sync2">
                                @if ($center->attachments->count())
                                    @foreach ($center->attachments as $attachment)
                                        <div class="item"><img
                                                src="{{ asset($attachment->path . '/' . $attachment->filename) }}"
                                                alt=""></div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 xl-100 box-col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-page-details">
                                <h3>{{ $center->name }}</h3>
                            </div>
                            <div class="product-price">
                            </div>
                            <ul class="product-color">
                                <li class="bg-primary"></li>
                                <li class="bg-secondary"></li>
                                <li class="bg-success"></li>
                                <li class="bg-info"></li>
                                <li class="bg-warning"></li>
                            </ul>
                            <hr>
                            <p>{{ $center->description }}</p>
                            <hr>
                            <div>
                                <table class="product-page-width">
                                    <tbody>
                                        <tr>
                                            <td> <b>Doctor &nbsp;&nbsp;&nbsp;:</b></td>
                                            <td>ali</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="product-title">share it</h6>
                                </div>
                                <div class="col-md-6">
                                    <div class="product-icon">
                                        <ul class="product-social">
                                            <li class="d-inline-block"><a href="#"><i class="fa fa-facebook"></i></a>
                                            </li>
                                            <li class="d-inline-block"><a href="#"><i
                                                        class="fa fa-google-plus"></i></a></li>
                                            <li class="d-inline-block"><a href="#"><i class="fa fa-twitter"></i></a>
                                            </li>
                                            <li class="d-inline-block"><a href="#"><i class="fa fa-instagram"></i></a>
                                            </li>
                                            <li class="d-inline-block"><a href="#"><i class="fa fa-rss"></i></a></li>
                                        </ul>
                                        <form class="d-inline-block f-right"></form>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            {{-- <div class="row"> --}}
                            {{-- <div class="col-md-6">
                      <h6 class="product-title">Rate Now</h6>
                    </div> --}}
                            {{-- <div class="col-md-6">
                      <div class="d-flex">
                        <select id="u-rating-fontawesome" name="rating" autocomplete="off">
                          <option value="1">1</option>
                          <option value="2">2</option>
                          <option value="3">3</option>
                          <option value="4">4</option>
                          <option value="5">5</option>
                        </select><span>(250 review)</span>
                      </div>
                    </div> --}}
                            {{-- </div> --}}
                            {{-- <hr> --}}
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 xl-cs-35 box-col-6">
                    <div class="card">
                        <div class="card-body">
                            <!-- side-bar colleps block stat-->
                            <div class="filter-block">
                                <h4>Center Phones</h4>
                                <ul>
                                    @if (count($center->phone) > 0)
                                        @foreach ($center->phone as $phone)
                                            <tr>
                                                <li>{{ $phone }}</li>
                                            </tr>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="collection-filter-block">
                                <ul class="pro-services">
                                    <li>
                                        <div class="media"><i data-feather="truck"></i>
                                            <div class="media-body">
                                                <h5>Packages </h5>
                                                <p>center Package</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media"><i data-feather="credit-card"></i>
                                            <div class="media-body">
                                                <h5>Online Payment </h5>
                                                <p>Contrary To Popular Belief. </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- silde-bar colleps block end here-->
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="card">
          <div class="row product-page-main">
            <div class="col-sm-12">
              <ul class="nav nav-tabs border-tab mb-0" id="top-tab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab" aria-controls="top-home" aria-selected="false">Febric</a>
                  <div class="material-border"></div>
                </li>
                <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="false">Video</a>
                  <div class="material-border"></div>
                </li>
                <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#top-contact" role="tab" aria-controls="top-contact" aria-selected="true">Details</a>
                  <div class="material-border"></div>
                </li>
                <li class="nav-item"><a class="nav-link" id="brand-top-tab" data-bs-toggle="tab" href="#top-brand" role="tab" aria-controls="top-brand" aria-selected="true">Brand</a>
                  <div class="material-border"></div>
                </li>
              </ul>
              <div class="tab-content" id="top-tabContent">
                <div class="tab-pane fade active show" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                  <p class="mb-0 m-t-20">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                  <p class="mb-0 m-t-20">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                </div>
                <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                  <p class="mb-0 m-t-20">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                </div>
                <div class="tab-pane fade" id="top-contact" role="tabpanel" aria-labelledby="contact-top-tab">
                  <p class="mb-0 m-t-20">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                </div>
                <div class="tab-pane fade" id="top-brand" role="tabpanel" aria-labelledby="brand-top-tab">
                  <p class="mb-0 m-t-20">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                </div>
              </div>
            </div>
          </div>
        </div> --}}
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')
    <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/js/rating/jquery.barrating.js') }}"></script>
    <script src="{{ asset('assets/js/rating/rating-script.js') }}"></script>
    <script src="{{ asset('assets/js/owlcarousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/js/ecommerce.js') }}"></script>
@endsection
