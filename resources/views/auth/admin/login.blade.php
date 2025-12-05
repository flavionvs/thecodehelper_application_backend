<!doctype html>
<html lang="en" dir="ltr">
  <head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>		
		<!--favicon -->
		<link rel="icon" href="{{asset('theme/assets/images/brand/favicon.ico')}}" type="image/x-icon"/>
		<link rel="shortcut icon" href="{{asset('theme/assets/images/brand/favicon.ico')}}" type="image/x-icon"/>

		<!-- TITLE -->
		<title>CSB</title>

		<!-- DASHBOARD CSS -->
		<link href="{{asset('theme/assets/css/style.css')}}" rel="stylesheet"/>
		<link href="{{asset('theme/assets/css/style-modes.css')}}" rel="stylesheet"/>

		<!-- SINGLE-PAGE CSS -->
		<link href="{{asset('theme/assets/plugins/single-page/css/main.css')}}" rel="stylesheet" type="text/css">

		<!--C3.JS CHARTS PLUGIN -->
		<link href="{{asset('theme/assets/plugins/charts-c3/c3-chart.css')}}" rel="stylesheet"/>

		<!-- CUSTOM SCROLL BAR CSS-->
		<link href="{{asset('theme/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>

		<!--- FONT-ICONS CSS -->
		<link href="{{asset('theme/assets/css/icons.css')}}" rel="stylesheet"/>

		<!-- Skin css-->
		<link href="{{asset('theme/assets/skins/skins-modes/color1.css')}}"  id="theme" rel="stylesheet" type="text/css" media="all" />

	</head>

	<body>

		<!-- BACKGROUND-IMAGE -->
		<div class="login-img">

			<!-- GLOABAL LOADER -->
			<div id="global-loader">
				<img src="{{asset('theme/assets/images/svgs/loader.svg')}}" class="loader-img" alt="Loader">
			</div>

			<div class="page">
				<div class="">
				    <!-- CONTAINER OPEN -->
					{{-- <div class="col col-login mx-auto">
						<div class="text-center">
							<img src="{{asset('theme/assets/images/brand/logo-2.png')}}" class="header-brand-img" alt="">
						</div>
					</div> --}}
					<div class="container-login100">
						<div class="wrap-login100 p-6">
							<form class="login100-form validate-form" action="{{url('admin/login')}}" method="post">
                @csrf
								<span class="login100-form-title">
									Member Login
								</span>
								<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
									<input class="input100" type="text" name="email" placeholder="Email">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<i class="zmdi zmdi-email" aria-hidden="true"></i>
									</span>
								</div>
								<div class="wrap-input100 validate-input" data-validate = "Password is required">
									<input class="input100" type="password" name="password" placeholder="Password">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<i class="zmdi zmdi-lock" aria-hidden="true"></i>
									</span>
								</div>
								<div class="text-right pt-1">
									<p class="mb-0"><a href="forgot-password.html" class="text-primary ml-1">Forgot Password?</a></p>
								</div>
							 <div class="container-login100-form-btn">
									<button type="submit" class="login100-form-btn btn-primary">
										Login
                  </button>
								</div>
								{{--	<div class="text-center pt-3">
									<p class="text-dark mb-0">Not a member?<a href="register.html" class="text-primary ml-1">Sign UP now</a></p>
								</div>
								<div class=" flex-c-m text-center mt-3">
								     <p>Or</p> 
									<div class="social-icons">
										<ul>
											<li><a class="btn  btn-social btn-block"><i class="fa fa-google-plus text-google-plus"></i> Sign up with Google</a></li>
											<li><a class="btn  btn-social btn-block mt-2"><i class="fa fa-facebook text-facebook"></i> Sign in with Facebook</a></li>
										</ul>
									</div>
								</div> --}}
							</form>
						</div>
					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>
		</div>
		<!-- BACKGROUND-IMAGE CLOSED -->

		<!-- JQUERY SCRIPTS -->
		<script src="{{asset('theme/assets/js/vendors/jquery-3.2.1.min.js')}}"></script>

		<!-- BOOTSTRAP SCRIPTS -->
		<script src="{{asset('theme/assets/js/vendors/bootstrap.bundle.min.js')}}"></script>

		<!-- SPARKLINE -->
		<script src="{{asset('theme/assets/js/vendors/jquery.sparkline.min.js')}}"></script>

		<!-- CHART-CIRCLE -->
		<script src="{{asset('theme/assets/js/vendors/circle-progress.min.js')}}"></script>

		<!-- RATING STAR -->
		<script src="{{asset('theme/assets/plugins/rating/jquery.rating-stars.js')}}"></script>

		<!-- SELECT2 JS -->
		<script src="{{asset('theme/assets/plugins/select2/select2.full.min.js')}}"></script>
		<script src="{{asset('theme/assets/js/select2.js')}}"></script>

		<!-- INPUT MASK PLUGIN-->
		<script src="{{asset('theme/assets/plugins/input-mask/jquery.mask.min.js')}}"></script>

		<!-- CUSTOM SCROLL BAR JS-->
		<script src="{{asset('theme/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js')}}"></script>

		<!-- CUSTOM JS-->
		<script src="{{asset('theme/assets/js/custom.js')}}"></script>

	</body>
</html>
