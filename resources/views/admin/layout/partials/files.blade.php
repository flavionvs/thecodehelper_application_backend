


  <!-- Add And Edit Modal -->
  <div class="modal fade" id="forms-modal" tabindex="-1" role="dialog" aria-labelledby="forms-modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title form-header" id="forms-modalTitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="data"></div>
      </div>
    </div>
  </div>
  <!-- Add And Edit Modal -->
  <div class="modal fade" id="forms-modal-xl" tabindex="-1" role="dialog" aria-labelledby="forms-modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title form-header" id="forms-modalTitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="data"></div>
      </div>
    </div>
  </div>
  
  
   <!--Delete Modal -->
   <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title form-header" id="delete-modalTitle">Delete Warning</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-right" id="data">
          <form  action="" method="post" id="delete-form">                    
              <input type="hidden" name="_token" value="{{csrf_token()}}"> 
              <input type="hidden" name="_method" value="DELETE">
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
              <button type="submit" class="btn btn-danger btn-sm">Yes</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <button type="button" id="paidModel" class="btn btn-primary" data-toggle="modal" data-target="#paid-modal">
    Launch demo modal
  </button>
  
   <!--Delete Modal -->
   <div class="modal fade" id="view-image-modal" tabindex="-1" role="dialog" aria-labelledby="view-image-modalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title form-header" id="view-image-modalTitle">Delete Warning</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-right" id="data">
          <img src="" id="image-preview" alt="">
        </div>
      </div>
    </div>
  </div>