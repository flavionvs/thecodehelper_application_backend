@extends(guardName().'.layout.default')

@section('title', __('admin.Website Setting'))

@section('content')
<section class="content-header" style="padding-bottom:0px!important">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h3>{{ucfirst(str_replace('-',' ',Request::segment(3)))}}</h3>
          </div>          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">            
            <div class="col-12">             
                <div class="card p-3" style="overdlow:scroll!important">                          
             
                    <form action="{{url(guardName().'/update-website-setting')}}" method="post" id="form" enctype="multipart/form-data">
                        @csrf   
                        @if(Request::segment(3) == 'logo')             
                        <div class="row mb-2 tabs-container logo">
                            <div class="col-md-3 mb-2 text-md-right">
                                <label for="">Logo</label>
                            </div>
                            <div class="col-md-9 mb-2">
                                <img id="preview" src='{{$data->logo}}' alt="" class="logo-img">
                                <input type="file" name="logo" class="form-control image" data-id="preview">
                            </div>                                            
                        </div>
                        @endif
                        @if(Request::segment(3) == 'contact-us')
                        <div class="row mb-2 tabs-container contact-detail">
                            <div class="col-md-3 mb-2 text-md-right">
                                <label for="">Phone Number</label>
                            </div>
                            <div class="col-md-9 mb-2">
                                <input type="text" name="phone" class="form-control numeric " value="{{$data->phone}}">
                            </div>                    
                            <div class="col-md-3 mb-2 text-md-right">
                                <label for="">Email</label>
                            </div>
                            <div class="col-md-9 mb-2">
                                <input type="email" name="email" class="form-control" value="{{$data->email}}">
                            </div>                    
                            <div class="col-md-3 mb-2 text-md-right">
                                <label for="">Address</label>
                            </div>
                            <div class="col-md-9 mb-2">
                                <textarea name="address" class="form-control-textarea" value="{{$data->address}}"></textarea>
                            </div>                                                               
                        </div>
                        @endif
                        @if(Request::segment(3) == 'social-link')
                        <div class="row mb-2 tabs-container social-links">
                            <div class="col-md-3 mb-2 text-md-right">
                                <label for="">Facebook</label>
                            </div>
                            <div class="col-md-9 mb-2">
                                <input type="text" name="facebook" class="form-control" value="{{$data ? $data->facebook : ''}}">
                            </div>                    
                            <div class="col-md-3 mb-2 text-md-right">
                                <label for="">Instagram</label>
                            </div>
                            <div class="col-md-9 mb-2">
                                <input type="text" name="instagram" class="form-control" value="{{$data ? $data->instagram : ''}}">
                            </div>                    
                            <div class="col-md-3 mb-2 text-md-right">
                                <label for="">Linked In</label>
                            </div>
                            <div class="col-md-9 mb-2">
                                <input type="text" name="linked_in" class="form-control" value="{{$data ? $data->linked_in : ''}}">
                            </div>                                       
                            <div class="col-md-3 mb-2 text-md-right">
                                <label for="">Youtube</label>
                            </div>
                            <div class="col-md-9 mb-2">
                                <input type="text" name="youtube" class="form-control" value="{{$data ? $data->youtube : ''}}">
                            </div>
                            <div class="col-md-3 mb-2 text-md-right">
                                <label for="">Twitter</label>
                            </div>
                            <div class="col-md-9 mb-2">
                                <input type="text" name="twitter" class="form-control" value="{{$data ? $data->twitter : ''}}">
                            </div>
                            {{-- <div class="col-md-3 mb-2 text-md-right">
                                <label for="">What's App</label>
                            </div>
                            <div class="col-md-9 mb-2">
                                <input type="text" name="whatsapp" class="form-control" value="{{$data ? $data->whatsapp : ''}}">
                            </div> --}}
                        </div>
                        @endif
                        @if(Request::segment(3) == 'terms-and-conditions')
                        <div class="row mb-2 tabs-container term-and-condition">
                            <div class="col-md-12">
                                <label for="">Term And Condition</label>                        
                                <textarea type="text" name="term_and_condition" class="textarea form-control">{{$data ? $data->term_and_condition : ''}}</textarea>
                            </div>
                        </div>
                        @endif
                        @if(Request::segment(3) == 'privacy-policy')
                        <div class="row mb-2 tabs-container privacy-policy">
                            <div class="col-md-12">
                                <label for="">Privacy Policy</label>                        
                                <textarea type="text" name="privacy_policy" class="textarea form-control">{{$data ? $data->privacy_policy : ''}}</textarea>
                            </div>
                        </div>
                        @endif
                        @if(Request::segment(3) == 'return-policy')
                        <div class="row mb-2 tabs-container privacy-policy">
                            <div class="col-md-12">
                                <label for="">Return Policy</label>                        
                                <textarea type="text" name="return_policy" class="textarea form-control">{{$data ? $data->return_policy : ''}}</textarea>
                            </div>
                        </div>
                        @endif
                        @if(Request::segment(3) == 'about-us')
                        <div class="row mb-2 tabs-container about-us">
                            <div class="col-md-12">
                                <label for="">About Us</label>                        
                                <textarea type="text" name="about_us" class="textarea form-control">{{$data ? $data->about_us : ''}}</textarea>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-9 mb-2 offset-md-3 text-right">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>                          
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
@endsection
