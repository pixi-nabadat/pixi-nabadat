@extends('dashboard.landingPage.landing_template')
@section('content')
{{-- start section about --}}
<section id="About" class="about text-center wow bounceIn" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="300" data-wow-iteration="2">
    <div class="container">
        <h1>Discover the power of <span>Nabadat</span></h1>
        <p class="lead">Hello Let Me Introduce Our New Template M.Hamada Created With All The Love With <strong>Bootstrap</strong> 3.2.0</p>
        <div class="row">
            <div class="col-xs-12">
                <button class="btn btn-success" type="submit"><i class="fa fa-apple"></i> App Store</button>
                <button class="btn btn-success" type="submit"><i class="fa fa-google-play"></i> Google Play</button>
            </div>
            <div class="col-xs-12">
                <img class="img-responsive" src="{{ asset('landing_page/images/image1.webp') }}">
            </div>

        </div>
    </div>
</section>
{{-- end section about --}}

<!-- Start Section Our Clients-->
<div class="our-clients text-center">
    <marquee behavior="scroll" direction="left">
        <ul class="list-unstyled list-inline">
            <li>
                <img class="img-responsive center-block wow bounceIn" src="{{ asset('landing_page/images/logo1.jpg') }}" data-offset="200" data-duration=".5s" data-wow-delay=".5s">
            </li>
            <li>
                <img class="img-responsive center-block wow bounceIn" src="{{ asset('landing_page/images/logo2.jpg') }}" data-offset="200" data-duration=".5s" data-wow-delay="1s">
            </li>
            <li>
                <img class="img-responsive center-block wow bounceIn" src="{{ asset('landing_page/images/logo3.jpg') }}" data-offset="200" data-duration=".5s" data-wow-delay="1.5s">
            </li>
            <li>
                <img class="img-responsive center-block wow bounceIn" src="{{ asset('landing_page/images/logo4.png') }}" data-offset="200" data-duration=".5s" data-wow-delay="2s">
            </li>
            <li>
                <img class="img-responsive center-block wow bounceIn" src="{{ asset('landing_page/images/logo5.png') }}" data-offset="200" data-duration=".5s" data-wow-delay="2.5s">
            </li>
            <li>
                <img class="img-responsive center-block wow bounceIn" src="{{ asset('landing_page/images/logo6.png') }}" data-offset="200" data-duration=".5s" data-wow-delay="3s">
            </li>
        </ul>
    </marquee>
    
</div>
<!-- End Section Our clients-->

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

{{-- Start Section CEO --}}
<section class="ceo text-center">
    <!--Start Container-->
    <div class="container">
        <div class="item">
            <div class="row visible-md visible-lg">
                <div class="col-md-6">
                    <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                         <span>Emily L.</span>
                         <h2 class="h1">“I had tried every teeth whitening product out there, but nothing seemed to work. After just one session with Mobi, my teeth were multiple shades whiter. I couldn’t believe it!”</h2>
                         <p class="lead">5-star review from App Store</p>
                    </div>
                </div>
                <div class="col-md-6">
                     <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                         <img class="img-responsive" src="{{ asset('landing_page/images/image4.webp') }}">
                     </div>
                 </div>
             </div>
             <div class="row visible-xs visible-sm">
                 <div class="col-md-6">
                      <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                          <img class="img-responsive" src="{{ asset('landing_page/images/image4.webp') }}">
                      </div>
                 </div>
                 <div class="col-md-6">
                     <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                          <span>Emily L.</span>
                          <h2 class="h1">“I had tried every teeth whitening product out there, but nothing seemed to work. After just one session with Mobi, my teeth were multiple shades whiter. I couldn’t believe it!”</h2>
                          <p class="lead">5-star review from App Store</p>
                     </div>
                 </div>
             </div>
        </div>
    </div>
</section>
{{-- End Section CEO --}}

{{-- start section how it works --}}
<section class="how-it-works text-center wow bounceIn" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="300" data-wow-iteration="2">
    <div class="container">
        <span>HOW IT WORKS</span>
        <h1>Transform Your Teeth with
            SmileBright: A Step-by-Step Guide</h1>
        <p class="lead">Nabadat is a mobile app for dental health management, with appointment

            tracking, reminders, and hygiene education.</p>
    </div>
</section>
{{-- end section how it works --}}
<!--Start Testimonial Section-->
<section class="testimonial text-center wow flipInY" data-wow-duration="1s" data-wow-delay="0.5s" data-wow-offset="400" data-wow-iteration="1">
    <div class="container">
        <h2 class="h1">What Our Clients Say</h2>
            <!--Start Testimonial Carousel-->
            <div id="carousel_testimonial" class="carousel slide" data-ride="carousel">
                <div class="row">
                    <div class="col-xs-12 col-lg-6">
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <img class="img-responsive" src="{{ asset('landing_page/images/transform1.webp') }}">
                            </div>
                            <div class="item">
                                <img class="img-responsive" src="{{ asset('landing_page/images/transform2.webp') }}">
                            </div>
                            <div class="item">
                                <img class="img-responsive" src="{{ asset('landing_page/images/transform3.webp') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-6">
                        <ol class="carousel-indicators">
                            <li class="text-left" data-target="#carousel_testimonial" data-slide-to="0" class="active">
                                <div>
                                    <h3>Answer some questions about you</h3>
                                    <p>Each feature is designed to bring out the smile you deserve. That's why millions of people have changed their lives with our removable aligners.</p>
                                    <button class="btn btn-danger">Learn More</button>
                                </div>     
                            </li>
                            <li class="text-left" data-target="#carousel_testimonial" data-slide-to="1">
                                <div>
                                    <h3>Upload your smile and send us</h3>
                                    <p>Each feature is designed to bring out the smile you deserve. That's why millions of people have changed their lives with our removable aligners.</p>
                                    <button class="btn btn-danger">Learn More</button>
                                </div>
                            </li>
                            <li class="text-left" data-target="#carousel_testimonial" data-slide-to="2">
                                <div>
                                    <h3>Schedule an appointment</h3>
                                    <p>Each feature is designed to bring out the smile you deserve. That's why millions of people have changed their lives with our removable aligners.</p>
                                    <button class="btn btn-danger">Learn More</button>
                                </div>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <!--End Testimonial Carousel-->
        
        
    </div>
    <!-- End Container-->
</section>
<!--End Testimonial Section-->
{{-- Start Section download app --}}
<section class="download-app text-center">
    <!--Start Container-->
    <div class="container">
        <div class="item1">
            <div class="row visible-md visible-lg">
                <div class="col-md-6">
                    <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                         <h2 class="h1">Download our Nabadat app to get started now</h2>
                         <p class="lead">Zero code, maximum speed. Make professional sites easy, fast and fun while delivering best-in-class SEO, performance.</p>
                         <button class="btn btn-success" type="submit"><i class="fa fa-apple"></i> App Store</button>
                         <button class="btn btn-success" type="submit"><i class="fa fa-google-play"></i> Google Play</button>
                     </div>
                </div>
                <div class="col-md-6">
                     <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                         <img class="img-responsive" src="{{ asset('landing_page/images/image1.webp') }}">
                     </div>
                 </div>
             </div>
             <div class="row visible-xs visible-sm">
                 <div class="col-md-6">
                      <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                          <img class="img-responsive" src="{{ asset('landing_page/images/image1.webp') }}">
                      </div>
                  </div>
                  <div class="col-md-6">
                     <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                          <h2 class="h1">Download our Nabadat app to get started now</h2>
                          <p class="lead">Zero code, maximum speed. Make professional sites easy, fast and fun while delivering best-in-class SEO, performance.</p>
                          <button class="btn btn-success" type="submit"><i class="fa fa-apple"></i> App Store</button>
                          <button class="btn btn-success" type="submit"><i class="fa fa-google-play"></i> Google Play</button>
                      </div>
                 </div>
              </div>
        </div>
        
    </div>
</section>
{{-- End Section download app --}}
{{-- start section how it works --}}
<section class="benefits-categories text-center wow bounceIn" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="300" data-wow-iteration="2">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 text-left">
                <span>BENEFITS</span>
                <h2 class="h1">Straighten your teeth without braces
                    with our Clear Aligners</h2 class="h1">
                <p class="lead">Are you looking for a discreet and comfortable way to straighten your teeth? Our teeth treatment

                    services offer clear aligners that are virtually invisible, perfect for busy individuals who want to improve their smile.</p>
            </div>
            <div class="item col-md-6 text-left">
                <i class="fa fa-hospital-o fa-3x"></i>
                <h3>Maximize your control with Nabadat</h3>
                <p>Precise and predictable technology. We can show the result you can expect before the treatment even starts.</p>
                <button class="btn btn-default" type="button">Learn More</button>
            </div>
            <div class="item col-md-6 text-left">
                <i class="fa fa-hospital-o fa-3x"></i>
                <h3>Taking comfort up a notch with Nabadat</h3>
                <p>Our materials makes the aligners more gentle, better-fitting, and easier to put on and remove.</p>
                <button class="btn btn-default" type="button">Learn More</button>
            </div>
            <div class="item col-md-6 text-left">
                <i class="fa fa-hospital-o fa-3x"></i>
                <h3>Make the most of your time with faster experiences.</h3>
                <p>Mobi is up to 2X faster than other clear aligners, with simple weekly changes and with advanced excellen mobile dashboard..</p>
                <button class="btn btn-default" type="button">Learn More</button>
            </div>
            <div class="item col-md-6 text-left">
                <i class="fa fa-hospital-o fa-3x"></i>
                <h3>Stay protected with our dental solutions!</h3>
                <p>Once you learn how fast it is to publish sites in Framer, you’ll find excuses to build sites for everything. Kick off your blog, redesign.</p>
                <button class="btn btn-default" type="button">Learn More</button>
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
                {{--  --}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="item item2">
                    <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <span>John D.</span>
                        <h3>“I had been experiencing tooth pain for years, but was too afraid to go to the dentist. Mobi made the process easy and painless, and now I’m pain-free!”</h3>
                        <p class="lead">5-star review from Play Store</p>
                    </div>    
                </div>
            </div>
            <div class="col-md-6">
                <div class="item item3">
                    <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <span>Sarah T.</span>
                        <h3>“I was nervous about getting braces as an adult, but Mobi made the experience comfortable and easy. My teeth are now perfectly aligned and I couldn’t be happier.”</h3>
                        <p class="lead">5-star review from Play Store</p>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</section>
{{-- End Section ceo categories --}}
<!--Start Section analytics-->
<section class="analytics text-center">
    <!--Start Container-->
    <div class="container">
        <span>ANALYTICS</span>
        <h2 class="h1">Join millions who find peace with us</h2>
        <div class="row">
           <div class="item col-xs-12 col-md-4">
               <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                   <h2 class="h1">1541</h2>
                    <p>Community Members</p>
               </div>
               
           </div>
           <div class="item col-xs-12 col-md-4">
               <div class="feat wow bounceInUp" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                    <h2 class="h1">3941</h2>
                    <p>Minutes spent in self-care</p>
               </div>
               
           </div>
           <div class="item col-xs-12 col-md-4">
               <div class="feat wow bounceInDown" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                    <h2 class="h1">2143</h2>
                    <p>5-star reviews</p>
               </div>
           </div>
        </div>
    </div>
</section>
<!--End Section analytics-->
<!--Start Section blog-->
<section class="blog text-left">
    <!--Start Container-->
    <div class="container">
        <span>BLOG</span>
        <h2 class="h1">Get the latest news</h2>
        <div class="row">
           <div class="item col-xs-12 col-md-4">
               <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                    <img class="img-responsive" src="{{ asset('landing_page/images/blog1.webp') }}">
                    <p>Apr 8, 2022</p>
                    <h3>Starting and Growing a Career in Web Design</h3>
               </div>
               
           </div>
           <div class="item col-xs-12 col-md-4">
               <div class="feat wow bounceInUp" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                    <img class="img-responsive" src="{{ asset('landing_page/images/blog2.webp') }}">
                    <p>Mar 15, 2022</p>
                    <h3>Create a Landing Page That Performs Great</h3>
               </div>
               
           </div>
           <div class="item col-xs-12 col-md-4">
               <div class="feat wow bounceInDown" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                    <img class="img-responsive" src="{{ asset('landing_page/images/blog3.webp') }}">
                    <p>Feb 28, 2022</p>
                    <h3>How Can Designers Prepare for the Future?</h3>
               </div>
           </div>
        </div>
    </div>
</section>
<!--End Section blog-->
<hr>
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