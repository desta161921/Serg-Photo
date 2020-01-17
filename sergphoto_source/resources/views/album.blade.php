<!DOCTYPE html>
<html>
<head>
    @include('includes.head');
</head>
<body>
@include('includes.header')
<?php
            use Carbon\Carbon;
            use App\Comment;
?>
<div class="container__album">
    <div class="wrapper__album">
        <div class="album__list">
            <h2 class="album__list-heading">{{$album->album_Name}}</h2>
            <p class="album__list-p">{{$album->album_Description}}</p>
        </div>
        @if(DB::table('albums')->where('album_Id', $album->album_Id)->where('user_Id', Auth::id())->exists())
            <div class="album__information">
                <p class="album__information-p">Current privacy: {{$album->album_Permission}}</p>
                <div class="album-information-main">
                    
                    <form method="POST" class="album-information-form" action="/updateAlbum" value="<?php echo csrf_token(); ?>">
                        {{ csrf_field() }}
                        <input type="hidden" name="album_Id" value="{{ $album->album_Id }}">
                        <div class="album-information-radio">
                        @if($album->album_Permission == 'private')
                            <label class="album-label"><input type="radio" class="album-radio" name="album_Privacy" value="private" checked>Private</input></label>
                            <label class="album-label"><input type="radio" class="album-radio" name="album_Privacy" value="public">Public</input></label>
                        @else
                            <label class="album-label"><input type="radio" class="album-radio" name="album_Privacy" value="private">Private</input></label>
                            <label class="album-label"><input type="radio" class="album-radio" name="album_Privacy" value="public" checked>Public</input></label>
                        @endif
                        </div>
                        <input type="submit" class="btn btnH btn-upload" value="Update privacy">
                    </form>
                    
                                          
                    <form method="POST" action="/deleteAlbum" value="<?php echo csrf_token(); ?>">
                        {{ csrf_field() }}
                        <input type="hidden" name="album_Id" value="{{ $album->album_Id }}">
                        <input type="submit" class="btn btnH btn-upload" onclick="return deleteAlbum();" value="Delete album">
                    </form>
                </div>                    
            </div>

            <div id="myModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-heading">
                            <h2 class="modal-heading-h">Upload photo</h2>
                        </div>
                        <span class="btn-closeModal">&times;</span>
                    </div>
                    <div class="modal-body-album">
                        <div class="image__upload">
                            <form class="image__upload-form" value="<?php echo csrf_token(); ?>" enctype="multipart/form-data" name="_token" action="/uploadImage"  method="POST">
                                <div class="image__upload-l">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="album_Id" value="{{ $album->album_Id }}">
                                    <input type="text" class="image__upload-input" name="file_Description" placeholder="Caption.." required>
                                    <input type="text" id="geocomplete" class="image__upload-input" name="file_Location" placeholder="Location.." required>
                                </div>
                                <div class="image__upload-r">
                                    <input type="file" accept="image/*" onchange="preview_image(event)" name="profileImages">
                                    <select class="image__upload-select" name="filter" id="filter" onchange="changeFilters()">
                                        <option value="Select-filter">Select Filter</option>
                                        <option value="Normal" checked>Normal</option>
                                        <option value="Grayscale">Grayscale</option>
                                        <option value="Invert">Invert</option>
                                        <option value="Sepia">Sepia</option>
                                        <option value="Saturate">Saturate</option>
                                        <option value="Opacity">Opacity</option>
                                        <option value="Hue-rotate">Hue Rotate</option>
                                        <option value="Brightness">Brightness</option>
                                        <option value="Contrast">Contrast</option>
                                    </select>
                                    <input type="submit" class="btn btn-uploadImage" value="Upload image">
                                </div>
                            </form>
                        </div>
                        <div class="image__upload-bottom">
                            <img class="image__upload-img" id="output_image"/>
                        </div>
                    </div>
                </div>
            </div>

        @endif
        @if(DB::table('albums')->where('album_Id', $album->album_Id)->where('album_Permission', 'private')->exists() && !DB::table('albums')->where('album_Id', $album->album_Id)->where('user_Id', Auth::id())->exists())
            <p class="text-mid">Album is private. Only owner can see content.</p>
        @else
            @php
                $photo = DB::table('files')->where('album_Id', $album->album_Id)->orderBy('file_Id', 'Desc')->paginate(20);
            @endphp
            <div class="album__images">
                <div class="profile__gallery-row">
                    <div class="profile__gallery-plus">
                        <a id="myBtn" class="delete__photo-form" href="#"><img class="album__images-plus" src="{{ url('/') }}/img/plus.png"></a>
                    </div>
                    @foreach($photo as $photos)
                    <div class="profile__gallery-column">
                        @php
                            $comments = DB::table('comments')
                                ->where('file_Id', $photos->file_Id)
                                ->orderBy('created_at', 'desc')
                                ->get(); 
                                
                        @endphp
                        <div id="box-{{$photos->file_Id}}" hidden>
                            <div class="album__l">
                                <div class="album__l-l">
                                    <img class="album__l-img" src="{{ url('/') }}/uploads/users/{{$photos->user_Id}}/{{$album->album_Name}}/{{$photos->file_Name}}">
                                </div>
                                <div class="album__l-r"> 
                                    <div class="album__l-d">
                                        <p class="album__l-owner"> {{ DB::table('users')->where('user_Id', $photos->user_Id)->first()->first_Name }} {{ DB::table('users')->where('user_Id', $photos->user_Id)->first()->last_Name }} </p>
                                        <p> {{ $photos->created_at }} </p>
                                        
                                        <div class="album__likes"><div id="like-{{$photos->file_Id}}" value="{{ (DB::table('reacts')->where('file_Id', $photos->file_Id)->count()) }}">{{(DB::table("reacts")->where("file_Id", $photos->file_Id)->count())}}</div>&nbsp;like(s)</div> 
                                        
                                        @php
                                            $reactnames = DB::table("reacts")->where("file_Id", $photos->file_Id)->take(2)->orderBy("created_at", "desc")->get()
                                        @endphp
                                        @foreach($reactnames as $reactname)
                                            {{ app\User::find($reactname->user_Id)->first_Name . " " . app\User::find($reactname->user_Id)->last_Name }}
                                        @endforeach
                                        <form method="POST" id="likeform-{{$photos->file_Id}}">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="file_Id" value="{{ $photos->file_Id }}">
                                            @if(!DB::table("reacts")->where("user_Id",Auth::id())->where("file_Id",$photos->file_Id)->exists())
                                                <input type="hidden" id="plusOne" name="plusOneLike" value="Like">
                                            @else
                                                <input type="hidden" id="plusOne" name="plusOneLike" value="Unlike">
                                            @endif
                                        </form>
                                        @if(!DB::table("reacts")->where("user_Id",Auth::id())->where("file_Id",$photos->file_Id)->exists())
                                            <input type="button" id="likebutton-{{$photos->file_Id}}" onclick="React({{ $photos->file_Id }}, +1)" name="plusOneLike" value="Like">
                                        @else
                                            <input type="button" id="likebutton-{{$photos->file_Id}}" onclick="React({{ $photos->file_Id }}, -1)" name="plusOneLike" value="Unlike">
                                        @endif
                                    </div>
                                    <div class="album__l-commentsection"><div class="new_comment-{{$photos->file_Id}}"></div>
                                        @foreach ($comments as $comment)
                                            @if(Carbon::parse($comment->created_at)->diffInDays() <= 1)
                                                @php
                                                $createdAt = Carbon::parse($comment->created_at)->diffForHumans();
                                                @endphp
                                            @else
                                                @php
                                                $createdAt = Carbon::parse($comment->created_at)->formatLocalized("%A %d. %B %Y");  
                                                @endphp
                                            @endif
                                            @php
                                                 $author = DB::table("users")->where("user_Id", $comment->user_Id)->first();
                                            @endphp
                                            <div class="{{$comment->comment_Id}}"><div class="album__l-comments">
                                                <p class="album__l-author"> {{$author->first_Name}} {{$author->last_Name}} - {{$createdAt}} </p>
                                                @if($comment->user_Id == Auth::id())
                                                    <input type="button" class="btn-deleteCmnt" onclick="DeleteComment({{$comment->comment_Id}})" value="Delete">
                                                @endif
                                            </div>
                                            <p class="album__l-comment"> {{$comment->comment_Text}} </p></div>
                                        @endforeach
                                    
            
                                        <form class="album__l-nc" id="newcomment-{{ $photos->file_Id }}" method="POST" value="<?php echo csrf_token(); ?>" name="_token">
                                            <input type="hidden" name="file_Id" value="{{ $photos->file_Id }}">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <textarea id="comment-data-{{ $photos->file_Id }}" rows="3" cols="50" class="feed-input" name="comment_Text" placeholder="Comment.." style="width: 100%"></textarea>
                                            <input type="button" class="btn btn-form btn-cmnt" onclick="addComment({{$photos->file_Id}})" value="Leave comment">
                                        </form>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" data-featherlight='#box-{{$photos->file_Id}}'><img class="album__images-img" src="{{ url('/') }}/uploads/users/{{$photos->user_Id}}/{{$album->album_Name}}/{{$photos->file_Name}}"></a>
                        @if($photos->user_Id == Auth::id())
                            <form class="delete__photo-form" method="POST" action="/deletePhoto" value="<?php echo csrf_token(); ?>" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="event_Id" value="{{$photos->event_Id}}">
                                <input type="hidden" name="user_Id" value="{{$photos->user_Id}}">
                                <input type="hidden" name="file_Name" value="/uploads/users/{{$photos->user_Id}}/{{$album->album_Name}}/{{$photos->file_Name}}">
                                <input type="submit" class="btn btnH btn-deletephoto" value="Delete">
                            </form>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            {{ $photo->links() }}
        @endif
    </div>
</div>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBquHYr7B677DsAk_rvnt09kDyAcJ6KC4U&amp;sensor=false&amp;libraries=places"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript" src="{{ URL::asset('js/jquery.geocomplete.min.js') }}"></script>
    <script>
      $(function(){
        $("#geocomplete").geocomplete()
      });
    </script>
<script type="text/javascript" src="{{ URL::asset('js/lightbox.min.js') }}"></script>
<script src="//cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="{{ URL::asset('js/modal.js') }}"></script>
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
<script>
    function addComment(id) {
        var comment = document.getElementById('comment-data');
        var data = $('.featherlight-inner #newcomment-'+id).serialize();
        var text = $(".featherlight-inner #comment-data-"+id).val();
        
        $.ajax({
            type: "POST",
            url: "{{ url('/') }}/newComment",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: (data)
        })
        $('.new_comment-'+id).prepend('<p class="album__l-author">{{\Auth::user()->first_Name}} {{\Auth::user()->last_Name}} - Now </p></br> <p class="album__l-comment">'+text+'</p></br>');
 	$(".featherlight-inner #comment-data-"+id).val('');       
    }
    
    function React(id, value2) {
        var token = $('meta[name="csrf-token"]').attr('content');
        var count = $('.featherlight-inner #like-'+id).val();
                
        $.ajax({
            type: "POST",
            url: "{{ url('/') }}/plusOne",
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('.featherlight-inner #likeform-'+id).serialize(),
            success:function(data){
                if (value2 == 1){
                    $('.featherlight-inner #like-'+id).html(Math.abs(count)+1);
                    $('.featherlight-inner #like-'+id).val(Math.abs(count)+1);
                    $(".featherlight-inner #like-"+id).attr("value",Math.abs(count)+1);
                    $(".featherlight-inner #likebutton-"+id).val('Unlike');
                    $(".featherlight-inner #likebutton-"+id).attr("onclick","React("+id+", -1)");
                }else{
                    $('.featherlight-inner #like-'+id).html(Math.abs(count)-1);
                    $('.featherlight-inner #like-'+id).val(Math.abs(count)-1);
                    $(".featherlight-inner #like-"+id).attr("value",Math.abs(count)-1);
                    $(".featherlight-inner #likebutton-"+id).val('Like');
                    $(".featherlight-inner #likebutton-"+id).attr("onclick","React("+id+", +1)");
                }
            },
            error:function(){
                alert("Something went wrong.");
            }
        });
    };
</script>
</body>
</html>
