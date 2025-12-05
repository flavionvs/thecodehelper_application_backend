@extends('admin.layout.default', ['title' => 'Project'])
@section('content')

<div class="app-content">
  <x-header header="Project" link1="Project" />
  <x-card header="Filter" collapse="yes">
        <div class="row">                       
            <div class="col-md-4">
                <label for="">Client</label>
                <select id="client" class="form-control chosen">
                    <option value="">All</option>
                    @foreach ($clients as $item)                                            
                        <option value="{{ $item->id }}">{{ $item->first_name }}</option>                                            
                    @endforeach
                </select>
            </div>                                         
            <div class="col-md-4">
                <label for="">Category</label>
                <select id="category" class="form-control chosen">
                    <option value="">All</option>    
                    @foreach ($categories as $item)                        
                        <option value="{{ $item->id }}">{{ $item->name }}</option>                                                                
                    @endforeach                
                </select>
            </div>                                         
        </div>
    </x-card>
   <x-table title="Project" modal="large" role="create project" header="Add Project" url='{{route(guardName().".project.create")}}'>
    <thead>
            <tr>
                <th class="wd-15p">S.No.</th>                                                                                    
                <th class="wd-20p">Client</th>                                                                                                                                       
                <th class="wd-20p">Service Name</th>                                                                                                                                       
                <th class="wd-20p">Budget</th>                                                                                    
                <th class="wd-20p">Category</th>                                                                                    
                <th class="wd-20p">Applications</th>                                                                                                    
                <th class="wd-20p">DateTime</th>                                                                                    
                @if(request()->user()->can('edit project') || request()->user()->can('delete project'))
                <th class="wd-25p">Action</th>            
                @endif            
            </tr>
        </thead>                                  
   </x-table>
</div>  
@endsection
@push('scripts')
<script>
        var table;
        $(document).ready(function () {    
            table = $('#myTable').DataTable({                
                lengthMenu: [10, 20, 50, 100, 200, 500, 1000, 3000, 5000, 10000, 20000, 50000, 100000],                                
                ajax: {
                    "url" : "{{request()->fullUrl()}}",
                    "data" : function(d){
                        d.client = $('#client').val();
                        d.category = $('#category').val();                        
                    }
                },             
                columns: [         
                    { data: 'DT_RowIndex', orderable:false, searchable:false},                                                                        
                    { data: "client", name:'users.first_name'},                                                                                                                                                                                                                     
                    { data: "title"},                                                                                                                                                                                                                     
                    { data: "budget"},                                                                                                                                                                                                                     
                    { data: "category_id", name:'categories.name'},                                                                                                                                                                                                                     
                    { data: "application"},                                                                                                                                                                                                 
                    { data: "created_at"},                                                                                                                                                                                                 
                    @if(request()->user()->can('edit project') || request()->user()->can('delete project'))
                    { data: "action" , name: "action" },   
                    @endif
                    ],
            });
            $('#client, #category').change(function(){
                table.ajax.reload();
            });
        });

        datas();
        function datas(){            
  
        }
       
    </script>
@endpush
