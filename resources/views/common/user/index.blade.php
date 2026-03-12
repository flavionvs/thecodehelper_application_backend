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
            <th class="wd-5p"><input type="checkbox" id="check_all_bulk"></th>
            <th class="wd-10p">S.No.</th>    
            <th class="wd-20p">Name</th>
            <th class="wd-20p">Email</th>
            <th class="wd-20p">Phone</th>
            <th class="wd-25p">Action</th>                        
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
            <h5>Are you sure you want to delete <span id="bulk-delete-count" class="text-danger"></span> {{$role}}(s)?</h5>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
            <p class="text-danger"><strong>Warning:</strong> This will permanently delete the selected {{strtolower($role)}}(s) and all their related data (projects, applications, payments, etc).</p>
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
    $(document).ready(function () {    
        table = $('#myTable').DataTable({         
            aaSorting:[[1,'desc']],                      
            ajax: {
                "url" : "{{request()->fullUrl()}}",
                "data" : function(d){
                    d.type = $('#type').val();
                    d.role = $('#role').val();
                }
            },             
            columns: [
                { data: 'checkbox', searchable:false, orderable:false},         
                { data: 'DT_RowIndex', searchable:false, orderable:false},                
                { data: "first_name" , name: "first_name" },                                                                                               
                { data: "email" , name: "email" },                                                                               
                { data: "phone" , name: "phone" },                                                                                               
                { data: "action" , name: "action" },                   
            ],
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
                url: '/'+('{{ guardName() }}')+'/user-bulk-delete',
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
