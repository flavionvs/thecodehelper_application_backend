@extends('web.layout.default')
@section('content')
    <style>
        header {
            height: 150px !important;
        }

        .fs-12 {
            font-size: 12px !important;
        }

        .message {
            margin-left: 17px;
            background: #efefef;
            color: black;
            border-radius: 27px;
            width: 80%;
            box-shadow: 0 0 2px 0 black;
            border: 1px solid #63ba88;
            font-family: emoji;
        }
    </style>
    {{-- // this is written for not to reload page after booking --}}
    <div class="row mt-2">
        <div class="col-xs-3 col-md-3 p-0 m-0" style="padding-left:25px!important">
            <a href="{{ url('superadmin/dashboard') }}"><img src="{{ asset('images/meeting-logo3.png') }}" style="width:60px"></a>
        </div>
        <div class="col-xs-3 col-md-3 p-0 m-0" style="padding-top:14px!important">
            <button type="button"
                style="border: #009845 solid 1px; border-radius: 30px; padding: 5px; font-size: 12px; font-weight: 400px; width:150px;    box-shadow: 0 0 2px 0 black;
                        "
                data-toggle="modal" data-target="#exampleModal">
                Live View
            </button>
        </div>
        <div class="col-xs-6 col-md-6 text-center p-0 m-0" style="padding-top:14px!important">
            <p class="message">Click on the box to view details of the room.</p>
        </div>
    </div>
    {{-- <script>
        let i = 0;
    </script> --}}
    <div class="row" style="margin:5px 5px 33px 5px">
        @foreach ($rooms as $item)
            @php
                $date = date('Y-m-d');
                $meetingDate = '';
                $startTime = '';
                $endTime = '';
                $color = 'green';
                $cls = '';
                $booking = App\Models\Booking::whereRoomId($item->id)
                    ->orderBy('date', 'asc')
                    ->orderBy('from_time', 'asc')
                    ->where('status', 'Pending')                    
                    ->get();
                    
                if ($booking) {
                    foreach ($booking as $key => $value) {
                        // condition for meeting is running
                        if (strtotime(date('Y-m-d h:i A')) < strtotime($value->date . ' ' . $value->from_time)) {
                            $meetingDate = $value->date;
                            $startTime = $value->from_time;
                            $endTime = $value->to_time;
                            break;
                        }
                    }
                }
                $meetingDate1 = '';
                $startTime1 = '';
                $endTime1 = '';
                $booking1 = App\Models\Booking::whereRoomId($item->id)
                    ->whereDate('date', '=', $date)
                    ->orderBy('from_time', 'asc')
                    ->get();
                if ($booking1) {
                    foreach ($booking1 as $key => $value1) {
                        // if (strtotime(date('Y-m-d h:i A')) <= strtotime($value1->date . ' ' . $value1->from_time)) {
                            // dd(date('Y-m-d h:i:s').' '.$value1->date . ' ' . $value1->from_time.' '.date('Y-m-d h:i:s').' '.$value1->date . ' ' . $value1->to_time);
                            // dd(date('Y-m-d h:i:s') > date('Y-m-d h:i:s', strtotime( $value1->date . ' ' . $value1->to_time)));
                            // dd(strtotime(date('Y-m-d h:i:s')) >= strtotime($value1->date . ' ' . $value1->from_time));
                        if (
                            date('Y-m-d h:i:s') >= date('Y-m-d h:i:s', strtotime( $value1->date . ' ' . $value1->from_time)) && 
                            date('Y-m-d h:i:s') <= date('Y-m-d h:i:s', strtotime( $value1->date . ' ' . $value1->to_time))
                           ) {
                            
                            $color = 'red';
                            $cls = 'booked';
                            $meetingDate1 = $value1->date;
                            $startTime1 = $value1->from_time;
                            $endTime1 = $value1->to_time;
                            break;
                        }
                    }
                }
                // $cls = 'card-animate';
            @endphp
            <div class="booking-btn box-container{{$item->id}} col-lg-2 col-md-4 col-sm-6 col-12  d-flex justify-content-center align-items-center p-0 m-0"
                data-toggle="modal" data-target="#bookingform" data-id="{{ $item->id }}">
                <div class="card m-1 booked{{$item->id}} text-center pt-2" 
                        data-running-date="{{ $meetingDate1 }}"
                        data-running-from-time="{{ $startTime1}}" 
                        data-running-to-time="{{ $endTime1 }}"
                        data-next-date="{{ $meetingDate }}"
                        data-next-from-time="{{ $startTime }}" 
                        data-next-to-time="{{ $endTime }}"
                        style="background-color:{{ $color }};width:97%;height:132px;padding:10px">
                    <h4 class="card-title" style="color:white ; font-family: lato; font-size:15px; margin-bottom: 2px;font-style:normal">
                        {{ $item->name }} <br> ( Seating {{ $item->capacity }} )</h4>
                    <p style="font-family: lato;color:#fff; margin-bottom: 10px;" class="fs-12">
                        Next Booking: </p>
                    <p class="fs-12" style="color: white ;margin-top: -10px;font-family: lato; margin-bottom: 8px;">
                        {{ $meetingDate ? date('d-m-Y', strtotime($meetingDate)) : '' }}
                    </p>
                    <p class="fs-12" style="color: white ;margin-top: -13px;font-family: lato; margin-bottom: 8px;">
                        @if ($startTime)
                            {{ date('h:i A', strtotime($startTime)) }} - {{ date('h:i A', strtotime($endTime)) }}
                        @else
                            No Booking!
                        @endif
                    </p>
                    <span id="time-left{{$item->id}}" style="color: white;margin-top: -13px;font-size: 12px;"></span>
                </div>
            </div>
            <script>
               var i{{$item->id}} = 0;
               var j{{$item->id}} = 0;
            setInterval(() => {
                // $('.booked{{$item->id}}').map(function() {
                    var currentDate{{$item->id}} = new Date();

                    var startTime{{$item->id}} = $('.booked{{$item->id}}').data('running-date') + ' ' + $('.booked{{$item->id}}').data('running-from-time');
                    if($('.booked{{$item->id}}').data('running-from-time') == 'no' || new Date($('.booked{{$item->id}}').data('running-date') + ' ' + $('.booked{{$item->id}}').data('running-to-time')) < currentDate{{$item->id}}){
                        startTime{{$item->id}} = $('.booked{{$item->id}}').data('next-date') + ' ' + $('.booked{{$item->id}}').data('next-from-time');
                    }
                    var endTime{{$item->id}} = $('.booked{{$item->id}}').data('running-date') + ' ' + $('.booked{{$item->id}}').data('running-to-time');
                    if($('.booked{{$item->id}}').data('running-to-time') == 'no'  || new Date($('.booked{{$item->id}}').data('running-date') + ' ' + $('.booked{{$item->id}}').data('running-to-time')) < currentDate{{$item->id}}){                        
                        endTime{{$item->id}} = $('.booked{{$item->id}}').data('next-date') + ' ' + $('.booked{{$item->id}}').data('next-to-time');
                    }
                    // @if($item->id == 6)
                    //     console.log(startTime{{$item->id}});                    
                    // @endif
                    
                
                    var compareStartDate{{$item->id}} = new Date(startTime{{$item->id}})
                    var compareEndDate{{$item->id}} = new Date(endTime{{$item->id}})
                    var timeDifference{{$item->id}} = (compareEndDate{{$item->id}}.getTime() - currentDate{{$item->id}}.getTime()) / 1000;
                    timeDifference{{$item->id}} = parseInt(timeDifference{{$item->id}});
                    // console.log(timeDifference{{$item->id}});
                    if (compareStartDate{{$item->id}}.getTime() <= currentDate{{$item->id}}.getTime() && timeDifference{{$item->id}} < 900 && timeDifference{{$item->id}} > 0) {
                        $('.booked{{$item->id}}').addClass('card-animate');
                        var minutes{{$item->id}} = Math.floor(timeDifference{{$item->id}} / 60);
                        var remainingSeconds{{$item->id}} = timeDifference{{$item->id}} % 60;
                        $('.booked{{$item->id}}').find('#time-left{{$item->id}}').html('Left Time - ' + addLeadingZero(minutes{{$item->id}}) +
                            ':' +
                            addLeadingZero(remainingSeconds{{$item->id}}) +
                            ' secs. ');
                            i{{$item->id}}++;
                            j{{$item->id}} == 0;
                            
                            if(i{{$item->id}} == 1){
                                getRoomData({{$item->id}});
                            }
                        // $('.booked{{$item->id}}').removeClass('card-animate').css('background-color', 'red');
                    } else if (compareStartDate{{$item->id}}.getTime() <= currentDate{{$item->id}}.getTime() && compareEndDate{{$item->id}} >=
                        currentDate{{$item->id}}) {
                            i{{$item->id}}++;
                            j{{$item->id}} == 0;
                            if(i{{$item->id}} == 1){
                                getRoomData({{$item->id}});
                            }
                        $('.booked{{$item->id}}').removeClass('card-animate').css('background-color', 'red');
                    } else {
                        i{{$item->id}} = 0;
                        j{{$item->id}}++;
                        if(j{{$item->id}} == 1){
                            getRoomData({{$item->id}});
                        }
                        $('.booked{{$item->id}}').removeClass('card-animate').css('background-color', 'green');
                        $('.booked{{$item->id}}').find('#time-left{{$item->id}}').html('');
                    }
                    
                // }).get();
                // console.log(i);
            }, 1000);
          
            </script>
        @endforeach
    </div>
    <marquee behavior="scroll" direction="left" style="background: #cf3636;
    color: white;
    font-size: 15px;
    position: fixed;
    bottom: 0;
    z-index: 10;">Room booking is available from 9am to 6pm.</marquee>
    @endsection
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $('#page').html('<input type="hidden" name="page" value="live-mr">');
    })
       function addLeadingZero(number) {
                if (number < 10) {
                    return "0" + number;
                } else {
                    return number;
                }
        }
        function getRoomData(room_id){
            setTimeout(() => {                                
                $.ajax({
                    url : '{{url("get-room-data")}}/'+room_id,
                    success : function(res){
                        $('.box-container'+room_id).html(res);
                    }
                })
            }, 1000);
        }
          // Enable pusher logging - don't include this in production
            Pusher.logToConsole = false;
            var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
                cluster: 'ap2'
            });
        
            var channel = pusher.subscribe('my-channel');
            channel.bind('my-event', function(data) {
                if(data.type == 'live-mr'){
                    getRoomData(data.room_id);
                }
            });
</script>