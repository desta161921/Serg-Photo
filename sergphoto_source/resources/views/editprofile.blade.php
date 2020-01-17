<!DOCTYPE html>
<html>
    <head>
        @include('includes.head');    
    </head>
    <body>
        @include('includes.header');
        <div class="container__profile">
            <div class="wrapper__profile">
            @guest
                <div class="album__list">
                    <h2 class="error-h">Error</h2>
                </div>
                <center><h1 class="error-p">Login to edit your profile</h1></center>
            @else
                <div class="editprofile__information bb-white">
                    <?php 
                        $userId = Auth::id(); 
                        $user = \App\User::find($userId);
                    ?>
                    <img src="/uploads/avatars/{{ $user->avatar }}" class="profile__img">
                    <div class="profile__description">
                        <h1 class="profile__description-name">{{ $user->first_Name }} {{ $user->last_Name }}</h1>
                    </div>
                    <div class="editprofile__information-buttons">
                        <form enctype="multipart/form-data" action="/editprofile" method="POST">
                            <input type="file" name="avatar">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-form btn-w" value="Update profile picture">
                        </form>
                        <form enctype="multipart/form-data" action="/deleteavatar" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-form btn-w" value="Delete profile picture">
                        </form>
                    </div>
                </div>
                <div class="editprofile__fields">
                    <form method="POST" name="_token" action="profile/update" class="editprofile__form" value="<?php echo csrf_token(); ?>">
                        {{ csrf_field() }}
                        <div class="form-inputs">
                            <div class="form-group ep-g" {{ $errors->has('location') ? ' has-error ' : ' ' }}>
                                <label for="location" class="editprofile-label">Location </label>
                                <input type="text" id="geocomplete" class="editprofile-input" name="location" placeholder="{{ $user->location }}" action="{{ action('UserController@update') }}">
                            </div>
                            <div class="form-group ep-g" {{ $errors->has('DOB') ? ' has-error ' : ' ' }}>
                                <label for="DOB" class="editprofile-label">Date of birth </label>
                                <input type="date" class="editprofile-input" name="DOB" value="{{ $user->DOB }}" action="{{ action('UserController@update') }}">
                            </div>
                        </div>
                        
                        <div class="form-group editprofile-btns">
                            <button type="submit" class="btn btn-form btn-upprofile">Update</button>
                            <a class="btn btn-form btn-upprofile" href="{{ action('UserController@deleteUser') }}" id="delete_User" onclick="return deleteUser();">Delete User</a>
                        </div>
                    </form>
                </div>
            @endguest
            </div>
        </div>
        <script type="text/javascript" src="{{ URL::asset('js/javascript.js') }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDiEw6eEobaD__SGRhNQrY-tFtQFdqVGY&amp;sensor=false&amp;libraries=places"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript" src="{{ URL::asset('js/jquery.geocomplete.min.js') }}"></script>
    <script>
      $(function(){
        $("#geocomplete").geocomplete()
      });
    </script>
    </body>
</html>
