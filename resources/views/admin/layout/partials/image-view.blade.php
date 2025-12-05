@php
$ext = pathinfo($url, PATHINFO_EXTENSION);
// if($ext == 'pdf'){                    
//     $url = 'https://play-lh.googleusercontent.com/LvJB3SJdelN1ZerrndNgRcDTcgKO49d1A63C5hNJP06rMvsGkei-lwV52eYZJmMknCwW';
// }elseif($ext != 'png' && $ext != 'jpg' && $ext != 'jpeg' && $ext != 'gif'){
//     $url = 'https://storage.googleapis.com/gweb-uniblog-publish-prod/images/Google_Docs.max-1100x1100.png';
// } 
@endphp
{{-- <div class="color-image-container image38 ui-droppable">
    <input type="hidden" name="galleries[]" value="{{$url}}">
    <img src="{{asset($url)}}" width="100%" alt="">
    <span class="cross remove">X</span>
</div>       --}}
<div class="color-image-container image" data-id="">
    <img src="{{asset($url)}}" class="color-image" style="width: {{$width ?? '100px'}}">
    @if(!isset($single))
        <i class="fa fa-times remove-image" data-id=""></i>
        <input type="hidden" name="color[{{ $pcid }}][image][]" value="{{$path}}">
    @else
        <input type="hidden" name="image" value="{{$path}}">
    @endif
</div>
    {{-- <style>
        .image-holder{
            position: relative;width: 25%;padding: 10px;border: 1px solid lightgray;
        }
        .cross{
            position: absolute;
    top: 0;
    right: 0px;
    background: red;
    padding: 0px 4px;
    color: white;
    font-weight: bold;
    cursor: pointer;
        }
    </style> --}}