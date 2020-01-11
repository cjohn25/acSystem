<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head> 
		<meta name="csrf-token" content="{{ csrf_token() }}">
		 
	<title>{{config('app.name', 'Aircon Controller System')}}</title>
	{{-- css link  --}} 
	@include('links.headLink')
	{{-- end link --}}
</head>
<body class="page-body page-fade">
	<div class="page-container">	
	{{-- <div class="main-content"> --}}
			<div class="">
			<div class="row  navbar navbar-inverse">
				<!-- Profile Info and Notifications -->
				<div class="col-md-6 col-sm-8 clearfix">
					<ul class="user-info pull-left pull-none-xsm">
						<!-- Profile Info -->
						<li class="profile-info dropdown" style="padding: 15px"><!-- add class "pull-right" if you want to place this from right -->
							<a {{-- href="accounts/{{$item->id}}"  --}}
							   class="dropdown-toggle" data-toggle="dropdown"  style="color:azure">
							   {{-- <img src="assets/images/thumb-1.png" alt="" class="img-circle" /> --}}
							   <strong>Howdy,&nbsp;&nbsp;</strong>
							   {{ Auth::user()->name }}
						   </a> 
							<ul class="dropdown-menu">
								<!-- Reverse Caret -->
								<li class="caret"></li>
								<!-- Profile sub-links -->
								<li>
									<a href="/accountsProfile">
										<i class="entypo-user"></i>
										Edit Profile
									</a>
								</li>
							</ul>
						</li>
					</ul>
					<ul class="user-info pull-left pull-right-xs pull-none-xsm">
						<!-- Raw Notifications -->
						<!-- Message Notifications -->
						<!-- Task Notifications -->
					</ul>
				</div>
				<!-- Raw Links -->
				<div class="col-md-6 col-sm-4 clearfix hidden-xs">
					<ul class="list-inline links-list pull-right"> 
						<li  style="padding: 10px">
							<a  href="{{ route('logout') }}" 
							onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color:azure">
								Log Out <i class="entypo-logout right"></i>
							</a>	
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
								</form>
						</li>
					</ul>
				</div>
			</div> 
			<br /> 
			<div class="row">
				<div class="col-md-12 col-sm-8 clearfix">
					{{-- INSERT All Content --}}
					  @yield('content')
					{{-- END Content --}}
				</div>
			</div>
			<!-- Footer -->
			<footer class="main">
					<div class="text-center">
							&copy; 2018 <strong> Admin Theme by Pabz</strong>		
				</div>	
			</footer>	
		</div>
	{{-- SIDE BAR MENU --}}
	<div class="sidebar-menu">
		{{-- {{ menu('main','partials.menu.main')}} --}}
		 @include('menuItems.sidebar')
	</div>
	{{-- SIDE BAR MENU --}}
 	</div>
</body>	
{{-- script --}}
@include('links.footLink')
</html>