<!DOCTYPE html>
<html>
    <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <body>
        <?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <main>
    <div id="fullpage">
        <div class="section" id="section0">
            <section class="section__login" id="login">
                <div class="container__box">
                    <h2 class="heading-landing">Photogram</h2>
                    <?php if(auth()->guard()->guest()): ?>
                    <form class="form__login" method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo e(csrf_field()); ?>


                    <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                        <label for="email" class="form-label">E-Mail Address</label>
                            <input id="email" type="email" class="form__login-text" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                    </div>

                   <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                        <label for="password" class="control-label">Password</label>
                            <input id="password" type="password" class="form__login-text" name="password" required>
                                <?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <a class="btn btn-form form-group__link" href="<?php echo e(route('password.request')); ?>">Forgot your Password?</a>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="login__btn">Log in</button>
                    </div>
                    
                    <div class="form-group">
                        <a class="btn btn-primary" href="#3rdPage">Sign up</a>
                    </div>
                    
                    <div class="form-group">
                        <a class="btn btn-primary btn-facebook" href="/auth/facebook">
                        <i class="fa fa-facebook-official" aria-hidden="true"></i>Log in with Facebook</a>
                    </div>
                     <div class="form-group">
                        <a class="btn btn-primary btn-google" href="/auth/google"><i class="fa fa-google-official" aria-hidden="true"></i>Log in with Google</a>
                    </div>
                    </form>
                    <?php else: ?>
                    Welcome <?php echo e(Auth::user()->first_Name); ?> <?php echo e(Auth::user()->last_Name); ?>

                    
                                                <li>
                                        <a href="<?php echo e(route('logout')); ?>"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                            <?php echo e(csrf_field()); ?>

                                        </form>
                                    </li>
                                    
                    <?php endif; ?>
                </div>
            </section>
        </div>
            
        <div class="section" id="section1">
            <div class="content">
                <section class="section__about" id="about">
                    <div class="container__box"><h2 class="heading-landing">About Photogram</h2>
                        <p class="section__about-p">Photogram is a webapplication developed as a final project for graduation students
                        at Applied Computer Sciene at OsloMet.</p>
                        <p class="section__about-p">This webapplication is only made for education purposes.</p>
                    </div>
                </section>
            </div>
        </div>
            
        <div class="section" id="section2">
            <section class="section__sign-up" id="register">
                <div class="container__box">
                    <h2 class="heading-landing">Photogram</h2>
                    <form class="form__signup" method="POST" action="<?php echo e(route('register')); ?>">
                    <?php echo e(csrf_field()); ?>


                    <div class="form-group<?php echo e($errors->has('first_Name') ? ' has-error' : ''); ?>">
                        <label for="firstname" class="form-label">First name</label>
                            <input id="first_Name" type="text" class="form__login-text" name="first_Name" value="<?php echo e(old('first_Name')); ?>" required autofocus>
                            <?php if($errors->has('first_Name')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('first_Name')); ?></strong>
                                </span>
                            <?php endif; ?>
                    </div>

                    <div class="form-group<?php echo e($errors->has('last_Name') ? ' has-error' : ''); ?>">
                        <label for="lastname" class="control-label">Last name</label>
                            <input id="last_Name" type="text" class="form__login-text" name="last_Name" required>
                            <?php if($errors->has('last_Name')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('last_Name')); ?></strong>
                                </span>
                            <?php endif; ?>
                    </div>
                        
                    <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                        <label for="email" class="control-label">E-mail Address</label>
                            <input id="email" type="email" class="form__login-text" name="email" required>
                            <?php if($errors->has('email')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('email')); ?></strong>
                                </span>
                            <?php endif; ?>
                    </div>
                        
                    <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                        <label for="password" class="control-label">Password</label>
                            <input id="password" type="password" class="form__login-text" name="password" required>
                            <?php if($errors->has('password')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('password')); ?></strong>
                                </span>
                            <?php endif; ?>
                    </div>
                        
                    <div class="form-group">
                        <label for="password_confirmation" class="control-label">Confirm password</label>
                            <input id="password_confirmation" type="password" class="form__login-text" name="password_confirmation" required>
                            <?php if($errors->has('password-confirm')): ?>
                                <span class="help-block">
                                    <strong><?php echo e($errors->first('password_Confirmation')); ?></strong>
                                </span>
                            <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" id="create__btn">Create account </button>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-primary btn-facebook" href="/auth/facebook"><i class="fa fa-facebook-official" aria-hidden="true"></i>Create account with Facebook</a>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-primary btn-google" href="/auth/google"><i class="fa fa-google-official" aria-hidden="true"></i>Create account with Google</a>
                    </div>
                    </form>
                </div>
                    
            <?php echo $__env->make('includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </section>
        </div>
    </div>
    </main>
    <script type="text/javascript" src="js/fullPage.min.js"></script>
    <script type="text/javascript" src="js/fullPageInit.js"></script>
    </body>
</html>


                        <!--<div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>> Remember Me
                                </label>
                            </div>
                        </div>-->