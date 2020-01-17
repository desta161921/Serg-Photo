<!DOCTYPE html>
<html>
<head>
    @include('includes.head');
</head>

<body>
@include('includes.header');
<div class="container__events">
    <div class="wrapper__events">
        @if(DB::table('participants')->where('user_Id', '=', Auth::id())->where('event_Id','=', $event->event_Id)->where('participant_Role','=','Admin')->exists())
            <div class="event__header" style="background-image: url('{{ url('/') }}/uploads/events/{{ $event->event_Header }}')"></div>
            <div class="event__header-info">
                <form enctype="multipart/form-data" class="editevent__form-header" action="/updateHead" method="POST">
                    <!-- <label class="editevent-label-h">Event header</label> -->
                    <input type="file" class="editEventHeader-input" name="event-header">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="eventId" value="{{ $event->event_Id }}">
                    <input type="submit" class="btn btn-form btn-editEventHeader" value="Update event picture">
                </form>
            </div>
            <div class="editevent__main">
            <?php
                $row = DB::table('participants')->where('event_Id', $event->event_Id)->get();
            ?>
                <form method="POST" class="editevent__form-main" name="_token" action="/updateEvent" value="<?php echo csrf_token(); ?>">
                    {{ csrf_field() }}
                    <div class="editevent__group-l">
                        <div class="form-group ep-g" {{ $errors->has('event_Name') ? ' has-error ' : ' ' }}>
                            <label for="event_Name" class="editevent-label">Event name </label>
                            <input type="text" class="editevent__group-input" name="event_Name" value=" {{ $event->event_Name }}" action="{{ action('EventController@updateEvent') }}">
                        </div>
                        <div class="form-group ep-g" {{ $errors->has('event_Description') ? ' has-error ' : ' ' }}>
                            <label for="event_Description" class="editevent-label">Description </label>
                            <textarea class="txtarea-editevent" name ="event_Description" action="{{ action('EventController@updateEvent') }}" rows="5" cols="30" required>{{ $event->event_Description }}</textarea>
                        </div>
                    </div>
                    <div class="editevent__group-r">
                        <div class="form-group ep-g" {{ $errors->has('class') ? ' has-error ' : ' ' }}>
                            <label for="event_Location" class="editevent-label">Event location </label>
                            <input id="geocomplete" type="text" class="editevent__group-input" name="event_Location" value="{{ $event->event_Location }}" action="{{ action('EventController@updateEvent') }}">
                        </div>
                        <div class="form-group ep-g" {{ $errors->has('location') ? ' has-error ' : ' ' }}>
                            <label for=event_Privacy class="editevent-label">Level of privacy </label>
                            <select name="event_Privacy" class="editevent__group-input" value=" {{ $event->event_Privacy }}" action="{{ action('EventController@updateEvent') }}">
                               <option value="private">Private</option>
                                <option value="public" selected>Public</option>
                                <option value="hidden">Hidden (Link only)</option>
                            </select>
                        </div>
                        <div class="form-group ep-g" {{ $errors->has('event_Type') ? ' has-error ' : ' ' }}>
                            <label for="event_Type" class="editevent-label">Type of event </label>
                            <select name="event_Type" class="editevent__group-input" value=" {{ $event->event_Type }}" action="{{ action('EventController@updateEvent') }}">
                                <option value="WEDDING">WEDDING</option>
                                <option value="PARTY">PARTY</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="event_Id" value="{{ $event->event_Id }}" action="{{ action('EventController@updateEvent') }}">
                    <div class="form-group editevent__btns ep-g">
                        <button type="submit" class="btn btn-form btn-w">Update event</button>
                </form>
        
                <form method="POST" name"_token" enctype="multipart/form-data" action="/deleteEvent" value="<?php echo csrf_token(); ?>">
                       {{ csrf_field() }}
                    <input type="hidden" name="event_Id" value="{{ $event->event_Id }}">
                        <button class="btn btn-form btn-w" href="{{ action('EventController@deleteEvent') }}" id="delete_Event">Delete event</button>
                    </div>
                </form>
            </div>
        @else
        <script type="text/javascript">
            window.location = "../{{$event->event_Id}}";
        </script>
        @endif
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDiEw6eEobaD__SGRhNQrY-tFtQFdqVGY&amp;sensor=false&amp;libraries=places"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.geocomplete.min.js') }}"></script>
<script>
$(function(){
    $("#geocomplete").geocomplete()
});
</script>
</body>
</html>
