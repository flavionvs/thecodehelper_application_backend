@extends('admin.layout.default', ['title' => 'Application'])
@section('content')

<div class="app-content">
  <x-header header="Application" link1="Application" />
    <x-card header="Filter" collapse="yes">
        <div class="row">                       
            <div class="col-md-4">
                <label for="">Freelancer</label>
                <select id="user" class="form-control chosen">
                    <option value="">All</option>
                    @foreach ($users as $item)                                            
                        <option value="{{ $item->user_id }}">{{ $item->user->first_name }}</option>                                            
                    @endforeach
                </select>
            </div>                                                     
            <div class="col-md-4">
                <label for="">Project</label>
                <select id="project" class="form-control chosen">
                    <option value="">All</option>
                    @foreach ($projects as $item)                                            
                        <option value="{{ $item->project_id }}">{{ $item->project->title }}</option>                                            
                    @endforeach
                </select>
            </div>                                                     
        </div>
    </x-card>
   <x-table title="Application" header="Add Application">
    <thead>
            <tr>
                <th class="wd-15p">S.No.</th>                                                                                    
                <th class="wd-20p">Username</th>                                                                                                                                       
                <th class="wd-20p">Project</th>                                                                                                                                       
                <th class="wd-20p">User Budget</th>                                                                                                                                       
                <th class="wd-20p">Attachments</th>                                                                                    
                <th class="wd-20p">Status</th>                                                                                    
                <th class="wd-20p">DateTime</th>                                                                                                                    
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
                        d.user = $('#user').val();
                        d.project = $('#project').val();
                    }
                },             
                columns: [         
                    { data: 'DT_RowIndex', orderable:false, searchable:false},                                                                        
                    { data: "user_id", name:'users.first_name'},                                                                                                                                                                                                                     
                    { data: "project_id", name:'projects.title'},                                                                                                                                                                                                                     
                    { data: "total_amount"},                                                                                                                                                                                                                                         
                    { data: "attachment"},                                                                                                                                                                                                 
                    { data: "status"},                                                                                                                                                                                                 
                    { data: "created_at"},                                                                                                                                                                                                                     
                    ],
            });
            $('#user, #project').change(function(){
                table.ajax.reload();
            });
        });

        datas();
        function datas(){            
  
        }
       
    </script>
@endpush
