<!DOCTYPE html>
<html>
<head>
    @include('includes.head');
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
@include('includes.header')
<div class="container__album">
    <div class="wrapper__album">
        <div class="album__list">
            <h2 class="album__list-heading">{{$event->event_Name}}</h2>
            <p class="event__description-about e__d-a">{{$event->event_Description}}</p>
        </div>
        @if ((!is_null(DB::table('participants')->where('user_Id', '=', Auth::id())->where('event_Id', '=', $event->event_Id)->where('participant_Role', '=', 'Admin')->first())))
            <div class="invitation__template">
                <h1 class="invitation__template-heading">Preview</h1>
                @if (file_exists(public_path().'/uploads/events/'.$event->event_Id.'/invitation.png'))
                    <img src="{{url('/uploads/events/'.$event->event_Id.'/invitation.png')}}">
                    <a class="btn btn-form btn-invitation" href="{{url('/events/'. $event->event_Id .'/invitation/edit')}}" id="edit__event">Edit invitation layout</a>
                @else
                <p>No preview since you haven't made the invitation layout yet</p>
                <a class="btn btn-form event__btn-group" href="{{url('/events/'. $event->event_Id .'/invitation/edit')}}" id="edit__event">Create invitation layout</a>
            </div>
            @endif
            <div class="invitation__template-mailinvite">
                <h2 class="invitation__template-mh">Invite</h2>
                <div class="invitation__template-form">
                    <form method="POST" name"_token" enctype="multipart/form-data" action="{{ route('invite') }}" value="<?php echo csrf_token(); ?>">
                         {{ csrf_field() }}
                        <input type="email" class="invitation__template-search" id="search" name="search"></input>
                        <input type="submit" class="invitation__template-invite" value="Invite via email">
                        <input type="hidden" id="event_Id" name="event_Id" value="{{$event->event_Id}}"></input>
                    </form>
                </div>
            </div>
            
            @php
                $invite = DB::table('invites')->where('event_Id', $event->event_Id)->get()
            @endphp
            <div class="invitation__template-invited">
                <h2 class="invitation__template-mh">Pending invitations</h2>
                <table class="invitation__template-table">
                    <tr>
                        <th class="invitation__template-th">Email</th>
                        <th class="invitation__template-th">Token</th>
                        <th class="invitation__template-th">Delete</th>
                    </tr>
                    @foreach($invite as $invites)
                    <tr>
                        <td class="invitation__template-td">{{$invites->email}}</td>
                        <td class="invitation__template-td">{{$invites->token}}</td>
                        <td>
                            <form method="POST" name"deleteInvitation" class="invitation__template-delete" action="{{url('/events/invitation/delete')}}" value="<?php echo csrf_token(); ?>">
                                 {{ csrf_field() }}
                                <input type="hidden" id="invite_token" name="invite_token" value="{{$invites->token}}"></input>
                                <input type="submit" class="invitation__template-invite lp" value="Delete invitation"></input>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </table>
                @else
                    Only admin can view invitation.
                @endif
            </div>
    </div>
</div>

</body>
</html>