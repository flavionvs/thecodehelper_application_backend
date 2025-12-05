@extends('web.layout.default')
@section('content')
    <div style="    background: url(http://127.0.0.1:8000/images/bg.jpeg);
height: 100vh;
background-size: cover;
">
        <div style="    width: 100%;
        background: #00000030;
        height: 100vh;
        align-items: center;
        text-align: center;
        padding-top: 40vh;">
            <h1 style="    text-align: center;
    width: 100%;
    color: white;
    font-family: inherit;margin-bottom:20px">
                Welcome to our Home Page
            </h1>
            <a href="{{url('superadmin/login')}}" style="    background: royalblue;
            color: white;
            padding: 12px;
            border-radius: 3px;">Superadmin Login</a>
        </div>
    </div>
@endsection
