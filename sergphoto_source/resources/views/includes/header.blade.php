@if (session('alert'))
        <script>
            alert("{{ html_entity_decode(session('alert')) }}");
        </script>
@endif 


 <header class="header" >
    <div class="header-container">
        <div class="header__logo-box">
            <a href="{{ URL::asset('/') }}"><img src={{ URL::asset('img/logo.png') }} alt="Logo" class="header__logo"></a>
            <a href="{{ URL::asset('/') }}"><h3 class="header__logo-text">SergPhoto</h3></a>
        </div>
        @guest
        @else
            <form class="header__search" action="{{ URL::asset('toSearchableArray') }}" method="POST" value=" {{ csrf_token() }}">
                {{ csrf_field() }}
                <div class="search">
                    <button id="searchButton" class="btn-search" type="submit"><span class="fa fa-search"></span></button>
                    <input type="text" class="header__search-box" name="searchValue">
                </div>
            </form>
        @endguest
        <nav class="nav" >
            @guest
            <ul class="nav__items">
                <li class="nav__item">
                    <a class="btn btn-nav" href="/">Log in</a>
                </li>
                <li class="nav__item">
                    <a class="btn btn-nav" href="/signup">Sign up</a>
                </li>
            </ul>
            @else
            <ul class="nav__items">
                <div class="dropdown" >
                    <button class="btnDrop" onclick="notifications()">Notifications {{Auth::user()->unreadNotifications->count()}}</button>
                    <div class="notifications__content" id="notificationDropdown" style="display:none">
                        @php
                        if(Auth::user()->notifications->count() != 0){
                            @endphp
                            <div id="notification_all">
                            @php
                            foreach (Auth::user()->notifications as $notification) {
                                if($notification->read_at == NULL){
                                    echo "<div id='".$notification->id."'><p><a href='".$notification->data['url']."'> (UNREAD)".$notification->data['message'].'</a>  <input type="button" onclick="DeleteNotification()" value="Delete" /></p></div>';
                                    Auth::user()->unreadNotifications()->update(['read_at' => now()]);
                                }else{
                                    @endphp
                                    <div id="{{$notification->id}}"><p><a href="{{$notification->data['url']}}"> (READ) {{$notification->data['message']}}</a>  <input type="button" onclick="DeleteNotification('{{$notification->id}}')" value="Delete" /></p></div>
                                    @php
                                }
                            }
                            @endphp
                                <input type="button" onclick="DeleteNotification('all')" value="Delete all" />
                            </div>
                            @php
                        }else{
                        echo "No notifications";
                        }
                        @endphp
                        
                    </div>
                </div>
                <li class="nav__item">
                    <a class="btn btn-nav" href="{{ route('feed')}}">Feed</a>
                </li>
                <li class="nav__item">
                    <a class="btn btn-nav" href="{{ route('profile')}}">Profile</a>
                </li>
                <li class="nav__item">
                    <a class="btn btn-nav" href="{{ route('events')}}">Events</a>
                </li>
                <li class="nav__item">
                    <a class="btn btn-nav" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
            @endguest
        </nav>
    </div>
</header>
@if (session('alert'))
        <script>
            alert("{{ html_entity_decode(session('alert')) }}");
        </script>
@endif 
<script>
    function DeleteNotification(pid) {
        var token = $('meta[name="csrf-token"]').attr('content');
        if(pid == 'all'){
            if (confirm("Press Ok to delete all notification.")) {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/') }}/notification/delete",
                    headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        _token:'{{ csrf_token() }}',
                        notification: 'all'
                    },
                    success:function(data){
                        $('#notification_all').html('No notifications');
                    },
                    error:function(){
                        alert("Something went wrong.");
                    }
                    });
            } else {
                alert("You pressed Cancel!");
            }
        }else{
            $.ajax({
                type: "POST",
                url: "{{ url('/') }}/notification/delete",
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    _token:'{{ csrf_token() }}',
                    notification: pid
                },
                success:function(data){
                    $('#'+pid).hide();
                },
                error:function(){
                    alert("Something went wrong.");
                }
            });
        }
    };
</script>

