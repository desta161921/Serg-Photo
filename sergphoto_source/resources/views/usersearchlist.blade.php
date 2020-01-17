<!DOCTYPE html>
<html>
<head>
    @include('includes.head')
</head>
<body>
    @include('includes.header')
    <div class="container__search">
        <div class="wrapper__search">
            <div class="search__users">
                <h1>Users:</h1>
                @if($userquery != 'empty')
                    <?php
                        $users = $userquery->get();
                    ?>
                @foreach($users as $user)
                    <a class="btn btn-searchResult" href="{{ route('profile')}}/{{$user->user_Id}}">{{$user->first_Name}} {{$user->last_Name}}<br></a>
                @endforeach
                @else
                    Empty search
                @endif
            </div>
            <div class="search__events">
                <h1 class="search__events-heading">Events:</h1>
                 
                @if($eventquery != 'empty')
                    <?php
                        $events = $eventquery->get();
                    ?>
                @foreach($events as $event)
                    <a class="btn btn-searchResult" href="{{ route('events')}}/{{$event->event_Id}}">{{$event->event_Name}} <br>
                @endforeach
                @else
                    Empty search
                @endif
            </div>
        </div>
    </div>
</body>
</html>
