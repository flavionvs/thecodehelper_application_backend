<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex">
                    <div class="card-title w-50">Filter</div>                
                    <div class="w-50 text-right">                        
                        <a href="javascript::void(0)" class="btn btn-primary" id="toggle-bar">&nbsp;<i class="fa fa-plus"></i></a>                                        
                    </div>
            </div>
            <div class="card-body">
                        {{$slot}}                    
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#toggle-bar').click(function(){
			$(this).parent().parent().next('.card-body').slideToggle();
		});
    });
</script>