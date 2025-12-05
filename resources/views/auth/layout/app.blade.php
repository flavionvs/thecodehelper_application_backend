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
		<title>{{$title}}</title>
		
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
		{!! RecaptchaV3::initJs() !!}

	</head>

	<body>

		<!-- BACKGROUND-IMAGE -->
		<div class="login-img">

			<!-- GLOABAL LOADER -->
			<div id="global-loader">
				<img src="{{asset('theme/assets/images/svgs/loader.svg')}}" class="loader-img" alt="Loader">
			</div>

			@yield('content')

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

        <script>
            $(document).ready(function(){
                $('.eye').click(function(){
                    if($('.password').attr('type') == 'password'){
                        $(this).removeClass('zmdi-eye').addClass('zmdi-eye-off');
                        $('.password').attr('type', 'text');
                    }else{
                        $('.password').attr('type', 'password');
                        $(this).addClass('zmdi-eye').removeClass('zmdi-eye-off');
                    }
                });  
                $('.eye1').click(function(){
                    if($('.password1').attr('type') == 'password'){
                        $(this).removeClass('zmdi-eye').addClass('zmdi-eye-off');
                        $('.password1').attr('type', 'text');
                    }else{
                        $('.password1').attr('type', 'password');
                        $(this).addClass('zmdi-eye').removeClass('zmdi-eye-off');
                    }
                });  
            });
        </script>
        <style>
            .eye{
                position: absolute;
                top: 15px;
                right: 10px;
            }
            .eye1{
                position: absolute;
                top: 15px;
                right: 10px;
            }
        </style>
	</body>
</html>
