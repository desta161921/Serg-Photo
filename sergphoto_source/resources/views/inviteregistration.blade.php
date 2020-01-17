<!DOCTYPE html>
<html>
<head>
    @include('includes.head')
</head>
<body>
@include('includes.header')
<div class="container__box">
    <?php
        $url = $_SERVER['REQUEST_URI'];
        $token = basename($url);
        
    ?>
    <div class="wrapper">
        <div class="box-landing">
            @if(DB::table('invites')->where('token', $token)->exists())
            @php
                $email = DB::table('invites')->where('token',$token)->first();
                $event = DB::table('events')->where('event_Id', $email->event_Id)->first();
                session()->put('token', $token);
            @endphp
            @guest
            <form class="form" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="signup__heading">
                    <h2 class="heading-1">Sign up</h2>
                    Login first if you already have a user
                </div>
                <div class="form-group form-social">
                    <a href="/auth/facebook" class="btn-face"><i class="fa fa-facebook-official" aria-hidden="true"></i>Facebook</a>
                    <a href="/auth/google" class="btn-google"><img src="img/googlelogo.png">Google</a>
                </div>
                <div class="form-group{{ $errors->has('first_Name') ? ' has-error' : '' }}">
                    <label for="first_Name" class="form-label">First name</label>
                    <input id="first_Name" type="text" class="form-input" name="first_Name" value="{{ old('first_Name') }}" required autofocus>
                        @if ($errors->has('first_Name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('first_Name') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group{{ $errors->has('last_Name') ? ' has-error' : '' }}">
                    <label for="last_Name" class="form-label">Last name</label>
                    <input id="last_Name" type="text" class="form-input" name="last_Name" value="{{ old('last_Name') }}" required autofocus>
                        @if ($errors->has('last_Name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('last_Name') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group{{ $errors->has('DOB') ? ' has-error' : '' }}">
                    <label for="DOB" class="form-label">Date of birth</label>
                    <input id="DOB" type="date" class="form-input" name="DOB" value="{{ old('DOB') }}" required autofocus>
                        @if ($errors->has('DOB'))
                            <span class="help-block">
                                <strong>{{ $errors->first('DOB') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                    <label for="gender" class="form-label">Gender</label>
                      <input type="radio" name="gender" value="male"> Male
                      <input type="radio" name="gender" value="female"> Female
                        @if ($errors->has('DOB'))
                            <span class="help-block">
                                <strong>{{ $errors->first('gender') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="form-label">E-Mail Address</label>
                    <input id="email" type="email" class="form-input" name="email" value="{{$email->email}}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" class="form-input" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input id="password_confirmation" type="password" class="form-input" name="password_confirmation" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>                        
                <div class="form-group">
                    <input id="invite" type="hidden" class="form-input landing-input" name="invite" value="true">
                    <input id="token" type="hidden" class="form-input landing-input" name="token" value="{{$token}}">
                    <button type="submit" class="btn btn-form">Create new account</button>
                </div>
            </form>
            @else
            <p>You have been invited to the event "{{$event->event_Name}}".</p>
            </div>
            <div class="box-landing">
            <form method="POST" name"deleteInvitation" action="/inviteregistration/join" value="<?php echo csrf_token(); ?>">
                {{ csrf_field() }}
                <input type="hidden" id="event_Id" name="event_Id" value="{{$event->event_Id}}"></input>
                <input id="token" type="hidden" name="token" value="{{$token}}">
                <input type="submit" class="btn btn-form" value="Join event"></input>
            </form>
            @endguest
            @else
            Token does not exist or already in use
            @endif
        </div>
    </div>
</div>
@include('includes.footer')
</body>
</html>


                