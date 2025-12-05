@extends('admin.layout.default', ['title' => 'My Profile'])
@section('content')
    @php
        $user = auth()
            ->guard(guardName())
            ->user();
    @endphp
    <div class="app-content">
        <x-header header="My Profile" link1="My Profile" />
        <x-card header="Update Profile" collapse="no">
            <form action="{{ url(guardName() . '/update-profile') }}" method="post" enctype="multipart/form-data" id="form">
                @csrf
                <div class="row d-flex justify-space-around">
                    <div class="col-md-6 offset-md-3 mt-3">
                        <div class="row">
                           <div class="col-md-6 offset-md-3">
                               <img src="{{ asset(viewImage($user->image)) }}" width="150px"
                               id="image">
                           </div>
                           <div class="col-md-12"></div>
                                <div class="col-lg-3 mb-2 text-lg-right">
                                    <label for="">Image</label>
                                </div>
                            <div class="col-md-9 mb-2 text-center">
                                <input type="file" name="image" class="form-control image" accept="image/*"
                                    data-id="image">
                            </div>
                            <div class="col-lg-3 mb-2 text-lg-right">
                                <label for="">Full Name</label>
                            </div>
                            <div class="col-lg-9 mb-2">
                                <input type="text" name="first_name" class="form-control"
                                    value="{{ $user->first_name }}">
                            </div>
                            <div class="col-lg-3 text-lg-right">
                                <label for="">Phone</label>
                            </div>
                            <div class="col-lg-9 mb-2">
                                <input type="text" name="phone" class="form-control numeric"
                                    value="{{ $user->phone }}">
                            </div>
                            <div class="col-lg-3 text-lg-right">
                                <label for="">Email</label>
                            </div>
                            <div class="col-lg-9 mb-2">
                                <input type="email" name="email" class="form-control"
                                    value="{{ $user->email }}" autocomplete="off">
                            </div>
                            <div class="col-lg-3 text-lg-right">
                                <label for="">New Password</label>
                            </div>
                            <div class="col-lg-9 mb-2">
                                <div class="position-relative">
                                    <input type="password" name="password" class="form-control password" value=""
                                        autocomplete="off">
                                    <i class="fa fa-eye eye"></i>
                                </div>
                            </div>
                            <div class="col-md-12 text-right mr-3">
                                <button type="submit" class="btn btn-primary btn form-btn">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </x-card>
    @endsection
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#generate-password').click(function() {
                    generatePwd();
                });

                function generatePwd() {resources
                    $('.password').val(Math.floor(Math.random() * 99999999) + 10000000);
                }
                $('.eye').click(function() {
                    if ($(this).prev('.password').attr('type') == 'password') {
                        $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                        $(this).prev('.password').attr('type', 'text');
                    } else {
                        $(this).addClass('fa-eye').removeClass('fa-eye-slash');
                        $(this).prev('.password').attr('type', 'password');
                    }
                });

             
            });
        </script>
    @endpush
