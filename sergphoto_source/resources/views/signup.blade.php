<!DOCTYPE html>
<html>
<head>
    @include('includes.head')
</head>
<body>
@include('includes.header')
<div class="container__box">
    <video autoplay loop id="video-bg">
        <source src="vid/bg.webm" type="video/mp4">
    </video>
    <div class="wrapper__main">
        <div class="signup__container">
            @guest
            <form class="signup__form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="signup__heading">
                    <h2 class="heading-1">Sign up</h2>
                </div>
                <div class="signup__box">
                    <div class="signup__box-l">
                        <div class="signup__group" {{ $errors->has('first_Name') ? ' has-error' : '' }}>
                            <input id="first_Name" type="text" class="signup-input" name="first_Name" value="{{ old('first_Name') }}" required autofocus>
                            <span class="float-label">First name</span>
                                @if ($errors->has('first_Name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_Name') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="signup__group" {{ $errors->has('last_Name') ? ' has-error' : '' }}>
                            <input id="last_Name" type="text" class="signup-input" name="last_Name" value="{{ old('last_Name') }}" required autofocus>
                            <span class="float-label">Last name</span>
                                @if ($errors->has('last_Name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_Name') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="signup__group" {{ $errors->has('email') ? ' has-error' : '' }}>
                            <input id="email" type="text" class="signup-input" name="email" value="{{ old('email') }}" required autofocus>
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
                        </div>
                        <div class="signup__group">
                            <input id="password_confirmation" type="password" class="signup-input" name="password_confirmation" required>
                            <span class="float-label">Confirm password</span>
                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div> 
                        <div class="signup__box-r">
                        <div class="signup__group" {{ $errors->has('DOB') ? ' has-error' : '' }}>
                            <label for="DOB" class="form-label">Date of birth</label>
                            <input id="DOB" type="date" class="form-input" name="DOB" value="{{ old('DOB') }}" autofocus>
                            @if ($errors->has('DOB'))
                            <span class="help-block">
                                <strong>{{ $errors->first('DOB') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="signup__group" {{ $errors->has('gender') ? ' has-error' : '' }}>
                            <label for="gender" class="form-label">Gender</label>
                            <input type="radio" name="gender" value="male" class=""> Male
                            <input type="radio" name="gender" value="female"> Female
                            @if ($errors->has('DOB'))
                            <span class="help-block">
                                <strong>{{ $errors->first('gender') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="signup__group">
                            <button type="submit" class="btn btn-form">Create new account</button>
                        </div>
                    </div>
                </div>
            </form>
            @endguest
        </div>
    </div>
</div>
@include('includes.footer')
</body>
</html>


                