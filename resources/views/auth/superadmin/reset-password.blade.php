@extends('auth.layout.app', ['title' => 'CSB'])
@section('content')
<div class="page">
	<div class="">
		<!-- CONTAINER OPEN -->
		<div class="col col-login mx-auto">
			<div class="text-center">
				<img src="{{asset('theme/assets/images/brand/logo-2.png')}}" class="header-brand-img" alt="">
			</div>
		</div>
		<div class="container-login100">
			<div class="wrap-login100 p-6">
				<form class="login100-form validate-form" action="{{url('superadmin/reset-password')}}" method="post">
					@csrf
					<input type="hidden" name="forgot_token" value="{{Request::segment(3)}}">
					<span class="login100-form-title">
						Reset Password
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
					<div class="wrap-input100 validate-input position-relative" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100 password" type="password" name="password" placeholder="New Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="zmdi zmdi-lock" aria-hidden="true"></i>
						</span>
						<i class="zmdi zmdi-eye eye" aria-hidden="true"></i>
					</div>				
					<div class="wrap-input100 validate-input position-relative" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100 password1" type="password" name="password_confirmation" placeholder="Confirm Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="zmdi zmdi-lock" aria-hidden="true"></i>
						</span>
						<i class="zmdi zmdi-eye eye1" aria-hidden="true"></i>
					</div>				
					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn btn-primary">
							Reset Password
						  </button>
					</div>			
				</form>
			</div>
		</div>
	</div>
</div>
@endsection