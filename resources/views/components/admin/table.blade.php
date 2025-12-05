@php
    $modalId = '';
    if(isset($modal) && $modal == 'large'){
        $modalId = '#myModal-lg';
    }elseif(isset($modal) && $modal == 'extra large'){
        $modalId = '#myModal-xl';
    }
@endphp
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex">
                    <div class="card-title w-50">{{$title}}</div>                
                    <div class="w-50 text-right">                                           
                        @if(isset($header))
                            <a                              
                            @if(isset($modal_or_page) && $modal_or_page == '1')                           
                                href="{{$url}}"
                                class="btn btn-primary"
                            @elseif(isset($url) && $url)                                
                                data-toggle="modal" 
                                data-backdrop="static" 
                                data-keyboard="false" 
                                data-target="{{$modalId}}" 
                                data-header="{{$header}}" 
                                data-url="{{$url}}" 
                                href="javascript::void(0)" 
                                class="btn btn-primary add-btn"
                            @endif                                
                                >
                                <i class="fa fa-plus"></i>{{$header}}</a>
                        @endif                      
                        @if(isset($header1))
                            @can($role1)
                            <a data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="{{$modalId1}}" data-header="{{$header1}}" data-url="{{$url1}}" href="javascript::void(0)" class="btn btn-primary add-btn"><i class="fa fa-plus"></i>{{$header1}}</a>
                            @endcan
                        @endif                      
                        @if(isset($header2))
                            @can($role2)
                            <a data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="{{$modalId1}}" data-header="{{$header2}}" data-url="{{$url2}}" href="javascript::void(0)" class="btn btn-primary add-btn"><i class="fa fa-plus"></i>{{$header2}}</a>
                            @endcan
                        @endif                                                            
                        @if(isset($header3))                            
                            <button type="submit" class="btn btn-primary add-btn"></i>{{$header3}}</button>                            
                        @endif                                                            
                    </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped table-bordered text-nowrap w-100">
                        {{$slot}}                    
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>