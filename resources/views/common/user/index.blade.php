@php   
    if(request()->segment(2) == 'freelancer'){
        $role = 'Freelancer';
        $modal_size = '';
        $modal_or_page = '1';
    }elseif(request()->segment(2) == 'client'){
        $role = 'Client';
        $modal_size = 'medium';
        $modal_or_page = '0';
    }
    $create_url = route(guardName().".user.create").'?role='.ucfirst(request()->segment(2));       
@endphp
@extends('admin.layout.default', ['title' => $role.' Management'])
@section('content')
<div class="app-content">
  <x-header header="{{$role}} Management" link1="{{$role}} Management" />
  <x-table title="{{$role}} Management" modal="{{$modal_size}}" url="{{$modal_or_page}}" role="create user" header="Add {{$role}}" url='{{$create_url}}'>
    <thead>
        <tr>
            <th class="wd-15p">S.No.</th>    
            <th class="wd-20p">Name</th>
            <th class="wd-20p">Email</th>
            <th class="wd-20p">Phone</th>
            <th class="wd-25p">Action</th>                        
        </tr>
    </thead>                                  
   </x-table>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {    
        table = $('#myTable').DataTable({         
            aaSorting:[[0,'desc']],                      
            ajax: {
                "url" : "{{request()->fullUrl()}}",
                "data" : function(d){
                    d.type = $('#type').val();
                    d.role = $('#role').val();
                }
            },             
            columns: [         
                { data: 'DT_RowIndex', searchable:false, orderable:false},                
                { data: "first_name" , name: "first_name" },                                                                                               
                { data: "email" , name: "email" },                                                                               
                { data: "phone" , name: "phone" },                                                                                               
                { data: "action" , name: "action" },                   
            ],
        }); 
        $('#type').change(function(){
            table.ajax.reload();
        });     
    });    
    datas();
    function datas(){
        $('.type').change(function(){
            changeType();
        })
        function changeType(){
            let type = $('.type').val();     
            if(type == 'User'){
                $('.certificate').addClass('d-none');
            }else{
                $('.certificate').removeClass('d-none');
            }
        }
    }
</script>
@endpush
