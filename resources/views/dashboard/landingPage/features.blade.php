@extends('dashboard.landingPage.landing_template')
@section('content')
    {{-- Start Section intro --}}
    <section class="jumbotron text-center">
        <!--Start Container-->
        <div class="container">
            <div class="row">
               <div class="col-xs-12">
                   <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <h1>Straighten your teeth without braceswith our Clear Aligners</h1>
                        <p class="lead">Zero code, maximum speed. Make professional sites easy, fast and fun

                            while delivering best-in-class SEO, performance.</p>
                        <button class="btn btn-success" type="submit"><i class="fa fa-apple"></i> App Store</button>
                        <button class="btn btn-success" type="submit"><i class="fa fa-google-play"></i> Google Play</button>
                    </div>
               </div>
            </div>
        </div>
    </section>
    {{-- End Section intro --}}
    {{-- start section benefits categories --}}
    <section class="benefits-categories text-center wow bounceIn" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="300" data-wow-iteration="2">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-left">
                    <div class="item">
                        <i class="fa fa-hospital-o fa-3x"></i>
                        <h3>Maximize your control with Nabadat</h3>
                        <p>Precise and predictable technology. We can show the result you can expect before the treatment even starts.</p>
                        <button class="btn btn-default" type="button">Learn More</button>
                    </div>
                </div>
                <div class="col-md-6 text-left">
                    <div class="item">
                        <i class="fa fa-hospital-o fa-3x"></i>
                        <h3>Taking comfort up a notch with Nabadat</h3>
                        <p>Our materials makes the aligners more gentle, better-fitting, and easier to put on and remove.</p>
                        <button class="btn btn-default" type="button">Learn More</button>
                    </div>
                </div>
                <div class="col-md-6 text-left">
                    <div class="item">
                        <i class="fa fa-hospital-o fa-3x"></i>
                        <h3>Make the most of your time with faster experiences.</h3>
                        <p>Mobi is up to 2X faster than other clear aligners, with simple weekly changes and with advanced excellen mobile dashboard..</p>
                        <button class="btn btn-default" type="button">Learn More</button>
                    </div>
                </div>
                <div class="col-md-6 text-left">
                    <div class="item">
                        <i class="fa fa-hospital-o fa-3x"></i>
                        <h3>Stay protected with our dental solutions!</h3>
                        <p>Once you learn how fast it is to publish sites in Framer, you’ll find excuses to build sites for everything. Kick off your blog, redesign.</p>
                        <button class="btn btn-default" type="button">Learn More</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- end section benefits categories --}}
    
    <!--Start Section benefits-->
    <section class="benefits text-center">
        <!--Start Container-->
        <div class="container">
            <div class="row">
               <div class="col-md-6">
                    <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <img class="img-responsive" src="{{ asset('landing_page/images/image2.webp') }}">
                    </div>
               </div>
               <div class="col-md-6">
                   <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <span>BENEFITS</span>
                        <h2 class="h1">Save time and money with our powerful tools</h2>
                        <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                        <button class="btn btn-danger" type="submit">Get in Touch</button>
                   </div>
                   
               </div>
            </div>
        </div>
    </section>
    <section class="benefits text-center">
        <!--Start Container-->
        <div class="container">
            <div class="row">
               <div class="col-md-6">
                   <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <span>BENEFITS</span>
                        <h2 class="h1">More then 7000+ Doctors are members of Nabadat</h2>
                        <p class="lead">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                        <button class="btn btn-danger" type="submit">Download App — Free</button>
                   </div>
               </div>
               <div class="col-md-6">
                <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                    <img class="img-responsive" src="{{ asset('landing_page/images/image3.webp') }}">
                </div>
           </div>
            </div>
        </div>
    </section>
    <!--End Section benefits-->

    {{-- Start Section benefits --}}
    <section class="benefits text-center">
        <!--Start Container-->
        <div class="container">
            <div class="row visible-md visible-lg">
                <div class="col-md-6">
                     <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                         <img class="img-responsive" src="{{ asset('landing_page/images/transform3.webp') }}">
                     </div>
                </div>
                <div class="col-md-6">
                    <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                         <span>BENEFITS</span>
                         <h2 class="h1">Plan an appointment with your doctor in the interval of the time you want</h2>
                         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.</p>
                         <button class="btn btn-danger">Get in Touch</button>
                    </div>
                </div>
            </div>
            <div class="row visible-xs visible-sm">
               <div class="col-md-6">
                   <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <span>BENEFITS</span>
                        <h2 class="h1">Plan an appointment with your doctor in the interval of the time you want</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.</p>
                        <button class="btn btn-danger">Get in Touch</button>
                   </div>
               </div>
               <div class="col-md-6">
                    <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <img class="img-responsive" src="{{ asset('landing_page/images/transform3.webp') }}">
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    {{-- End Section benefits --}}
    {{-- Start Section benefits --}}
    <section class="benefits text-center">
        <!--Start Container-->
        <div class="container">
            <div class="row visible-md visible-lg">
               <div class="col-md-6">
                   <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <span>BENEFITS</span>
                        <h2 class="h1">Everything is more perfect with advanced tooth recognition system</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.</p>
                        <button class="btn btn-danger">Download App — Free</button>
                   </div>
               </div>
               <div class="col-md-6">
                    <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <img class="img-responsive" src="{{ asset('landing_page/images/transform2.webp') }}">
                    </div>
                </div>
            </div>
            <div class="row visible-xs visible-sm">
                <div class="col-md-6">
                     <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                         <img class="img-responsive" src="{{ asset('landing_page/images/transform2.webp') }}">
                     </div>
                </div>
                <div class="col-md-6">
                    <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                         <span>Emily L.</span>
                         <h2 class="h1">Everything is more perfect with advanced tooth recognition system</h2>
                         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.</p>
                         <button class="btn btn-danger">Download App — Free</button>
                    </div>
                </div>
             </div>
        </div>
    </section>
    {{-- End Section benefits --}}

    {{-- Start Section download app --}}
    <section class="download-app text-center">
        <!--Start Container-->
        <div class="container">
            <div class="item item1">
                <div class="row">
                    <div class="col-md-6 visible-md visible-lg">
                        <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                            <h2 class="h1">Download our Mobi app to get started now</h2>
                            <p class="lead">Zero code, maximum speed. Make professional sites easy, fast and fun while delivering best-in-class SEO, performance.</p>
                            <button class="btn btn-success"><i class="fa fa-apple"></i> App Store</button>
                            <button class="btn btn-success"><i class="fa fa-gogole-play"></i> Google Play</button>
                        </div>
                    </div>
                    <div class="col-md-6 visible-md visible-lg">
                        <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                            <img class="img-responsive" src="{{ asset('landing_page/images/image1.webp') }}">
                        </div>
                    </div>
                    
                    <div class="col-md-6 visible-xs visible-sm">
                        <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                            <img class="img-responsive" src="{{ asset('landing_page/images/image5.webp') }}">
                        </div>
                    </div>
                    <div class="col-md-6 visible-xs visible-sm">
                        <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                            <span>Sarah T.</span>
                            <h2 class="h1">“I was always self-conscious about my smile, but after getting teeth treatment from Mobi, I can’t stop grinning! My teeth look and feel amazing.”</h2>
                            <p class="lead">5-star review from App Store</p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    {{-- End Section download app --}}
    
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