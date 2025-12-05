<?php 
if(!empty($data->id)){
    $url = route(guardName().'.category.update', [$data->id]);
    $submit_button = 'Update Category';
}else{    
    $url = route(guardName().'.category.store');
    $submit_button = 'Create Category';
}
?>
<form action="{{$url}}" method="post" enctype="multipart/form-data" id="form">
    @csrf
    @if(!empty($data->id))
    @method('PUT')
    @endif
    <div class="row">
        <div class="col-md-3 text-md-right mb-2">
            <label for="">Image</label>                                  
        </div>
        <div class="col-lg-9 mb-2">
            <img src="{{$data->image ? asset($data->image) : asset(config('constant.dummy_image'))}}" id="preview" class="dummy-img" alt="">
            <input type="file" name="image" class="form-control image" accept="image/png, image/jpg, image/jpeg" data-id="preview">
            <small>Image size should be 300 × 210 px ( 1:1 )</small>
        </div>                                                                                           
        <div class="col-md-3 text-md-right">
            <label for="">Name</label>                                  
        </div>
        <div class="col-md-9 mb-2">                                  
            <input type="text" name="name" class="form-control name" data-target="slug"  value="{{$data->name}}" >
        </div>                                
        <div class="col-md-3 text-md-right">
            <label for="">Slug</label>                                  
        </div>
        <div class="col-md-9 mb-2">                                  
            <input type="text" name="slug" class="form-control slug"  value="{{$data->slug}}" >
        </div>     
        <div class="col-md-3 text-md-right">
            <label for="">Status</label>                                  
        </div>
        <div class="col-md-9 mb-2">                                  
            <select name="status" id="" class="form-control">
                <option value="">Select Status</option>
                <option value="Active" @if($data->status == 'Active') selected @endif>Active</option>
                <option value="Inactive" @if($data->status == 'Inactive') selected @endif>Inactive</option>
            </select>
        </div>                            
        <!-- <div class="col-md-3 text-md-right">
            <label for="">Meta Tag</label>                                  
        </div>
        <div class="col-md-9 mb-2">                                  
            <input type="text" name="meta_tag" class="form-control"  value="{{$data->meta_tag}}" >
        </div>                                
        <div class="col-md-3 text-md-right">
            <label for="">Meta Description</label>                                  
        </div>
        <div class="col-md-9 mb-2">                                  
            <textarea name="meta_description" class="form-control">{{$data->meta_description}}</textarea>
        </div>                                 -->
        <div class="col-md-12 text-right mr-3">
            <button type="submit" class="btn btn-primary btn form-btn">{{$submit_button}}</button>
        </div>                                         
    </div>   
</form>           