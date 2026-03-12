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
                <th class="wd-5p"><input type="checkbox" id="check_all_bulk"></th>
                <th class="wd-10p">S.No.</th>                                                                                    
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
   <button id="bulk-delete-btn" class="btn btn-danger" style="display:none; position:fixed; bottom:30px; right:30px; z-index:1050; font-size:16px; padding:10px 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
       <i class="fa fa-trash"></i> Delete Selected (<span class="bulk-count">0</span>)
   </button>
</div>

{{-- Bulk Delete Confirmation Modal --}}
<div id="bulk-delete-modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h5>Are you sure you want to delete <span id="bulk-delete-count" class="text-danger"></span> project(s)?</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <p class="text-danger"><strong>Warning:</strong> This will permanently delete the selected project(s) and all related applications, payments, and attachments.</p>
            <form id="bulk-delete-form">
              <input type="hidden" id="bulk-delete-ids" value="[]">
              <div class="text-right">          
                <button type="button" class="btn btn-secondary btn-md" data-dismiss="modal">Cancel</button>        
                <button type="submit" class="btn btn-danger btn-md">Yes, Delete All</button>        
              </div>    
            </form>
        </div>           
    </div>
  </div>
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
                    { data: 'checkbox', orderable:false, searchable:false},         
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

            // Select all checkboxes
            $('#check_all_bulk').on('click', function(){
                var checked = this.checked;
                $('.bulk-check').each(function(){ this.checked = checked; });
                toggleBulkDeleteBtn();
            });
            $('#myTable').on('change', '.bulk-check', function(){ toggleBulkDeleteBtn(); });

            function toggleBulkDeleteBtn(){
                var count = $('.bulk-check:checked').length;
                if(count > 0){
                    $('#bulk-delete-btn').show().find('.bulk-count').text(count);
                } else {
                    $('#bulk-delete-btn').hide();
                }
            }

            // Bulk delete button handler
            $('#bulk-delete-btn').on('click', function(){
                var ids = [];
                $('.bulk-check:checked').each(function(){ ids.push($(this).val()); });
                if(ids.length === 0) return;
                $('#bulk-delete-count').text(ids.length);
                $('#bulk-delete-ids').val(JSON.stringify(ids));
                $('#bulk-delete-modal').modal('show');
            });

            // Bulk delete form submit
            $('#bulk-delete-form').on('submit', function(e){
                e.preventDefault();
                var ids = JSON.parse($('#bulk-delete-ids').val());
                showLoader();
                $.ajax({
                    url: '/'+('{{ guardName() }}')+'/project-bulk-delete',
                    type: 'POST',
                    data: { ids: ids, _token: '{{ csrf_token() }}' },
                    success: function(res){
                        hideLoader();
                        $('#bulk-delete-modal').modal('hide');
                        if(res.status){
                            toastr.success(res.message);
                            table.ajax.reload();
                            $('#check_all_bulk').prop('checked', false);
                            $('#bulk-delete-btn').hide();
                        } else {
                            toastr.error(res.message);
                        }
                    },
                    error: function(){ hideLoader(); toastr.error('Something went wrong'); }
                });
            });
        });

        datas();
        function datas(){            
  
        }
       
    </script>
@endpush
