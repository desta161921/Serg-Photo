<title>You've been invited to a SergPhoto Event</title>

<p>You have been invited to join the event "{{DB::table('events')->where('event_Id', '=', $invite->event_Id)->first()->event_Name}}" </p>
<p>Click the link below to activate your new account and join the event</p>
<p><a href="{{url('/inviteregistration')}}/{{$invite->token}}">Click here</a> to join!</p>
<img src="{{url('/uploads/events/'.$invite->event_Id.'/invitation.png')}}">