<?php 
if(!empty($data->id)){
    $url = route(guardName().'.project.update', [$data->id]);
    $submit_button = 'Update Account Type';
}else{    
    $url = route(guardName().'.project.store');
    $submit_button = 'Create Account Type';
}
?>
<form action="{{$url}}" method="post" enctype="multipart/form-data" id="form">
    @csrf
    @if(!empty($data->id))
    @method('PUT')
    @endif
    <input type="hidden" id="id" value="{{$data->id}}">
    <div class="row">    
        <div class="col-md-3 text-md-right">
            <label for="">Client</label>                                  
        </div>        
        <div class="col-md-9 mb-2">                                  
            <select name="user_id" class="form-control chosen">
                <option value="">Select Client</option>
                @foreach ($clients as $item)
                    <option value="{{$item->id}}" @if($item->id == $data->user_id) selected @endif>{{$item->first_name}}</option>
                @endforeach
            </select>        
        </div>                                                                                                                                                                                                                                                                  
        <div class="col-md-3 text-md-right">
            <label for="">Project Title</label>                                  
        </div>
        <div class="col-md-9 mb-2">                                  
            <input type="text" name="title" class="form-control"  value="{{$data->title}}" >
        </div>                                                                                                                     
        <div class="col-md-3 text-md-right">
            <label for="">Category</label>                                  
        </div>        
        <div class="col-md-9 mb-2">                                  
            <select name="category_id" class="form-control chosen">
                <option value="">Select Category</option>
                @foreach ($category as $item)
                    <option value="{{$item->id}}" @if($item->id == $data->category_id) selected @endif>{{$item->name}}</option>
                @endforeach
            </select>        
        </div>                                      
        <div class="col-md-3 text-md-right">
            <label for="">Budget</label>                                  
        </div>
        <div class="col-md-9 mb-2">                                  
            <input type="text" name="budget" class="form-control"  value="{{$data->budget}}" >
        </div>                
        <div class="col-md-3 text-md-right">
            <label for="">Tags</label>                                  
        </div>
        <div class="col-md-9 mb-2">                                  
            <input type="text" name="tags" class="form-control"  value="{{$data->tags}}" >
        </div>                
        <div class="col-md-3 text-md-right">
            <label for="">Description</label>                                  
        </div>
        <div class="col-md-9 mb-2">                                  
            <textarea name="description" class="summernote">{{$data->description}}</textarea>
        </div>                
        <div class="col-md-12 text-right mr-3">
            <button type="submit" class="btn btn-primary btn form-btn">{{$submit_button}}</button>
        </div>                                         
    </div>   
</form>           