@extends('auth.layout.app', ['title' => 'Login'])
@section('content')
<div class="page">
	<div class="" style="background: url({{asset("images/meeting-desktop.jpg")}});background-size: cover;
    height: 100vh;
    width: 100vw;">	
		<div class="container-login100">
			<div class="wrap-login100 p-6" style="background: #000000ba!important">
				<form class="login100-form validate-form" action="{{url('superadmin/login')}}" method="post">
					@csrf
					<span class="login100-form-title text-white">
						SUPERADMIN LOGIN
					</span>
					@if(Session::get('success'))
					<p style="color:green">{{Session::get('success')}}</p>
					@endif
					@if(Session::get('message'))
					<p style="color:red">{{Session::get('message')}}</p>
					@endif
					@if(Session::get('failed'))
					<p style="color:red">{{Session::get('failed')}}</p>
					@endif                     
					@if ($errors->any())
						@foreach ($errors->all() as $error)
						<p style="color:red">{{$error}}</p>
						@endforeach
					@endif
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
				
					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn btn-primary">
							Login
						  </button>
					</div>
				
				</form>
			</div>
		</div>
		<!-- CONTAINER CLOSED -->
	</div>
</div>
@endsection