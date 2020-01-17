<!DOCTYPE html>
<html>
<head>
    <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body>
<?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container__box">
    <?php
        $url = $_SERVER['REQUEST_URI'];
        $token = basename($url);
        
    ?>
    <div class="wrapper">
        <div class="box-landing">
            <?php if(DB::table('invites')->where('token', $token)->exists()): ?>
            <?php
                $email = DB::table('invites')->where('token',$token)->first();
                $event = DB::table('events')->where('event_Id', $email->event_Id)->first();
                session()->put('token', $token);
            ?>
            <?php if(auth()->guard()->guest()): ?>
            <form class="form" method="POST" action="<?php echo e(route('register')); ?>">
                <?php echo e(csrf_field()); ?>

                <div class="signup__heading">
                    <h2 class="heading-1">Sign up</h2>
                    Login first if you already have a user
                </div>
                <div class="form-group form-social">
                    <a href="/auth/facebook" class="btn-face"><i class="fa fa-facebook-official" aria-hidden="true"></i>Facebook</a>
                    <a href="/auth/google" class="btn-google"><img src="img/googlelogo.png">Google</a>
                </div>
                <div class="form-group<?php echo e($errors->has('first_Name') ? ' has-error' : ''); ?>">
                    <label for="first_Name" class="form-label">First name</label>
                    <input id="first_Name" type="text" class="form-input" name="first_Name" value="<?php echo e(old('first_Name')); ?>" required autofocus>
                        <?php if($errors->has('first_Name')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('first_Name')); ?></strong>
                            </span>
                        <?php endif; ?>
                </div>
                <div class="form-group<?php echo e($errors->has('last_Name') ? ' has-error' : ''); ?>">
                    <label for="last_Name" class="form-label">Last name</label>
                    <input id="last_Name" type="text" class="form-input" name="last_Name" value="<?php echo e(old('last_Name')); ?>" required autofocus>
                        <?php if($errors->has('last_Name')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('last_Name')); ?></strong>
                            </span>
                        <?php endif; ?>
                </div>
                <div class="form-group<?php echo e($errors->has('DOB') ? ' has-error' : ''); ?>">
                    <label for="DOB" class="form-label">Date of birth</label>
                    <input id="DOB" type="date" class="form-input" name="DOB" value="<?php echo e(old('DOB')); ?>" required autofocus>
                        <?php if($errors->has('DOB')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('DOB')); ?></strong>
                            </span>
                        <?php endif; ?>
                </div>
                <div class="form-group<?php echo e($errors->has('gender') ? ' has-error' : ''); ?>">
                    <label for="gender" class="form-label">Gender</label>
                      <input type="radio" name="gender" value="male"> Male
                      <input type="radio" name="gender" value="female"> Female
                        <?php if($errors->has('DOB')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('gender')); ?></strong>
                            </span>
                        <?php endif; ?>
                </div>
                <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                    <label for="email" class="form-label">E-Mail Address</label>
                    <input id="email" type="email" class="form-input" name="email" value="<?php echo e($email->email); ?>" required autofocus>
                        <?php if($errors->has('email')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('email')); ?></strong>
                            </span>
                        <?php endif; ?>
                </div>
                <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                    <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" class="form-input" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input id="password_confirmation" type="password" class="form-input" name="password_confirmation" required>
                    <?php if($errors->has('password')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('password')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>                        
                <div class="form-group">
                    <input id="invite" type="hidden" class="form-input landing-input" name="invite" value="true">
                    <input id="token" type="hidden" class="form-input landing-input" name="token" value="<?php echo e($token); ?>">
                    <button type="submit" class="btn btn-form">Create new account</button>
                </div>
            </form>
            <?php else: ?>
            <p>You have been invited to the event "<?php echo e($event->event_Name); ?>".</p>
            </div>
            <div class="box-landing">
            <form method="POST" name"deleteInvitation" action="/inviteregistration/join" value="<?php echo csrf_token(); ?>">
                <?php echo e(csrf_field()); ?>

                <input type="hidden" id="event_Id" name="event_Id" value="<?php echo e($event->event_Id); ?>"></input>
                <input id="token" type="hidden" name="token" value="<?php echo e($token); ?>">
                <input type="submit" class="btn btn-form" value="Join event"></input>
            </form>
            <?php endif; ?>
            <?php else: ?>
            Token does not exist or already in use
            <?php endif; ?>
        </div>
    </div>
</div>
<?php echo $__env->make('includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
</html>


                