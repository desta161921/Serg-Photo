<!DOCTYPE html>
<html>
<head>
    @include('includes.head');
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.1.0/css/swiper.min.css">
</head>
<body>
    @include('includes.header')
    <div class="container__profile">
        <div class="wrapper__profile">
            <div class="profile__information">
                    <img src="{{ URL::asset('uploads/avatars') }}/{{ $user->avatar }}" class="profile__img">
                    <div class="profile__description">
                        <h1 class="profile__description-name">{{ $user->first_Name }} {{ $user->last_Name }}</h1>
                    </div>
                    <div class="profile__info">
                        <p class="profile__description-study">Date of birth: {{ $user->DOB }}</p>
                        <p class="profile__description-study">Location: {{ $user->location }}</p>
                        @if(Auth::id() == $user->user_Id)
                            <a class="btn btn-form" href="{{ route('editprofile')}}" id="event_Modal">Edit profile</a>
                            <button id="myBtn" class="btn-form btn-feed">Create album</button>
                            <div id="myModal" class="modal">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="modal-heading">
                                            <h2 class="modal-heading-h">Create album</h2>
                                        </div>
                                        <span class="btn-closeModal">&times;</span>
                                    </div>
                                    <div class="modal-body">
                                        <div class="profile__upload">
                                            <form value="<?php echo csrf_token(); ?>" class="album_upload-form" enctype="multipart/form-data" name="_token" action="/createAlbum"  method="POST">
                                                <input type="text" class="feed-input" name="album_Name-input" placeholder="Name..">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="text" class="feed-input" name="album_Description" placeholder="Description.." required>
                                                <select class="album-input" name="album_Privacy">
                                                    <option value="" disabled selected>Select permissions</option>
                                                    <option value="public">Public</option>
                                                    <option value="private">Private</option>
                                                </select>
                                                <input type="submit" class="btn btn-upload" value="Create album">
                                            </form>
                                        </div>
                                        <div class="profile__upload-bottom">
                                            <img class="mainfeed__post-img" id="output_image"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                </div>
            </div>
            <div class="album__list">
                <h2 class="album__list-heading">Albums</h2>
            </div>  
            <div class="profile__gallery">
                @php
                    $album = DB::table('albums')->where('user_Id', $user->user_Id)->paginate(3);
                    $i = 0;
                @endphp
                
                @foreach($album as $albums)
                @if($albums->album_Permission == 'public' || $albums->user_Id == Auth::id())
                    <div class="profile__gallery-description">
                        <a href="{{ url('/') }}/album/{{$albums->album_Id}}"><h1 class="profile__gallery-p">{{$albums->album_Name}} - ({{DB::table('files')->where('user_Id', $user->user_Id)->where('album_Id', $albums->album_Id)->count()}} photos)</h1></a>
                        <h3 class="profile__gallery-heading">{{$albums->album_Description}}</h3>
                    </div>
                    @php
                        $photo = DB::table('files')->where('user_Id', $user->user_Id)->where('album_Id', $albums->album_Id)->take(4)->orderBy('file_Id', 'Desc')->get();
                        $i++;
                    @endphp
                    <div class="profile__gallery-row">
                    @foreach($photo as $photos)
                        <div class="profile__gallery-column">
                            <a href="{{ url('/') }}/album/{{$albums->album_Id}}">
                            <img class="profile__gallery-img" src="{{ url('/') }}/uploads/users/{{$photos->user_Id}}/{{$albums->album_Name}}/{{$photos->file_Name}}"></a>
                        </div>
                    @endforeach
                    </div>
                @endif
                @endforeach
                {{ $album->links() }}

            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ URL::asset('js/modal.js') }}"></script>
</body>
</html>