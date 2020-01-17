<!DOCTYPE html>
<html>
    <head>
    <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </head>
    <body>
        <?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="section" id="section2">
            <div class="container__box">
                <div class="wrapper">
                    <div class="left">
                        <h2 class="heading-head">Photogram</h2>
                    </div>
                    <div class="right">
                        <?php if(auth()->guard()->guest()): ?>
                        <form class="form" method="POST" action="<?php echo e(route('register')); ?>#signup">
                            <?php echo e(csrf_field()); ?>

                            <h2 class="heading-1">Sign up</h2>
                            <div class="form-group<?php echo e($errors->has('first_Name') ? ' has-error' : ''); ?>">
                                <label for="first_Name" class="form-label">First name</label>
                                <input id="first_Name" type="text" class="form__input" name="first_Name" value="<?php echo e(old('first_Name')); ?>" required autofocus>
                                    <?php if($errors->has('first_Name')): ?>
                                        <span class="help-block">
                                            <strong><?php echo e($errors->first('first_Name')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                            </div>
                            <div class="form-group<?php echo e($errors->has('last_Name') ? ' has-error' : ''); ?>">
                                <label for="last_Name" class="form-label">Last name</label>
                                <input id="last_Name" type="text" class="form__input" name="last_Name" value="<?php echo e(old('last_Name')); ?>" required autofocus>
                                    <?php if($errors->has('last_Name')): ?>
                                        <span class="help-block">
                                            <strong><?php echo e($errors->first('last_Name')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                            </div>
                            <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                <label for="email" class="form-label">E-Mail Address</label>
                                <input id="email" type="email" class="form__input" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
                                    <?php if($errors->has('email')): ?>
                                        <span class="help-block">
                                            <strong><?php echo e($errors->first('email')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                            </div>
                            <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                                <label for="password" class="form-label">Password</label>
                                    <input id="password" type="password" class="form__input" name="password" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input id="password_confirmation" type="password" class="form__input" name="password_confirmation" required>
                                <?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>                        
                            <!--<div class="form-group<?php echo e($errors->has('password2conf') ? ' has-error' : ''); ?>">
                                <label for="password2conf" class="form-label">Confirm password</label>
                                    <input id="password2conf" type="password" class="form__input" name="password2conf" required>
                                        <?php if($errors->has('passwordTwoConfirm')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('passwordTwoConfirm')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                            </div> -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-form">Create new account</button>
                            </div>
                            <div class="form-group">
                                <a href="/" class="btn btn-form" id="login__btn">Log in</a>
                            </div>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php echo $__env->make('includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
    <script type="text/javascript" src="js/fullPage.min.js"></script>
    </body>
</html>


                    