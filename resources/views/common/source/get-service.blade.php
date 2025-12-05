<select name="service_id" class="form-control chosen" id="service_id">
    <option value="">Select Service</option>           
    @if($service)
        @foreach($service as $item)
        @php        
            $select = '';
            if($item->id == $service_id){
                $select = 'selected';
            }
        @endphp
        <option value="{{$item->id}}" {{$select}}>{{$item->name}}</option>
        @endforeach   
    @endif
</select>
    