<div class="page-header">
  <div class="header-wrapper row m-0">
    <form class="form-inline search-full col" action="#" method="get">
      <div class="mb-3 w-100">
        <div class="Typeahead Typeahead--twitterUsers">
          <div class="u-posRelative">
            <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search Cuba .." name="q" title="" autofocus>
            <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span></div>
            <i class="close-search" data-feather="x"></i>
          </div>
          <div class="Typeahead-menu"></div>
        </div>
      </div>
    </form>
    {{-- <div class="header-logo-wrapper col-auto p-0"> --}}
      {{-- <div class="logo-wrapper"><a href="{{route('home')}}"><img class="img-fluid" src="{{asset('assets/images/logo/logo.png')}}" alt=""></a></div> --}}
      {{-- <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i></div>
    </div>
    <div class="left-header col horizontal-wrapper ps-0">

    </div>
    <div class="nav-right col-8 pull-right right-header p-0">
      <ul class="nav-menus">
        <li class="language-nav">
          <div class="translate_wrapper">
            <div class="current_lang">
              <div class="lang"><i class="flag-icon flag-icon-{{ (App::getLocale() == 'en') ? 'us' : App::getLocale() }}"></i><span class="lang-txt">{{ App::getLocale() }} </span></div>
            </div>
            <div class="more_lang">
              <a href="{{ route('lang', 'en' )}}" class="{{ (App::getLocale()  == 'en') ? 'active' : ''}}">
                <div class="lang {{ (App::getLocale()  == 'en') ? 'selected' : ''}}" data-value="en"><i class="flag-icon flag-icon-us"></i> <span class="lang-txt">English</span><span> (US)</span></div>
              </a>
              <a href="{{ route('lang' , 'de' )}}" class="{{ (App::getLocale()  == 'de') ? 'active' : ''}} ">
                <div class="lang {{ (App::getLocale()  == 'de') ? 'selected' : ''}}" data-value="de"><i class="flag-icon flag-icon-de"></i> <span class="lang-txt">Deutsch</span></div>
              </a>
              <a href="{{ route('lang' , 'es' )}}" class="{{ (App::getLocale()  == 'en') ? 'active' : ''}}">
                <div class="lang {{ (App::getLocale()  == 'es') ? 'selected' : ''}}" data-value="es"><i class="flag-icon flag-icon-es"></i> <span class="lang-txt">Español</span></div>
              </a>
              <a href="{{ route('lang' , 'fr' )}}" class="{{ (App::getLocale()  == 'fr') ? 'active' : ''}}">
                <div class="lang {{ (App::getLocale()  == 'fr') ? 'selected' : ''}}" data-value="fr"><i class="flag-icon flag-icon-fr"></i> <span class="lang-txt">Français</span></div>
              </a>
              <a href="{{ route('lang' , 'pt' )}}" class="{{ (App::getLocale()  == 'pt') ? 'active' : ''}}">
                <div class="lang {{ (App::getLocale()  == 'pt') ? 'selected' : ''}}" data-value="pt"><i class="flag-icon flag-icon-pt"></i> <span class="lang-txt">Português</span><span> (BR)</span></div>
              </a>
              <a href="{{ route('lang' , 'cn' )}}" class="{{ (App::getLocale()  == 'cn') ? 'active' : ''}}">
                <div class="lang {{ (App::getLocale()  == 'cn') ? 'selected' : ''}}" data-value="cn"><i class="flag-icon flag-icon-cn"></i> <span class="lang-txt">简体中文</span></div>
              </a>
              <a href="{{ route('lang' , 'ae' )}}" class="{{ (App::getLocale()  == 'ae') ? 'active' : ''}}">
                <div class="lang {{ (App::getLocale()  == 'ae') ? 'selected' : ''}}" data-value="en"><i class="flag-icon flag-icon-ae"></i> <span class="lang-txt">لعربية</span> <span> (ae)</span></div>
              </a>
            </div>
          </div>
        </li>
        <li>                         <span class="header-search"><i data-feather="search"></i></span></li>
        <li class="onhover-dropdown">
          <div class="notification-box"><i data-feather="bell"> </i><span class="badge rounded-pill badge-secondary">4                                </span></div>
          <ul class="notification-dropdown onhover-show-div">
            <li>
              <i data-feather="bell"></i>
              <h6 class="f-18 mb-0">Notitications</h6>
            </li>
            <li>
              <p><i class="fa fa-circle-o me-3 font-primary"> </i>Delivery processing <span class="pull-right">10 min.</span></p>
            </li>
            <li>
              <p><i class="fa fa-circle-o me-3 font-success"></i>Order Complete<span class="pull-right">1 hr</span></p>
            </li>
            <li>
              <p><i class="fa fa-circle-o me-3 font-info"></i>Tickets Generated<span class="pull-right">3 hr</span></p>
            </li>
            <li>
              <p><i class="fa fa-circle-o me-3 font-danger"></i>Delivery Complete<span class="pull-right">6 hr</span></p>
            </li>
            <li><a class="btn btn-primary" href="#">Check all notification</a></li>
          </ul>
        </li>
        <li class="onhover-dropdown">
          <div class="notification-box"><i data-feather="star"></i></div>
          <div class="onhover-show-div bookmark-flip">
            <div class="flip-card">
              <div class="flip-card-inner">
                <div class="front">
                  <ul class="droplet-dropdown bookmark-dropdown">
                    <li class="gradient-primary">
                      <i data-feather="star"></i>
                      <h6 class="f-18 mb-0">Bookmark</h6>
                    </li>
                    <li>
                      <div class="row">
                        <div class="col-4 text-center"><i data-feather="file-text"></i></div>
                        <div class="col-4 text-center"><i data-feather="activity"></i></div>
                        <div class="col-4 text-center"><i data-feather="users"></i></div>
                        <div class="col-4 text-center"><i data-feather="clipboard"></i></div>
                        <div class="col-4 text-center"><i data-feather="anchor"></i></div>
                        <div class="col-4 text-center"><i data-feather="settings"></i></div>
                      </div>
                    </li>
                    <li class="text-center">
                      <button class="flip-btn" id="flip-btn">Add New Bookmark</button>
                    </li>
                  </ul>
                </div>
                <div class="back">
                  <ul>
                    <li>
                      <div class="droplet-dropdown bookmark-dropdown flip-back-content">
                        <input type="text" placeholder="search...">
                      </div>
                    </li>
                    <li>
                      <button class="d-block flip-back" id="flip-back">Back</button>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li>
          <div class="mode"><i class="fa fa-moon-o"></i></div>
        </li>
        <li class="cart-nav onhover-dropdown">
          <div class="cart-box"><i data-feather="shopping-cart"></i><span class="badge rounded-pill badge-primary">2</span></div>
          <ul class="cart-dropdown onhover-show-div">
            <li>
              <h6 class="mb-0 f-20">Shoping Bag</h6>
              <i data-feather="shopping-cart"></i>
            </li>
            <li class="mt-0">
              <div class="media">
                <img class="img-fluid rounded-circle me-3 img-60" src="{{asset('assets/images/ecommerce/01.jpg')}}" alt="">
                <div class="media-body">
                  <span>V-Neck Shawl Collar Woman's Solid T-Shirt</span>
                  <p>Yellow(#fcb102)</p>
                  <div class="qty-box">
                    <div class="input-group"><span class="input-group-prepend">
                      <button class="btn quantity-left-minus" type="button" data-type="minus" data-field=""><i data-feather="minus"></i></button></span>
                      <input class="form-control input-number" type="text" name="quantity" value="1"><span class="input-group-prepend">
                      <button class="btn quantity-right-plus" type="button" data-type="plus" data-field=""><i data-feather="plus"></i></button></span>
                    </div>
                  </div>
                  <h6 class="text-end text-muted">$299.00</h6>
                </div>
                <div class="close-circle"><a href="#"><i data-feather="x"></i></a></div>
              </div>
            </li>
            <li class="mt-0">
              <div class="media">
                <img class="img-fluid rounded-circle me-3 img-60" src="{{asset('assets/images/ecommerce/03.jpg')}}" alt="">
                <div class="media-body">
                  <span>V-Neck Shawl Collar Woman's Solid T-Shirt</span>
                  <p>Yellow(#fcb102)</p>
                  <div class="qty-box">
                    <div class="input-group"><span class="input-group-prepend">
                      <button class="btn quantity-left-minus" type="button" data-type="minus" data-field=""><i data-feather="minus"></i></button></span>
                      <input class="form-control input-number" type="text" name="quantity" value="1"><span class="input-group-prepend">
                      <button class="btn quantity-right-plus" type="button" data-type="plus" data-field=""><i data-feather="plus"></i></button></span>
                    </div>
                  </div>
                  <h6 class="text-end text-muted">$299.00</h6>
                </div>
                <div class="close-circle"><a href="#"><i data-feather="x"></i></a></div>
              </div>
            </li>
            <li>
              <div class="total">
                <h6 class="mb-2 mt-0 text-muted">Order Total : <span class="f-right f-20">$598.00</span></h6>
              </div>
            </li>
            <li><a class="btn btn-block w-100 mb-2 btn-primary view-cart" href="#">Go to shoping bag</a><a class="btn btn-block w-100 btn-secondary view-cart" href="#">Checkout</a></li>
          </ul>
        </li>
        <li class="onhover-dropdown">
          <i data-feather="message-square"></i>
          <ul class="chat-dropdown onhover-show-div">
            <li>
              <i data-feather="message-square"></i>
              <h6 class="f-18 mb-0">Message Box                                    </h6>
            </li>
            <li>
              <div class="media">
                <img class="img-fluid rounded-circle me-3" src="{{asset('assets/images/user/1.jpg')}}" alt="">
                <div class="status-circle online"></div>
                <div class="media-body">
                  <span>Erica Hughes</span>
                  <p>Lorem Ipsum is simply dummy...</p>
                </div>
                <p class="f-12 font-success">58 mins ago</p>
              </div>
            </li>
            <li>
              <div class="media">
                <img class="img-fluid rounded-circle me-3" src="{{asset('assets/images/user/2.jpg')}}" alt="">
                <div class="status-circle online"></div>
                <div class="media-body">
                  <span>Kori Thomas</span>
                  <p>Lorem Ipsum is simply dummy...</p>
                </div>
                <p class="f-12 font-success">1 hr ago</p>
              </div>
            </li>
            <li>
              <div class="media">
                <img class="img-fluid rounded-circle me-3" src="{{asset('assets/images/user/4.jpg')}}" alt="">
                <div class="status-circle offline"></div>
                <div class="media-body">
                  <span>Ain Chavez</span>
                  <p>Lorem Ipsum is simply dummy...</p>
                </div>
                <p class="f-12 font-danger">32 mins ago</p>
              </div>
            </li>
            <li class="text-center"> <a class="btn btn-primary" href="#">View All     </a></li>
          </ul>
        </li>
        <li class="maximize"><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
        <li class="profile-nav onhover-dropdown p-0 me-0">
          <div class="media profile-media">
            <img class="b-r-10" src="{{asset('assets/images/dashboard/profile.jpg')}}" alt="">
            <div class="media-body">
              <span>Emay Walter</span>
              <p class="mb-0 font-roboto">Admin <i class="middle fa fa-angle-down"></i></p>
            </div>
          </div>
          <ul class="profile-dropdown onhover-show-div">
            <li><a href="#"><i data-feather="user"></i><span>Account </span></a></li>
            <li><a href="#"><i data-feather="mail"></i><span>Inbox</span></a></li>
            <li><a href="#"><i data-feather="file-text"></i><span>Taskboard</span></a></li>
            <li><a href="#"><i data-feather="settings"></i><span>Settings</span></a></li>
            <li><a href="#"><i data-feather="log-in"> </i><span>Log in</span></a></li>
          </ul>
        </li>
      </ul>
    </div> --}}
    <script class="result-template" type="text/x-handlebars-template">
      <div class="ProfileCard u-cf">
      <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
      <div class="ProfileCard-details">
      <div class="ProfileCard-realName">@{{name}}</div>
      </div>
      </div>
    </script>
    <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
  </div>
</div>
