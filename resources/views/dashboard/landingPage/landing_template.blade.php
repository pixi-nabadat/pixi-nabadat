<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link rel="stylesheet" href="{{ asset('landing_page/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing_page/css/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('landing_page/css/plugins.css') }}">
    @if(\Route::current()->getName() == "landingPage.index")
    <link rel="stylesheet" href="{{ asset('landing_page/css/index.css') }}">
    @elseif(\Route::current()->getName() == "landingPage.features")
    <link rel="stylesheet" href="{{ asset('landing_page/css/features.css') }}">
    @elseif (\Route::current()->getName() == "landingPage.testimonials")
    <link rel="stylesheet" href="{{ asset('landing_page/css/testimonials.css') }}">
    @elseif (\Route::current()->getName() == "landingPage.blog")
    <link rel="stylesheet" href="{{ asset('landing_page/css/blog.css') }}">
    @elseif (\Route::current()->getName() == "landingPage.contact")
    <link rel="stylesheet" href="{{ asset('landing_page/css/contact.css') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('landing_page/css/colors/default_theme.css') }}">
    <link rel="stylesheet" href="{{ asset('landing_page/css/hover.css') }}">
    <link rel="stylesheet" href="{{ asset('landing_page/css/animate.css') }}">
    <script src="{{ asset('landing_page/js/html5shiv.min.js') }}"></script>
    <script src="{{ asset('landing_page/js/respond.min.js') }}"></script>
    
</head>
<body>
    <!-- Start our navbar-->
    <nav class="navbar navbar-default  navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mydiv" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand hidden-xs" href="#">Nabadat <span class="btn btn-default"> We're Hiring!</span></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="mydiv">
      
        <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="{{ route('landingPage.features') }}">Features <span class="sr-only">(current)</span></a></li>
            <li><a href="{{ route('landingPage.testimonials') }}">Testmonials</a></li>
            <li><a href="{{ route('landingPage.blog') }}">Blog</a></li>
            <li><a href="{{ route('landingPage.contact') }}">Contact</a></li>        
      </ul>
        
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
    
    <!--End our navbar-->
    
    @yield('content')
    
    <!-- Start Scroll To Top-->
        <div id="scroll-top" class="fa fa-chevron-up"></div>
    <!-- End Scroll To Top-->
    <script src="{{ asset('landing_page/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('landing_page/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('landing_page/js/plugins.js') }}"></script>
    <script src="{{ asset('landing_page/js/wow.min.js') }}"></script>
    <script src="{{ asset('landing_page/js/jquery.nicescroll.min.js') }}"></script>
    <script>new WOW().init();</script>
</body>
</html>