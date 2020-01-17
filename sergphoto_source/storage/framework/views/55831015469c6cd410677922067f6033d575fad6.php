<!DOCTYPE html>
<html>
    <?php echo $__env->make('includes.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <body>
        <?php echo $__env->make('includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <main>
    <div id="fullpage">
        <div class="section" id="section0">
            <div class="container__box">
                <div class="wrapper">
                    <div class="left">
                        <h2 class="heading-head">Photogram</h2>
                    </div>
                    <div class="right">
                    <?php if(auth()->guard()->guest()): ?>
                        <form class="form" method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo e(csrf_field()); ?>

                        <h2 class="heading-1">Sign in with</h2>
                        <div class="form-group form-social">
                            <a href="/auth/facebook" class="btn-face"><i class="fa fa-facebook-official" aria-hidden="true"></i>Facebook</a>
                            <a href="/auth/google" class="btn-google"><img src="http://diylogodesigns.com/blog/wp-content/uploads/2016/04/google-logo-icon-PNG-Transparent-Background.png">Google</a>
                        </div>
                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <p class="form-p"><span>Or sign in with</span></p>
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
                                    <?php if($errors->has('password')): ?>
                                        <span class="help-block">
                                            <strong><?php echo e($errors->first('password')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-form" id="login__btn">Log in</button>
                        </div>
                        <div class="form-group">
                            <a class="btn btn-form" href="<?php echo e(route('password.request')); ?>">Create new account</a>
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
                </div>
            </div>
        </div>
            
        <div class="section" id="section1">
            <div class="container__box">
                <div class="wrapper">
                    <div class="right about__us">
                        <h2 class="heading-1">About us</h2>
                        <p class="about__us-p">Photogram is a webapplication developed as a final project for graduation students at Applied Computer Sciene at OsloMet.</p>
                        <p class="about__us-p">This webapplication is only made for educational purposes.</p>
                    </div>
                    <div class="left">
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="section" id="section2">
            <div class="container__box">
                <div class="wrapper">
                    <div class="left">
                        <h2 class="heading-head">Photogram</h2>
                    </div>
                    <div class="right">
                        <?php if(auth()->guard()->guest()): ?>
                        <form class="form" method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo e(csrf_field()); ?>

                        <h2 class="heading-1">Sign in with</h2>
                        <div class="form-group form-social">
                            <a href="/auth/facebook" class="btn-face"><i class="fa fa-facebook-official" aria-hidden="true"></i>Facebook</a>
                            <a href="/auth/google" class="btn-google"><img src="http://diylogodesigns.com/blog/wp-content/uploads/2016/04/google-logo-icon-PNG-Transparent-Background.png">Google</a>
                        </div>
                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <p class="form-p"><span>Or sign in with</span></p>
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
                                    <?php if($errors->has('password')): ?>
                                        <span class="help-block">
                                            <strong><?php echo e($errors->first('password')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-form" id="login__btn">Log in</button>
                        </div>
                        <div class="form-group">
                            <a class="btn btn-form" href="<?php echo e(route('password.request')); ?>">Create new account</a>
                        </div>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
            <?php echo $__env->make('includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    </main>
    <script type="text/javascript" src="js/fullPage.min.js"></script>
    </body>
</html>


                    