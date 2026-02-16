{{-- @extends('layouts.admin') --}}

{{-- @section('page_title', 'لوحة التحكم')

@section('content') --}}
<!doctype html>
<html lang="an">
<head>
    	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
   

    	{{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css"> --}}
    {{-- <title>ElectroStore Admin</title> --}}

    {{-- <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"> --}}

	{{-- Page style  --}}
    	<link rel="stylesheet" href="{{ asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') }}">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="{{ asset('admin-assets/plugins/fontawesome-free/css/all.min.css') }}">
		<!-- Theme style -->
		<link rel="stylesheet" href="{{ asset('admin-assets/css/adminlte.min.css') }}">
		<link rel="stylesheet" href="{{ asset('admin-assets/css/custom.css') }}">
</head>
	<body class="hold-transition sidebar-mini">
		
<!-- Site wrapper -->
		<div class="wrapper">
			<!-- Navbar -->
			<nav class="main-header navbar navbar-expand navbar-white navbar-light">
				<!-- Right navbar links -->
				<ul class="navbar-nav">
					<li class="nav-item">
					  	<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
					</li>					
				</ul>
				<div class="navbar-nav pl-2">
					<!-- <ol class="breadcrumb p-0 m-0 bg-white">
						<li class="breadcrumb-item active">Dashboard</li>
					</ol> -->
				</div>
				
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" data-widget="fullscreen" href="#" role="button">
							<i class="fas fa-expand-arrows-alt"></i>
						</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
							<img src="{{ asset('admin-assets/img/avatar5.png') }}" class='img-circle elevation-2' width="40" height="40" alt="">
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
						
						@auth
					    <h4 class="h4 mb-0"><strong>{{ Auth::user()->name }}</strong></h4>
    					<div class="mb-3">{{ Auth::user()->email }}</div>
						@endauth
							{{-- Error type : Trying to get property 'name' of non-object --}}
							{{-- <h4 class="h4 mb-0"><strong>{{Auth::user()->name }}</strong></h4>
							<div class="mb-3">{{Auth::user()->email}}</div> --}}
							<div class="dropdown-divider"></div>
							
							<div class="dropdown-divider"></div>
							<a href="{{ route('password.change') }}" class="dropdown-item">
                                <i class="fas fa-lock mr-2"></i> Change Password
                            </a>

							@auth
							@if(auth()->user()->role_id === 1)
							<a href="{{ url('/super-admins') }}" class="dropdown-item">
                                <i class="fas fa-user mr-2"></i> Super Admins
                            </a>
							<a href="{{ url('/sub-admins') }}" class="dropdown-item">
                                <i class="fas fa-user mr-2"></i> Sub Admins
                            </a>
							<a href="{{ url('/customers') }}" class="dropdown-item">
                                <i class="fas fa-user mr-2"></i> Customers
                            </a>
							<a href="{{ route('setting.index') }}" class="dropdown-item">
								<i class="fas fa-cog mr-2"></i> Settings								
							</a>
                        @endif
						@endauth
							<div class="dropdown-divider"></div>

					<!-- Logout Form  used the post -->
				<form method="POST" action="{{ route('logout') }}">
					@csrf  <!-- This is the CSRF token, very important for security -->

					<a href="{{ route('logout') }}"
					class="dropdown-item text-danger"
					onclick="event.preventDefault(); this.closest('form').submit();">
						<i class="fas fa-sign-out-alt mr-2"></i>
					Logout
					</a>
				</form>

        <div class="dropdown-divider"></div>

					</li>
				</ul>
			</nav>
			<!-- /.navbar -->
			<!-- Main Sidebar Container -->
			@include('dsadmin.layouts.sidebar')
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
                @yield('content')
			</div>
			<!-- /.content-wrapper -->
			<footer class="main-footer">
				
				<strong> &copy; 2026 by Team Coder
			</footer>
			
		</div>
		<!-- ./wrapper -->
		<!-- jQuery -->
		<script src="{{asset('admin-assets/plugins/jquery/jquery.min.js')}}"></script>
        		<!-- Bootstrap 4 -->
		<script src="{{asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

	
		<!-- AdminLTE App -->
		<script src="{{ asset('admin-assets/js/adminlte.min.js') }}"></script>
		<!-- AdminLTE for demo purposes -->
		<script src="{{ asset('admin-assets/js/demo.js') }}"></script>

        @yield('customJs')
		<!-- Bootstrap JS -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

	</body>
    </html>