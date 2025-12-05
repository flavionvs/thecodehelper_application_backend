<!-- imageupload.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Laravel Multiple Images Upload Using Dropzone</title>
    <meta name="_token" content="{{csrf_token()}}" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
</head>
<body>
<div class="container">
       
    <h3 class="jumbotron">Laravel Multiple Images Upload Using Dropzone</h3>
    <form method="post" action="{{url('image/upload/store')}}" enctype="multipart/form-data" 
                  class="dropzone" id="dropzone">
    @csrf
    </form>  
    <div id="img"></div>
<script type="text/javascript">
        Dropzone.options.dropzone =
         {
            maxFilesize: 200,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
               return time+file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 50000,
            removedfile: function(file) 
            {
                var name = file.upload.filename;
                $.ajax({
                    headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                    type: 'POST',
                    url: '{{ url("image/delete") }}',
                    data: {filename: name},
                    success: function (data){
                        console.log("File has been successfully removed!!");
                    },
                    error: function(e) {
                        console.log(e);
                    }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ? 
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
       
            success: function(file, response) 
            {
                console.log(response);  
                let BASE_URL = window.origin;              
                $('#img').append('<img src="'+BASE_URL+'/'+response.success+'" width="150px" height="150px">');
            },
            error: function(file, response)
            {
               return false;
            }
};
</script>
</body>
</html>