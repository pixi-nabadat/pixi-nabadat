<div class="sidebar-wrapper">
	<div>
		<div class="logo-wrapper">
			 <a href="{{route('home')}}"><img class="img-fluid for-light" src="{{asset('assets/images/logo/logo.png')}}" alt=""><img class="img-fluid for-dark" src="{{asset('assets/images/logo/logo_dark.png')}}" alt=""></a>
			<div class="back-btn"><i class="fa fa-angle-left"></i></div>
			<div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
		</div>
		<div class="logo-icon-wrapper"><a href="{{route('home')}}"><img class="img-fluid" src="{{asset('assets/images/logo/logo-icon.png')}}" alt=""></a></div>
		<nav class="sidebar-main">
			<div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
			<div id="sidebar-menu">
				<ul class="sidebar-links" id="simple-bar">
					<li class="back-btn">
						<a href="{{route('home')}}"><img class="img-fluid" src="{{asset('assets/images/logo/logo-icon.png')}}" alt=""></a>
						<div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
					</li>
					<li class="sidebar-main-title">
						<div>
							<h6 class="lan-1">{{ trans('lang.General') }} </h6>
                     		<p class="lan-2">{{ trans('lang.general_routes') }}</p>
						</div>
					</li>
					<li class="sidebar-list">

                        {{--                        start clients ------------------------------------------}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/doctors' ? 'active' : '' }}" href="#"><i data-feather="airplay"></i><span class="lan-6">{{ trans('lang.clients') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/doctors' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-4 {{ Route::currentRouteName()==route('clients.index') ? 'active' : '' }}" href="{{route('clients.index')}}">{{ trans('lang.view') }}</a></li>
                            <li><a class="lan-4 {{ Route::currentRouteName()==route('clients.index') ? 'active' : '' }}" href="{{route('clients.create')}}">{{ trans('lang.create') }}</a></li>
                        </ul>

                        {{--                        end clients --------------------------------------}}


{{--                        start doctors ------------------------------------------}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/doctors' ? 'active' : '' }}" href="#"><i data-feather="airplay"></i><span class="lan-6">{{ trans('lang.doctors') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/doctors' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-4 {{ Route::currentRouteName()==route('doctors.index') ? 'active' : '' }}" href="{{route('doctors.index')}}">{{ trans('lang.view') }}</a></li>
                            <li><a class="lan-4 {{ Route::currentRouteName()==route('doctors.index') ? 'active' : '' }}" href="{{route('doctors.create')}}">{{ trans('lang.create') }}</a></li>
                        </ul>

{{--                        end doctors --------------------------------------}}

{{--                        start clincs -------------------------------------}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/doctors' ? 'active' : '' }}" href="#"><i data-feather="airplay"></i><span class="lan-6">{{ trans('lang.clinics') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/doctors' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('clinics.index') ? 'active' : '' }}" href="{{route('clinics.index')}}">{{ trans('lang.view') }}</a></li>
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('clinics.index') ? 'active' : '' }}" href="{{route('clinics.index')}}">{{ trans('lang.create') }}</a></li>
                        </ul>
{{--                        end clincs ------------------------------------------}}

						{{--start devices--}}
						<a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/devices' ? 'active' : '' }}" href="#"><i data-feather="airplay"></i><span class="lan-6">{{ trans('lang.devices') }}</span>
							<div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/devices' ? 'down' : 'right' }}"></i></div>
						</a>
						<ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
							<li><a class="lan-5 {{ Route::currentRouteName()==route('devices.index') ? 'active' : '' }}" href="{{route('devices.index')}}">{{ trans('lang.view') }}</a></li>
							<li><a class="lan-5 {{ Route::currentRouteName()==route('devices.create') ? 'active' : '' }}" href="{{route('devices.create')}}">{{ trans('lang.create') }}</a></li>
						</ul>
						{{--end devices--}}
					</li>
                </ul>
			</div>
			<div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
		</nav>
	</div>
</div>
