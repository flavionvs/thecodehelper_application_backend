@extends('emails.mail')
@section('content')
<body style="background-color: rgb(38 167 81)">
  <div class="form">                  
      <div class="form-small"; style="padding: 0px">
          <div style="text-align: center;padding:17px">
              <img class="mail-image" style="width: 100px" alt="top image" src="https://meeting.fadsanindia.in/images/meeting-logo3.png" width="">
          </div>
          <h1 class="h1-font">Meeting Cancelled By Admin<h1>
          <p class="p-font">Hey <b>{{$user->first_name}}</b>, Your meeting scheduled in the room named <b>{{$booking->room->name}}</b> on <b>{{dateFormat($booking->date)}}</b> from <b>{{date('h:i A', strtotime($booking->from_time))}}</b> to <b>{{date('h:i A', strtotime($booking->to_time))}}</b> has been cancelled by the administrator.</p>                
            <br>
          <p class="p-font"><b>Reason : -</b></p>
          <p class="p-font">{{$booking->reason}}</p>          
          
      </div>

      <div>                
          <p class="p-footer">Email sent by DS Group. <br>
          Copyright © {{date('Y')}} Inc. All rights reserved</p>
      </div>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
</body>
@endsection