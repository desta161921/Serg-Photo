<!DOCTYPE html>
<html>
<head>
    <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body>
<?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div class="container__box">
    <video autoplay loop id="video-bg">
        <source src="vid/bg.webm" type="video/mp4">
    </video>
    <div class="wrapper__main">
        <div class="signup__container">
            <?php if(auth()->guard()->guest()): ?>
            <form class="signup__form" method="POST" action="<?php echo e(route('register')); ?>">
                <?php echo e(csrf_field()); ?>

                <div class="signup__heading">
                    <h2 class="heading-1">Sign up</h2>
                </div>
                <div class="signup__box">
                    <div class="signup__box-l">
                        <div class="signup__group" <?php echo e($errors->has('first_Name') ? ' has-error' : ''); ?>>
                            <input id="first_Name" type="text" class="signup-input" name="first_Name" value="<?php echo e(old('first_Name')); ?>" required autofocus>
                            <span class="float-label">First name</span>
                                <?php if($errors->has('first_Name')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('first_Name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                        </div>
                        <div class="signup__group" <?php echo e($errors->has('last_Name') ? ' has-error' : ''); ?>>
                            <input id="last_Name" type="text" class="signup-input" name="last_Name" value="<?php echo e(old('last_Name')); ?>" required autofocus>
                            <span class="float-label">Last name</span>
                                <?php if($errors->has('last_Name')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('last_Name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                        </div>
                        <div class="signup__group" <?php echo e($errors->has('email') ? ' has-error' : ''); ?>>
                            <input id="email" type="text" class="signup-input" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
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
                        </div>
                        <div class="signup__group">
                            <input id="password_confirmation" type="password" class="signup-input" name="password_confirmation" required>
                            <span class="float-label">Confirm password</span>
                            <?php if($errors->has('password')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('password')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                    </div> 
                        <div class="signup__box-r">
                        <div class="signup__group" <?php echo e($errors->has('DOB') ? ' has-error' : ''); ?>>
                            <label for="DOB" class="form-label">Date of birth</label>
                            <input id="DOB" type="date" class="form-input" name="DOB" value="<?php echo e(old('DOB')); ?>" autofocus>
                            <?php if($errors->has('DOB')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('DOB')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="signup__group" <?php echo e($errors->has('gender') ? ' has-error' : ''); ?>>
                            <label for="gender" class="form-label">Gender</label>
                            <input type="radio" name="gender" value="male" class=""> Male
                            <input type="radio" name="gender" value="female"> Female
                            <?php if($errors->has('DOB')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('gender')); ?></strong>
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="signup__group">
                            <button type="submit" class="btn btn-form">Create new account</button>
                        </div>
                    </div>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php echo $__env->make('includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
</html>


                