<style>
    nav i {
        font-size: 20px !important;
    }
</style>
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
                        {{-- start country --}}
                        {{dd(request()->route()->getPrefix())}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/country' ? 'active' : '' }}" href="#"><i class="fa fa-map-marker p-r-5"></i><span class="lan-6">{{ trans('lang.country') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == 'country' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/country' ? 'block;' : 'none;' }}">
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('country.index') ? 'active' : '' }}" href="{{route('country.index')}}">{{ trans('lang.countries') }}</a></li>
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('country.create') ? 'active' : '' }}" href="{{route('country.create')}}">{{ trans('lang.create_country') }}</a></li>
                        </ul>
                        {{-- end country --}}

                        {{-- start governorate --}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/governorate' ? 'active' : '' }}" href="#"><i class="fa fa-map-marker p-r-5"></i><span class="lan-6">{{ trans('lang.governorate') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/governorate' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('governorate.index') ? 'active' : '' }}" href="{{route('governorate.index')}}">{{ trans('lang.governorate') }}</a></li>
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('governorate.create') ? 'active' : '' }}" href="{{route('governorate.create')}}">{{ trans('lang.create_governorate') }}</a></li>
                        </ul>
                        {{-- end governorate --}}

                        {{-- end city --}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/city' ? 'active' : '' }}" href="#"><i class="fa fa-map-marker p-r-5"></i><span class="lan-6">{{ trans('lang.city') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/city' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('city.index') ? 'active' : '' }}" href="{{route('city.index')}}">{{ trans('lang.city') }}</a></li>
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('city.create') ? 'active' : '' }}" href="{{route('city.create')}}">{{ trans('lang.create_city') }}</a></li>
                        </ul>
                        {{-- end city --}}

                        {{--start clients--}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/doctors' ? 'active' : '' }}" href="#"><i class="fa fa-user p-r-5"></i><span class="lan-6">{{ trans('lang.clients') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/doctors' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/doctors' ? 'block;' : 'none;' }}">
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('clients.index') ? 'active' : '' }}" href="{{route('clients.index')}}">{{ trans('lang.view') }}</a></li>
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('clients.index') ? 'active' : '' }}" href="{{route('clients.create')}}">{{ trans('lang.create') }}</a></li>
                        </ul>
                        {{-- end clients --}}

                        {{-- end centers --}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/centers' ? 'active' : '' }}" href="#"><i class="fa fa-home p-r-5"></i><span class="lan-6">{{ trans('lang.center') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/centers' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('centers.index') ? 'active' : '' }}" href="{{route('centers.index')}}">{{ trans('lang.center') }}</a></li>
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('centers.create') ? 'active' : '' }}" href="{{route('centers.create')}}">{{ trans('lang.create_center') }}</a></li>
                        </ul>
                        {{-- end centers --}}

                        {{-- start doctors --}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/doctors' ? 'active' : '' }}" href="#"><i class="fa fa-user p-r-5"></i><span class="lan-6">{{ trans('lang.doctors') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/doctors' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('doctors.index') ? 'active' : '' }}" href="{{route('doctors.index')}}">{{ trans('lang.view') }}</a></li>
                            <li><a class="lan-4 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('doctors.index') ? 'active' : '' }}" href="{{route('doctors.create')}}">{{ trans('lang.create') }}</a></li>
                        </ul>
                        {{-- end doctors --}}

                        {{-- start categories ---}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/categories' ? 'active' : '' }}" href="#"><i class="fa fa-cube p-r-5"></i><span class="lan-6">{{ trans('lang.category') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/categories' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('categories.index') ? 'active' : '' }}" href="{{route('categories.index')}}">{{ trans('lang.view') }}</a></li>
                            <li><a class="lan-5 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('categories.create') ? 'active' : '' }}" href="{{route('categories.create')}}">{{ trans('lang.create') }}</a></li>
                        </ul>
                        {{-- end categories --}}

                        {{-- start coupon ---}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/coupons' ? 'active' : '' }}" href="#"><i class="fa fa-sort-numeric-asc p-r-5"></i><span class="lan-6">{{ trans('lang.coupon') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/coupons' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('coupons.index') ? 'active' : '' }}" href="{{route('coupons.index')}}">{{ trans('lang.view') }}</a></li>
                            <li><a class="lan-5 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('coupons.create') ? 'active' : '' }}" href="{{route('coupons.create')}}">{{ trans('lang.create') }}</a></li>
                        </ul>
                        {{-- end coupon --}}

						{{-- start devices --}}
						<a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/devices' ? 'active' : '' }}" href="#"><i class="fa fa-cubes p-r-5"></i><span class="lan-6">{{ trans('lang.devices') }}</span>
							<div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/devices' ? 'down' : 'right' }}"></i></div>
						</a>
						<ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
							<li><a class="lan-5 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('devices.index') ? 'active' : '' }}" href="{{route('devices.index')}}">{{ trans('lang.view') }}</a></li>
							<li><a class="lan-5 {{ \Illuminate\Support\Facades\Route::currentRouteName()==route('devices.create') ? 'active' : '' }}" href="{{route('devices.create')}}">{{ trans('lang.create') }}</a></li>
						</ul>
						{{-- end devices --}}

                         {{-- start product ---}}
                         <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/products' ? 'active' : '' }}" href="#"><i data-feather="airplay"></i><span class="lan-6">{{ trans('lang.product') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/products' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('products.index') ? 'active' : '' }}" href="{{route('products.index')}}">{{ trans('lang.view') }}</a></li>
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('products.create') ? 'active' : '' }}" href="{{route('products.create')}}">{{ trans('lang.create') }}</a></li>
                        </ul>
                        {{-- end product --}}

                        {{-- start package --}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/packages' ? 'active' : '' }}" href="#"><i data-feather="airplay"></i><span class="lan-6">{{ trans('lang.package') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/packages' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('packages.index') ? 'active' : '' }}" href="{{route('packages.index')}}">{{ trans('lang.view') }}</a></li>
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('packages.create') ? 'active' : '' }}" href="{{route('packages.create')}}">{{ trans('lang.create') }}</a></li>
                        </ul>
                        {{--end package --}}

                        {{--start Cancel Reason ---}}
                        <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/cancelReasons' ? 'active' : '' }}" href="#"><i data-feather="airplay"></i><span class="lan-6">{{ trans('lang.cancelReason') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/cancelReasons' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('cancelReasons.index') ? 'active' : '' }}" href="{{route('cancelReasons.index')}}">{{ trans('lang.view') }}</a></li>
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('cancelReasons.create') ? 'active' : '' }}" href="{{route('cancelReasons.create')}}">{{ trans('lang.create') }}</a></li>
                        </ul>
                        {{-- end Cancel Reason --}}

                         {{--start Center Devices ---}}
                         <a class="sidebar-link sidebar-title {{request()->route()->getPrefix() == '/centerDevices' ? 'active' : '' }}" href="#"><i data-feather="airplay"></i><span class="lan-6">{{ trans('lang.centerDevices') }}</span>
                            <div class="according-menu"><i class="fa fa-angle-{{request()->route()->getPrefix() == '/centerDevices' ? 'down' : 'right' }}"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->route()->getPrefix() == '/widgets' ? 'block;' : 'none;' }}">
                            <li><a class="lan-5 {{ Route::currentRouteName()==route('centerDevices.index') ? 'active' : '' }}" href="{{route('centerDevices.index')}}">{{ trans('lang.view') }}</a></li>
                        </ul>
                        {{-- end Center Devices --}}

					</li>
                </ul>
			</div>
			<div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
		</nav>
	</div>
</div>
