@extends('dashboard.landingPage.landing_template')
@section('content')
    {{-- Start Section download app --}}
    <section class="download_app text-center">
        <!--Start Container-->
        <div class="container">
            <div class="row">
               <div class="col-xs-12">
                   <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <h1>Get the latest news</h1>
                        <p class="lead">Zero code, maximum speed. Make professional sites easy, fast and fun

                            while delivering best-in-class SEO, performance.</p>
                    </div>
               </div>
            </div>
        </div>
    </section>
    {{-- End Section download app --}}
     <!--Start Section blog-->
     <section class="blog text-left">
        <!--Start Container-->
        <div class="container">
            <span>BLOG</span>
            <h2 class="h1">Get the latest news</h2>
            <div class="row">
               <div class="item col-xs-12 col-md-4">
                   <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <img class="img-responsive" src="{{ asset('landing_page/images/blog/image1.webp') }}">
                        <p>Apr 8, 2022</p>
                        <h3>Starting and Growing a Career in Web Design</h3>
                   </div>
                   
               </div>
               <div class="item col-xs-12 col-md-4">
                   <div class="feat wow bounceInUp" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <img class="img-responsive" src="{{ asset('landing_page/images/blog/image2.webp') }}">
                        <p>Mar 15, 2022</p>
                        <h3>Create a Landing Page That Performs Great</h3>
                   </div>
                   
               </div>
               <div class="item col-xs-12 col-md-4">
                   <div class="feat wow bounceInDown" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <img class="img-responsive" src="{{ asset('landing_page/images/blog/image3.webp') }}">
                        <p>Feb 28, 2022</p>
                        <h3>How Can Designers Prepare for the Future?</h3>
                   </div>
               </div>
               <div class="item col-xs-12 col-md-4">
                   <div class="feat wow bounceInDown" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <img class="img-responsive" src="{{ asset('landing_page/images/blog/image4.webp') }}">
                        <p>Feb 6, 2022</p>
                        <h3>Building a Navigation Component with Variables</h3>
                   </div>
               </div>
               <div class="item col-xs-12 col-md-4">
                   <div class="feat wow bounceInDown" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <img class="img-responsive" src="{{ asset('landing_page/images/blog/image5.webp') }}">
                        <p>Jan 12, 2022</p>
                        <h3>How to Create an Effective Design Portfolio</h3>
                   </div>
               </div>
            </div>
        </div>
    </section>
    <!--End Section blog-->

    {{-- Start Section ceo categories --}}
    <section class="ceo-categories text-center">
        <!--Start Container-->
        <div class="container">
            <div class="item item1">
                <div class="row">
                    <div class="col-md-6 visible-md visible-lg">
                        <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                            <h2 class="h1">Download our Mobi app to get started now</h2>
                            <p>Zero code, maximum speed. Make professional sites easy, fast and fun while delivering best-in-class SEO, performance.</p>
                            <button class="btn btn-success"><i class="fa fa-apple"></i> App Store</button>
                            <button class="btn btn-success"><i class="fa fa-google-play"></i> Google Play</button>
                        </div>
                    </div>
                    <div class="col-md-6 visible-md visible-lg">
                        <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                            <img class="img-responsive" src="{{ asset('landing_page/images/image1.webp') }}">
                        </div>
                    </div>
                    {{--  --}}
                    <div class="col-md-6 visible-xs visible-sm">
                        <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                            <img class="img-responsive" src="{{ asset('landing_page/images/image1.webp') }}">
                        </div>
                    </div>
                    <div class="col-md-6 visible-xs visible-sm">
                        <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                            <h2 class="h1">Download our Mobi app to get started now</h2>
                            <p>Zero code, maximum speed. Make professional sites easy, fast and fun while delivering best-in-class SEO, performance.</p>
                            <button class="btn btn-success"><i class="fa fa-apple"></i> App Store</button>
                            <button class="btn btn-success"><i class="fa fa-google-play"></i> Google Play</button>
                        </div>
                    </div>
                    {{--  --}}
                </div>
            </div>
        </div>
    </section>
    {{-- End Section ceo categories --}}
@endsection