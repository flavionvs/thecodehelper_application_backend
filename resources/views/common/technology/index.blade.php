@extends('admin.layout.default', ['title' => 'Technology'])
@section('content')

<div class="app-content">
  <x-header header="Technology" link1="Technology" />
   <x-table title="Technology" modal="large" role="create technology" header="Add Technology" url='{{route(guardName().".technology.create")}}'>
    <thead>
            <tr>
                <th class="wd-15p">S.No.</th>                                                                    
                <th class="wd-20p">Name</th>                                                    
                <th class="wd-20p">Status</th>                                                                                    
                @if(request()->user()->can('edit technology') || request()->user()->can('delete technology'))
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
                lengthMenu: [10, 20, 50, 100, 200, 500],                                
                ajax: {
                    "url" : "{{url(guardName().'/technology')}}",
                    "data" : function(d){
                        d.type = $('input[id="filter-value"]').val();
                    }
                },             
                columns: [         
                    { data: 'DT_RowIndex', orderable:false, searchable:false},
                    { data: "name"},                                                                                                   
                    { data: "status"},                                                                                                                       
                    @if(request()->user()->can('edit technology') || request()->user()->can('delete technology'))
                    { data: "action" , name: "action" },   
                    @endif
                    ],
            });
        });
       
    </script>
@endsection
