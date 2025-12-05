@extends('admin.layout.default', ['title' => 'Ip Address'])
@section('content')
<div class="app-content">
  <x-header header="Ip Address" link1="Ip Address" />
   <x-card header="Ip Address" collapse="no">    
    <form action="{{url(guardName().'/ip-setting')}}" method="post" enctype="multipart/form-data" id="form">
        @csrf        
        <div class="row d-flex justify-space-around">
            <div class="col-md-12 mt-3">
                <div class="row">                                          
                    <div class="col-lg-12 mt-3">
                        <div class="row">                                                                                        
                            <div class="col-lg-1 text-lg-right">
                                <label for="">IP</label>                                  
                            </div>
                            <div class="col-lg-11 mb-2">                                  
                                <textarea name="ip" class="form-control" cols="30" rows="2">{{$data->ip}}</textarea>
                                <small>eg: 103.1.2.322, 132.4.12.32, 33.1.232.344</small>
                            </div>                               
                            
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

