@extends('web.layout.default')
@section('content')
@php
$setting = App\Models\WebsiteSetting::first();
@endphp
<section id="sign-up">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="form-head">
                    <h2>Register</h2>                    
                    <form action="{{url('register')}}" method="post">
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
                                <span>Name</span>
                            </div>
                            <div class="col-md-8">
                                <div class="input-field">
                                    <input type="text" name="name" value="{{old('name')}}" placeholder="Full Name">
                                </div>
                            </div> 
                            <div class="col-md-4">
                                <span>Email</span>
                            </div>
                            <div class="col-md-8">
                                <div class="input-field">
                                    <input type="email" name="email" value="{{old('email')}}" placeholder="eg: example@gmail.com">
                                </div>
                            </div>                                                              
                            <div class="col-md-4">
                                <span>Phone</span>
                            </div>
                            <div class="col-md-8">
                                <div class="input-field">
                                    <input type="text" name="phone" value="{{old('phone')}}" placeholder="eg: 1234567890">
                                </div>
                            </div>                                                              
                            <div class="col-md-4">
                                <span>State</span>
                            </div>
                            <div class="col-md-8">
                                <div class="input-field">
                                        <select name="state" class="form-control" style="border: none;outline: none;box-shadow: none;width: 100%;background-color: #fff;border: 1px solid #000;padding: 5px 15px;height: 40px;border-radius: 10px;box-shadow: ">
                                        <option @if(old('state') == 'Andhra Pradesh') selected @endif>Andhra Pradesh</option>
                                        <option @if(old('state') == 'Arunachal Pradesh') selected @endif>Arunachal Pradesh</option>
                                        <option @if(old('state') == 'Assam') selected @endif>Assam</option>
                                        <option @if(old('state') == 'Bihar') selected @endif>Bihar</option>
                                        <option @if(old('state') == 'Chhattisgarh') selected @endif>Chhattisgarh</option>
                                        <option @if(old('state') == 'Goa') selected @endif>Goa</option>
                                        <option @if(old('state') == 'Gujarat') selected @endif>Gujarat</option>
                                        <option @if(old('state') == 'Haryana') selected @endif>Haryana</option>
                                        <option @if(old('state') == 'Himachal Pradesh') selected @endif>Himachal Pradesh</option>
                                        <option @if(old('state') == 'Jharkhand') selected @endif>Jharkhand</option>
                                        <option @if(old('state') == 'Karnataka') selected @endif>Karnataka</option>
                                        <option @if(old('state') == 'Kerala') selected @endif>Kerala</option>
                                        <option @if(old('state') == 'Madhya Pradesh') selected @endif>Madhya Pradesh</option>
                                        <option @if(old('state') == 'Maharashtra') selected @endif>Maharashtra</option>
                                        <option @if(old('state') == 'Manipur') selected @endif>Manipur</option>
                                        <option @if(old('state') == 'Meghalaya') selected @endif>Meghalaya</option>
                                        <option @if(old('state') == 'Mizoram') selected @endif>Mizoram</option>
                                        <option @if(old('state') == 'Nagaland') selected @endif>Nagaland</option>
                                        <option @if(old('state') == 'Odisha') selected @endif>Odisha</option>
                                        <option @if(old('state') == 'Punjab') selected @endif>Punjab</option>
                                        <option @if(old('state') == 'Rajasthan') selected @endif>Rajasthan</option>
                                        <option @if(old('state') == 'Sikkim') selected @endif>Sikkim</option>
                                        <option @if(old('state') == 'Tamil Nadu') selected @endif>Tamil Nadu</option>
                                        <option @if(old('state') == 'Telangana') selected @endif>Telangana</option>
                                        <option @if(old('state') == 'Tripura') selected @endif>Tripura</option>
                                        <option @if(old('state') == 'Uttarakhand') selected @endif>Uttarakhand</option>
                                        <option @if(old('state') == 'Uttar Pradesh') selected @endif>Uttar Pradesh</option>
                                        <option @if(old('state') == 'West Bengal') selected @endif>West Bengal</option>
                                    </select>
                                </div>
                            </div>      
                                                                                    
                            <div class="col-md-4">
                                <span>City</span>
                            </div>
                            <div class="col-md-8">
                                <div class="input-field">
                                    <input type="text" name="city" value="{{old('city')}}" placeholder="eg: Lucknow">
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
                            <div class="col-md-4">
                                <span>Confirm Password</span>
                            </div>
                            <div class="col-md-8">
                                <div class="input-field">
                                    <input type="password" name="password_confirmation" placeholder="eg: 12345678">
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