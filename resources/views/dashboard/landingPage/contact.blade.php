@extends('dashboard.landingPage.landing_template')
@section('content')
{{-- Start Section ceo categories --}}
   <section class="contact-form text-center">
    <!--Start Container-->
    <div class="container">
        <div class="item item1">
            <div class="row">
                <div class="col-md-6">
                    <div class="feat wow bounceInUp text-left" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <span>CONTACT</span>
                        <h1>Get in touch</h1>
                        <p class="lead">Reach out to us through the contact form or the details provided below to share your feedback, inquiries, or suggestions.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feat wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" data-wow-offset="100" data-wow-iteration="1">
                        <form>
                            <div class="form-group">

                                <input type="text" class="form-control input-lg" placeholder="Name">
                            </div>
                            <div class="form-group">
                            <input type="email" class="form-control input-lg" placeholder="Email">
                            </div>
                            <div class="form-group">
                            <textarea style="resize: vertical" class="form-control input-lg" placeholder="Message"></textarea>
                            </div>
                            <div class="form-group">
                            <button class="btn btn-danger btn-lg btn-block">Sign Up</button>
                            </div>
                        </form>
                    </div>
                </div>
               
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
                        <div class="panel-heading" roels="tab" id="heading-three">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-three" aria-expanded="true" aria-controls="collapse-three">
                                    What should I do if I have a toothache?
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-three" class="panel-collapse collapse" roles="tabpanel" aria-labelledby="heading-three">
                            <div class="panel-body">
                                If you have a toothache, it is important to schedule an appointment with your dentist as soon as possible. In the meanwhile, you can try rinsing your mouth with warm salt water, taking pain medication as directed, and avoiding hot or cold foods and drinks.
                            </div>
                        </div>
                    </div>
                    <!--End Question 4-->
                    <!--Start Question 5-->
                    <div class="panel panel-default">
                        <div class="panel-heading" roels="tab" id="heading-three">
                            <h4 class="panel-title">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse-three" aria-expanded="true" aria-controls="collapse-three">
                                    How long do dental implants last?
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-three" class="panel-collapse collapse" roles="tabpanel" aria-labelledby="heading-three">
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