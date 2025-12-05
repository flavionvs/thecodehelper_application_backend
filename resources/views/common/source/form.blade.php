<?php 
if(!empty($data->id)){
    $url = route(guardName().'.source.update', [$data->id]);
    $submit_button = 'Update Source';
}else{    
    $url = route(guardName().'.source.store');
    $submit_button = 'Create Source';
}
?>
<form action="{{$url}}" method="post" enctype="multipart/form-data" id="form">
    @csrf
    @if(!empty($data->id))
    @method('PUT')
    @endif
    <div class="row">                                                                                                        
        <div class="col-md-2 text-md-right">
            <label for="">Vertical</label>                                  
        </div>
        <div class="col-md-10 mb-2">                                  
            <select id="vertical_id" class="form-control chosen" data-service-id="{{$data->service_id}}">                                                
                <option value="">Select Vertical</option>                                
                @foreach ($vertical as $item)
                    <option value="{{$item->id}}" @if($data->service->vertical->id ?? null == $item->id) selected @endif>{{$item->name}}</option>
                @endforeach
            </select>   
        </div>                                                                                                       
        <div class="col-md-2 text-md-right">
            <label for="">Service</label>                                  
        </div>
        <div class="col-md-10 mb-2" id="service">                                  
            <select name="service_id" class="form-control chosen">                                                
                <option value="">Select Service</option>                                                
            </select>   
        </div>       
        <div class="col-md-2 text-md-right">
            <label for="">source</label>                                  
        </div>
        <div class="col-md-10 mb-2">                                  
            <input type="text" name="name" class="form-control"  value="{{$data->name}}" >
        </div>                                                                                                    
        <div class="col-md-12 text-right mr-3">
            <button type="submit" class="btn btn-primary btn form-btn">{{$submit_button}}</button>
        </div>                                         
    </div>   
</form>           