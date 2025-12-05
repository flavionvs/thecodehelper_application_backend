let BASE_URL = window.location.origin+'/'+GUARD_NAME;
let table_category, table_beneficiary, table_financial, table_disburse_log, table_beneficiary_proposal, table_physical_tracking, table_utilization_certificate;
function showLoader(){
  $('#global-loader').show();
}
function hideLoader(){
  $('#global-loader').hide();
}


  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      error : function(res){
        if(res.status == 422){    
 
          // Proposal submi     
          let validation = '<ul>';
          $.each(res.responseJSON.errors, function(index, value){
          
            // Find the input, select, or textarea element by name
            let inputElement = $('input[name=' + index + ']');
            let selectElement = $('select[name=' + index + ']');
            let textareaElement = $('textarea[name=' + index + ']');

            // Append the error message after the input element
            if (inputElement.length) {
              if (inputElement.next().hasClass('chosen-container')) {
                inputElement.next().after('<div class="error-message">' + value + '</div>');
              } else {
                  inputElement.after('<div class="error-message">' + value + '</div>');
              }
            } else if (selectElement.length) {
              if (selectElement.next().hasClass('chosen-container')) {
                selectElement.next().after('<div class="error-message">' + value + '</div>');
              } else {                  
                  selectElement.after('<div class="error-message">' + value + '</div>');
              }
            } else if (textareaElement.length) {
              if (textareaElement.next().hasClass('chosen-container')) {
                textareaElement.next().after('<div class="error-message">' + value + '</div>');
              } else {                  
                  textareaElement.after('<div class="error-message">' + value + '</div>');
              }
            }        
          });            
          validation = validation+'</ul>'; 
          toastr.error('Please fill all required fields');
        }   
          hideLoader();
      }, 
    beforeSend : function(){
      showLoader();
    },
    complete: function() {
        assets();
        hideLoader(); 
        setTimeout(() => {
          hideLoader();           
        }, 1000); 
  
    }, 
      

  });
    $('.add-btn').click(function(){
      getData($(this), 'add');    
    });          
    $('.add-btn1, .edit-btn').click(function(){
      getData($(this));    
    });          
    $('table#myTable').on('click', 'a.edit-btn, a.proposal-preview, a.beneficiary-linking', function(){                   
      getData($(this));      
    })    
    $('table#myTable1').on('click', 'a.edit-btn, a.proposal-preview, a.beneficiary-linking', function(){                   
      getData($(this));      
    })    
    $('.submit-rejection').click(function(){
      let val = $('textarea[name=feedback]').val();
      $('input[name=feedback]').val(val);
      $('#form').submit();
      $('textarea[name=feedback]').val('');
    })
    function getData(cls, type = '', data = ''){     
      showLoader();       
      $('#create-edit-form').html('');
      $('.modal-title').html(cls.data('header'));                     
      var url = cls.data('url');
      var size = cls.data('target');   
      if(size == '#myModal-lg'){
        size = 'lg';
      }else if(size == '#myModal-xl'){
        size = 'xl';
      }else{
        size = 'md';
      }      
      var _type = type;
      let _data = '';
      if(data){
        _data = {data:data};
      }
      $.ajax({
        url:url,    
        data:_data,        
        success:function(res){
          if(size == 'lg'){
            $('#create-edit-form-lg').html(res);
          }else if(size == 'xl'){
            $('#create-edit-form-xl').html(res);
          }else{
            $('#create-edit-form-md').html(res);
          }        
          submit(_type);
          uploadImage();   
          createSlug();

          if (is_function("datas")) {
            datas();            
          }
          $('.chosen').chosen();        
          // $('#myTable').DataTable(); 
          hideLoader();            
          assets();
        },  
     
      }); 
    }   
         
    function createSlug(){
      $('.slug').on('input', function(){
          let text = $(this).val();
          let target = $(this).data('target');
          $('#'+target).val(slugify(text));
      })
    }   
    function slugify(text) {
    return text
        .toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')  // Remove non-alphanumeric characters
        .replace(/\s+/g, '-')          // Replace whitespace with dashes
        .replace(/-+/g, '-')           // Remove consecutive dashes
        .trim();                       // Trim leading/trailing whitespace
    }
    function is_function(func) {
      return typeof window[func] !== 'undefined' && $.isFunction(window[func]);
    }
    $('table#myTable').on('click', 'a.delete-btn', function(){     
        var url = $(this).data('url');
        $('#delete-form').attr('action', url);
    });
    submit();
    function submit(_type){
      $('#form, #delete-form, .form').off().submit(function(e){
        $('.error-message').remove();
        showLoader();
        e.preventDefault();
     
        // $('.submit-btn').attr('disabled', true);
        var data = new FormData(this);
        var url = $(this).attr('action');  
        var __type = _type;          
        $.ajax({
          url:url,
          type:'post',
          data:data,
          processData:false,
          contentType:false,
          cache:false,    
          success:function(res){
            $('.submit-btn').attr('disabled', false);            
            if(res.status == true){
              $('.close-certificate-mdoal').click();
              if(res.reload != undefined){
                window.location.href = res.reload;
              }else{
                toastr.success(res.message);
                if(res.stay == undefined || res.stay == false){                                  
                    $('.close').click();
                }
                if(__type == 'add'){
                  table.ajax.reload();                                                  
                }else{
                   // this is the case of beneficiary linking
                   if (typeof table !== 'undefined') {
                    table.ajax.reload(null, false);                    
                  }
                  
                }
              }
              $('.chosen').chosen();
            // for otp verification only   
            if(res.login_modal != undefined && res.login_modal){
              $('#otpModal').modal('show');
            }else{
              $('#verify').removeClass('btn-primary').addClass('btn-success').html('Verified');
            }    
            if(is_function('timer')){
              timer();
            }
            }else if(res.status == false){                            
              toastr.error(res.message);
            }        
            hideLoader();
            assets();         
          }
        })
      });
    }  

  

    assets();
    function assets(){
      $('.numeric').on('input', function(){
          $(this).val($(this).val().replace(/[^0-9\.]/g,''));                                          
          var limit = $(this).data('limit');
          if (limit != undefined) {
            if ($(this).val().length > limit) {
              $(this).val($(this).val().slice(0, limit));
            }
          }
          var max = $(this).data('max');
          if (max != undefined) {                   
              if ($(this).val() > max) {
                  $(this).val(max);
              }
          }
          if($(this).val() < 0){
            $(this).val('0');
          }
      });           
      $("#image").change(function() {
        let id = $(this).data('img');
        readURL(this, id);
      });		 
      if($('.chosen').html() != undefined){
        $('.chosen').chosen();
      }   
    }    

      $('.website-setting-list li').click(function(){
        $('.website-setting-list').children().map(function(){
          if($(this).hasClass('active-form')){
            $(this).removeClass('active-form');
          }
        }).get();
        $(this).addClass('active-form'); 
        $('.tabs-container').addClass('d-none')     
        let clas = $(this).data('class');            
        $('.'+clas).removeClass('d-none');
      })    
      function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('#'+id).attr('src', e.target.result);
            }                            
            reader.readAsDataURL(input.files[0]); 
        }
      }
      uploadImage();
      function uploadImage(){
        $(".image").change(function() {
          var id = $(this).data('id')
          readURL(this, id);
        });
      } 
      $('.image').click(function(){
        $('#image-preview').prop('src', $(this).attr('src'));
      });    
      $('.lang-div').click(function(){
        $('.lang-div').removeClass('current-lang');
        $(this).addClass('current-lang');
        $(this).removeClass('d-none');
        $('.description').addClass('d-none');
        let cls = $(this).data('id');
        $('.'+cls).removeClass('d-none');        
      });         
  
  
  function saveUploadedImage(image) {
    let _this = $(image);            
    var target = $(image).data('target');        
    var name = $(image).data('name');        
    var progress_bar = $(image).data('progress');        
    var urlname = BASE_URL+'/upload-files';
    let method = $('#form').attr('method');
    var jform = new FormData($('#form')[0]);        
        jform.append('file_name', name);
    $('.'+progress_bar).removeClass('d-none');
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        }
    });
    $.ajax({
        xhr: function () {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = ((evt.loaded / evt.total) * 100);
                    percentComplete = Math.ceil(percentComplete);
                    $("."+progress_bar).width(percentComplete + '%');
                    $("."+progress_bar).html(percentComplete + '%');
                }
            }, true);
            return xhr;
        },
        type: method,
        url: urlname,
        data: jform,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $("."+progress_bar).width('0%');
            $('#uploadStatus').html('');
        },
        error: function () {
            $('.tohide').addClass('d-none');
            $('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
        },
        success: function (data) {
            if (data.status == true) {
                $("."+progress_bar).width('0%');
                $('.'+progress_bar).addClass('d-none');
                $('#'+target).prepend(data.html);                
                checkRows();
            }
        }        
    });   
  }

  
  
  
  
  
  
   
  