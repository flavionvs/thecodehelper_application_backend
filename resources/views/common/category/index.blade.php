@extends('admin.layout.default', ['title' => 'Category'])
@section('content')

<div class="app-content">
  <x-header header="Category" link1="Category" />
   <x-table title="Category" modal="large" role="create category" header="Add Category" url='{{route(guardName().".category.create")}}'>
    <thead>
            <tr>
                <th class="wd-15p">S.No.</th>
                <th class="wd-20p">Image</th>                                                   
                <th class="wd-20p">Name</th>                                                    
                <th class="wd-20p">Slug</th>                                                                                    
                @if(request()->user()->can('edit category') || request()->user()->can('delete category'))
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
                    "url" : "{{url(guardName().'/category')}}",
                    "data" : function(d){
                        d.type = $('input[id="filter-value"]').val();
                    }
                },             
                columns: [         
                    { data: 'DT_RowIndex', orderable:false, searchable:false},
                    { data: "image" , name: "image" },                                                                                                   
                    { data: "name" , name: "name" },                                                                                                   
                    { data: "slug" , name: "slug" },                                                                                                   
                    @if(request()->user()->can('edit category') || request()->user()->can('delete category'))
                    { data: "action" , name: "action" },   
                    @endif
                    ],
            });
        });
       
    </script>
@endsection
