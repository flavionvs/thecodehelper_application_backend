@extends('admin.layout.default', ['title' => 'Roles'])
@section('content')
<div class="app-content">
  <x-header header="Role" link1="Role" />
   <x-table title="Role" role="create role" header="Add Role" url='{{route(guardName().".role.create")}}'>
    <thead>
            <tr>
                <th class="wd-15p">S.No.</th>
                <th class="wd-20p">Name</th>                                    
                <th class="wd-20p">Guard</th>                                    
                <th class="wd-10p">Status</th>
                @if(auth()->guard(guardName())->user()->can('edit role') || auth()->guard(guardName())->user()->can('delete role'))
                <th class="wd-25p">Action</th>            
                @endif            
            </tr>
        </thead>                                  
   </x-table>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        var table;
        $(document).ready(function () {    
            table = $('#myTable').DataTable({
                
                aaSorting:[[0,'desc']],
                
                ajax: {
                    "url" : "{{url(guardName().'/role')}}",
                    "data" : function(d){
                        d.type = $('input[id="filter-value"]').val();
                    }
                },             
                columns: [         
                    { data: 'DT_RowIndex', orderable:false, searchable:false},
                    { data: "name" , name: "name" },                                                                               
                    { data: "guard_name" , name: "guard_name" },               
                    { data: "status" , name: "status" },               
                    @if(auth()->guard(guardName())->user()->can('edit role') || auth()->guard(guardName())->user()->can('delete role'))
                    { data: "action" , name: "action" },   
                    @endif
                    ],
            });                        
        });
    </script>
@endsection
