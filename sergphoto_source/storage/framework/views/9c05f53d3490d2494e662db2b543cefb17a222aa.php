<!DOCTYPE html>
<html>
<head>
<?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body>
    <?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
        <?php if(auth()->guard()->guest()): ?>
            <form class="form" method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo e(csrf_field()); ?>

                <h2 class="heading-1">Sign in with</h2>
                <div class="form-group form-social">
                    <a href="/auth/facebook" class="btn-face"><i class="fa fa-facebook-official" aria-hidden="true"></i>Facebook</a>
                    <a href="/auth/google" class="btn-google"><img src="img/googlelogo.png">Google</a>
                </div>
                <div class="form-group">
                    <p class="form-p"><span>Or sign in with</span></p>
                </div>
                <div class="signup__group" <?php echo e($errors->has('email') ? ' has-error' : ''); ?>>
                    <input id="email" type="text" class="signup-input" name="email" value="<?php echo e(old('email')); ?>" required>
                    <span class="float-label">E-mail address</span>
                    <?php if($errors->has('email')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('email')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="signup__group" <?php echo e($errors->has('password') ? ' has-error' : ''); ?>>
                    <input id="password" type="password" class="signup-input" name="password" required>
                    <span class="float-label">Password</span>
                    <?php if($errors->has('password')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('password')); ?></strong>
                        </span>
                    <?php endif; ?>
                </div>
                <a href="password/reset" class="form-label form-passwordreset">Forgot password?</a>
                <div class="form-group">
                    <button type="submit" class="btn btn-form btn-login" id="login__btn">Log in</button>
                </div>
                <div class="form-group">
                    <a class="btn btn-form" href="/signup">Create new account</a>
                </div>
            </form>
            <?php else: ?>
            <div class="right__loggedin">
                <div class="right__loggedin-welcome">
                    <h2 class="heading-welcome">Welcome <?php echo e(Auth::user()->first_Name); ?> <?php echo e(Auth::user()->last_Name); ?></h2>
                    <?php 
                        $userId = Auth::id(); 
                        $user = \App\User::find($userId);
                    ?>
                    <img src="<?php echo e(URL::asset('uploads/avatars')); ?>/<?php echo e($user->avatar); ?>" class="home__img">
                    <div class="right__loggedin-links">
                        <a class="btn btn-links" href="/feed">Feed</a>
                        <a class="btn btn-links" href="/events">Events</a>
                        <a class="btn btn-links" href="/myevents">My events</a>
                        <a class="btn btn-links" href="/profile">Profile</a>
                    </div>
                </div>
                <a href="<?php echo e(route('logout')); ?>"
                class="btn btn-logout"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                Logout</a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo e(csrf_field()); ?>

                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</main>
    <?php echo $__env->make('includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
</html>


                    