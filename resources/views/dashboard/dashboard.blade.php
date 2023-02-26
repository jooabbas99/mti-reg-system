@include('dashboard.layouts.header')
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
					<div class="page-icon">
						<i class="icon-laptop_windows"></i>
					</div>
					<div class="page-title">
						<h3>Dashboard</h3>
					
						<h6 class="sub-heading">Welcome to dashboard.</h6>
					</div>

				</div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
			@if(Auth::user()->role =='1')
				<div class="row gutters">
			        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
			        	<a href="{{route('user.index')}}">
				            <div class="plain-widget blue" data-toggle="tooltip" title="Users">
				                <div class="growth bg-info"><i class="icon-users"></i></div>
				                <h3>{{$users}}</h3>
				                <p>Users</p>
				                <div class="progress sm no-shadow">
				                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%;" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100"></div>
				                </div>
				            </div>
				        </a>
			        </div>
		        </div>
		    
	        
	        @else
	        	<h2 align="center">Welcome</h2>
	        @endif
        
	</div>
	<!-- END: .main-content -->
@include('dashboard.layouts.footer')