@extends('admin.layout.default', ['title' => 'Sub Category'])
@section('content')

<div class="app-content">
  <x-header header="Sub Category" link1="Sub Category" />
   <x-table title="Sub Category" modal="large" role="create Sub category" header="Add Sub Category" url='{{route(guardName().".sub-category.create")}}'>
    <thead>
            <tr>
                <th class="wd-15p">S.No.</th>
                <th class="wd-20p">Image</th>                                                    
                <th class="wd-20p">Category</th>                                                    
                <th class="wd-20p">Name</th>                                                    
                <th class="wd-20p">Slug</th>                                                                                    
                @if(request()->user()->can('edit sub category') || request()->user()->can('delete sub category'))
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
                    "url" : "{{url(guardName().'/sub-category')}}",
                    "data" : function(d){
                        d.type = $('input[id="filter-value"]').val();
                    }
                },             
                columns: [         
                    { data: 'DT_RowIndex', orderable:false, searchable:false},
                    { data: "image" , name: "image" },                                                                                                   
                    { data: "category_id" , name: "categories.name" },                                                                                                   
                    { data: "name" , name: "name" },                                                                                                   
                    { data: "slug" , name: "slug" },                                                                                                   
                    @if(request()->user()->can('edit sub category') || request()->user()->can('delete sub category'))
                    { data: "action" , name: "action" },   
                    @endif
                    ],
            });
        });
        datas();
        function datas(){
            $('#type').change(function(){
                getCategory();
            })
            getCategory();
            function getCategory(){
                let type_id = $('#type').val();
                let category_id = $('#type').data('category');
                $.ajax({
                    url : '{{url(guardName()."/get-category")}}/'+type_id,
                    data : {category_id:category_id},
                    success :function(res){
                        $('#category').html(res);
                    }
                })
            }
        }
    </script>
@endsection
