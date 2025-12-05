@extends('admin.layout.default', ['title' => 'Lang'])
@section('content')

<div class="app-content">
  <x-header header="Lang" link1="Lang" />
   <x-table title="Lang" modal="large" role="create lang" header="Add Lang" url='{{route(guardName().".lang.create")}}'>
    <thead>
            <tr>
                <th class="wd-15p">S.No.</th>                                                                    
                <th class="wd-20p">Name</th>                                                    
                <th class="wd-20p">Status</th>                                                                                    
                @if(request()->user()->can('edit lang') || request()->user()->can('delete lang'))
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
                    "url" : "{{url(guardName().'/lang')}}",
                    "data" : function(d){
                        d.type = $('input[id="filter-value"]').val();
                    }
                },             
                columns: [         
                    { data: 'DT_RowIndex', orderable:false, searchable:false},
                    { data: "name"},                                                                                                   
                    { data: "status"},                                                                                                                       
                    @if(request()->user()->can('edit lang') || request()->user()->can('delete lang'))
                    { data: "action" , name: "action" },   
                    @endif
                    ],
            });
        });
       
    </script>
@endsection
