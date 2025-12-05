@extends('admin.layout.default')

@section('title', 'Update Profile')

@section('content')
<div class="app-content">

  <!-- PAGE-HEADER -->
  <div class="page-header">
    <h4 class="page-title">Update Profile</h4>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url(guardName().'/dashboard')}}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Update Profile</li>
    </ol>
  </div>

  <!-- ROW OPEN -->
  <div class="row">
    <div class="col-md">
      <div class="card overflow-hidden">
        {{-- <div class="card-header">
          <h3 class="card-title">Select2</h3>
        </div> --}}
        <div class="card-body">   
          <form action="{{url(guardName().'/update-profile')}}" method="post" id="form" enctype="multipart/form-data" >
            @csrf
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Email Address" value="{{auth()->guard(guardName())->user()->email}}">
              </div>                              
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-label">Old Password</label>
                <input type="password" class="form-control" name="old_password" placeholder="Enter old password">
              </div>                              
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-label">New Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter new password">
              </div>                              
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confiem password">
              </div>                              
            </div>
            <div class="col-md-12">
              <small>Note :- If you don't want to update the password then leave the password fields blank</small>
            </div>
          </div>
        </div>
        <div class="card-footer text-right">
          <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
      </form>
    </div><!-- COL END -->
  </div>
  <!-- ROW CLOSED -->
</div>
@endsection
