<!DOCTYPE html>
<html>
<head>
@include('includes.head')
</head>
<body>
    @include('includes.header')
<main>
<div class="container__box">
    <video autoplay muted loop id="video-bg">
        <source src="vid/bg.webm" type="video/mp4">
    </video>
    <script>
        document.getElementById('video-bg').play();
    </script>
    <div class="wrapper__main">
        <div class="box-landing">
        @guest
            <form class="form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <h2 class="heading-1">Sign in with</h2>
                <div class="form-group form-social">
                    <a href="/auth/facebook" class="btn-face"><i class="fa fa-facebook-official" aria-hidden="true"></i>Facebook</a>
                    <a href="/auth/google" class="btn-google"><img src="img/googlelogo.png">Google</a>
                </div>
                <div class="form-group">
                    <p class="form-p"><span>Or sign in with</span></p>
                </div>
                <div class="signup__group" {{ $errors->has('email') ? ' has-error' : '' }}>
                    <input id="email" type="text" class="signup-input" name="email" value="{{ old('email') }}" required>
                    <span class="float-label">E-mail address</span>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="signup__group" {{ $errors->has('password') ? ' has-error' : '' }}>
                    <input id="password" type="password" class="signup-input" name="password" required>
                    <span class="float-label">Password</span>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <a href="password/reset" class="form-label form-passwordreset">Forgot password?</a>
                <div class="form-group">
                    <button type="submit" class="btn btn-form btn-login" id="login__btn">Log in</button>
                </div>
                <div class="form-group">
                    <a class="btn btn-form" href="/signup">Create new account</a>
                </div>
            </form>
            @else
            <div class="right__loggedin">
                <div class="right__loggedin-welcome">
                    <h2 class="heading-welcome">Welcome {{ Auth::user()->first_Name }} {{ Auth::user()->last_Name }}</h2>
                    <?php 
                        $userId = Auth::id(); 
                        $user = \App\User::find($userId);
                    ?>
                    <img src="{{ URL::asset('uploads/avatars') }}/{{ $user->avatar }}" class="home__img">
                    <div class="right__loggedin-links">
                        <a class="btn btn-links" href="/feed">Feed</a>
                        <a class="btn btn-links" href="/events">Events</a>
                        <a class="btn btn-links" href="/myevents">My events</a>
                        <a class="btn btn-links" href="/profile">Profile</a>
                    </div>
                </div>
                <a href="{{ route('logout') }}"
                class="btn btn-logout"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
            @endguest
        </div>
    </div>
</div>
</main>
    @include('includes.footer')
</body>
</html>


                    