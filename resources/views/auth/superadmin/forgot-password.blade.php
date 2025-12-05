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
				<form class="login100-form validate-form" action="{{url('superadmin/forgot-password')}}" method="post">
					@csrf
					<span class="login100-form-title">
						Forgot Password
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
					<div class="text-right pt-1">
						<p class="mb-0"><a href="{{url('superadmin/login')}}" class="text-primary ml-1">Login ?</a></p>
					</div>
					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn btn-primary">
							Send Link
						  </button>
					</div>			
				</form>
			</div>
		</div>
	</div>
</div>
@endsection