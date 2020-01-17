<!DOCTYPE html>
<html>
<head>
    @include('includes.head')
</head>
<body>
@include('includes.header')
    <div class="container__events">
        <div class="wrapper__eventlist">
            <div class="event__list">
                <h2 class="event__list-heading">Your eventlist</h2>
            </div>
            <div class="event__info">
                <?php
                    $eventCount = DB::table('participants')
                    ->where('user_Id', Auth::id())
                    ->orderBy('event_Id', 'desc')
                    ->get();
                ?>
                <table class="event__info-table">
                    <tr>
                        <th class="event__info-heading">Event</th>
                        <th class="event__info-heading">User role</th>
                        <th class="event__info-heading">Participants</th>
                    </tr>
                @foreach($eventCount as $event)
                    <tr>
                        <td><p class="event__description-name el__d-name"><a class="event__description-link" href="{{route('events')}}/{{$event->event_Id}}">{{\App\Event::find($event->event_Id)->event_Name}}</a></p></td>
                        <td><p class="event__description-about">{{$event->participant_Role}}</p></td>
                        <td><p class="event__description-about"><?php echo (DB::table('participants')->where('event_Id', $event->event_Id)->count())?></p></td>
                    </tr>
                @endforeach
                </table>
                <a class="btn-event btn-form" href="events">All events</a>
            </div>
        </div>
    </div>
</body>
</html>
