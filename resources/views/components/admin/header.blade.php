<div class="page-header">
    {{-- <h4 class="page-title">{{$header}} {{$slot}}</h4> --}}
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url(guardName().'/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$link1}}</li>
        @if(isset($link2))
        <li class="breadcrumb-item active" aria-current="page">{{$link2}}</li>
        @endif
    </ol>
</div>
