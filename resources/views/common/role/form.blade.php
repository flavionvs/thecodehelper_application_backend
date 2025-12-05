<?php 
if(!empty($data->id)){
    $url = route(guardName().'.role.update', [$data->id]);
    $submit_button = 'Update Role';
}else{    
    $url = route(guardName().'.role.store');
    $submit_button = 'Create Role';
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
                <input type="text" name="name" class="form-control"  value="{{$data->name ? $data->name : ''}}" >
            </div>                                    
            <div class="col-md-3 text-md-right">
                <label for="">Guard</label>                                  
            </div>
            <div class="col-md-9 mb-2">
                <select name="guard_name" class="form-control chosen" id="">
                    <option value="admin" @if($data->guard_name == 'admin') selected @endif>Admin</option>
                    <option value="employee" @if($data->guard_name == 'employee') selected @endif>Employee</option>                    
                </select>
            </div>                            
            <div class="col-md-3 text-md-right">
                <label for="">Status</label>                                  
            </div>
            <div class="col-md-9 mb-2">
                <select name="status" class="form-control chosen"id="">
                    <option @if($data->status == 'Active') selected @endif>Active</option>
                    <option @if($data->status == 'Inactive') selected @endif>Inactive</option>
                </select>
            </div>                            
        <div class="col-md-12 text-right mr-3">
            <button type="submit" class="btn btn-primary btn-sm">{{$submit_button}}</button>
        </div>                                         
    </div>   
</form>           