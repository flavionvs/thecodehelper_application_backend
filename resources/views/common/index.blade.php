@extends('admin.layout.default', ['title' => config('constant.app_name')])
@section('content')
<div class="app-content">  
  <div class="row mt-5">  
    <div class="col-sm-6 col-lg-6 col-xl-3">
      <div class="card">
        <div class="card-body bg-yellow iconfont text-left">
          <h6 class="mb-3">Total User</h6>
          <h2 class="mb-1 text-white display-4 font-weight-bold">45</h2>          
        </div> 
      </div>
    </div> 
</div>
  
@endsection
@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/snap.svg/0.5.1/snap.svg-min.js"></script>
<script src="{{asset('theme/js/chart1.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  $(document).ready(function(){
    setTimeout(() => {    
      $('.static').listtopie({
          startAngle:270,
          strokeWidth:1,
          hoverEvent:false,
          drawType:'round',
          speedDraw:500,        
          textSize:'0',
          hoverAnimate:true,
          marginCenter:1,
          sectorRotate:false,
          easingType:mina.bounce,
          infoText:false,
          fillOpacity:1,
      });
    }, 1000);
  })
</script>
@endpush