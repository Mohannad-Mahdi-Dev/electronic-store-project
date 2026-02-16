
@section('dsadmin.layouts.app')

@endsection
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
				<!-- Brand Logo -->
				<a href="{{ route('home') }}" class="brand-link">
				<img src="{{ asset('admin-assets/img/AdminLogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
					<span class="brand-text font-weight-light">Electronics Store</span>
				</a>
				<!-- Sidebar -->
				<div class="sidebar">
					<!-- Sidebar user (optional) -->
					<nav class="mt-2">
						<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
							<!-- Add icons to the links using the .nav-icon class
								with font-awesome or any other icon font library -->
							

							<li class="nav-item">
							<a href="{{ url('/dashboard') }}"
								class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
								<i class="nav-icon fas fa-tachometer-alt"></i>
								Dashboard
							</a>
							</li>

							<li class="nav-item">
								<a href="{{ url('/categories') }}"
									class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">
									<i class="nav-icon fas fa-file-alt"></i>
									<p>Category</p>
								</a>
							</li>

							{{-- <li class="nav-item">
								<a href="#" class="nav-link">
									<i class="nav-icon fas fa-file-alt"></i>
									<p>Sub Category</p>
								</a>
							</li> --}}
							<li class="nav-item">
								<a href="{{ url('/brands') }}" class="nav-link {{ request()->is('brands*') ? 'active' : '' }}">
									<svg class="h-6 nav-icon w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
										<path stroke-linecap="round" stroke-linejoin="round" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
									  </svg>
									<p>Brands</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{ url('/products') }}" class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
									<i class="nav-icon fas fa-tag"></i>
									Products
								</a>
							</li>

							
							{{-- <li class="nav-item">
								<a href="#" class="nav-link">
									<!-- <i class="nav-icon fas fa-tag"></i> -->
									<i class="fas fa-truck nav-icon"></i>
									<p>Shipping</p>
								</a>
							</li>							 --}}
					
							<li class="nav-item">
								<a href="{{ url('/orders') }}"
									class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">
									<i class="nav-icon fas fa-shopping-bag"></i>
									Orders
								</a>
							</li>

						@auth 
						@if(auth()->user()->role_id === 1)

							<li class="nav-item">
								<a href="{{ url('/discounts') }}" class="nav-link {{ request()->is('discounts*') ? 'active' : '' }}">
									<i class="nav-icon  fa fa-percent" aria-hidden="true"></i>
									<p>Discount</p>
								</a>
							</li>		


							<li class="nav-item">
								<a href="{{url('/super-admins')}}" class="nav-link {{ request()->is('super-admins*') ? 'active' : '' }}">
									<i class="nav-icon  fas fa-users"></i>
									<p>Users</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="{{url('/pages')}}" class="nav-link {{ request()->is('pages*') ? 'active' : '' }}">
									<i class="nav-icon  far fa-file-alt"></i>
									<p>Pages</p>
								</a>
							</li>	
						@endif
						@endauth
						</ul>
					</nav>
					<!-- /.sidebar-menu -->
				</div>
				<!-- /.sidebar -->
         	</aside>