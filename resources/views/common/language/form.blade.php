<?php 
if(!empty($data->id)){
    $url = route(guardName().'.language.update', [$data->id]);
    $submit_button = 'Update Language';
}else{    
    $url = route(guardName().'.language.store');
    $submit_button = 'Create Language';
}
?>
<form action="{{$url}}" method="post" enctype="multipart/form-data" id="form">
    @csrf
    @if(!empty($data->id))
    @method('PUT')
    @endif
    <div class="row">                                                                                         
        <div class="col-md-3 text-md-right">
            <label for="">Name</label>                                  
        </div>
        <div class="col-md-9 mb-2">                                  
            <input type="text" name="name" class="form-control name"  value="{{$data->name}}" >
        </div>                                
        <div class="col-md-3 text-md-right">
            <label for="">Status</label>                                  
        </div>
        <div class="col-md-9 mb-2">                                  
            <select name="status" id="" class="form-control">
                <option value="Active" @if($data->status == 'Active') selected @endif>Active</option>
                <option value="Inactive" @if($data->status == 'Inactive') selected @endif>Inactive</option>
            </select>
        </div>                                    
        <div class="col-md-12 text-right mr-3">
            <button type="submit" class="btn btn-primary btn form-btn">{{$submit_button}}</button>
        </div>                                         
    </div>   
</form>           