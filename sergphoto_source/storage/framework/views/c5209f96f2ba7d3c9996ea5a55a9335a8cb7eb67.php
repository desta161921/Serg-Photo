<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="<?php echo e(route('register')); ?>">
                        <?php echo e(csrf_field()); ?>


                        <div class="form-group<?php echo e($errors->has('first_Name') ? ' has-error' : ''); ?>">
                            <label for="first_Name" class="col-md-4 control-label">First name</label>

                            <div class="col-md-6">
                                <input id="first_Name" type="text" class="form-control" name="first_Name" value="<?php echo e(old('first_Name')); ?>" required autofocus>

                                <?php if($errors->has('first_Name')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('first_Name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div> 

                        <div class="form-group<?php echo e($errors->has('last_Name') ? ' has-error' : ''); ?>">
                            <label for="last_Name" class="col-md-4 control-label">Last name</label>

                            <div class="col-md-6">
                                <input id="last_Name" type="text" class="form-control" name="last_Name" value="<?php echo e(old('last_Name')); ?>" required autofocus>

                                <?php if($errors->has('last_Name')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('last_Name')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="<email></email>" type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required>

                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                <?php if($errors->has('password')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>