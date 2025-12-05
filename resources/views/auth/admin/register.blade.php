@extends('web.layout.default')
@section('content')
<div class="container-fluid logInBack">
	<div class="container">
    	<div class="row">
        	<div class="col-xs-12 col-md-6"></div>
            <div class="col-xs-12 col-md-5 loginOuter">
            	<aside class="text-right">
            	<a href="index.html"><img src="{{url('web/image/logo.png')}}" class="formLogo"></a>
                </aside>
            	<div class="logInForm">
                	<h3 class="mainColor">Register with your details</h3>
                    <form action="{{url('register')}}" method="post">
                        @csrf
                    	<input type="text" name="name" placeholder="Your Name ">
                        @error('name')
                        <p class="error">{{$message}}</p>
                        @enderror
                    	<input type="text" name="email" placeholder="Email Address ">
                        @error('email')
                        <p class="error">{{$message}}</p>
                        @enderror
                        <input type="password" name="password" placeholder="Password">
                        <input type="password" name="password_confirmation" placeholder="Confirm Password">
                        @error('password')
                        <p class="error">{{$message}}</p>
                        @enderror
                        <button type="submit" value="Login" class="logSub">Login</button>
                        <h5 class="text-center mainColor"><a href="recover-password.html">Don't know your password?</a></h5>
                    </form>
                </div>
            </div>
            <div class="col-xs-12 col-md-1"></div>
        </div>
    </div>
</div>
@endsection