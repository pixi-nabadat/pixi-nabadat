@extends('dashboard.landingPage.landing_template')
@section('content')
    {{-- Start Section intro --}}
    <section class="jumbotron text-center">
        <!--Start Container-->
        <div class="container">
            <div class="row">
               <div class="col-xs-12">
                   <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <h1>Don’t take our word for it.
                            Over 100M people trust us</h1>
                        <p class="lead">Our team strives to provide the best customer experience possible. See how our dedication to customer satisfaction translates into success stories from our customers. These testimonials speak to our mission of making our customers happy and fulfilled.</p>
                        <button class="btn btn-danger" type="submit"><i class="fa fa-apple"></i> Get inTouch</button>
                    </div>
               </div>
            </div>
        </div>
    </section>
    {{-- End Section intro --}}
    <!-- Start Section Our Clients-->
    <div class="our-clients text-center">
        <marquee behavior="scroll" direction="left">
            <ul class="list-unstyled list-inline">
                <li class="client-data">
                    <img class="img-responsive center-block wow bounceIn" src="{{ asset('landing_page/images/testimonial/image1.webp') }}" data-offset="200" data-duration=".5s" data-wow-delay=".5s">
                    <div>
                        <span>canada</span>
                        <h4>Enes Aktas</h4>
                    </div>
                </li>
                <li class="client-data">
                    <img class="img-responsive center-block wow bounceIn" src="{{ asset('landing_page/images/testimonial/image2.webp') }}" data-offset="200" data-duration=".5s" data-wow-delay="1s">
                    <div>
                        <span>canada</span>
                        <h4>Enes Aktas</h4>
                    </div>
                </li>
                <li class="client-data">
                    <img class="img-responsive center-block wow bounceIn" src="{{ asset('landing_page/images/testimonial/image3.webp') }}" data-offset="200" data-duration=".5s" data-wow-delay="1.5s">
                    <div>
                        <span>canada</span>
                        <h4>Enes Aktas</h4>
                    </div>
                </li>
                <li class="client-data">
                    <img class="img-responsive center-block wow bounceIn" src="{{ asset('landing_page/images/testimonial/image4.webp') }}" data-offset="200" data-duration=".5s" data-wow-delay="2s">
                    <div>
                        <span>canada</span>
                        <h4>Enes Aktas</h4>
                    </div>
                </li>
                <li class="client-data">
                    <img class="img-responsive center-block wow bounceIn" src="{{ asset('landing_page/images/testimonial/image5.webp') }}" data-offset="200" data-duration=".5s" data-wow-delay="2.5s">
                    <div>
                        <span>canada</span>
                        <h4>Enes Aktas</h4>
                    </div>
                </li>
            </ul>
        </marquee>
        
        <marquee behavior="scroll" direction="right">
            <ul class="list-unstyled list-inline">
                <li class="client-data">
                    <img class="img-responsive center-block wow bounceIn" src="{{ asset('landing_page/images/testimonial/image6.webp') }}" data-offset="200" data-duration=".5s" data-wow-delay=".5s">
                    <div>
                        <span>canada</span>
                        <h4>Enes Aktas</h4>
                    </div>
                </li>
                <li class="client-data">
                    <img class="img-responsive center-block wow bounceIn" src="{{ asset('landing_page/images/testimonial/image7.webp') }}" data-offset="200" data-duration=".5s" data-wow-delay="1s">
                    <div>
                        <span>canada</span>
                        <h4>Enes Aktas</h4>
                    </div>
                </li>
                <li class="client-data">
                    <img class="img-responsive center-block wow bounceIn" src="{{ asset('landing_page/images/testimonial/image8.webp') }}" data-offset="200" data-duration=".5s" data-wow-delay="1.5s">
                    <div>
                        <span>canada</span>
                        <h4>Enes Aktas</h4>
                    </div>
                </li>
                <li class="client-data">
                    <img class="img-responsive center-block wow bounceIn" src="{{ asset('landing_page/images/testimonial/image9.webp') }}" data-offset="200" data-duration=".5s" data-wow-delay="2s">
                    <div>
                        <span>canada</span>
                        <h4>Enes Aktas</h4>
                    </div>
                </li>
                <li class="client-data">
                    <img class="img-responsive center-block wow bounceIn" src="{{ asset('landing_page/images/testimonial/image10.webp') }}" data-offset="200" data-duration=".5s" data-wow-delay="2.5s">
                    <div>
                        <span>canada</span>
                        <h4>Enes Aktas</h4>
                    </div>
                </li>
            </ul>
        </marquee>
        
    </div>
    <!-- End Section Our clients-->
    {{-- Start Section ceo categories --}}
    <section class="ceo-categories text-center">
        <!--Start Container-->
        <div class="container">
            <div class="item item1">
                <div class="row">
                    <div class="col-md-6 visible-md visible-lg">
                        <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                            <span>Emily L.</span>
                            <h2 class="h1">“I had tried every teeth whitening product out there, but nothing seemed to work. After just one session with Mobi, my teeth were multiple shades whiter. I couldn’t believe it!”</h2>
                            <p class="lead">5-star review from App Store</p>
                        </div>
                    </div>
                    <div class="col-md-6 visible-md visible-lg">
                        <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                            <img class="img-responsive" src="{{ asset('landing_page/images/image4.webp') }}">
                        </div>
                    </div>
                    {{--  --}}
                    <div class="col-md-6 visible-xs visible-sm">
                        <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                            <img class="img-responsive" src="{{ asset('landing_page/images/image4.webp') }}">
                        </div>
                    </div>
                    <div class="col-md-6 visible-xs visible-sm">
                        <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                            <span>Emily L.</span>
                            <h2 class="h1">“I had tried every teeth whitening product out there, but nothing seemed to work. After just one session with Mobi, my teeth were multiple shades whiter. I couldn’t believe it!”</h2>
                            <p class="lead">5-star review from App Store</p>
                        </div>
                    </div>
                    {{--  --}}
                </div>
            </div>
        </div>
    </section>
    {{-- End Section ceo categories --}}
    {{-- start section how it works --}}
    <section class="benefits-categories text-center wow bounceIn" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="300" data-wow-iteration="2">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-left">
                    <div class="item">
                        <span>John D.</span>
                        <h3>“I had been experiencing tooth pain for years, but was too afraid to go to the dentist. Mobi made the process easy and painless, and now I’m pain-free!”</h3>
                        <p class="lead">5-star review from Play Store</p>
                    </div>
                </div>
                <div class="col-md-6 text-left">
                    <div class="item">
                        <span>Sarah T.</span>
                        <h3>“I was nervous about getting braces as an adult, but Mobi made the experience comfortable and easy. My teeth are now perfectly aligned and I couldn’t be happier.”</h3>
                        <p class="lead">5-star review from Play Store</p>
                    </div>
                </div>
                <div class="col-md-6 text-left">
                    <div class="item">
                        <span>John D.</span>
                        <h3>“I had been experiencing tooth pain for years, but was too afraid to go to the dentist. Mobi made the process easy and painless, and now I’m pain-free!”</h3>
                        <p class="lead">5-star review from Play Store</p>
                    </div>
                </div>
                <div class="col-md-6 text-left">
                    <div class="item">
                        <span>Sarah T.</span>
                        <h3>“I was nervous about getting braces as an adult, but Mobi made the experience comfortable and easy. My teeth are now perfectly aligned and I couldn’t be happier.”</h3>
                        <p class="lead">5-star review from Play Store</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- end section how it works --}}

    {{-- Start Section ceo categories --}}
    <section class="ceo-categories text-center">
        <!--Start Container-->
        <div class="container">
            <div class="item item1">
                <div class="row">
                    <div class="col-md-6 visible-md visible-lg">
                        <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                            <span>Sarah T.</span>
                            <h2 class="h1">“I was always self-conscious about my smile, but after getting teeth treatment from Mobi, I can’t stop grinning! My teeth look and feel amazing.”</h2>
                            <p class="lead">5-star review from App Store</p>
                        </div>
                    </div>
                    <div class="col-md-6 visible-md visible-lg">
                        <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                            <img class="img-responsive" src="{{ asset('landing_page/images/image5.webp') }}">
                        </div>
                    </div>
                    {{--  --}}
                    <div class="col-md-6 visible-xs visible-sm">
                        <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                            <img class="img-responsive" src="{{ asset('landing_page/images/image4.webp') }}">
                        </div>
                    </div>
                    <div class="col-md-6 visible-xs visible-sm">
                        <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                            <span>Sarah T.</span>
                            <h2 class="h1">“I was always self-conscious about my smile, but after getting teeth treatment from Mobi, I can’t stop grinning! My teeth look and feel amazing.”</h2>
                            <p class="lead">5-star review from App Store</p>
                        </div>
                    </div>
                    {{--  --}}
                </div>
            </div>
        </div>
    </section>
    {{-- End Section ceo categories --}}
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
    
    <!--Start Section help center-->
    <section class="help-center">
        <section class="text-center">
            <!--Start Container-->
            <div class="container">
                <span>HELP CENTER</span>
                <h2 class="h1">Frequently Asked Questions</h2>
                <p class="lead">Our customer support team is here to assist you. Start by browsing our FAQ
    
                    section to find answers to your questions.</p>
               
            </div>
        </section>
        {{-- start FAQ --}}
        <section class="faq-questions">
            <div class="container">
                <div class="panel-group" id="accordion" roles="tablist" aria-multiselectable="true">
                    <!--Start Question 1-->
                    <div class="panel panel-default">
                        <div class="panel-heading" roels="tab" id="heading-one">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-one" aria-expanded="true" aria-controls="collapse-one">
                                    What kind of teeth treatments do you offer?
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-one" class="panel-collapse collapse in" roles="tabpanel" aria-labelledby="heading-one">
                            <div class="panel-body">
                                We offer a variety of teeth treatments, including dental cleanings, teeth whitening, fillings, root canals, crowns, and bridges.
                            </div>
                        </div>
                    </div>
                    <!--End Question 1-->
                    
                    <!--Start Question 2-->
                    <div class="panel panel-default">
                        <div class="panel-heading" roels="tab" id="heading-two">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-two" aria-expanded="true" aria-controls="collapse-two">
                                    How often should I get a dental check-up?
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-two" class="panel-collapse collapse" roles="tabpanel" aria-labelledby="heading-two">
                            <div class="panel-body">
                                It is recommended to get a dental check-up every six months to ensure optimal oral health.
                            </div>
                        </div>
                    </div>
                    <!--End Question 2-->
                    
                    <!--Start Question 3-->
                    <div class="panel panel-default">
                        <div class="panel-heading" roels="tab" id="heading-three">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-three" aria-expanded="true" aria-controls="collapse-three">
                                    What is teeth whitening and how does it work?
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-three" class="panel-collapse collapse" roles="tabpanel" aria-labelledby="heading-three">
                            <div class="panel-body">
                                Teeth whitening is a cosmetic treatment that uses bleach or other materials to lighten the color of your teeth. It works by breaking down the stains on your teeth and removing them.
                            </div>
                        </div>
                    </div>
                    <!--End Question 3-->
                    <!--Start Question 4-->
                <div class="panel panel-default">
                    <div class="panel-heading" roels="tab" id="heading-four">
                        <h4 class="panel-title">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-four" aria-expanded="true" aria-controls="collapse-four">
                                What should I do if I have a toothache?
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-four" class="panel-collapse collapse" roles="tabpanel" aria-labelledby="heading-four">
                        <div class="panel-body">
                            If you have a toothache, it is important to schedule an appointment with your dentist as soon as possible. In the meanwhile, you can try rinsing your mouth with warm salt water, taking pain medication as directed, and avoiding hot or cold foods and drinks.
                        </div>
                    </div>
                </div>
                <!--End Question 4-->
                <!--Start Question 5-->
                <div class="panel panel-default">
                    <div class="panel-heading" roels="tab" id="heading-five">
                        <h4 class="panel-title">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-five" aria-expanded="true" aria-controls="collapse-five">
                                How long do dental implants last?
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-five" class="panel-collapse collapse" roles="tabpanel" aria-labelledby="heading-five">
                        <div class="panel-body">
                            With proper care, dental implants can last a lifetime. However, the actual lifespan of dental implants may vary depending on several factors, including the patient's oral health habits and the quality of the implant and crown materials used.
                        </div>
                    </div>
                </div>
                <!--End Question 5-->
                </div>
            </div>
        </section>
        {{-- end FAQ --}}
    </section>
    <!--End Section help center-->
@endsection