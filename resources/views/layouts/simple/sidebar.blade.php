<div class="sidebar-wrapper">
	<div>
		<div class="logo-wrapper">
			{{-- <a href="{{route('/')}}"><img class="img-fluid for-light" src="{{asset('assets/images/logo/logo.png')}}" alt=""><img class="img-fluid for-dark" src="{{asset('assets/images/logo/logo_dark.png')}}" alt=""></a> --}}
			<div class="back-btn"><i class="fa fa-angle-left"></i></div>
			<div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
		</div>
		<div class="logo-icon-wrapper"><a href="{{route('/')}}"><img class="img-fluid" src="{{asset('assets/images/logo/logo-icon.png')}}" alt=""></a></div>
		<nav class="sidebar-main">
			<div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
			<div id="sidebar-menu">
				<ul class="sidebar-links" id="simple-bar">
					<li class="back-btn">
						<a href="{{route('/')}}"><img class="img-fluid" src="{{asset('assets/images/logo/logo-icon.png')}}" alt=""></a>
						<div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
					</li>
					<li class="sidebar-main-title">
						<div>
							<h6 class="lan-1">{{ trans('lang.General') }} </h6>
                     		<p class="lan-2">{{ trans('lang.Dashboards,widgets & layout.') }}</p>
						</div>
					</li>
					<li class="sidebar-list">
						<label class="badge badge-success">2</label><a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/dashboard' ? 'active' : '' }}" href="#"><i data-feather="home"></i><span class="lan-3">{{ trans('lang.Dashboards') }}</span>
							<div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/dashboard' ? 'down' : 'right' }}"></i></div>
						</a>
						<ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/dashboard' ? 'block;' : 'none;' }}">
							<li><a class="lan-4 {{ Route::currentRouteName()=='index' ? 'active' : '' }}" href="{{route('index')}}">{{ trans('lang.Default') }}</a></li>
                     		<li><a class="lan-5 {{ Route::currentRouteName()=='dashboard-02' ? 'active' : '' }}" href="{{route('dashboard-02')}}">{{ trans('lang.Ecommerce') }}</a></li>
						</ul>
					</li>
					<li class="sidebar-list">
						<label class="badge badge-success">2</label><a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == 'addCountry' ? 'active' : '' }}" href="#"><i data-feather="home"></i><span class="lan-3">{{ trans('lang.Locations') }}</span>
							<div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/addCountry' ? 'down' : 'right' }}"></i></div>
						</a>
						<ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/addCountry' ? 'block;' : 'none;' }}">
							<li><a class="lan-4 {{ Route::currentRouteName()=='index' ? 'active' : '' }}" href="{{route('addCountry')}}">{{ trans('lang.Country') }}</a></li>
                            <li><a class="lan-4 {{ Route::currentRouteName()=='index' ? 'active' : '' }}" href="{{route('governateform')}}">{{ trans('lang.Governorate') }}</a></li>
                            <li><a class="lan-4 {{ Route::currentRouteName()=='index' ? 'active' : '' }}" href="{{route('cityform')}}">{{ trans('lang.City') }}</a></li>
						</ul>
					</li>

					<li class="sidebar-list">
							<a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/widgets' ? 'active' : '' }}" href="#"><i data-feather="airplay"></i><span class="lan-6">{{ trans('lang.Widgets') }}</span>
								<div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/widgets' ? 'down' : 'right' }}"></i></div>
							</a>
							<ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
			                    <li><a href="{{route('general-widget')}}" class="{{ Route::currentRouteName()=='general-widget' ? 'active' : '' }}">{{ trans('lang.General') }}</a></li>
			                    <li><a href="{{route('chart-widget')}}" class="{{ Route::currentRouteName()=='chart-widget' ? 'active' : '' }}">{{ trans('lang.Chart') }}</a></li>
		                  	</ul>
					</li>
					<li class="sidebar-list">
						<a class="sidebar-link sidebar-title {{ request()->route()->getPrefix() == '/page-layouts' ? 'active' : '' }}" href="#"><i data-feather="layout"></i>
							<span class="lan-7">{{ trans('lang.Page layout') }}</span>
							<div class="according-menu"><i class="fa fa-angle-{{ request()->route()->getPrefix() == '/page-layouts' ? 'down' : 'right' }}"></i></div>
						</a>
	                    <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/page-layouts' ? 'block;' : 'none;' }}">
                          <li><a href="{{ route('box-layout') }}" class="{{ Route::currentRouteName() == 'box-layout' ? 'active' : '' }}">Boxed</a></li>
                          <li><a href="{{ route('layout-rtl') }}" class="{{ Route::currentRouteName() == 'layout-rtl' ? 'active' : '' }}">RTL</a></li>
                          <li><a href="{{ route('layout-dark') }}" class="{{ Route::currentRouteName() == 'layout-dark' ? 'active fw-bold' : '' }}">Dark Layout</a></li>
                          <li><a href="{{ route('hide-on-scroll') }}" class="{{ Route::currentRouteName() == 'hide-on-scroll' ? 'active' : '' }}">Hide Nav Scroll</a></li>
                          <li><a href="{{ route('footer-light') }}" class="{{ Route::currentRouteName() == 'footer-light' ? 'active' : '' }}">Footer Light</a></li>
                          <li><a href="{{ route('footer-dark') }}" class="{{ Route::currentRouteName() == 'footer-dark' ? 'active' : '' }}">Footer Dark</a></li>
                          <li><a href="{{ route('footer-fixed') }}" class="{{ Route::currentRouteName() == 'footer-fixed' ? 'active' : '' }}">Footer Fixed</a></li>
                      </ul>
                  	</li>
{{--					----------------------------------------------------------}}
					<li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav {{ Route::currentRouteName()=='bookmark' ? 'active' : '' }}" href="{{route('bookmark')}}"><i data-feather="heart"> </i><span>{{ trans('lang.Bookmarks') }}</span></a></li>
{{--					----------------------------------------------------------}}
                    <li class="sidebar-main-title">
						<div>
							<h6>{{ trans('lang.Forms & Table') }}</h6>
                 			<p>{{ trans('lang.Ready to use froms & tables') }}</p>
						</div>
					</li>
					<li class="sidebar-list">
						<a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/forms' ? 'active' : '' }}" href="#">
							<i data-feather="file-text"></i><span>{{ trans('lang.Forms') }}</span>
							<div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/forms' ? 'down' : 'right' }}"></i></div>
						</a>
						<ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/forms' ? 'block;' : 'none;' }}">
							<li>
								<a class="submenu-title {{ in_array(Route::currentRouteName(), ['form-validation', 'base-input', 'radio-checkbox-control', 'input-group', 'megaoptions']) ? 'active' : '' }}" href="#">Form Controls
									<div class="according-menu"><i class="fa fa-angle-{{ in_array(Route::currentRouteName(), ['form-validation', 'base-input', 'radio-checkbox-control', 'input-group', 'megaoptions']) ? 'down' : 'right' }}"></i></div>
								</a>
								<ul class="nav-sub-childmenu submenu-content" style="display: {{ in_array(Route::currentRouteName(), ['form-validation', 'base-input', 'radio-checkbox-control', 'input-group', 'megaoptions']) ? 'block' : 'none;' }};">
									<li><a href="{{route('form-validation')}}" class="{{ Route::currentRouteName()=='form-validation' ? 'active' : '' }}">Form Validation</a></li>
		                            <li><a href="{{route('base-input')}}" class="{{ Route::currentRouteName()=='base-input' ? 'active' : '' }}">Base Inputs</a></li>
		                            <li><a href="{{route('radio-checkbox-control')}}" class="{{ Route::currentRouteName()=='radio-checkbox-control' ? 'active' : '' }}">Checkbox & Radio</a></li>
		                            <li><a href="{{route('input-group')}}" class="{{ Route::currentRouteName()=='input-group' ? 'active' : '' }}">Input Groups</a></li>
		                            <li><a href="{{route('megaoptions')}}" class="{{ Route::currentRouteName()=='megaoptions' ? 'active' : '' }}">Mega Options</a></li>
								</ul>
							</li>
							<li>
								<a class="submenu-title {{ in_array(Route::currentRouteName(), ['datepicker', 'time-picker', 'datetimepicker','daterangepicker' ,'touchspin', 'select2', 'switch', 'typeahead', 'clipboard']) ? 'active' : '' }}" href="#">Form Widgets
									<div class="according-menu"><i class="fa fa-angle-{{ in_array(Route::currentRouteName(), ['datepicker', 'time-picker', 'datetimepicker','daterangepicker' ,'touchspin', 'select2', 'switch', 'typeahead', 'clipboard']) ? 'down' : 'right' }}"></i></div>
								</a>
								<ul class="nav-sub-childmenu submenu-content" style="display: {{ in_array(Route::currentRouteName(), ['datepicker', 'time-picker', 'datetimepicker','daterangepicker' ,'touchspin', 'select2', 'switch', 'typeahead', 'clipboard']) ? 'block' : 'none;' }};">
										<li><a href="{{route('datepicker')}}" class="{{ Route::currentRouteName()=='datepicker' ? 'active' : '' }}">Datepicker</a></li>
		                              	<li><a href="{{route('time-picker')}}" class="{{ Route::currentRouteName()=='time-picker' ? 'active' : '' }}">Timepicker</a></li>
		                              	<li><a href="{{route('datetimepicker')}}" class="{{ Route::currentRouteName()=='datetimepicker' ? 'active' : '' }}">Datetimepicker</a></li>
		                              	<li><a href="{{route('daterangepicker')}}" class="{{ Route::currentRouteName()=='daterangepicker' ? 'active' : '' }}">Daterangepicker</a></li>
		                              	<li><a href="{{route('touchspin')}}" class="{{ Route::currentRouteName()=='touchspin' ? 'active' : '' }}">Touchspin</a></li>
		                              	<li><a href="{{route('select2')}}" class="{{ Route::currentRouteName()=='select2' ? 'active' : '' }}">Select2</a></li>
		                              	<li><a href="{{route('switch')}}" class="{{ Route::currentRouteName()=='switch' ? 'active' : '' }}">Switch</a></li>
		                              	<li><a href="{{route('typeahead')}}" class="{{ Route::currentRouteName()=='typeahead' ? 'active' : '' }}">Typeahead</a></li>
		                              	<li><a href="{{route('clipboard')}}" class="{{ Route::currentRouteName()=='clipboard' ? 'active' : '' }}">Clipboard</a></li>
								</ul>
							</li>
							<li>
								<a class="submenu-title {{ in_array(Route::currentRouteName(), ['default-form', 'form-wizard', 'form-wizard-two', 'form-wizard-three']) ? 'active' : '' }}" href="#">Form Layout
									<div class="according-menu"><i class="fa fa-angle-{{ in_array(Route::currentRouteName(), ['default-form', 'form-wizard', 'form-wizard-two', 'form-wizard-three']) ? 'down' : 'right' }}"></i></div>
								</a>
								<ul class="nav-sub-childmenu submenu-content" style="display: {{ in_array(Route::currentRouteName(), ['default-form', 'form-wizard', 'form-wizard-two', 'form-wizard-three']) ? 'block' : 'none;' }};">
	                              	<li><a href="{{route('default-form')}}" class="{{ Route::currentRouteName()=='default-form' ? 'active' : '' }}">Default Forms</a></li>
	                              	<li><a href="{{route('form-wizard')}}" class="{{ Route::currentRouteName()=='form-wizard' ? 'active' : '' }}">Form Wizard 1</a></li>
	                              	<li><a href="{{route('form-wizard-two')}}" class="{{ Route::currentRouteName()=='form-wizard-two' ? 'active' : '' }}">Form Wizard 2</a></li>
	                              	<li><a href="{{route('form-wizard-three')}}" class="{{ Route::currentRouteName()=='form-wizard-three' ? 'active' : '' }}">Form Wizard 3</a></li>
	                        	</ul>
							</li>
						</ul>
					</li>
					<li class="mega-menu">
						<a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/others' ? 'active' : '' }}" href="#"><i data-feather="layers"></i><span>{{ trans('lang.Others') }}</span>
							<div class="according-menu other"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/others' ? 'down' : 'right' }}"></i></div>
						</a>
						<div class="mega-menu-container menu-content">
							<div class="container-fluid">
								<div class="row">
									<div class="col mega-box">
										<div class="link-section">
											<div class="submenu-title">
												<h5>Error Page</h5>
												<div class="according-menu"><i class="fa fa-angle-{{ in_array(Route::currentRouteName(), ['error-400', 'error-401', 'error-403', 'error-404', 'error-500', 'error-503']) ? 'down' : 'right' }}"></i></div>
											</div>
											<ul class="submenu-content opensubmegamenu" style="display: {{ in_array(Route::currentRouteName(), ['error-400', 'error-401', 'error-403', 'error-404', 'error-500', 'error-503']) ? 'block;' : 'none;' }}">
												<li><a href="{{route('error-400')}}" class="{{ Route::currentRouteName()=='error-400' ? 'active' : '' }}">Error 400</a></li>
		                                       <li><a href="{{route('error-401')}}" class="{{ Route::currentRouteName()=='error-401' ? 'active' : '' }}">Error 401</a></li>
		                                       <li><a href="{{route('error-403')}}" class="{{ Route::currentRouteName()=='error-403' ? 'active' : '' }}">Error 403</a></li>
		                                       <li><a href="{{route('error-404')}}" class="{{ Route::currentRouteName()=='error-404' ? 'active' : '' }}">Error 404</a></li>
		                                       <li><a href="{{route('error-500')}}" class="{{ Route::currentRouteName()=='error-500' ? 'active' : '' }}">Error 500</a></li>
		                                       <li><a href="{{route('error-503')}}" class="{{ Route::currentRouteName()=='error-503' ? 'active' : '' }}">Error 503</a></li>
											</ul>
										</div>
									</div>
									<div class="col mega-box">
										<div class="link-section">
											<div class="submenu-title">
												<h5> Authentication</h5>
												<div class="according-menu"><i class="fa fa-angle-{{ in_array(Route::currentRouteName(), ['login', 'login-one', 'login-two', 'login-bs-validation', 'login-bs-tt-validation', 'login-sa-validation', 'sign-up', 'sign-up-one', 'sign-up-two', 'sign-up-wizard', 'unlock', 'forget-password', 'reset-password', 'maintenance']) ? 'down' : 'right' }}"></i></div>
											</div>
											<ul class="submenu-content opensubmegamenu" style="display: {{ in_array(Route::currentRouteName(), ['login', 'login-one', 'login-two', 'login-bs-validation', 'login-bs-tt-validation', 'login-sa-validation', 'sign-up', 'sign-up-one', 'sign-up-two', 'sign-up-wizard', 'unlock', 'forget-password', 'reset-password', 'maintenance']) ? 'block;' : 'none;' }}">
												<li><a href="{{route('login')}}" target="_blank">Login Simple</a></li>
			                                    <li><a href="{{route('login-one')}}" target="_blank">Login with bg image</a></li>
			                                    <li><a href="{{route('login-two')}}" target="_blank">Login with image two </a></li>
			                                    <li><a href="{{route('login-bs-validation')}}" target="_blank">Login With validation</a></li>
			                                    <li><a href="{{route('login-bs-tt-validation')}}" target="_blank">Login with tooltip</a></li>
			                                    <li><a href="{{route('login-sa-validation')}}" target="_blank">Login with sweetalert</a></li>
			                                    <li><a href="{{route('sign-up')}}" target="_blank">Register Simple</a></li>
			                                    <li><a href="{{route('sign-up-one')}}" target="_blank">Register with Bg Image </a></li>
			                                    <li><a href="{{route('sign-up-two')}}" target="_blank">Register with Bg video</a></li>
			                                    <li><a href="{{route('sign-up-wizard')}}" target="_blank">Register wizard</a></li>
			                                    <li><a href="{{route('unlock')}}">Unlock User</a></li>
			                                    <li><a href="{{route('forget-password')}}">Forget Password</a></li>
			                                    <li><a href="{{route('reset-password')}}">Reset Password</a></li>
			                                    <li><a href="{{route('maintenance')}}">Maintenance</a></li>
											</ul>
										</div>
									</div>
									<div class="col mega-box">
										<div class="link-section">
											<div class="submenu-title">
												<h5>Coming Soon</h5>
												<div class="according-menu"><i class="fa fa-angle-{{ in_array(Route::currentRouteName(), ['comingsoon', 'comingsoon-bg-video', 'comingsoon-bg-img']) ? 'down' : 'right' }}"></i></div>
											</div>
											<ul class="submenu-content opensubmegamenu"  style="display: {{ in_array(Route::currentRouteName(), ['comingsoon', 'comingsoon-bg-video', 'comingsoon-bg-img']) ? 'block;' : 'none;' }}">
												<li><a href="{{route('comingsoon')}}" class="{{ Route::currentRouteName()=='comingsoon' ? 'active' : '' }}">Coming Simple</a></li>
		                                       <li><a href="{{route('comingsoon-bg-video')}}" class="{{ Route::currentRouteName()=='comingsoon-bg-video' ? 'active' : '' }}">Coming with Bg video</a></li>
		                                       <li><a href="{{route('comingsoon-bg-img')}}" class="{{ Route::currentRouteName()=='comingsoon-bg-img' ? 'active' : '' }}">Coming with Bg Image</a></li>
											</ul>
										</div>
									</div>
									<div class="col mega-box">
										<div class="link-section">
											<div class="submenu-title">
												<h5>Email templates</h5>
												<div class="according-menu"><i class="fa fa-angle-{{ in_array(Route::currentRouteName(), ['basic-template', 'email-header', 'template-email', 'ecommerce-templates', 'email-order-success']) ? 'down' : 'right' }}"></i></div>
											</div>
											<ul class="submenu-content opensubmegamenu" style="display: {{ in_array(Route::currentRouteName(), ['basic-template', 'email-header', 'template-email', 'ecommerce-templates', 'email-order-success']) ? 'block;' : 'none;' }}">
												<li><a href="{{route('basic-template')}}" class="{{ Route::currentRouteName()=='basic-template' ? 'active' : '' }}">Basic Email</a></li>
		                                       <li><a href="{{route('email-header')}}" class="{{ Route::currentRouteName()=='email-header' ? 'active' : '' }}">Basic With Header</a></li>
		                                       <li><a href="{{route('template-email')}}" class="{{ Route::currentRouteName()=='template-email' ? 'active' : '' }}">Ecomerce Template</a></li>
		                                       <li><a href="{{route('template-email-2')}}" class="{{ Route::currentRouteName()=='template-email-2' ? 'active' : '' }}">Email Template 2</a></li>
		                                       <li><a href="{{route('ecommerce-templates')}}" class="{{ Route::currentRouteName()=='ecommerce-templates' ? 'active' : '' }}">Ecommerce Email</a></li>
		                                       <li><a href="{{route('email-order-success')}}" class="{{ Route::currentRouteName()=='email-order-success' ? 'active' : '' }}">Order Success</a></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
                </ul>
			</div>
			<div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
		</nav>
	</div>
</div>
