@extends('web.layout.default')
@section('content')

<section id="sign-up">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="form-head">
                    <h2>Login</h2>
                    <form action="{{url('login')}}" method="post">
                        @csrf
                        <div class="col-md-8 offset-md-4">
                            @if(isset($user) && !empty($user))
                            <h3> Refer By - {{$user->name}}</h3>                   
                            <input type="hidden" name="refer_by" value="{{$user->id}}">
                        @endif
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
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <span>Phone</span>
                            </div>
                            <div class="col-md-8">
                                <div class="input-field">
                                    <input type="text" name="phone" class="numeric" placeholder="eg: 123-123-1234">
                                </div>
                            </div>                  
                            <div class="col-md-4">
                                <span>Password</span>
                            </div>
                            <div class="col-md-8">
                                <div class="input-field">
                                    <input type="password" name="password" placeholder="eg: 12345678">
                                </div>
                            </div>                  
                            <div class="col-md-12">
                                <input type="submit" value="Login">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection