@extends('admin.layout.default', ['title' => 'Cancellation Requests'])
@section('content')

<div class="app-content">
  <x-header header="Cancellation Requests" link1="Cancellation Requests" />
  
   <div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex">
                <div class="card-title w-50">Cancellation Requests</div>                
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered text-nowrap w-100">
                        <thead>
                            <tr>
                                <th class="wd-5p">S.No.</th>
                                <th class="wd-15p">Project</th>
                                <th class="wd-10p">Client</th>
                                <th class="wd-10p">Freelancer</th>
                                <th class="wd-10p">Amount</th>
                                <th class="wd-15p">Cancel Reason</th>
                                <th class="wd-10p">Requested At</th>
                                <th class="wd-10p">Status</th>
                                <th class="wd-15p">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
   </div>
</div>

<!-- Refund Confirmation Modal -->
<div class="modal fade" id="refundModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Process Refund & Cancel Project</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to process the refund and cancel this project?</p>
                <p><strong>Project:</strong> <span id="refund-project-name"></span></p>
                <p><strong>Amount to transfer to freelancer:</strong> $<span id="refund-amount"></span></p>
                <div class="form-group">
                    <label>Admin Notes (optional)</label>
                    <textarea id="admin-notes" class="form-control" rows="3" placeholder="Add any admin notes..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="confirm-refund-btn">Process Refund & Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Cancellation Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Cancellation Request</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reject this cancellation request? The project will remain in progress.</p>
                <p><strong>Project:</strong> <span id="reject-project-name"></span></p>
                <div class="form-group">
                    <label>Rejection Reason</label>
                    <textarea id="reject-reason" class="form-control" rows="3" placeholder="Reason for rejecting cancellation..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" id="confirm-reject-btn">Reject Cancellation</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    var table;
    var currentProjectId = null;

    $(document).ready(function () {    
        table = $('#myTable').DataTable({                
            lengthMenu: [10, 20, 50, 100],                                
            ajax: {
                "url" : "{{ request()->fullUrl() }}",
            },             
            columns: [         
                { data: 'DT_RowIndex', orderable: false, searchable: false },                                                                        
                { data: "project" },                                                                                                                                                                                                                     
                { data: "client" },                                                                                                                                                                                                                     
                { data: "freelancer" },                                                                                                                                                                                                                     
                { data: "amount" },                                                                                                                                                                                                                     
                { data: "cancel_reason" },                                                                                                                                                                                                 
                { data: "requested_at" },                                                                                                                                                                                                 
                { data: "status" },                                                                                                                                                                                                 
                { data: "action", orderable: false, searchable: false },   
            ],
        });
    });

    // Refund button click
    $(document).on('click', '.refund-btn', function() {
        currentProjectId = $(this).data('project-id');
        $('#refund-project-name').text($(this).data('project-name'));
        $('#refund-amount').text($(this).data('amount'));
        $('#admin-notes').val('');
        $('#refundModal').modal('show');
    });

    // Confirm refund
    $('#confirm-refund-btn').on('click', function() {
        var btn = $(this);
        btn.prop('disabled', true).text('Processing...');
        
        $.ajax({
            url: '{{ url(guardName() . "/process-cancellation") }}/' + currentProjectId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                action: 'approve',
                admin_notes: $('#admin-notes').val()
            },
            success: function(response) {
                $('#refundModal').modal('hide');
                if (response.status) {
                    alert(response.message);
                    table.ajax.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('Error processing refund: ' + (xhr.responseJSON?.message || 'Unknown error'));
            },
            complete: function() {
                btn.prop('disabled', false).text('Process Refund & Cancel');
            }
        });
    });

    // Reject button click
    $(document).on('click', '.reject-btn', function() {
        currentProjectId = $(this).data('project-id');
        $('#reject-project-name').text($(this).data('project-name'));
        $('#reject-reason').val('');
        $('#rejectModal').modal('show');
    });

    // Confirm reject
    $('#confirm-reject-btn').on('click', function() {
        var btn = $(this);
        btn.prop('disabled', true).text('Processing...');
        
        $.ajax({
            url: '{{ url(guardName() . "/process-cancellation") }}/' + currentProjectId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                action: 'reject',
                admin_notes: $('#reject-reason').val()
            },
            success: function(response) {
                $('#rejectModal').modal('hide');
                if (response.status) {
                    alert(response.message);
                    table.ajax.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'Unknown error'));
            },
            complete: function() {
                btn.prop('disabled', false).text('Reject Cancellation');
            }
        });
    });
</script>
@endpush
