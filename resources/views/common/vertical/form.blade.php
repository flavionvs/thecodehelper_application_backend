<?php 
if(!empty($data->id)){
    $url = route(guardName().'.vertical.update', [$data->id]);
    $submit_button = 'Update Vertical';
}else{    
    $url = route(guardName().'.vertical.store');
    $submit_button = 'Create Vertical';
}
?>
<form action="{{$url}}" method="post" enctype="multipart/form-data" id="form">
    @csrf
    @if(!empty($data->id))
    @method('PUT')
    @endif
    <div class="row">        
        <div class="col-md-2 text-md-right">
            <label for="">Name</label>                                  
        </div>
        <div class="col-md-10 mb-2">                                  
            <input type="text" name="name" class="form-control"  value="{{$data->name}}" >
        </div>                                                                                  
        <div class="col-md-12 text-right mr-3">
            <button type="submit" class="btn btn-primary btn form-btn">{{$submit_button}}</button>
        </div>                                         
    </div>   
</form>           