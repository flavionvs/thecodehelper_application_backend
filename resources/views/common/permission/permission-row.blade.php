@php
    $rand = rand(100000, 999999);
    $view = true;
    $create = true;
    $edit = true;
    $delete = true;
    if(isset($not_included) && in_array('view', $not_included)){
        $view = false;
    }
    if(isset($not_included) && in_array('create', $not_included)){
        $create = false;
    }
    if(isset($not_included) && in_array('edit', $not_included)){
        $edit = false;
    }
    if(isset($not_included) && in_array('delete', $not_included)){
        $delete = false;
    }
@endphp
@if($column == 1)
<tr>
    <th>
        <input type="checkbox" name="permission[]" class="single{{$rand}}" value="{{$permission_name}}" {{roleHasPermission($role_id, $permission_name)}}>
    </th>    
    <th colspan="5">{{$permission_name}}</th>                                                                    
</tr>         
@elseif($column == 4)
<tr>
    <th><input type="checkbox" class="main" data-class="single{{$rand}}" 
        @if(
            $view && $create && $edit && $delete &&
            roleHasPermission($role_id, 'view '.$permission_name) && 
            roleHasPermission($role_id, 'create '.$permission_name) && 
            roleHasPermission($role_id, 'edit '.$permission_name) && 
            roleHasPermission($role_id, 'delete '.$permission_name)
            )
            checked
        @elseif(
            $create && $edit && $delete &&            
            roleHasPermission($role_id, 'create '.$permission_name) && 
            roleHasPermission($role_id, 'edit '.$permission_name) && 
            roleHasPermission($role_id, 'delete '.$permission_name)
        )
        checked
        @elseif(
            $edit && $delete &&                        
            roleHasPermission($role_id, 'edit '.$permission_name) && 
            roleHasPermission($role_id, 'delete '.$permission_name)
        )
        checked
        @elseif(
            $delete &&                        
            roleHasPermission($role_id, 'delete '.$permission_name)
        )
        checked
        @endif
        ></th>    
    <th>{{$permission_name}}</th>            
    <td>
        @if($view)
            <input type="checkbox" name="permission[]" class="single{{$rand}}" value="view {{$permission_name}}" {{roleHasPermission($role_id, 'view '.$permission_name)}}>
        @endif
    </td>    
    <td>
        @if($create)
            <input type="checkbox" name="permission[]" class="single{{$rand}}" value="create {{$permission_name}}" {{roleHasPermission($role_id, 'create '.$permission_name)}}>
        @endif
    </td>    
    <td>
        @if($edit)
            <input type="checkbox" name="permission[]" class="single{{$rand}}" value="edit {{$permission_name}}" {{roleHasPermission($role_id, 'edit '.$permission_name)}}>
        @endif
    </td>    
    <td>
        @if($delete)
            <input type="checkbox" name="permission[]" class="single{{$rand}}" value="delete {{$permission_name}}" {{roleHasPermission($role_id, 'delete '.$permission_name)}}>
        @endif
    </td>    
</tr>   
@endif