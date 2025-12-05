@extends('web.layout.default')
@section('content')
    <style>
        header {
            height: 120px !important;
        }

        table {
            font-size: 16px;
            text-align: center
        }

        .btns {
            width: 142px !important;
            display: block;
            padding: 3px 0;
            border-radius: 3px;
            color: white;
        }

        .feedback-btn {
            background: royalblue;
        }

        .cancel-btn {
            background: #dc3545;
            position: absolute;
            top: 11px;
            right: -14px;
            width: 20px!important;
            height: 27px;
            padding: 0px;
        }
        .view-btn {
            background: #28a845;
        }
        .cancelled-btn {
            cursor:not-allowed;
        }

        .btns:hover {
            opacity: .9;
            color: white;
        }
        .message{
            font-size: 17px;
    font-family: sans-serif;
    color: red;
        }
        .status span{
            width: 120px!important;
        }
    </style>
    <div class="container" style="min-height:70vh">
        
                <table class="table" id="myTable">
                    <thead>
                        <tr class="bg-light">
                            <th>S.N</th>
                            <th>&nbsp;&nbsp;&nbsp;&nbsp;Room&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th>Capacity</th>
                            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Timing&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </th>
                            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Booking&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </th>
                            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Status&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </th>
                            {{-- <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Action&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booking as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->room->name }}</td>
                                <td>{{ $item->room->capacity }}</td>
                                <td>{{ date('h:i A', strtotime($item->from_time)) . ' - ' . date('h:i A', strtotime($item->to_time)) }}
                                </td>
                                <td>{{ date('d-m-Y', strtotime($item->date)) }}</td>
                                <td class="status position-relative" data-date="{{ $item->date }}" data-from-time="{{ $item->from_time }}"
                                    data-to-time="{{ $item->to_time }}">{!! status($item->status) !!}                               
                                    @if($item->status == 'Pending')
                                        <a href="{{ url('cancel-booking', $item->id) }}" data-toggle="modal"
                                            data-target="#exampleModal" class="cancel-btn btns" onclick="$('#booking_id').val({{$item->id}})" target="_blank">
                                        X
                                        </a>                                    
                                    @endif                                
                                </td>
                                {{-- <td class="feedback">
                                    @if ($item->status == 'Ended')
                                        @if ($item->conference || $item->beverages || $item->audio || $item->computer || $item->response || $item->overall)
                                            <a href="{{ url('view-feedback', $item->id) }}" class="view-btn btns"
                                                target="_blank">View Feedback</a>
                                        @else
                                            <a href="{{ url('give-feedback', $item->id) }}" class="feedback-btn btns"
                                                target="_blank">Give Feedback</a>
                                        @endif
                                    @elseif($item->status == 'Pending')
                                        <a href="{{ url('cancel-booking', $item->id) }}" data-toggle="modal"
                                            data-target="#exampleModal" class="cancel-btn btns" onclick="$('#booking_id').val({{$item->id}})" target="_blank">Cancel</a>
                                    @elseif($item->status == 'Cancelled')
                                        <a href="javascript::void(0)" class="cancelled-btn bg-orange btns">Cancelled</a>
                                    @endif
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            
    </div>
    </main>
    <!-- Button trigger modal -->
    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Launch demo modal
  </button> --}}

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cancel Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('cancel-booking') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <h4 class="color-red message">Are you sure, you want to cancel ?</h4>
                        <input type="hidden" name="booking_id" id="booking_id">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Cancel Booking</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
