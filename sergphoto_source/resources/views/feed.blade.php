<!DOCTYPE html>
<html>
<head>
    @include('includes.head');    
    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
</head>
<body>
@include('includes.header');
<div class="container__mainfeed">
    <div class="wrapper__mainfeed top-feed">
        <div class="event__list">
            <h2 class="event__list-heading">Feed</h2>
        </div>
        
        <?php
            use Carbon\Carbon;
            use App\Comment;
            // Get Image from table
            $user_Id = Auth::id();
            
            $userPhotos = DB::table('files')
            ->where('created_at', '>=', \Carbon\Carbon::now()->subHours(24))
            ->orderBy('file_Id', 'desc')
            ->get();
            $i = 0;
        ?>
        @guest
        <h2>You are not logged in</h2>
        @else
        @if($userPhotos->isempty())
        <center><h1 class="error-p">No photo has been uploaded the last 48 hours.</h1></center>
        @endif
            
        @foreach($userPhotos as $userPhoto)
            @if(DB::table('events')->where('event_Id', $userPhoto->event_Id)->where('event_Privacy', "public")->exists() OR DB::table('participants')->where('event_Id', $userPhoto->event_Id)->where('user_Id', $user_Id)->exists() OR $userPhoto->event_Id == NULL)
            @if(!DB::table('albums')->where('user_Id', $userPhoto->user_Id)->where('album_Id', $userPhoto->album_Id)->where('album_Permission', 'private')->exists())    
                <div class="mainfeed__post">
                    <p class="mainfeed__post-description mfeed-p">{{ $userPhoto->file_Description }}</p>
                    <div class="mainfeed__post-flex">
                        <p class="mainfeed__post-location">{{ $userPhoto->file_Location }}</p>
                        <p class="mainfeed__post-author">{{ DB::table('users')->where('user_Id', $userPhoto->user_Id)->first()->first_Name }}
                        {{DB::table('users')->where('user_Id', $userPhoto->user_Id)->first()->last_Name}}</p>
                    </div>
                    @if($userPhoto->event_Id == NULL)
                        <a href="{{ url('/') }}/uploads/users/{{ $userPhoto->user_Id }}/{{ DB::table('albums')->where('album_Id', $userPhoto->album_Id)->pluck('album_Name')->first() }}/{{ $userPhoto->file_Name }}" data-lightbox="Album" data-title="{{$userPhoto->file_Description}}">
                        <img src='/uploads/users/{{ $userPhoto->user_Id }}/{{ DB::table('albums')->where('album_Id', $userPhoto->album_Id)->pluck('album_Name')->first() }}/{{ $userPhoto->file_Name }}' class="mainfeed__post-img"></img></a>
                    @else 
                        <a href="{{ url('/') }}/uploads/events/{{ $userPhoto->event_Id }}/{{ $userPhoto->file_Name }}" data-lightbox="Album" data-title="{{$userPhoto->file_Description}}">
                        <img src='/uploads/events/{{ $userPhoto->event_Id }}/{{ $userPhoto->file_Name }}' class="mainfeed__post-img"></img></a>
                    @endif
                    <div class="mainfeed__plus">
                   <div id="like-{{$userPhoto->file_Id}}" value="{{ (DB::table('reacts')->where('file_Id', $userPhoto->file_Id)->count()) }}">{{ (DB::table('reacts')->where('file_Id', $userPhoto->file_Id)->count()) }}</div>
                    @php
                        $i ++;
                        $reactnames = DB::table('reacts')->where('file_Id', $userPhoto->file_Id)->take(2)->orderBy('created_at', 'desc')->get()
                    @endphp
                    @foreach($reactnames as $reactname)
                    {{ app\User::find($reactname->user_Id)->first_Name . " " . app\User::find($reactname->user_Id)->last_Name }}
                    @endforeach
                    <p>likes this.</p>
                    <form method="POST" id="likeform-{{$userPhoto->file_Id}}" value="<?php echo csrf_token(); ?>">
                        {{ csrf_field() }}
                        <input type="hidden" id="file_Id" name="file_Id" value="{{ $userPhoto->file_Id }}">
                        @if(!DB::table('reacts')->where('user_Id',Auth::id())->where('file_Id',$userPhoto->file_Id)->exists())
                            <input type="hidden" id="plusOne" name="plusOneLike" value="+1">
                        @else
                            <input type="hidden" id="plusOne" name="plusOneLike" value="-1">
                        @endif
                    </form>
                        @if(!DB::table('reacts')->where('user_Id',Auth::id())->where('file_Id',$userPhoto->file_Id)->exists())
                            <input type="button" id="likebutton-{{$userPhoto->file_Id}}" onclick="React({{ $userPhoto->file_Id }}, +1)" name="plusOneLike" value="Like">
                        @else
                            <input type="button" id="likebutton-{{$userPhoto->file_Id}}" onclick="React({{ $userPhoto->file_Id }}, -1)" name="plusOneLike" value="Unlike">
                        @endif
                    </div>
                    <div id="list-{{$i}}" class="mainfeed__comments">
                        <ul class="list">
                        @php
                            $comments = DB::table('comments')
                            ->where('file_Id', $userPhoto->file_Id)
                            ->orderBy('created_at', 'desc')
                            ->get();
                        @endphp
                        <li class="list-comments"><div id="new_comment-{{$userPhoto->file_Id}}"></div></li>
                        @foreach($comments as $comment)
                            @if(Carbon::parse($comment->created_at)->diffInDays() <= 1)
                                @php
                                    $createdAt = Carbon::parse($comment->created_at)->diffForHumans();
                                @endphp
                            @else
                                @php
                                    $createdAt = Carbon::parse($comment->created_at)->formatLocalized('%A %d. %B %Y');  
                                @endphp
                            @endif
                            @php
                                $author = DB::table('users')->where('user_Id', $comment->user_Id)->first();
                            @endphp
                            <li class="list-comments"><div class="{{$comment->comment_Id}}"><div class="mainfeed__comments-posts">{{$author->first_Name}} {{$author->last_Name}} - {{$createdAt}}
                            
                            @if($comment->user_Id == Auth::id())
                                <input type="button" class="btn-deleteCmnt" onclick="DeleteComment('{{$comment->comment_Id}}')" value="Delete">
                            @endif
                            </div>
                            <div class="comment-text">{{$comment->comment_Text}}</div></div></li>
                        @endforeach
                        </ul>
                        <ul class="pagination"></ul>
                        <script>
                            var pagination = new List('list-{{$i}}', {
                              valueNames: ['name'],
                              page: 6,
                              pagination: true
                            });
                        </script>
                        <p id="output"></p>
                    </div>

                    @if(DB::table('users')->where($user_Id == Auth::Id()))
                        <form class="mfeed-p" id="newcomment-{{ $userPhoto->file_Id }}" method="POST" value="<?php echo csrf_token(); ?>" name="_token">
                            <input type="hidden" name="file_Id" value="{{ $userPhoto->file_Id }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <textarea id="comment-data-{{ $userPhoto->file_Id }}" rows="4" cols="50" class="feed-input" name="comment_Text" placeholder="Comment.."></textarea>
                            <input type="button" class="btn btn-upload btn-event-upload" onclick="addComment({{$userPhoto->file_Id}})" value="Leave comment">
                        </form>
                    @endif 
                </div>
            @endif
            @endif
        @endforeach
        @endguest
    </div>
</div>

@if(!empty($comment))
<script>
    function DeleteComment(pid) {
        var token = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            type: "POST",
            url: "{{ url('/') }}/deleteComment",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                _token:'{{ csrf_token() }}',
                comment_Id: pid
            },
            success:function(data){
                $('.'+pid).remove();
            },
            error:function(){
                alert("Couldn't load your comment.");
            }
        });
    };
</script>
@endif
@if (Auth::check())
<script>
    function addComment(id) {
        var comment = document.getElementById('comment-data');
        var data = $('#newcomment-'+id).serialize();
        var text = $("#comment-data-"+id).val();
        
        $.ajax({
            type: "POST",
            url: "{{ url('/') }}/newComment",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: (data)
        })
        $('#new_comment-'+id).prepend('{{\Auth::user()->first_Name}} {{\Auth::user()->last_Name}} - Now </br> '+text+'</br>');
        document.getElementById('comment-data-'+id).value = '';
    }
    
    function React(id, value2) {
        var token = $('meta[name="csrf-token"]').attr('content');
        var count = document.getElementById('like-'+id).getAttribute('value');
                
        $.ajax({
            type: "POST",
            url: "{{ url('/') }}/plusOne",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#likeform-'+id).serialize(),
            success:function(data){
                if (value2 == 1){
                    $('#like-'+id).html(Math.abs(count)+1);
                    document.getElementById('like-'+id).value = Math.abs(count+1);
                    $("#like-"+id).attr("value",Math.abs(count)+1);
                    document.getElementById('likebutton-'+id).value = 'Unlike';
                    $("#likebutton-"+id).attr("onclick","React("+id+", -1)");
                }else{
                    $('#like-'+id).html(Math.abs(count)-1);
                    document.getElementById('like-'+id).value = (Math.abs(count)-1);
                    $("#like-"+id).attr("value",Math.abs(count)-1);
                    document.getElementById('likebutton-'+id).value = 'Like';
                    $("#likebutton-"+id).attr("onclick","React("+id+", +1)");
                }
            },
            error:function(){
                alert("Something went wrong.");
            }
        });
    };
</script>
@endif
<script type="text/javascript" src="{{ URL::asset('js/lightbox.min.js') }}"></script>
<script src="{{ URL::asset('js/pagination.js') }}"></script>
<script src="{{ URL::asset('js/modal.js') }}"></script>
</body>
</html>
