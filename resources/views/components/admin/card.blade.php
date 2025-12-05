@php
    $number = rand(10000000, 999999999);
    if(isset($modal) && $modal == 'large'){
        $modalId = '#myModal-lg';
    }elseif(isset($modal) && $modal == 'extra large'){
        $modalId = '#myModal-xl';
    }else{
        $modalId = '#myModal';
    }
@endphp
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            @if (isset($header))
                <div class="card-header d-flex">
                    <div class="card-title w-50">{{ $header }}</div>
                    <div class="w-50 text-right">
                        @if (isset($collapse) && $collapse == 'yes')
                            <a href="javascript::void(0)" class="btn btn-primary toggle-bar{{ $number }}"
                                data-slide="to-be-slide{{ $number }}">&nbsp;<i class="fa fa-plus"></i></a>
                        @endif
                        @if (isset($submit))
                            @if (
                                !isset($role) ||
                                    (isset($role) &&
                                        auth()->guard(guardName())->user()->can($role)))
                                <button type="submit" class="btn btn-primary add-btn"></i>{{ $submit }}</button>
                            @endif
                        @endif
                        @if (isset($header) && isset($url))
                            @if (!isset($role) || request()->user()->can($role))
                                <a
                                @if (isset($newTab) && $newTab == '1') href="{{ $url }}"
                                    class="btn btn-primary"
                                @else
                                    data-toggle="modal" 
                                    data-backdrop="static" 
                                    data-keyboard="false" 
                                    data-target="{{ $modalId }}" 
                                    data-header="{{ $header }}" 
                                    data-url="{{ $url }}" 
                                    href="javascript::void(0)" 
                                    class="btn btn-primary add-btn"
                                @endif
                                >
                                    <i class="fa fa-plus"></i>{{ $header }}</a>                            
                        @endif
                        @endif

                </div>
            </div>
        @endif
        <div class="card-body to-be-slide{{ $number }}">
            {{ $slot }}
        </div>
    </div>
</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.toggle-bar{{ $number }}').click(function() {
            let cls = $(this).data('slide');
            $('.' + cls).slideToggle();
        });
    });
</script>
