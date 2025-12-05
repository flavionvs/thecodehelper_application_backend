<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body" id="create-edit-form-md">
            
        </div>        
    </div>
  </div>
</div>

<div id="myModal-lg" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">Modal Title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body" id="create-edit-form-lg">
            
        </div>        
    </div>

  </div>
</div>

<div id="myModal-xl" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xl">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">Modal Title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body" id="create-edit-form-xl">
            
        </div>        
    </div>

  </div>
</div>
<div id="document" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="" id="documentLabel2">Document List</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
          <table class="table text-center doc-table">
            <tr>
                <th>Name</th>
                <th>Doc Type</th>
                <th>Action</th>
            </tr>                 
            <tbody id="document-list"></tbody>
        </table>    
        </div>        
    </div>

  </div>
</div>

{{-- Delete Modal --}}
<div id="delete-modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="" id="exampleModalLabel2">Are you sure, you want to delete ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" id="delete-form" method="post">
              @csrf
              @method('DELETE')
              <div class="text-right">          
                <button type="button" class="btn btn-danger btn-md" data-dismiss="modal" aria-label="Close">No</button>        
                <button type="submit" class="btn btn-primary btn-md">Yes</button>        
              </div>    
            </form>
        </div>           
    </div>

  </div>
</div>

<div id="actions">
  
</div>

