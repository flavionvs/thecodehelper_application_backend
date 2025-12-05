<!doctype html>
<html lang="en" dir="ltr">
	<head>
		<script>
			let GUARD_NAME = '{{guardName()}}';						
		</script>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!--favicon -->
		<link rel="icon" href="{{asset('theme/assets/images/brand/favicon.ico')}}" type="image/x-icon"/>
		<link rel="shortcut icon" href="{{asset('theme/assets/images/brand/favicon.ico')}}" type="image/x-icon"/>

		<!-- TITLE -->
		<title>
			@if(isset($title))
				{{$title}}
			@else
			{{config('constant.app_name')}}
			@endif
		</title>
		<link href="{{asset('theme/assets/css/sidemenu/closed-sidemenu.css')}}" rel="stylesheet">

		<link href="{{asset('theme/assets/plugins/tabs/style-2.css')}}" rel="stylesheet" type="text/css">

		<!-- PERFECT SCROLL BAR CSS-->
		<link href="{{asset('theme/assets/plugins/pscrollbar/perfect-scrollbar.css')}}" rel="stylesheet" />

		<!--- FONT-ICONS CSS -->
		<link href="{{asset('theme/assets/css/icons.css')}}" rel="stylesheet"/>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="{{asset('chosen/chosen.css')}}" rel="stylesheet"/>

		<!-- Skin css-->
		<link href="{{asset('theme/assets/skins/skins-modes/color1.css')}}"  id="theme" rel="stylesheet" type="text/css" media="all" />

		{{-- Datatable --}}
		<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">

    	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
		<!-- DASHBOARD CSS -->
		<link href="{{asset('admin/css/style.css')}}" rel="stylesheet"/>
		<link href="{{asset('admin/css/my-custom-style.css')}}" rel="stylesheet"/>
		<link href="{{asset('theme/assets/css/style.css')}}" rel="stylesheet"/>
		<link href="{{asset('theme/assets/css/style-modes.css')}}" rel="stylesheet"/>
		<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">  

	</head>

	<body class="app sidebar-mini default-header">
	    <!-- GLOBAL-LOADER -->
		<div id="global-loader">
			<img src="{{asset('theme/assets/images/svgs/loader.svg')}}" class="loader-img" alt="Loader">
		</div>

		<div class="page">
			<div class="page-main">
				<!-- HEADER -->
        @include('admin.layout.navbar')
				<!-- HEADER END -->

				<!-- Sidebar menu-->
				<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
				@include('admin.layout.sidebar')

				<!-- CONTAINER -->
				@yield('content')
				<!-- CONTAINER END -->
        </div>

			@include('admin.layout.right-sidebar')
			
		</div>
		@include('admin.layout.partials.modal')

		<!-- BACK-TO-TOP -->
		<a href="#top" id="back-to-top"><i class="fa fa-long-arrow-up"></i></a>

		<!-- JQUERY SCRIPTS -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>	
				
		<!-- BOOTSTRAP SCRIPTS -->
		<script src="{{asset('theme/assets/js/vendors/bootstrap.bundle.min.js')}}"></script>

		<!-- SPARKLINE -->
		<script src="{{asset('theme/assets/js/vendors/jquery.sparkline.min.js')}}"></script>

	
		<!-- RATING STAR -->
		<script src="{{asset('theme/assets/plugins/rating/jquery.rating-stars.js')}}"></script>

		<!-- SELECT2 JS -->
		<script src="{{asset('theme/assets/plugins/select2/select2.full.min.js')}}"></script>
		<script src="{{asset('theme/assets/js/select2.js')}}"></script>

		<!-- LEFT-MENU -->
		<script src="{{asset('theme/assets/plugins/sidemenu-toggle/sidemenu-toggle.js')}}"></script>

		<!-- PERFECT SCROLL BAR JS-->
		<script src="{{asset('theme/assets/plugins/pscrollbar/perfect-scrollbar.js')}}"></script>
		<script src="{{asset('theme/assets/plugins/pscrollbar/pscroll-leftmenu.js')}}"></script>

		<!-- SIDEBAR JS -->
		<script src="{{asset('theme/assets/plugins/sidebar/sidebar.js')}}"></script>
		
		<script src="{{asset('chosen/chosen.jquery.js')}}"></script>

		<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script> 
		<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
		<script src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
		<!-- CUSTOM JS -->
		<script src="{{asset('theme/assets/js/custom.js')}}"></script>
		<script src="{{asset('admin/js/datatable.js')}}"></script>
		<script src="{{asset('admin/js/script.js')}}"></script>		
		<script src="{{asset('summernote/summernote.min.js')}}"></script>    

		<script>		
			$(document).ready(function(){                  		
				toastr.options = {
				"positionClass": "toast-top-right",          
				"closeButton": true,
				"debug": false,
				"newestOnTop": true,
				"progressBar": true,
				"preventDuplicates": true,
				"preventOpenDuplicates": true,
				"onclick": null,
				"showDuration": "1000",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "5000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
				}
				@if(session()->get('success'))
				toastr.success("{{session()->get('success')}}");
				@endif
				@if(session()->get('info'))
				toastr.info("{{session()->get('info')}}");
				@endif
				@if(session()->get('warning'))
				toastr.warning("{{session()->get('warning')}}");
				@endif
				@if(session()->get('error'))
				toastr.error("{{session()->get('error')}}");
				@endif    
				@if($errors->all())
				@foreach ($errors->all() as $error)
				toastr.error("{{$error}}");
				@endforeach 
				@endif
			});        
		</script>
	@stack('scripts')
	</body>
</html>
